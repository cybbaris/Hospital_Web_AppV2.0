<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="/hospital-app/src/assets/css/style.css">
</head>
<body>
    <?php include("header.php"); ?>

    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <img id="logo" src="../assets/img/logo.png"
                                            style="width: 185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">S.M.B. Sağlık Grubu</h4>
                                    </div>

                                    <?php
                                    if (isset($_SESSION['error'])) {
                                        echo '<div class="alert alert-danger" role="alert">';
                                        echo $_SESSION['error'];
                                        echo '</div>';
                                        unset($_SESSION['error']);
                                    }
                                    ?>

                                    <form method="POST" action="login_process.php">
                                        <p>Giriş Sayfası</p>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="form2Example11">Telefon veya Kullanıcı Adı:</label>
                                            <input type="email" id="form2Example11" name="email" class="form-control"
                                                placeholder="Email adresiniz" required />
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="form2Example22">Şifre:</label>
                                            <input type="password" id="form2Example22" name="sifre" class="form-control" required />
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button class="btn btn-primary btn-login" type="submit">Giriş Yap</button>
                                            <br><a class="text-muted" href="#!">Şifremi Unuttum</a>
                                            <br><a href="register.php" class="mb-0 me-2">Hesabınız yok mu?</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="welcome-text px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">Hastanemize Hoşgeldiniz</h4>
                                    <p class="small mb-0">Randevu almak ve randevu takibinizi yapmak, geçmiş randevularınızı görüntülemek için giriş yapınız.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include("../dashboard/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>