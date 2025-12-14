<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deployment - MovilTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .status-success { color: #10b981; }
        .status-error { color: #ef4444; }
        .status-warning { color: #f59e0b; }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🚀 Deployment Center</h1>
            <p class="text-gray-600">Ejecuta migraciones y seeders de forma segura</p>
            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-sm text-yellow-800">
                    <strong>⚠️ IMPORTANTE:</strong> Estas rutas son temporales. Elimínalas después del despliegue.
                </p>
            </div>
        </div>

        <!-- Database Status -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Estado de la Base de Datos</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($tables as $table => $status)
                <div class="p-4 border rounded-lg">
                    <div class="font-medium">{{ $table }}</div>
                    <div class="text-sm {{ $status['exists'] ? 'status-success' : 'status-error' }}">
                        {{ $status['exists'] ? '✓ Existe' : '✗ No existe' }}
                    </div>
                    @if($status['exists'])
                    <div class="text-xs text-gray-500 mt-1">{{ $status['count'] }} registros</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Acciones</h2>
            <div class="space-y-4">
                <div>
                    <button 
                        onclick="runMigrations()" 
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        🔄 Ejecutar Migraciones
                    </button>
                    <p class="text-sm text-gray-600 mt-2">
                        Ejecuta todas las migraciones pendientes sin usar --force
                    </p>
                </div>

                <div>
                    <button 
                        onclick="checkStatus()" 
                        class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors"
                    >
                        📊 Ver Estado
                    </button>
                    <p class="text-sm text-gray-600 mt-2">
                        Verifica el estado actual de migraciones y tablas
                    </p>
                </div>
            </div>
        </div>

        <!-- Results -->
        <div id="results" class="bg-white rounded-lg shadow-lg p-6 hidden">
            <h2 class="text-xl font-semibold mb-4">Resultados</h2>
            <pre id="output" class="bg-gray-100 p-4 rounded text-sm overflow-auto max-h-96"></pre>
        </div>
    </div>

    <script>
        const token = new URLSearchParams(window.location.search).get('token') || '';

        function showResults(data) {
            const resultsDiv = document.getElementById('results');
            const outputPre = document.getElementById('output');
            resultsDiv.classList.remove('hidden');
            outputPre.textContent = JSON.stringify(data, null, 2);
        }

        function runMigrations() {
            fetch('{{ route("deployment.migrate") }}?token=' + token)
                .then(response => response.json())
                .then(data => {
                    showResults(data);
                    if (data.success) {
                        setTimeout(() => location.reload(), 2000);
                    }
                })
                .catch(error => {
                    showResults({ error: error.message });
                });
        }

        function checkStatus() {
            fetch('{{ route("deployment.status") }}?token=' + token)
                .then(response => response.json())
                .then(data => {
                    showResults(data);
                })
                .catch(error => {
                    showResults({ error: error.message });
                });
        }
    </script>
</body>
</html>

