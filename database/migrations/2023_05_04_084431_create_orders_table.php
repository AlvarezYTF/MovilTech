<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_date');
            $table->tinyInteger('order_status')
                ->comment('0 - Pendiente / 1 - Vendido');
            $table->integer('total_products');
            $table->integer('sub_total');
            $table->integer('vat');
            $table->integer('total');
            $table->string('invoice_no');
            $table->string('payment_type');
            $table->integer('pay');
            $table->integer('due');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys that reference orders table first
        if (Schema::hasTable('order_details')) {
            try {
                // Get the foreign key constraint name
                $foreignKey = DB::selectOne(
                    "SELECT CONSTRAINT_NAME 
                     FROM information_schema.KEY_COLUMN_USAGE 
                     WHERE TABLE_SCHEMA = DATABASE() 
                     AND TABLE_NAME = 'order_details' 
                     AND COLUMN_NAME = 'order_id' 
                     AND REFERENCED_TABLE_NAME = 'orders'"
                );
                
                if ($foreignKey) {
                    DB::statement("ALTER TABLE order_details DROP FOREIGN KEY {$foreignKey->CONSTRAINT_NAME}");
                }
            } catch (\Exception $e) {
                // Foreign key might not exist or already dropped
            }
        }
        
        Schema::dropIfExists('orders');
    }
};
