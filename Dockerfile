FROM php:8.2-apache

# Instalar extensiones necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar proyecto al contenedor
WORKDIR /var/www/html
COPY . .

# Exponer puerto
EXPOSE 80