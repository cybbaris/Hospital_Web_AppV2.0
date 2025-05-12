<?php
$vt_host = "hospital_db"; // Docker Compose'daki servis adı
$vt_kull = "root";
$vt_sifre = "rootpass"; // docker-compose.yml'deki MYSQL_ROOT_PASSWORD
$vt_adi = "hospital";

$baglanti = new mysqli($vt_host, $vt_kull, $vt_sifre, $vt_adi);

if ($baglanti->connect_error) {
    die("Bağlantı hatası: " . $baglanti->connect_error);
}

$baglanti->set_charset("utf8mb4"); // Daha modern karakter seti
?>