<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class DeploymentController extends Controller
{
    /**
     * Security token for deployment routes
     * IMPORTANT: Change this token and remove routes after deployment
     */
    private const DEPLOYMENT_TOKEN = 'CHANGE_THIS_TOKEN_IN_PRODUCTION';

    /**
     * Verify deployment token
     */
    private function verifyToken(Request $request): bool
    {
        $token = $request->get('token') ?? $request->header('X-Deployment-Token');
        return $token === self::DEPLOYMENT_TOKEN;
    }

    /**
     * Show deployment dashboard
     */
    public function index(Request $request)
    {
        if (!$this->verifyToken($request)) {
            abort(403, 'Invalid deployment token');
        }

        $migrations = $this->getPendingMigrations();
        $tables = $this->getTableStatus();

        return view('deployment.index', [
            'migrations' => $migrations,
            'tables' => $tables,
        ]);
    }

    /**
     * Run migrations
     */
    public function migrate(Request $request)
    {
        if (!$this->verifyToken($request)) {
            abort(403, 'Invalid deployment token');
        }

        try {
            Artisan::call('migrate', [
                '--no-interaction' => true,
            ]);

            $output = Artisan::output();

            return response()->json([
                'success' => true,
                'message' => 'Migrations executed successfully',
                'output' => $output,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage(),
                'error' => $e->getTraceAsString(),
            ], 500);
        }
    }

    /**
     * Run seeders (only non-destructive ones)
     */
    public function seed(Request $request)
    {
        if (!$this->verifyToken($request)) {
            abort(403, 'Invalid deployment token');
        }

        $seeder = $request->get('seeder', 'DatabaseSeeder');

        try {
            Artisan::call('db:seed', [
                '--class' => $seeder,
                '--no-interaction' => true,
            ]);

            $output = Artisan::output();

            return response()->json([
                'success' => true,
                'message' => 'Seeder executed successfully',
                'output' => $output,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Seeder failed: ' . $e->getMessage(),
                'error' => $e->getTraceAsString(),
            ], 500);
        }
    }

    /**
     * Check database status
     */
    public function status(Request $request)
    {
        if (!$this->verifyToken($request)) {
            abort(403, 'Invalid deployment token');
        }

        $migrations = $this->getPendingMigrations();
        $tables = $this->getTableStatus();
        $migrationStatus = $this->getMigrationStatus();

        return response()->json([
            'migrations' => $migrations,
            'tables' => $tables,
            'migration_status' => $migrationStatus,
        ]);
    }

    /**
     * Get pending migrations
     */
    private function getPendingMigrations(): array
    {
        try {
            $migrationsPath = database_path('migrations');
            $files = File::files($migrationsPath);
            
            $migrations = [];
            foreach ($files as $file) {
                $migrations[] = [
                    'name' => $file->getFilename(),
                    'path' => $file->getPathname(),
                ];
            }

            return $migrations;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get table status
     */
    private function getTableStatus(): array
    {
        $requiredTables = [
            'sessions',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'failed_jobs',
        ];

        $tables = [];
        foreach ($requiredTables as $table) {
            $tables[$table] = [
                'exists' => Schema::hasTable($table),
                'count' => Schema::hasTable($table) ? DB::table($table)->count() : 0,
            ];
        }

        return $tables;
    }

    /**
     * Get migration status
     */
    private function getMigrationStatus(): array
    {
        try {
            if (!Schema::hasTable('migrations')) {
                return [
                    'table_exists' => false,
                    'migrations' => [],
                ];
            }

            $executed = DB::table('migrations')
                ->orderBy('migration')
                ->pluck('migration')
                ->toArray();

            return [
                'table_exists' => true,
                'executed_count' => count($executed),
                'executed' => $executed,
            ];
        } catch (\Exception $e) {
            return [
                'table_exists' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}

