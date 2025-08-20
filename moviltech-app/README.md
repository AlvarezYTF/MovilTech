# MovilTech - Sistema de Gestión de Reparaciones y Ventas

Sistema web completo desarrollado en Laravel 12 para la gestión de un local de reparación de teléfonos y venta de accesorios.

## 🚀 Características Principales

### 📱 Módulos Implementados
- **Dashboard**: Estadísticas en tiempo real, métricas de ventas y inventario
- **Inventario**: CRUD completo de productos con categorías y proveedores
- **Ventas**: Sistema de ventas con selección de productos y cálculo automático
- **Facturación**: Generación de facturas en PDF
- **Reparaciones**: Gestión de reparaciones con seguimiento de estado
- **Reportes**: Estadísticas detalladas de ventas, inventario y reparaciones

### 🔐 Sistema de Roles y Permisos
- **Administrador**: Acceso completo a todos los módulos
- **Vendedor**: Gestión de ventas, clientes y facturación
- **Técnico**: Módulo de reparaciones e inventario
- **Cliente**: Visualización de historial y descarga de facturas

### 🎨 Interfaz de Usuario
- Diseño moderno con TailwindCSS
- Sidebar responsive con navegación intuitiva
- Tablas con filtros y búsqueda avanzada
- Formularios validados y modales de confirmación

## 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade + TailwindCSS + Alpine.js
- **Base de Datos**: MySQL/PostgreSQL/SQLite
- **Autenticación**: Laravel Sanctum + Spatie Laravel Permission
- **PDF**: DomPDF para generación de facturas
- **API**: Laravel Sanctum para futuras integraciones móviles

## 📋 Requisitos del Sistema

- PHP 8.2 o superior
- Composer 2.0+
- Node.js 16+ (para compilación de assets)
- Base de datos MySQL 8.0+, PostgreSQL 13+ o SQLite 3.35+

## 🚀 Instalación

### 1. Clonar el Repositorio
```bash
git clone <url-del-repositorio>
cd moviltech-app
```

### 2. Instalar Dependencias PHP
```bash
composer install
```

### 3. Configurar Variables de Entorno
```bash
cp .env.example .env
```

Editar el archivo `.env` con la configuración de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=moviltech
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 4. Generar Clave de Aplicación
```bash
php artisan key:generate
```

### 5. Ejecutar Migraciones y Seeders
```bash
php artisan migrate:fresh --seed
```

### 6. Crear Enlace Simbólico para Storage
```bash
php artisan storage:link
```

### 7. Instalar Dependencias Frontend (Opcional)
```bash
npm install
npm run build
```

### 8. Configurar Servidor Web
Configura tu servidor web (Apache/Nginx) para apuntar al directorio `public/` del proyecto.

## 👥 Usuarios de Prueba

El sistema incluye usuarios predefinidos para testing:

| Email | Contraseña | Rol |
|-------|------------|-----|
| `admin@moviltech.com` | `password` | Administrador |
| `vendedor@moviltech.com` | `password` | Vendedor |
| `tecnico@moviltech.com` | `password` | Técnico |
| `cliente@moviltech.com` | `password` | Cliente |

## 📊 Estructura de la Base de Datos

### Tablas Principales
- **users**: Usuarios del sistema
- **roles**: Roles de usuario
- **permissions**: Permisos del sistema
- **categories**: Categorías de productos
- **suppliers**: Proveedores
- **products**: Productos del inventario
- **customers**: Clientes
- **sales**: Ventas realizadas
- **sale_items**: Items de cada venta
- **repairs**: Reparaciones registradas

## 🔧 Configuración Adicional

### Permisos de Archivos
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Configuración de Cola (Opcional)
Para procesamiento en segundo plano:
```bash
php artisan queue:work
```

### Configuración de Cron (Opcional)
Para tareas programadas:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 📱 Uso del Sistema

### 1. Acceso al Sistema
- Navega a la URL de tu aplicación
- Inicia sesión con uno de los usuarios de prueba
- El sistema redirigirá al dashboard según tu rol

### 2. Gestión de Inventario
- **Ver Productos**: Lista completa con filtros
- **Crear Producto**: Formulario con validación
- **Editar Producto**: Modificación de datos existentes
- **Eliminar Producto**: Con confirmación de seguridad

### 3. Gestión de Ventas
- **Nueva Venta**: Selección de cliente y productos
- **Cálculo Automático**: Totales, impuestos y descuentos
- **Generar Factura**: PDF descargable
- **Historial**: Consulta de ventas realizadas

### 4. Gestión de Reparaciones
- **Nueva Reparación**: Registro de dispositivo y problema
- **Seguimiento**: Actualización de estado y avances
- **Costos**: Estimación y costo final
- **Fechas**: Estimación y cumplimiento

### 5. Reportes
- **Ventas**: Diarias, mensuales y anuales
- **Inventario**: Stock bajo y productos más vendidos
- **Reparaciones**: Estado y tiempos de entrega
- **Clientes**: Historial y preferencias

## 🔒 Seguridad

- Autenticación robusta con Laravel
- Middleware de permisos por rol
- Validación de formularios
- Protección CSRF
- Sanitización de datos
- Logs de auditoría

## 🚀 Despliegue en Producción

### 1. Optimizar para Producción
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Configurar Servidor Web
- Apache: Habilitar mod_rewrite
- Nginx: Configurar try_files
- SSL: Certificado HTTPS obligatorio

### 3. Monitoreo
- Logs de error
- Métricas de rendimiento
- Backup automático de base de datos

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📞 Soporte

Para soporte técnico o consultas:
- Crear un issue en el repositorio
- Contactar al equipo de desarrollo
- Revisar la documentación de Laravel

## 🔄 Actualizaciones

### Mantener el Sistema Actualizado
```bash
composer update
php artisan migrate
php artisan view:clear
php artisan config:clear
```

### Verificar Compatibilidad
- Revisar cambios en Laravel
- Actualizar dependencias gradualmente
- Probar en entorno de desarrollo

---

**MovilTech** - Sistema de Gestión Profesional para Reparaciones y Ventas de Dispositivos Móviles
