#!/bin/sh
LOGFILE='/var/log/backup.log'
TIMESTAMP=$(date +"%Y:%m:%d-%H:%M:%S")

#DATABASE
CONTAINER_NAME="hospital_db"
SQL_USER="root"
SQL_PASS="rootpass"
SQL_DB="hospital"
DB_PORT="3306"
BACKUP_DIR="sql_backup"
BACKUP_FILE="sql_backup.sql"
FILESIZE=$(stat -c%s "$BACKUP_DIR/$BACKUP_FILE")

#backup_dir
if [ ! -d $BACKUP_DIR ]; then
    mkdir -p "$BACKUP_DIR"
fi

#backup_touch
if [ ! -f $BACKUP_FILE ]; then
    touch "$BACKUP_FILE"
fi

#backup 

mysqldump --host="$CONTAINER_NAME" --port="$DB_PORT" --user="$SQL_USER" --password="$SQL_PASS" "$SQL_DB" > "$BACKUP_DIR/$BACKUP_FILE"

if [ $? -eq 0 ]; then
    echo "$TIMESTAMP itibari ile yedek basariyla alindi. dosya konumu: $BACKUP_DIR/$BACKUP_FILE, dosya boyutu: $FILESIZE kb" >> "/var/log/backup.log"
else
    echo "$TIMESTAMP itibari ile yedekleme yapilirken bir hata olustu." >> "/var/log/backup.log"
fi
