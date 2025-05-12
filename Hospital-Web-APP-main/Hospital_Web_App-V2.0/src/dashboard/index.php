<?php
require_once '../config/auth_check.php';

// Veritabanı bağlantısı (PDO ile güvenli)
$servername = "db";
$username = "hospital_user";
$password = "hospital_pass";
$dbname = "hospital";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8mb4"); // Türkçe karakter desteği
} catch(PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}

// Formdan veri alındığında kaydet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = $_POST['ad'] ?? '';
    $soyad = $_POST['soyad'] ?? '';
    $tc = $_POST['tc'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $sikayet = $_POST['sikayet'] ?? '';
    $bolum = $_POST['bolum'] ?? '';

    // Basit doğrulama
    if (empty($ad) || empty($soyad) || empty($tc) || empty($telefon) || empty($bolum)) {
        $error = "Lütfen tüm zorunlu alanları doldurun.";
    } else {
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
            $error = "Kayıt hatası: " . $e->getMessage();
        }
    }
}

// Arama terimini al
$arama = isset($_GET['arama']) ? trim($_GET['arama']) : '';
?>

<?php include("header.php"); ?>

<div class="container text-center">
    <div class="row">
        <div class="col">
            <h1 class="mt-5">HASTA KAYIT ALANI</h1>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" name="ad" placeholder="Mehmet" value="<?php echo isset($_POST['ad']) ? htmlspecialchars($_POST['ad']) : ''; ?>" required>
                    <label>Ad</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" name="soyad" placeholder="Yılmaz" value="<?php echo isset($_POST['soyad']) ? htmlspecialchars($_POST['soyad']) : ''; ?>" required>
                    <label>Soyad</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" name="tc" placeholder="12345678901" value="<?php echo isset($_POST['tc']) ? htmlspecialchars($_POST['tc']) : ''; ?>" required>
                    <label>Kimlik Numarası</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <input type="text" class="form-control" name="telefon" placeholder="0555-123-2144" value="<?php echo isset($_POST['telefon']) ? htmlspecialchars($_POST['telefon']) : ''; ?>" required>
                    <label>Telefon Numarası</label>
                </div>
                <div class="form-floating mt-3 mb-3">
                    <textarea class="form-control" name="sikayet" placeholder="Hastanın Şikayeti Nedir?" style="height: 100px"><?php echo isset($_POST['sikayet']) ? htmlspecialchars($_POST['sikayet']) : ''; ?></textarea>
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
                <p>Arama: "<?php echo htmlspecialchars($arama); ?>"</p>
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
                    echo "<p>$total kayıt bulundu.</p>";
                } catch(PDOException $e) {
                    echo "<p>Sonuç sayısı hatası: " . $e->getMessage() . "</p>";
                }
                ?>
                <a href="index.php" class="btn btn-outline-secondary btn-sm mb-3">Tümünü Göster</a>
            <?php endif; ?>
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
                        if ($arama) {
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
                                echo "<td>" . htmlspecialchars($row['ad']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['soyad']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['tc']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['telefon']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['bolum']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Kayıt bulunamadı.</td></tr>";
                        }
                    } catch(PDOException $e) {
                        echo "<tr><td colspan='6'>Veri çekme hatası: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>