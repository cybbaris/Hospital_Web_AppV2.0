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
    && apt-get clean
# apt-get update ile güncellemeleri alıyoruz ve ardından gerekli paketleri kuruyoruz

#RUN a2enmod rewrite
# apache2'de mod_rewrite'i etkinleştiriyoruz. mod_rewrite, URL'leri yeniden yazmak için kullanılır ve genellikle SEO dostu URL'ler oluşturmak için kullanılır.
#çok gerekli değil ama lazım olursa diye ekliyoruz

WORKDIR /var/www/html
# Çalışma dizinini /var/www/html olarak ayarlıyoruz. 

RUN mkdir -p /var/www/html/sql_backup && touch /var/log/backup.log && chown -R www-data:www-data /var/www/html/ && chown -R www-data:www-data /var/log/backup.log

EXPOSE 80
#80 portunu açıyoruz

#RUN echo "0 0 * * 0 root bash /var/www/html/admin/backup.sh" >> /etc/crontab

CMD ["sh", "-c", "service cron start && apachectl -D FOREGROUND"]
# apache2'yi ve cron servisini başlatıyoruz. apachectl -D FOREGROUND komutu, Apache'yi arka planda değil, ön planda çalıştırır. Bu, Docker konteynerinin sürekli çalışmasını sağlar.
# konteyner başlatıldığında hem Apache hem de cron servislerinin çalışmasını sağlar.