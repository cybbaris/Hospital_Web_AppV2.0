<?php
session_start();
require_once 'hospital_db.php';

// Veritabanı bağlantısı
$servername = "db";
$username = "hospital_user";
$password = "hospital_pass";
$dbname = "hospital";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8mb4");
} catch(PDOException $e) {
    die("Bağlantı hatası: " . $e->getMessage());
}

$page_title = "Hasta Yönetim Paneli";
ob_start();

//backup 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['run_backup'])) {
    $script = '/var/www/html/admin/backup.sh';
    $log_file = '/var/log/backup.log';

    // Log dosyası yoksa oluştur
    if (!file_exists($log_file)) {
        file_put_contents($log_file, ""); // boş log dosyası oluştur
    }

    if (file_exists($script)) {
        exec("sh $script 2>&1", $output, $status);
        $backup_result = ($status === 0) ? "Backup başarıyla alındı." : "Backup alınırken hata oluştu. Log dosyasını kontrol ediniz...";
        $backup_result .= "<br><pre>" . htmlspecialchars(implode("\n", $output)) . "</pre>";
    } else {
        $backup_result = "Backup scripti bulunamadı: $script";
    }

    // Log içeriğini oku
    if (file_exists($log_file)) {
        $backup_log_content = file_get_contents($log_file);
    } else {
        $backup_log_content = "Log dosyası bulunamadı.";
    }
}

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- backup --> 
<div class="my-4 p-3 border rounded bg-light">
    <h4>Yedekleme İşlemi</h4>
    <?php if (!empty($backup_result)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($backup_result); ?></div>
    <?php endif; ?>

    <form method="post">
        <button type="submit" name="run_backup" class="btn btn-primary">Backup Al</button>
    </form>

    <?php if (!empty($backup_log_content)): ?>
        <h5 class="mt-3">Backup Log:</h5>
        <pre style="max-height: 300px; overflow-y: auto; background: #f8f9fa; padding: 10px; border: 1px solid #ccc;">
<?php echo htmlspecialchars($backup_log_content); ?>
        </pre>
    <?php endif; ?>
</div>



<?php
$content = ob_get_clean();
include 'template.php';
?>