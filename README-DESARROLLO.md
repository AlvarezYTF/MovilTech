# MovilTech - Guía de Desarrollo

## 🚀 Configuración del Entorno de Desarrollo

### Estructura para Desarrollo
```
MovilTech/
├── index.php              # Punto de entrada para desarrollo local
├── .htaccess             # Configuración Apache para desarrollo
├── laravel.bat           # Script para comandos de Laravel
├── dev-serve.bat         # Script para iniciar servidor
├── dev-build.bat         # Script para compilar assets
├── storage/              # Enlace simbólico para desarrollo
│
├── public_html/          # Estructura para producción (Hostinger)
│   ├── index.php
│   ├── .htaccess
│   └── storage/
│
└── laravel_app/          # Código fuente de Laravel
    ├── app/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    └── artisan
```

## 🛠️ Comandos de Desarrollo

### Iniciar Servidor de Desarrollo
```bash
# Opción 1: Usar script
dev-serve.bat

# Opción 2: Comando directo
cd laravel_app
php artisan serve
```

### Comandos de Laravel
```bash
# Usar script (recomendado)
laravel.bat migrate
laravel.bat "make:controller ProductController"
laravel.bat route:list

# O directamente
cd laravel_app
php artisan [comando]
```

### Compilar Assets
```bash
# Usar script
dev-build.bat

# O directamente
npm run build
```

## 📁 Flujo de Trabajo

### 1. Desarrollo Local
- Trabaja normalmente en `laravel_app/`
- Usa `dev-serve.bat` para iniciar el servidor
- Accede a `http://localhost:8000`

### 2. Compilar para Producción
- Ejecuta `dev-build.bat` para compilar assets
- Los assets se compilan en `laravel_app/public/build/`

### 3. Preparar para Hostinger
- La carpeta `public_html/` ya está lista
- Solo necesitas subir los archivos según el README-HOSTINGER.md

## 🔧 Configuración de Base de Datos

### Para Desarrollo Local
Edita `laravel_app/.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=laravel_app/database/database.sqlite
```

### Para Producción
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

## 📝 Comandos Útiles

### Migraciones
```bash
laravel.bat migrate
laravel.bat migrate:fresh --seed
```

### Crear Modelos/Controladores
```bash
laravel.bat "make:model Product -m"
laravel.bat "make:controller ProductController --resource"
```

### Limpiar Cache
```bash
laravel.bat config:clear
laravel.bat route:clear
laravel.bat view:clear
```

### Ver Rutas
```bash
laravel.bat route:list
```

## 🎨 Frontend

### TailwindCSS
- Configuración en `tailwind.config.js`
- Compilar con `npm run build`

### Vite
- Configuración en `vite.config.js`
- Para desarrollo: `npm run dev`
- Para producción: `npm run build`

## 🚀 Despliegue

### Desarrollo → Producción
1. Compilar assets: `dev-build.bat`
2. Subir `public_html/` a `public_html/` en Hostinger
3. Subir `laravel_app/` fuera de `public_html/` en Hostinger
4. Configurar `.env` en el servidor
5. Ejecutar migraciones en el servidor

## ⚠️ Notas Importantes

- **Nunca subas** `node_modules/`, `tests/`, o archivos de desarrollo a producción
- **Siempre compila** los assets antes de subir a producción
- **Verifica** que `public_html/` tenga la estructura correcta
- **Configura** las variables de entorno en el servidor

## 🔍 Solución de Problemas

### Error 500 en Desarrollo
- Verificar que `laravel_app/vendor/` existe
- Ejecutar `composer install` en `laravel_app/`
- Verificar permisos de `storage/`

### Assets no Cargan
- Ejecutar `npm run build`
- Verificar que `storage/` sea un enlace simbólico válido

### Base de Datos no Conecta
- Verificar configuración en `.env`
- Ejecutar `laravel.bat migrate`

---
**MovilTech** - Entorno de desarrollo optimizado
