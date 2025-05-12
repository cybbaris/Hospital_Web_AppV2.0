<?php
$servername = "db";  // Docker container adı
$username = "hospital_user";  // Docker Compose'da tanımlanan kullanıcı
$password = "hospital_pass";  // Docker Compose'da tanımlanan şifre
$dbname = "hospital";  // Docker Compose'da tanımlanan veritabanı adı

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Hata modunu ayarla
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Türkçe karakter sorununu çözmek için
    $conn->exec("SET NAMES 'utf8'");
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
    die();
}
?> 