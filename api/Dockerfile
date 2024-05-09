# Usa la imagen de PHP adecuada
FROM php:8.3

# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-install gd pdo pdo_mysql mysqli mbstring xml

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación Laravel al contenedor
COPY . .

# Instala las dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Genera la clave de la aplicación Laravel
RUN php artisan key:generate
# Comando para iniciar el servidor Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
