<?php
class TCKimlikDogrulama {
    public function dogrula($tcno) {
        try {
            // TC Kimlik numarası algoritma kontrolü
            if (!$this->tcKimlikKontrol($tcno)) {
                return false;
            }

            // TC Kimlik numarası format kontrolü
            if (!preg_match('/^[1-9][0-9]{10}$/', $tcno)) {
                return false;
            }

            return true;
        } catch (Exception $e) {
            throw new Exception("Doğrulama hatası: " . $e->getMessage());
        }
    }

    private function tcKimlikKontrol($tcno) {
        // TC Kimlik numarası 11 haneli olmalı
        if (strlen($tcno) != 11) {
            return false;
        }

        // İlk hane 0 olamaz
        if ($tcno[0] == '0') {
            return false;
        }

        // 1, 3, 5, 7, 9. hanelerin toplamının 7 katından, 2, 4, 6, 8. hanelerin toplamı çıkartıldığında,
        // elde edilen sonucun 10'a bölümünden kalan, yani Mod10'u bize 10. haneyi verir.
        $tek = 0;
        $cift = 0;
        for ($i = 0; $i < 9; $i++) {
            if ($i % 2 == 0) {
                $tek += intval($tcno[$i]);
            } else {
                $cift += intval($tcno[$i]);
            }
        }
        $digit10 = (($tek * 7) - $cift) % 10;
        if ($digit10 != intval($tcno[9])) {
            return false;
        }

        // İlk 10 hanenin toplamından elde edilen sonucun 10'a bölümünden kalan, yani Mod10'u bize 11. haneyi verir.
        $toplam = 0;
        for ($i = 0; $i < 10; $i++) {
            $toplam += intval($tcno[$i]);
        }
        $digit11 = $toplam % 10;
        if ($digit11 != intval($tcno[10])) {
            return false;
        }

        return true;
    }
}
?> 