<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Admin Paneli'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .sidebar {
            height: 100%;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            padding: 15px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        .d-flex {
            flex: 1 0 auto;
        }
        footer {
            flex-shrink: 0;
            width: 100%;
            background-color: #343a40;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 40px;
        }
        .logo-img {
            max-width: 200px; 
            width: 90%; 
            height: auto;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar col-2">
            <div class="logo-container">
                <img src="uploads/logo.png" alt="Admin Logo" class="logo-img">
            </div>
            <a href="admin.php">Ana Sayfa</a>
            <a href="users.php">Kullanıcı Yönetimi</a>
            <a href="backup.php">Backup Yönetim Paneli</a>
            <a href="logout.php">Çıkış Yap</a>
        </div>
        <div class="col-10 p-4">
            <?php
            if (isset($content)) {
                echo $content;
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>