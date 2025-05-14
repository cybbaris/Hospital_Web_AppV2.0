
Uygulamamız, hasta kayıt girişleri, admin paneli ve yedekleme (backup) işlemleri üzerine kurulmuştur. Hastanemize üye olan kullanıcılar, Personel Yönetim Sayfasına erişerek burada Hasta Kayıt İşlemleri gerçekleştirebilirler. 

Yönetici (admin) paneli içerisinde backup işlemleri yerleştirildi ve bu şekilde SQL sayfasında haftalık yedekleme (crontab) ve manuel olarak yedekleme alma işlemiyapılmaktadır. 

--- 

## Kurulum
Öncelikle inen dosyalar içerisinde docker-compose.yml, docker-entrypoint.sh, Dockerfile ve src alanına gidiyoruz.

![docker-entry](/Asset/img/docker-entry.png)

bu alanda aşağıdaki komutu çalıştıralım.

```bash

sudo docker-compose up --build 

```

eğer bir hata çıktısı alırsanız öncelikle şu komutu çalıştırıp tekrar build etme işlemini gerçekleştirelim:

```bash

sudo chmod +x docker-entrypoint.sh

```

daha sonra SQL dosyalarımızı phpmyadmin üzerinden veritabanımıza eklememiz gerekiyor. bunun için http://localhost:8081 adresine gidip, "root:rootpass" ile giriş yapıyoruz. hospital veritabanının altında `Import` düğmesi ile SQL dosyalarımızı teker teker yükleyeceğiz. 

![SQL-Import](/Asset/img/SQL.png)

açılan sayfada sql klasörü içerisinde bulunan sql tablolarımızı File Upload düğmesi ile tek tek seçip yüklüyoruz.

![SQL-Upload](/Asset/img/SQL-upload.png)

sayfamızı çalıştırmak için http://localhost:8080 adresine gidiyoruz. Personel Hesabı oluşturmak için sağ üstteki User-Icon'a tıklayarak yeni hesap oluşturuyoruz. Hesabımızı oluştururken kullandığınız şifreyi unutmayınız. 


İyi çalışmalar!
