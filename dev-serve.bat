@echo off
echo Iniciando servidor de desarrollo...
cd laravel_app
php artisan serve --host=127.0.0.1 --port=8000
