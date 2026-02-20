FROM php:8.2-apache

# Evitar warning ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Instalar extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Activar rewrite
RUN a2enmod rewrite

# Forzar solo prefork
RUN a2dismod mpm_event mpm_worker || true
RUN a2enmod mpm_prefork

WORKDIR /var/www/html
COPY . .