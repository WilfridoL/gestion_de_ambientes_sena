#!/bin/bash
set -e

# Deshabilitar otros MPM por seguridad
a2dismod mpm_event || true
a2dismod mpm_worker || true

# Habilitar solo prefork
a2enmod mpm_prefork

# Evitar warning ServerName
echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Ejecutar entrypoint original
exec docker-php-entrypoint apache2-foreground