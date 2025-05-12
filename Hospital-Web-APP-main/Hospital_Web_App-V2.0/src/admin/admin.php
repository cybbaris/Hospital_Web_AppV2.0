<?php
session_start();
require_once 'hospital_db.php';

// Veritabanı bağlantısı
$servername = "db";
$username = "hospital_user";
$password = "hospital_pass";
$dbname = "hospital";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8mb4");
} catch(PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}

$page_title = "Hasta Yönetim Paneli";
ob_start();
?>

<?php include("header.php"); ?>

<div class="container">
    <h2 class="text-center mt-5">Hasta Yönetim Paneli</h2>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>İsim</th>
                <th>Soyisim</th>
                <th>TC Kimlik</th>
                <th>Telefon</th>
                <th>Şikayet</th>
                <th>Bölüm</th>
                <th>Kayıt Tarihi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $sql = "SELECT * FROM hastalar ORDER BY created_at DESC";
                $stmt = $conn->query($sql);
                $counter = 1;
                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['ad']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['soyad']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tc']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['telefon']) . "</td>";
                        echo "<td>" . (empty($row['sikayet']) ? '-' : htmlspecialchars($row['sikayet'])) . "</td>";
                        echo "<td>" . htmlspecialchars($row['bolum']) . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Kayıt bulunamadı.</td></tr>";
                }
            } catch(PDOException $e) {
                echo "<tr><td colspan='8'>Veri çekme hatası: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<?php
$content = ob_get_clean();
include 'template.php';
?>