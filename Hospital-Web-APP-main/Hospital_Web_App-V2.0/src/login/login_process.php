<?php
require_once("../config/db_connect.php");
session_start();

// Session güvenliği
session_regenerate_id(true); // Session ID'yi yenile
ini_set('session.cookie_httponly', 1); // HTTP Only flag
ini_set('session.cookie_secure', 1); // Secure flag

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['sifre'] ?? '';

    // Brute Force koruması
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt'] = time();
    }

    // 5 dakika içinde 5'ten fazla başarısız deneme varsa engelle
    if ($_SESSION['login_attempts'] >= 5) {
        if (time() - $_SESSION['last_attempt'] < 300) { // 300 saniye = 5 dakika
            $_SESSION['error'] = "Çok fazla başarısız deneme. Lütfen 5 dakika bekleyin.";
            header("Location: login.php");
            exit();
        } else {
            // 5 dakika geçmişse sayacı sıfırla
            $_SESSION['login_attempts'] = 0;
        }
    }

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email ve şifre alanları boş bırakılamaz!";
        header("Location: login.php");
        exit();
    }

    try {
        $stmt = $conn->prepare("SELECT * FROM personel WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $hashed_input = hash('sha256', $password);
        
        if ($user && $hashed_input === $user['sifre']) {
            // Başarılı giriş - sayaçları sıfırla
            $_SESSION['login_attempts'] = 0;
            
            // Session'ı temizle ve yeni session başlat
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['isim'] . ' ' . $user['soyisim'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['last_activity'] = time();
            
            header("Location: ../dashboard/index.php");
            exit();
        } else {
            // Başarısız giriş
            $_SESSION['login_attempts'] = 5; // Direkt 5 yap
            $_SESSION['last_attempt'] = time();
            
            $_SESSION['error'] = "Email veya şifre hatalı!";
            header("Location: login.php");
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Bir hata oluştu. Lütfen tekrar deneyin.";
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?> 