#!/bin/bash

# Disable conflicting MPMs and enable mpm_prefork
a2dismod mpm_event || true
a2dismod mpm_worker || true
a2enmod mpm_prefork || true

# Remove any leftover symlinks to prevent conflicts
rm -f /etc/apache2/mods-enabled/mpm_event.conf
rm -f /etc/apache2/mods-enabled/mpm_worker.conf

# Start Apache
exec apache2 -DFOREGROUND
