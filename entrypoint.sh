#!/bin/bash
set -e

# Puerto dinámico que Railway asigna
PORT=${PORT:-80}

# Cambiar puerto en Apache
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf

# Forzar solo prefork
a2dismod mpm_event || true
a2dismod mpm_worker || true
a2enmod mpm_prefork

echo "ServerName localhost" >> /etc/apache2/apache2.conf

exec docker-php-entrypoint apache2-foreground