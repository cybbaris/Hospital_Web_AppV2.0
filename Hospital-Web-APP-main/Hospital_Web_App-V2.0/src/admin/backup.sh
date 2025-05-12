#!/bin/sh
LOGFILE='/var/log/backup.log'
TIMESTAMP=$(date +"%Y:%m:%d-%H:%M:%S")
BACKUP_DIR='sql_backup'
BACKUP_FILE="hospital_backup.sql"

#DATABASE
CONTAINER_NAME="hospital_db"
SQL_USER="root"
SQL_PASS="rootpass"
SQL_DB="hospital"
DB_PORT="3306"
BACKUP_DIR="sql_backup"
BACKUP_FILE="sql_backup.sql"


#backup_dir
if [ ! -d $BACKUP_DIR ]; then
    mkdir -p "$BACKUP_DIR"
fi

#backup 

mysqldump --host="$CONTAINER_NAME" --port="$DB_PORT" --user="$SQL_USER" --password="$SQL_PASS" "$SQL_DB" > "$BACKUP_DIR/$BACKUP_FILE"

if [ $? -eq 0 ]; then
    echo "$TIMESTAMP Yedek basariyla alindi: $BACKUP_DIR/$BACKUP_FILE" >> "/var/log/backup.log"
else
    echo "$TIMESTAMP Ye92dekleme sirasinda bir hata olustu." >> "/var/log/backup.log"
fi
