<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/assets/css/main-style.css">

  <title>Hospital</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mt-3">
    <div class="container-fluid">
      <!-- Logo -->
      <a class="navbar-brand" href="#">
        <img src="assets/img/logo.png" id="logo" alt="Logo">
      </a>

      <!-- Toggler Button -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar İçeriği -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <!-- Orta Kısım: Menü Öğeleri -->
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <!-- Hizmet Binalarımız Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="hizmetBinalarimiz" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Hizmet Binalarımız
            </a>
            <ul class="dropdown-menu" aria-labelledby="hizmetBinalarimiz">
              <li><a class="dropdown-item" href="#">Genel Hastane Binası</a></li>
            </ul>
          </li>

          <!-- Tıbbi Birimler Dropdown -->
          <li class="nav-item">
            <a class="nav-link" href="#" id="tibbiBirimler" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Tıbbi Birimler
            </a>

       

          <!-- Sağlık Rehberi -->
          <li class="nav-item">
            <a class="nav-link" href="#">Sağlık Rehberi</a>
          </li>

          <!-- Kurumsal -->
          <li class="nav-item">
            <a class="nav-link" href="#">Kurumsal</a>
          </li>
        </ul>

        <!-- Sağ Taraf: Kullanıcı İkonu -->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="login/login.php">
              <img src="assets/icons/user.svg" id="user" alt="User Icon">
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
