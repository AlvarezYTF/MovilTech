# Dockerización de MovilTech

Este documento explica cómo ejecutar la aplicación MovilTech usando Docker.

## Requisitos

- Docker
- Docker Compose
- Make (opcional, para usar comandos simplificados)

## Configuración

### Archivos de configuración

- `Dockerfile` - Imagen de producción con Apache
- `Dockerfile.dev` - Imagen de desarrollo con PHP-FPM
- `docker-compose.yml` - Configuración de producción
- `docker-compose.dev.yml` - Configuración de desarrollo
- `.env.docker` - Variables de entorno para Docker

### Servicios incluidos

- **app**: Aplicación Laravel
- **nginx**: Servidor web (proxy reverso)
- **db**: Base de datos MySQL 8.0
- **redis**: Cache y sesiones
- **queue**: Worker para colas (opcional)
- **vite**: Servidor de desarrollo para assets (solo en dev)

## Uso

### Producción

```bash
# Construir y levantar los contenedores
make install

# O manualmente:
docker-compose up -d --build
```

### Desarrollo

```bash
# Construir y levantar los contenedores de desarrollo
make install-dev

# O manualmente:
docker-compose -f docker-compose.dev.yml up -d --build
```

## Comandos útiles

### Con Make

```bash
make help              # Ver todos los comandos disponibles
make up                # Levantar contenedores
make down              # Detener contenedores
make logs              # Ver logs
make shell             # Acceder al shell del contenedor
make migrate           # Ejecutar migraciones
make seed              # Ejecutar seeders
make fresh             # Migrate fresh + seed
make test              # Ejecutar tests
make clean             # Limpiar todo
```

### Con Docker Compose

```bash
# Producción
docker-compose up -d
docker-compose down
docker-compose logs -f
docker-compose exec app bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed

# Desarrollo
docker-compose -f docker-compose.dev.yml up -d
docker-compose -f docker-compose.dev.yml down
docker-compose -f docker-compose.dev.yml logs -f
docker-compose -f docker-compose.dev.yml exec app bash
```

## Acceso a la aplicación

- **Producción**: http://localhost:8080
- **Desarrollo**: http://localhost:8080 (con hot reload en puerto 5173)

## Base de datos

### Producción
- Host: localhost:3306
- Database: moviltech
- Usuario: moviltech
- Password: moviltech123

### Desarrollo
- Host: localhost:3307
- Database: moviltech_dev
- Usuario: moviltech
- Password: moviltech123

## Redis

### Producción
- Host: localhost:6379

### Desarrollo
- Host: localhost:6380

## Estructura de archivos Docker

```
docker/
├── apache/
│   └── 000-default.conf    # Configuración de Apache
├── nginx/
│   └── default.conf        # Configuración de Nginx
├── php/
│   └── local.ini          # Configuración de PHP
└── mysql/
    └── my.cnf             # Configuración de MySQL
```

## Troubleshooting

### Problemas comunes

1. **Error de permisos**: Ejecutar `make shell` y luego `chown -R www-data:www-data /var/www/html`

2. **Base de datos no conecta**: Verificar que el contenedor de MySQL esté corriendo y esperar unos segundos para que se inicialice

3. **Assets no cargan**: En desarrollo, verificar que el contenedor de Vite esté corriendo

4. **Puerto ocupado**: Cambiar los puertos en docker-compose.yml si están ocupados

### Logs

```bash
# Ver logs de todos los servicios
make logs

# Ver logs de un servicio específico
docker-compose logs -f app
docker-compose logs -f db
docker-compose logs -f nginx
```

### Limpieza

```bash
# Limpiar contenedores, imágenes y volúmenes
make clean

# Limpiar solo contenedores
docker-compose down
```

## Desarrollo

Para desarrollo, se recomienda usar `docker-compose.dev.yml` que incluye:

- PHP-FPM en lugar de Apache
- Vite para hot reload
- Base de datos en puerto diferente
- Variables de entorno de desarrollo

## Producción

Para producción, usar `docker-compose.yml` que incluye:

- Apache como servidor web
- Configuración optimizada
- Worker para colas
- Variables de entorno de producción



