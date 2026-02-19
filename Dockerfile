FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Asegurarse de usar solo prefork (necesario para mod_php)
RUN a2dismod mpm_event || true
RUN a2dismod mpm_worker || true
RUN a2enmod mpm_prefork

# Habilitar mod_rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . .

EXPOSE 80