<?php
require_once("../config/db_connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['sifre'] ?? '';

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
            // Session'ı temizle ve yeni session başlat
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['isim'] . ' ' . $user['soyisim'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['last_activity'] = time();
            
            header("Location: ../dashboard/index.php");
            exit();
        } else {
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