<?php
require_once '../config/auth_check.php';
require_once '../config/db_connect.php';
require_once '../config/TCKimlikDogrulama.php';

// Formdan veri alındığında kaydet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST['ad'] ?? '';
    $soyad = $_POST['soyad'] ?? '';
    $tc = $_POST['tc'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $sikayet = $_POST['sikayet'] ?? '';
    $bolum = $_POST['bolum'] ?? '';

    // Gelişmiş doğrulama
    $errors = [];
    
    // Boş alan kontrolleri
    if (empty($ad)) {
        $errors[] = "Ad alanı boş bırakılamaz.";
    }
    if (empty($soyad)) {
        $errors[] = "Soyad alanı boş bırakılamaz.";
    }
    if (empty($tc)) {
        $errors[] = "TC Kimlik numarası boş bırakılamaz.";
    }
    if (empty($telefon)) {
        $errors[] = "Telefon numarası boş bırakılamaz.";
    }
    if (empty($bolum)) {
        $errors[] = "Bölüm seçimi yapılmalıdır.";
    }
    
    // TC Kimlik kontrolü
    if (!empty($tc) && !preg_match('/^[0-9]{11}$/', $tc)) {
        $errors[] = "TC Kimlik numarası 11 haneli olmalıdır.";
    } else if (!empty($tc)) {
        try {
            $tcDogrulama = new TCKimlikDogrulama();
            if (!$tcDogrulama->dogrula($tc)) {
                $errors[] = "Geçersiz TC kimlik numarası. Lütfen kontrol ediniz.";
            }
        } catch (Exception $e) {
            $errors[] = "TC Kimlik doğrulama hatası: " . $e->getMessage();
        }
    }
    
    // Telefon kontrolü
    if (!empty($telefon) && !preg_match('/^[0-9]{10,11}$/', $telefon)) {
        $errors[] = "Telefon numarası 10 veya 11 haneli olmalıdır.";
    }
    
    // İsim ve soyisim kontrolü
    if (!empty($ad) && !preg_match('/^[A-Za-zÇĞİÖŞÜçğıöşü\s]+$/', $ad)) {
        $errors[] = "İsim sadece harf ve boşluk içerebilir.";
    }
    if (!empty($soyad) && !preg_match('/^[A-Za-zÇĞİÖŞÜçğıöşü\s]+$/', $soyad)) {
        $errors[] = "Soyisim sadece harf ve boşluk içerebilir.";
    }

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO hastalar (ad, soyad, tc, telefon, sikayet, bolum) 
                    VALUES (:ad, :soyad, :tc, :telefon, :sikayet, :bolum)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':ad' => $ad,
                ':soyad' => $soyad,
                ':tc' => $tc,
                ':telefon' => $telefon,
                ':sikayet' => $sikayet,
                ':bolum' => $bolum
            ]);
            header("Location: index.php"); // Sayfayı yenile
            exit();
        } catch(PDOException $e) {
            $errors[] = "Kayıt hatası: " . $e->getMessage();
        }
    }
}

// Arama terimini al ve güvenli hale getir
$arama = isset($_GET['arama']) ? trim(strip_tags(htmlspecialchars($_GET['arama']))) : '';

// Arama teriminin güvenli olup olmadığını kontrol et
function isSafeSearch($search) {
    // Sadece harf, rakam, Türkçe karakterler ve boşluk içerebilir
    return preg_match('/^[A-Za-zÇĞİÖŞÜçğıöşü0-9\s]+$/', $search);
}

// Arama terimi güvenli değilse boş string olarak ayarla
if (!isSafeSearch($arama)) {
    $arama = '';
}
?>

<?php include("header.php"); ?>

<div class="container text-center">
    <div class="row">
        <div class="col">
            <h1 class="mt-5">HASTA KAYIT ALANI</h1>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo $error; ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="hastaForm">
                <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" name="ad" id="ad" placeholder="Mehmet" 
                           value="<?php echo isset($_POST['ad']) ? $_POST['ad'] : ''; ?>" 
                           pattern="[A-Za-zÇĞİÖŞÜçğıöşü\s]+" 
                           title="Sadece harf ve boşluk kullanabilirsiniz"
                           required>
                    <label>Ad</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" name="soyad" id="soyad" placeholder="Yılmaz" 
                           value="<?php echo isset($_POST['soyad']) ? $_POST['soyad'] : ''; ?>" 
                           pattern="[A-Za-zÇĞİÖŞÜçğıöşü\s]+" 
                           title="Sadece harf ve boşluk kullanabilirsiniz"
                           required>
                    <label>Soyad</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" name="tc" id="tc" placeholder="12345678901" 
                           value="<?php echo isset($_POST['tc']) ? $_POST['tc'] : ''; ?>" 
                           pattern="[0-9]{11}" maxlength="11"
                           title="11 haneli TC kimlik numaranızı giriniz"
                           required>
                    <label>Kimlik Numarası</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" name="telefon" id="telefon" placeholder="0555-123-2144" 
                           value="<?php echo isset($_POST['telefon']) ? $_POST['telefon'] : ''; ?>" 
                           pattern="[0-9]{10,11}" maxlength="11"
                           title="10 veya 11 haneli telefon numaranızı giriniz"
                           required>
                    <label>Telefon Numarası</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <textarea class="form-control" name="sikayet" placeholder="Hastanın Şikayeti Nedir?" style="height: 100px"><?php echo isset($_POST['sikayet']) ? $_POST['sikayet'] : ''; ?></textarea>
                    <label>Hastanın Şikayetini Yazınız...</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <select class="form-select" name="bolum" required>
                        <option selected disabled>Geldiği Bölümü Seçiniz</option>
                        <option value="Kardiyoloji" <?php echo (isset($_POST['bolum']) && $_POST['bolum'] == 'Kardiyoloji') ? 'selected' : ''; ?>>Kardiyoloji</option>
                        <option value="Psikiyatri" <?php echo (isset($_POST['bolum']) && $_POST['bolum'] == 'Psikiyatri') ? 'selected' : ''; ?>>Psikiyatri</option>
                        <option value="Genel Cerrahi" <?php echo (isset($_POST['bolum']) && $_POST['bolum'] == 'Genel Cerrahi') ? 'selected' : ''; ?>>Genel Cerrahi</option>
                        <option value="Acil" <?php echo (isset($_POST['bolum']) && $_POST['bolum'] == 'Acil') ? 'selected' : ''; ?>>Acil</option>
                    </select>
                    <label>Nereye Geldi?</label>
                </div>
                <button type="submit" class="btn btn-outline-success">Gönder</button>
            </form>
        </div>

        <div class="col">
            <h1 class="mt-5">HASTALAR</h1>
            <?php if ($arama): ?>
                <p>Arama: "<?php echo $arama; ?>"</p>
                <?php
                try {
                    $sql = "SELECT COUNT(*) as total FROM hastalar";
                    $params = [];
                    if ($arama) {
                        $sql .= " WHERE ad LIKE :arama OR soyad LIKE :arama OR tc = :tc OR telefon = :telefon";
                        $params[':arama'] = '%' . $arama . '%';
                        $params[':tc'] = $arama;
                        $params[':telefon'] = $arama;
                    }
                    $stmt = $conn->prepare($sql);
                    $stmt->execute($params);
                    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                    echo "<p>" . $total . " kayıt bulundu.</p>";
                } catch(PDOException $e) {
                    echo "<p>Arama yapılırken bir hata oluştu.</p>";
                }
                ?>
                <a href="index.php" class="btn btn-outline-secondary btn-sm mb-3">Tümünü Göster</a>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Hasta aramak için üst menüdeki arama kutusunu kullanabilirsiniz.
                </div>
            <?php endif; ?>

            <?php if ($arama): ?>
            <table class="table mt-10">
                <thead class="mt-10">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">İsim</th>
                        <th scope="col">Soyisim</th>
                        <th scope="col">Tc Kimlik</th>
                        <th scope="col">Telefon</th>
                        <th scope="col">Geldiği Yer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        // Arama sorgusu
                        $sql = "SELECT * FROM hastalar";
                        $params = [];
                        if ($arama && isSafeSearch($arama)) {
                            $sql .= " WHERE ad LIKE :arama OR soyad LIKE :arama OR tc = :tc OR telefon = :telefon";
                            $params[':arama'] = '%' . $arama . '%';
                            $params[':tc'] = $arama;
                            $params[':telefon'] = $arama;
                        }
                        $sql .= " ORDER BY created_at DESC";
                        
                        $stmt = $conn->prepare($sql);
                        $stmt->execute($params);
                        
                        $counter = 1;
                        if ($stmt->rowCount() > 0) {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $counter++ . "</th>";
                                echo "<td>" . $row['ad'] . "</td>";
                                echo "<td>" . $row['soyad'] . "</td>";
                                echo "<td>" . $row['tc'] . "</td>";
                                echo "<td>" . $row['telefon'] . "</td>";
                                echo "<td>" . $row['bolum'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Kayıt bulunamadı.</td></tr>";
                        }
                    } catch(PDOException $e) {
                        echo "<tr><td colspan='6'>Arama yapılırken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function validateInput(input, type) {
    const value = input.value;
    let isValid = true;
    let errorMessage = '';

    switch(type) {
        case 'ad':
        case 'soyad':
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
    }

    if (!isValid && value !== '') {
        input.setCustomValidity(errorMessage);
    } else {
        input.setCustomValidity('');
    }
}

// Form gönderilmeden önce son kontrol
document.getElementById('hastaForm').addEventListener('submit', function(e) {
    const inputs = this.getElementsByTagName('input');
    let isValid = true;

    for (let input of inputs) {
        if (input.id) {
            validateInput(input, input.id);
            if (!input.checkValidity()) {
                isValid = false;
            }
        }
    }

    if (!isValid) {
        e.preventDefault();
        alert('Lütfen tüm alanları doğru şekilde doldurunuz.');
    }
});

// Input alanlarına event listener ekle
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            validateInput(this, this.id);
        });
    });
});
</script>

<?php include("footer.php"); ?>