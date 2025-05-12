<?php
// Hata raporlamasını kapat
error_reporting(0);
ini_set('display_errors', 0);

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
    
    // Bağlantı başarılı
    return $conn;
} catch(PDOException $e) {
    // Hata logla
    error_log("Veritabanı bağlantı hatası: " . $e->getMessage());
    
    // Kullanıcıya genel hata mesajı göster
    die("Veritabanına bağlanırken bir hata oluştu. Lütfen daha sonra tekrar deneyin.");
}

// SQL injection koruması için prepared statements kullanımını zorunlu kıl
function secureQuery($db, $sql, $params = []) {
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch(PDOException $e) {
        error_log("SQL hatası: " . $e->getMessage());
        throw new Exception("Sorgu işlenirken bir hata oluştu.");
    }
}

// XSS koruması için çıktı temizleme
function sanitizeOutput($data) {
    if (is_array($data)) {
        return array_map('sanitizeOutput', $data);
    }
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Veritabanı bağlantısını kapat
function closeConnection($db) {
    $db = null;
}
?> 