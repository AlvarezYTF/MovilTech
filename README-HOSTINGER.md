# MovilTech - Estructura para Hostinger

## 📁 Estructura Optimizada para Hosting Compartido

Esta estructura está **optimizada específicamente para Hostinger** y otros hosting compartidos.

### 🏗️ Estructura de Directorios

```
MovilTech/
├── public_html/              # Directorio web público (subir a public_html en Hostinger)
│   ├── index.php            # Punto de entrada de la aplicación
│   ├── .htaccess           # Configuración de Apache optimizada
│   ├── favicon.ico         # Icono del sitio
│   ├── robots.txt          # Configuración para motores de búsqueda
│   └── storage/            # Enlace simbólico a archivos públicos
│
├── laravel_app/            # Directorio privado (subir fuera de public_html)
│   ├── app/                # Lógica de aplicación
│   ├── bootstrap/          # Archivos de inicialización
│   ├── config/             # Configuraciones
│   ├── database/           # Migraciones y seeders
│   ├── resources/          # Vistas, CSS, JS
│   ├── routes/             # Definición de rutas
│   ├── storage/            # Archivos de almacenamiento
│   ├── vendor/             # Dependencias de Composer
│   ├── artisan             # CLI de Laravel
│   ├── composer.json       # Dependencias PHP
│   ├── composer.lock       # Versiones exactas
│   ├── .env                # Variables de entorno
│   └── .env.example        # Plantilla de variables
│
└── archivos_restantes/     # Archivos de desarrollo (no subir)
    ├── tests/              # Tests
    ├── package.json        # Dependencias Node.js
    ├── tailwind.config.js  # Configuración Tailwind
    └── vite.config.js      # Configuración Vite
```

## 🚀 Instrucciones de Subida a Hostinger

### 1. Subir Archivos Públicos
- **Subir todo el contenido de `public_html/`** al directorio `public_html/` en tu hosting
- Esto incluye: `index.php`, `.htaccess`, `favicon.ico`, `robots.txt`, y `storage/`

### 2. Subir Archivos Privados
- **Subir todo el contenido de `laravel_app/`** al directorio raíz de tu hosting (fuera de `public_html/`)
- Esto incluye: `app/`, `config/`, `database/`, `vendor/`, `.env`, etc.

### 3. Configurar Variables de Entorno
- Editar el archivo `.env` en el directorio `laravel_app/` con tus datos:
```env
APP_NAME="MovilTech"
APP_ENV=production
APP_KEY=base64:TU_CLAVE_AQUI
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=tu_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=mail.tu-dominio.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@tu-dominio.com
MAIL_PASSWORD=tu-password-email
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@tu-dominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 4. Ejecutar Comandos de Laravel
- Acceder al panel de Hostinger → Terminal
- Navegar al directorio `laravel_app/`
- Ejecutar:
```bash
cd laravel_app
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔧 Configuración Adicional

### Base de Datos
- Crear una base de datos MySQL en el panel de Hostinger
- Importar el archivo `database.sqlite` si es necesario
- O ejecutar las migraciones con `php artisan migrate`

### Permisos de Archivos
- Asegurar que `storage/` y `bootstrap/cache/` tengan permisos 755
- El archivo `.env` debe tener permisos 644

### SSL/HTTPS
- Activar SSL en el panel de Hostinger
- Actualizar `APP_URL` en `.env` para usar `https://`

## 📋 Checklist de Verificación

- [ ] Archivos de `public_html/` subidos a `public_html/` en hosting
- [ ] Archivos de `laravel_app/` subidos fuera de `public_html/`
- [ ] Archivo `.env` configurado con datos correctos
- [ ] Base de datos creada y configurada
- [ ] Comandos de Laravel ejecutados
- [ ] SSL activado
- [ ] Sitio accesible desde el navegador

## 🆘 Solución de Problemas

### Error 500
- Verificar permisos de archivos
- Revisar logs en `laravel_app/storage/logs/laravel.log`
- Verificar configuración de `.env`

### Assets no cargan
- Verificar que `storage/` esté en `public_html/`
- Ejecutar `php artisan storage:link`

### Base de datos no conecta
- Verificar credenciales en `.env`
- Confirmar que la base de datos existe
- Verificar que el usuario tenga permisos

## 📞 Soporte

Para problemas específicos de Hostinger:
- Revisar la documentación de Hostinger
- Contactar soporte técnico de Hostinger
- Verificar logs de error del servidor

---
**MovilTech** - Sistema optimizado para Hostinger
