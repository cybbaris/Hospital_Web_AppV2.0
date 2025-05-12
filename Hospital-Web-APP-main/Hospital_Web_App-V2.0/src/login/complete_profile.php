<?php
include("../dashboard/header.php");
session_start();

// Oturum kontrolü
if (!isset($_SESSION['user_id']) || !isset($_SESSION['missing_fields'])) {
    header("Location: login.php");
    exit();
}

$missing_fields = $_SESSION['missing_fields'];
?>

<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-12">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                    <img id="logo" src="../assets/img/logo.png" style="width: 185px;" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">TAKIM5 HASTANE</h4>
                                </div>

                                <form method="POST" action="update_profile.php">
                                    <p>Eksik Bilgileri Tamamlayın</p>
                                    
                                    <?php if (in_array('isim', $missing_fields)): ?>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="isim">İsim:</label>
                                        <input type="text" id="isim" name="isim" class="form-control" required 
                                               pattern="[A-Za-zÇĞİÖŞÜçğıöşü\s]+" 
                                               title="Sadece harf ve boşluk kullanabilirsiniz">
                                    </div>
                                    <?php endif; ?>

                                    <?php if (in_array('soyisim', $missing_fields)): ?>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="soyisim">Soyisim:</label>
                                        <input type="text" id="soyisim" name="soyisim" class="form-control" required
                                               pattern="[A-Za-zÇĞİÖŞÜçğıöşü\s]+"
                                               title="Sadece harf ve boşluk kullanabilirsiniz">
                                    </div>
                                    <?php endif; ?>

                                    <?php if (in_array('tc', $missing_fields)): ?>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="tc">TC Kimlik No:</label>
                                        <input type="text" id="tc" name="tc" class="form-control" required
                                               pattern="[0-9]{11}" maxlength="11"
                                               title="11 haneli TC kimlik numaranızı giriniz">
                                    </div>
                                    <?php endif; ?>

                                    <?php if (in_array('telefon', $missing_fields)): ?>
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="telefon">Telefon:</label>
                                        <input type="tel" id="telefon" name="telefon" class="form-control" required
                                               pattern="[0-9]{10,11}" maxlength="11"
                                               title="10 veya 11 haneli telefon numaranızı giriniz">
                                    </div>
                                    <?php endif; ?>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">
                                            Bilgileri Güncelle
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("../dashboard/footer.php"); ?> 