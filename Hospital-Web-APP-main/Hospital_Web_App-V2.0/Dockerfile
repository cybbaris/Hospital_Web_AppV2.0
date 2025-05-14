FROM debian:latest
#debian kurduğumuzu söylüyoruz

ENV DEBIAN_FRONTEND=noninteractive
#debian kurulum sırasında interaktif olmasın diye bu satırı ekliyoruz

RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    libapache2-mod-php \
    php-mysql \
    default-mysql-client \
    curl \
    unzip \
    nano \
    bash \
    cron \
    dos2unix \
    && apt-get clean
# apt-get update ile güncellemeleri alıyoruz ve ardından gerekli paketleri kuruyoruz

# Apache modüllerini etkinleştir
RUN a2enmod rewrite
RUN a2enmod headers

# Apache yapılandırmasını güncelle
RUN echo '<Directory /var/www/html/>\n\
    Options -Indexes\n\
    <FilesMatch "\.sh$">\n\
        Order allow,deny\n\
        Deny from all\n\
    </FilesMatch>\n\
</Directory>' > /etc/apache2/conf-available/security.conf

RUN a2enconf security

WORKDIR /var/www/html
# Çalışma dizinini /var/www/html olarak ayarlıyoruz. 

# Backup script için gerekli ayarlar
# 1. Dizin ve dosyaları oluştur
RUN mkdir -p /var/www/html/sql_backup && touch /var/log/backup.log

# 2. Script'i kopyala ve formatını düzelt
COPY src/admin/backup.sh /usr/local/bin/
RUN dos2unix /usr/local/bin/backup.sh

# 3. İzinleri ayarla
RUN chmod +x /usr/local/bin/backup.sh
RUN chown -R www-data:www-data /var/www/html/admin/backup.sh && chown -R www-data:www-data /var/log/backup.log

# 4. Container başlatıldığında script'i düzelt

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
#80 portunu açıyoruz

RUN echo "00 10 * * 1  root /usr/local/bin/backup.sh" >> /etc/crontab

CMD ["/usr/local/bin/docker-entrypoint.sh"]
# apache2'yi ve cron servisini başlatıyoruz. apachectl -D FOREGROUND komutu, Apache'yi arka planda değil, ön planda çalıştırır. Bu, Docker konteynerinin sürekli çalışmasını sağlar.
# konteyner başlatıldığında hem Apache hem de cron servislerinin çalışmasını sağlar.