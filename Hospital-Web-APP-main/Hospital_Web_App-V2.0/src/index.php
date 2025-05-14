<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/main-style.css">

  <title>Hospital</title>
</head>

<body>
  <?php include("main-header.php"); ?>

  <main role="main">
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="/assets/img/bakim.jpg" class="d-block w-100" alt="Hastanemizin Bakım Alanı">
          <div class="carousel-caption d-none d-md-block">
            <h5>Bakım Alanlarımız</h5>
            <p>Modern ve konforlu odalarımızla hastalarımıza en iyi hizmeti sunuyoruz.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/assets/img/danisma.jpg" class="d-block w-100" alt="Hastanemizin Danışma Alanı">
          <div class="carousel-caption d-none d-md-block">
            <h5>Danışma ve Karşılama</h5>
            <p>Güleryüzlü ekibimizle her zaman yanınızdayız.</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="/assets/img/mutlu.jpg" class="d-block w-100" alt="Hastanemizin Vizyonu, Mutlu İnsanlar">
          <div class="carousel-caption d-none d-md-block">
            <h5>Mutlu Hastalar</h5>
            <p>Hasta memnuniyeti bizim için önceliktir.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Geri</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">İleri</span.Concurrent>
      </button>
    </div>

    <hr class="mt-5 mb-5">

    <!-- Doktor Tanıtımları -->
    <div class="container marketing mt-5">
      <div class="row">
        <div class="col-lg-4 text-center animate-hover" data-aos="fade-up" data-aos-delay="100">
          <img class="rounded-circle mb-3" src="assets/img/dr/tilki.png" alt="Dr. Sinan Kocagöz" width="140" height="140">
          <h2>Dr. Sinan Kocagöz</h2>
          <p><strong>Uzmanlık Alanı:</strong> Kardiyoloji</p>
          <p>Dr. Kocagöz, 15 yıllık deneyimiyle kalp hastalıkları konusunda uzmandır.</p>
          <p><a class="btn btn-secondary" href="#" role="button">Detaylar »</a></p>
        </div>
        <div class="col-lg-4 text-center animate-hover" data-aos="fade-up" data-aos-delay="200">
          <img class="rounded-circle mb-3" src="assets/img/dr/lion.png" alt="Dr. Mehmet Mermer" width="140" height="140">
          <h2>Dr. Mehmet Mermer</h2>
          <p><strong>Uzmanlık Alanı:</strong> Ortopedi</p>
          <p>Dr. Mermer, kemik ve eklem rahatsızlıklarında 10 yılı aşkın deneyime sahiptir.</p>
          <p><a class="btn btn-secondary" href="#" role="button">Detaylar »</a></p>
        </div>
        <div class="col-lg-4 text-center animate-hover" data-aos="fade-up" data-aos-delay="300">
          <img class="rounded-circle mb-3" src="assets/img/dr/kedi.png" alt="Dr. Barış Güven" width="140" height="140">
          <h2>Dr. Barış Güven</h2>
          <p><strong>Uzmanlık Alanı:</strong> Nöroloji</p>
          <p>Dr. Güven, sinir sistemi hastalıkları tedavisinde uzmanlaşmıştır.</p>
          <p><a class="btn btn-secondary" href="#" role="button">Detaylar »</a></p>
        </div>
      </div>
    </div>

    <!-- Featurette'ler -->
    <hr class="featurette-divider">
    <div class="container">
      <div class="row featurette">
        <div class="col-md-7" data-aos="fade-right">
          <h2 class="featurette-heading">Son Teknoloji Tıbbi Ekipmanlar</h2>
          <p class="lead">Hastanemiz, en güncel tıbbi teknolojilerle donatılmıştır. MRI, CT tarayıcıları ve robotik cerrahi sistemleriyle hastalarımıza en iyi hizmeti sunuyoruz.</p>
        </div>
        <div class="col-md-5" data-aos="fade-left">
          <img class="featurette-image img-fluid mx-auto" src="assets/img/hastane/teknoloji.png" alt="Teknolojik Altyapı">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7 order-md-2" data-aos="fade-left">
          <h2 class="featurette-heading">Hasta Odaklı Yaklaşım</h2>
          <p class="lead">Her hastamızın bireysel ihtiyaçlarına özen gösteriyor, kişiselleştirilmiş tedavi planları sunuyoruz.</p>
        </div>
        <div class="col-md-5 order-md-1" data-aos="fade-right">
          <img class="featurette-image img-fluid mx-auto" src="assets/img/hastane/acil.png" alt="Hasta Odaklı Hizmet">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7" data-aos="fade-right">
          <h2 class="featurette-heading">Alanında Uzman Doktorlar</h2>
          <p class="lead">Hastanemizde, her biri kendi alanında uzmanlaşmış, deneyimli doktorlar görev yapmaktadır.</p>
        </div>
        <div class="col-md-5" data-aos="fade-left">
          <img class="featurette-image img-fluid mx-auto" src="assets/img/hastane/doktorlar.png" alt="Uzman Doktorlar">
        </div>
      </div>
    </div>

          <hr class="featurette-divider">

    <!-- Hasta Yorumları -->
    <div class="container marketing mt-5">
      <h2 class="text-center">Hasta Yorumları</h2>
      <div class="row">
        <div class="col-lg-4 text-center animate-hover" data-aos="fade-up" data-aos-delay="100">
          <img class="rounded-circle mb-3" src="assets/img/patients/ahmet.png" alt="Ahmet Yılmaz" width="140" height="140">
          <blockquote class="blockquote">
            <p>"Hastanenizde aldığım hizmetten çok memnun kaldım. Doktorlar çok ilgiliydi."</p>
            <footer class="blockquote-footer">Ahmet Yılmaz</footer>
          </blockquote>
        </div>
        <div class="col-lg-4 text-center animate-hover" data-aos="fade-up" data-aos-delay="200">
          <img class="rounded-circle mb-3" src="assets/img/patients/ayse.png" alt="Ayşe Demir" width="140" height="140">
          <blockquote class="blockquote">
            <p>"Ameliyatım çok başarılı geçti. Teşekkürler!"</p>
            <footer class="blockquote-footer">Ayşe Demir</footer>
          </blockquote>
        </div>
        <div class="col-lg-4 text-center animate-hover" data-aos="fade-up" data-aos-delay="300">
          <img class="rounded-circle mb-3" src="assets/img/patients/mehmet.png" alt="Mehmet Kaya" width="140" height="140">
          <blockquote class="blockquote">
            <p>"Çocuğumun tedavisinde gösterilen özen için minnettarım."</p>
            <footer class="blockquote-footer">Mehmet Kaya</footer>
          </blockquote>
        </div>
      </div>
    </div>


  </main>

    <?php include("dashboard/footer.php"); ?>

