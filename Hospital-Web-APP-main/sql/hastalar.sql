-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: db
-- Üretim Zamanı: 12 May 2025, 19:24:34
-- Sunucu sürümü: 8.0.42
-- PHP Sürümü: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `hospital`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hastalar`
--

CREATE TABLE `hastalar` (
  `id` int NOT NULL,
  `ad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soyad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tc` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefon` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sikayet` text COLLATE utf8mb4_unicode_ci,
  `bolum` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `hastalar`
--

INSERT INTO `hastalar` (`id`, `ad`, `soyad`, `tc`, `telefon`, `sikayet`, `bolum`, `created_at`) VALUES
(1, 'Mehmet', 'Mermer', '11111111111', '05333760843', 'sss', 'Kardiyoloji', '2025-05-12 19:10:18');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `hastalar`
--
ALTER TABLE `hastalar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tc` (`tc`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `hastalar`
--
ALTER TABLE `hastalar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
