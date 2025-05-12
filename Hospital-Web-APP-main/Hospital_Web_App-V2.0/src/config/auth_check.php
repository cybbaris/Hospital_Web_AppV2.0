<?php
session_start();

// Session'ın geçerliliğini kontrol et
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id']) || !isset($_SESSION['last_activity'])) {
    session_destroy();
    $_SESSION['error'] = "Bu sayfaya erişmek için giriş yapmalısınız!";
    header("Location: /login/login.php");
    exit();
}

// Session timeout kontrolü (30 dakika)
$timeout = 30 * 60; // 30 dakika
if (time() - $_SESSION['last_activity'] > $timeout) {
    session_destroy();
    $_SESSION['error'] = "Oturumunuz zaman aşımına uğradı. Lütfen tekrar giriş yapın.";
    header("Location: /login/login.php");
    exit();
}

// Son aktivite zamanını güncelle
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