<?php
require_once '../config/auth_check.php';
require_once '../config/db_connect.php';

// Oturum açmış kullanıcının bilgilerini al
$kullanici_adi = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Misafir';
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>Hospital</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Sol taraf -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <span class="nav-link">
            <i class="fas fa-user-circle me-2"></i>
            <?php echo htmlspecialchars($kullanici_adi); ?>
          </span>
        </li>
      </ul>

      <!-- Sağ taraf -->
      <ul class="navbar-nav ms-auto">
        <form class="d-flex me-3" role="search" method="GET" action="index.php">
          <input class="form-control me-2" type="search" name="arama" 
                 placeholder="Ad, Soyad, TC veya Telefon Ara" 
                 aria-label="Search" 
                 value="<?php echo isset($_GET['arama']) ? htmlspecialchars($_GET['arama']) : ''; ?>"
                 pattern="[A-Za-zÇĞİÖŞÜçğıöşü0-9\s]+"
                 title="Sadece harf, rakam ve boşluk kullanabilirsiniz"
                 maxlength="50">
          <button class="btn btn-outline-success" type="submit">Ara</button>
        </form>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../assets/icons/user.png" alt="User Icon" width="32" height="32" class="user-icon">
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item logout" href="../login/login.php"><i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
  
  <script>
    // Sayfa yüklendiğinde çalışacak kod
    $(document).ready(function() {
      // Dropdown toggle butonunu seç
      const dropdownToggle = document.querySelector('#userDropdown');
      
      // Bootstrap dropdown nesnesini oluştur
      const dropdown = new bootstrap.Dropdown(dropdownToggle, {
        offset: [0, 10],
        boundary: 'viewport'
      });

      // Dropdown menü öğelerine tıklama olayı ekle
      $('.dropdown-item').on('click', function(e) {
        if ($(this).hasClass('logout')) {
          e.preventDefault();
          if (confirm('Çıkış yapmak istediğinizden emin misiniz?')) {
            window.location.href = $(this).attr('href');
          }
        }
      });

      // Dropdown toggle butonuna tıklama olayı ekle
      $('#userDropdown').on('click', function(e) {
        e.preventDefault();
        dropdown.toggle();
      });
    });
  </script>
</body>
</html>