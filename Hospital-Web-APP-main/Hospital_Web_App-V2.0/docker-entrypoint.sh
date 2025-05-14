#!/bin/bash

# Backup script'ini düzelt
dos2unix /var/www/html/admin/backup.sh
chmod +x /var/www/html/admin/backup.sh

# Servisleri başlat
service cron start
apachectl -D FOREGROUND 