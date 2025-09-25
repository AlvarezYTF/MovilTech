# Usar la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de configuración de Apache
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copiar composer files
COPY composer.json composer.lock ./

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copiar package.json y package-lock.json (si existe)
COPY package*.json ./

# Instalar dependencias de Node.js
RUN npm install

# Copiar el resto de la aplicación
COPY . .

# Copiar archivo de configuración de entorno
COPY .env.docker .env

# Generar clave de aplicación
RUN php artisan key:generate

# Crear directorio de base de datos y archivo SQLite
RUN mkdir -p database && touch database/database.sqlite

# Ejecutar migraciones y seeders
RUN php artisan migrate --force
RUN php artisan db:seed --force

# Compilar assets
RUN npm run build

# Configurar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Exponer puerto 80
EXPOSE 80

# Comando por defecto
CMD ["apache2-foreground"]
