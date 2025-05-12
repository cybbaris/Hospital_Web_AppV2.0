<?php
require_once("../config/db_connect.php");
require_once("../config/TCKimlikDogrulama.php");
session_start();

// Hata raporlamayı aktif et
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Güvenlik ayarları
ini_set('max_input_vars', 100); // Maksimum input sayısı
ini_set('max_input_time', 60); // Input işleme süresi sınırı
ini_set('memory_limit', '128M'); // Bellek limiti

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // POST veri boyutu kontrolü
        if (empty($_POST) || count($_POST) > 10) {
            throw new Exception("Geçersiz form verisi");
        }

        // Form verilerini al ve temizle
        $isim = trim($_POST['isim'] ?? '');
        $soyisim = trim($_POST['soyisim'] ?? '');
        $tc = trim($_POST['tc'] ?? '');
        $telefon = trim($_POST['telefon'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $sifre = trim($_POST['sifre'] ?? '');

        // Maksimum uzunluk kontrolü
        $max_lengths = [
            'isim' => 50,
            'soyisim' => 50,
            'tc' => 11,
            'telefon' => 11,
            'email' => 100,
            'sifre' => 50
        ];

        foreach ($max_lengths as $field => $max_length) {
            if (strlen($$field) > $max_length) {
                throw new Exception("$field alanı çok uzun");
            }
        }

        // Özel karakter kontrolü  (Web sayfasına zararlı kod enjekte edilmesini önler)
        if (preg_match('/[<>{}[\]\\\/]/', $isim) || preg_match('/[<>{}[\]\\\/]/', $soyisim)) {
            throw new Exception("İsim ve soyisimde özel karakterler kullanılamaz");
        }

        // Basit doğrulama
        $errors = [];
        
        // İsim kontrolü
        if (empty($isim)) {
            $errors[] = "İsim alanı boş bırakılamaz";
        } elseif (!preg_match("/^[A-Za-zÇĞİÖŞÜçğıöşü\s]+$/u", $isim)) {
            $errors[] = "İsim sadece harf ve boşluk içerebilir";
        }

        // Soyisim kontrolü
        if (empty($soyisim)) {
            $errors[] = "Soyisim alanı boş bırakılamaz";
        } elseif (!preg_match("/^[A-Za-zÇĞİÖŞÜçğıöşü\s]+$/u", $soyisim)) {
            $errors[] = "Soyisim sadece harf ve boşluk içerebilir";
        }

        // TC kontrolü
        if (empty($tc)) {
            $errors[] = "TC kimlik numarası boş bırakılamaz";
        } elseif (!preg_match("/^[0-9]{11}$/", $tc)) {
            $errors[] = "Geçerli bir TC kimlik numarası giriniz";
        }

        // Telefon kontrolü
        if (empty($telefon)) {
            $errors[] = "Telefon numarası boş bırakılamaz";
        } elseif (!preg_match("/^[0-9]{10,11}$/", $telefon)) {
            $errors[] = "Geçerli bir telefon numarası giriniz";
        }

        // Email kontrolü
        if (empty($email)) {
            $errors[] = "Email alanı boş bırakılamaz";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Geçerli bir email adresi giriniz";
        }

        // Şifre kontrolü
        if (empty($sifre)) {
            $errors[] = "Şifre alanı boş bırakılamaz";
        } elseif (strlen($sifre) < 6) {
            $errors[] = "Şifre en az 6 karakter olmalıdır";
        }

        // Email benzersizlik kontrolü
        if (empty($errors)) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM personel WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Bu email adresi zaten kayıtlı";
            }
        }

        // TC benzersizlik kontrolü
        if (empty($errors)) {
            $stmt = $conn->prepare("SELECT COUNT(*) FROM personel WHERE tc = ?");
            $stmt->execute([$tc]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Bu TC kimlik numarası zaten kayıtlı";
            }
        }

        // TC Kimlik Doğrulama
        if (empty($errors)) {
            try {
                $tcDogrulama = new TCKimlikDogrulama();
                $sonuc = $tcDogrulama->dogrula($tc);
                
                if (!$sonuc) {
                    $errors[] = "Geçersiz TC kimlik numarası. Lütfen kontrol ediniz.";
                }
            } catch (Exception $e) {
                $errors[] = "TC Kimlik doğrulama servisi şu anda kullanılamıyor. Lütfen daha sonra tekrar deneyiniz.";
                error_log("TC Doğrulama Hatası: " . $e->getMessage());
            }
        }

        if (empty($errors)) {
            try {
                // Şifreyi SHA256 ile hashle
                $hashed_password = hash('sha256', $sifre);

                // Kullanıcıyı veritabanına ekle
                $sql = "INSERT INTO personel (isim, soyisim, tc, telefon, email, sifre) 
                        VALUES (:isim, :soyisim, :tc, :telefon, :email, :sifre)";
                
                $stmt = $conn->prepare($sql);
                $result = $stmt->execute([
                    ':isim' => $isim,
                    ':soyisim' => $soyisim,
                    ':tc' => $tc,
                    ':telefon' => $telefon,
                    ':email' => $email,
                    ':sifre' => $hashed_password
                ]);

                if ($result) {
                    // Session'daki form verilerini temizle
                    unset($_SESSION['form_data']);
                    
                    // Başarılı kayıt mesajı
                    $_SESSION['register_success'] = "Kayıt işlemi başarıyla tamamlandı! Şimdi giriş yapabilirsiniz.";
                    header("Location: login.php");
                    exit();
                } else {
                    throw new Exception("Veritabanına kayıt eklenemedi.");
                }

            } catch(PDOException $e) {
                error_log("Veritabanı Hatası: " . $e->getMessage());
                $errors[] = "Kayıt işlemi sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            // Form verilerini session'da sakla
            $_SESSION['form_data'] = [
                'isim' => $isim,
                'soyisim' => $soyisim,
                'tc' => $tc,
                'telefon' => $telefon,
                'email' => $email
            ];
            header("Location: register.php");
            exit();
        }

    } catch (Exception $e) {
        error_log("Genel Hata: " . $e->getMessage());
        $_SESSION['register_errors'] = ["Beklenmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyiniz."];
        header("Location: register.php");
        exit();
    }
} else {
    // POST değilse ana sayfaya yönlendir
    header("Location: register.php");
    exit();
}
?> 