<?php
session_start();

// Kullanıcı giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

// Session timeout kontrolü (30 dakika)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_destroy();
    header("Location: ../login/login.php?timeout=1");
    exit();
}
$_SESSION['last_activity'] = time();

// Kullanıcı bilgilerini veritabanından kontrol et
require_once 'db_connect.php';
try {
    $stmt = $conn->prepare("SELECT * FROM personel WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        // Kullanıcı veritabanında bulunamazsa session'ı temizle ve login sayfasına yönlendir
        session_destroy();
        $_SESSION['error'] = "Oturum geçersiz! Lütfen tekrar giriş yapın.";
        header("Location: /login/login.php");
        exit();
    }
} catch(PDOException $e) {
    // Hata durumunda güvenli bir şekilde login sayfasına yönlendir
    session_destroy();
    $_SESSION['error'] = "Bir hata oluştu. Lütfen tekrar giriş yapın.";
    header("Location: /login/login.php");
    exit();
}
?> 