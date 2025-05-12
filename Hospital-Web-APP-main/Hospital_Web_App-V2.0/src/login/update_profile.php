<?php
require_once("../config/db_connect.php");
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['missing_fields'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $errors = [];
    $updates = [];
    $params = [':id' => $user_id];

    // İsim kontrolü
    if (isset($_POST['isim'])) {
        $isim = trim($_POST['isim']);
        if (empty($isim)) {
            $errors[] = "İsim alanı boş bırakılamaz";
        } elseif (!preg_match("/^[A-Za-zÇĞİÖŞÜçğıöşü\s]+$/u", $isim)) {
            $errors[] = "İsim sadece harf ve boşluk içerebilir";
        } elseif (strlen($isim) > 255) {
            $errors[] = "İsim çok uzun";
        } else {
            $updates[] = "isim = :isim";
            $params[':isim'] = $isim;
        }
    }

    // Soyisim kontrolü
    if (isset($_POST['soyisim'])) {
        $soyisim = trim($_POST['soyisim']);
        if (empty($soyisim)) {
            $errors[] = "Soyisim alanı boş bırakılamaz";
        } elseif (!preg_match("/^[A-Za-zÇĞİÖŞÜçğıöşü\s]+$/u", $soyisim)) {
            $errors[] = "Soyisim sadece harf ve boşluk içerebilir";
        } elseif (strlen($soyisim) > 255) {
            $errors[] = "Soyisim çok uzun";
        } else {
            $updates[] = "soyisim = :soyisim";
            $params[':soyisim'] = $soyisim;
        }
    }

    // TC kontrolü
    if (isset($_POST['tc'])) {
        $tc = trim($_POST['tc']);
        if (empty($tc)) {
            $errors[] = "TC kimlik numarası boş bırakılamaz";
        } elseif (!preg_match("/^[0-9]{11}$/", $tc)) {
            $errors[] = "Geçerli bir TC kimlik numarası giriniz";
        } else {
            // TC benzersizlik kontrolü
            $stmt = $conn->prepare("SELECT COUNT(*) FROM personel WHERE tc = ? AND id != ?");
            $stmt->execute([$tc, $user_id]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Bu TC kimlik numarası başka bir kullanıcı tarafından kullanılıyor";
            } else {
                $updates[] = "tc = :tc";
                $params[':tc'] = $tc;
            }
        }
    }

    // Telefon kontrolü
    if (isset($_POST['telefon'])) {
        $telefon = trim($_POST['telefon']);
        if (empty($telefon)) {
            $errors[] = "Telefon numarası boş bırakılamaz";
        } elseif (!preg_match("/^[0-9]{10,11}$/", $telefon)) {
            $errors[] = "Geçerli bir telefon numarası giriniz";
        } else {
            $updates[] = "telefon = :telefon";
            $params[':telefon'] = $telefon;
        }
    }

    if (empty($errors) && !empty($updates)) {
        try {
            $sql = "UPDATE personel SET " . implode(", ", $updates) . " WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);

            // Session'ı güncelle
            if (isset($isim)) $_SESSION['user_name'] = $isim . ' ' . (isset($soyisim) ? $soyisim : '');
            if (isset($tc)) $_SESSION['user_tc'] = $tc;
            if (isset($telefon)) $_SESSION['user_phone'] = $telefon;

            // Başarılı mesajı
            $_SESSION['success_message'] = "Profil bilgileriniz başarıyla güncellendi";
            
            // Eksik alanları session'dan temizle
            unset($_SESSION['missing_fields']);
            
            header("Location: ../dashboard/index.php");
            exit();
        } catch(PDOException $e) {
            $errors[] = "Güncelleme sırasında bir hata oluştu: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['update_errors'] = $errors;
        header("Location: complete_profile.php");
        exit();
    }
}

// POST değilse login sayfasına yönlendir
header("Location: login.php");
exit();
?>