<?php 
session_start();
include("header.php"); ?>

<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">
                <div class="text-center">
                  <img id="logo" src="../assets/img/logo.png" style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">TAKIM5 HASTANE</h4>
                </div>

                <?php
                if (isset($_SESSION['register_errors'])) {
                    echo '<div class="alert alert-danger" role="alert">';
                    foreach ($_SESSION['register_errors'] as $error) {
                        echo $error . '<br>';
                    }
                    echo '</div>';
                    unset($_SESSION['register_errors']);
                }
                if (isset($_SESSION['register_success'])) {
                    echo '<div class="alert alert-success" role="alert">';
                    echo $_SESSION['register_success'];
                    echo '</div>';
                    unset($_SESSION['register_success']);
                }
                // Form verilerini session'dan al ve temizle
                $form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
                unset($_SESSION['form_data']);
                ?>

                <form method="POST" action="register_process.php" id="registerForm">
                  <p>Kayıt Sayfası</p>
                  <div class="row">
                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <label class="form-label" for="isim">İsim:</label>
                        <input type="text" id="isim" name="isim" class="form-control" required 
                               pattern="[A-Za-zÇĞİÖŞÜçğıöşü\s]+" 
                               title="Sadece harf ve boşluk kullanabilirsiniz"
                               value="<?php echo isset($form_data['isim']) ? htmlspecialchars($form_data['isim']) : ''; ?>"
                               oninput="validateInput(this, 'isim')">
                        <small class="text-muted">Sadece harf ve boşluk kullanabilirsiniz</small>
                      </div>
                    </div>
                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <label class="form-label" for="soyisim">Soyisim:</label>
                        <input type="text" id="soyisim" name="soyisim" class="form-control" required
                               pattern="[A-Za-zÇĞİÖŞÜçğıöşü\s]+"
                               title="Sadece harf ve boşluk kullanabilirsiniz"
                               value="<?php echo isset($form_data['soyisim']) ? htmlspecialchars($form_data['soyisim']) : ''; ?>"
                               oninput="validateInput(this, 'soyisim')">
                        <small class="text-muted">Sadece harf ve boşluk kullanabilirsiniz</small>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <label class="form-label" for="tc">TC Kimlik No:</label>
                        <input type="text" id="tc" name="tc" class="form-control" required
                               pattern="[0-9]{11}" maxlength="11"
                               title="11 haneli TC kimlik numaranızı giriniz"
                               value="<?php echo isset($form_data['tc']) ? htmlspecialchars($form_data['tc']) : ''; ?>"
                               oninput="validateInput(this, 'tc')">
                        <small class="text-muted">11 haneli TC kimlik numaranızı giriniz</small>
                      </div>
                    </div>
                    <div class="col-md-6 mb-4">
                      <div class="form-outline">
                        <label class="form-label" for="telefon">Telefon Numarası:</label>
                        <input type="tel" id="telefon" name="telefon" class="form-control" required
                               pattern="[0-9]{10,11}" maxlength="11"
                               title="10 veya 11 haneli telefon numaranızı giriniz"
                               value="<?php echo isset($form_data['telefon']) ? htmlspecialchars($form_data['telefon']) : ''; ?>"
                               oninput="validateInput(this, 'telefon')">
                        <small class="text-muted">10 veya 11 haneli telefon numaranızı giriniz</small>
                      </div>
                    </div>
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="email">E-Posta Adresi:</label>
                    <input type="email" id="email" name="email" class="form-control" required
                           value="<?php echo isset($form_data['email']) ? htmlspecialchars($form_data['email']) : ''; ?>"
                           oninput="validateInput(this, 'email')">
                    <small class="text-muted">Geçerli bir e-posta adresi giriniz</small>
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="sifre">Şifre:</label>
                    <input type="password" id="sifre" name="sifre" class="form-control" required
                           minlength="6" maxlength="50"
                           oninput="validateInput(this, 'sifre')">
                    <small class="text-muted">En az 6 karakter olmalıdır</small>
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-login" type="submit">
                      Kayıt Ol
                    </button>
                    <br><a class="text-muted" href="login.php">Zaten Hesabım Var</a>
                  </div>
                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
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

<script>
function validateInput(input, type) {
    const value = input.value;
    let isValid = true;
    let errorMessage = '';

    switch(type) {
        case 'isim':
        case 'soyisim':
            isValid = /^[A-Za-zÇĞİÖŞÜçğıöşü\s]+$/.test(value);
            errorMessage = 'Sadece harf ve boşluk kullanabilirsiniz';
            break;
        case 'tc':
            isValid = /^[0-9]{11}$/.test(value);
            errorMessage = '11 haneli TC kimlik numaranızı giriniz';
            break;
        case 'telefon':
            isValid = /^[0-9]{10,11}$/.test(value);
            errorMessage = '10 veya 11 haneli telefon numaranızı giriniz';
            break;
        case 'email':
            isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            errorMessage = 'Geçerli bir e-posta adresi giriniz';
            break;
        case 'sifre':
            isValid = value.length >= 6;
            errorMessage = 'Şifre en az 6 karakter olmalıdır';
            break;
    }

    if (!isValid && value !== '') {
        input.setCustomValidity(errorMessage);
    } else {
        input.setCustomValidity('');
    }
}

// Form gönderilmeden önce son kontrol
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const inputs = this.getElementsByTagName('input');
    let isValid = true;

    for (let input of inputs) {
        validateInput(input, input.id);
        if (!input.checkValidity()) {
            isValid = false;
        }
    }

    if (!isValid) {
        e.preventDefault();
        alert('Lütfen tüm alanları doğru şekilde doldurunuz.');
    }
});
</script>

<?php include("../dashboard/footer.php"); ?>