<?php
require_once '../config/auth_check.php';
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
    integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/hospital-app/src/assets/css/style.css">

  <title>Hospital</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Sol taraf -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../index.php">HASTANE</a>
        </li>
      </ul>

      <!-- Sağ taraf -->
      <ul class="navbar-nav">
        <form class="d-flex" role="search" method="GET" action="index.php">
          <input class="form-control me-2" type="search" name="arama" placeholder="Ad, Soyad, TC veya Telefon Ara" aria-label="Search" value="<?php echo isset($_GET['arama']) ? htmlspecialchars($_GET['arama']) : ''; ?>">
          <button class="btn btn-outline-success" type="submit">Ara</button>
        </form>
        <li class="nav-item">
          <a class="nav-link" href="/hospital-app/login/login.php">
            <img src="../assets/icons/user.svg" alt="User Icon" width="24" height="24">
          </a>
        </li>
      </ul>
    </div>
  </nav>