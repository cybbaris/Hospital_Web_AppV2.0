<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background: #1a1a1a; 
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            max-width: 400px;
            width: 100%;
            color: #ffffff; 
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-img {
            max-width: 200px;
            height: auto;
        }
        .form-label {
            color: #ffffff; 
        }
        .form-control {
            background-color: #333333; 
            border-color: #555555;
            color: #ffffff; 
        }
        .form-control:focus {
            background-color: #333333;
            border-color: #007bff;
            color: #ffffff;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #007bff; 
            border: none;
            transition: background-color 0.3s;
        }
        .text-danger {
            color: #ff4d4d !important; 
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo-container">
            <img src="../assets/img/logo.png" alt="Admin Logo" class="logo-img">
        </div>
        <form method="POST" action="login_process.php">
            <div class="mb-3">
                <label for="username" class="form-label">Kullanıcı Adı</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-light w-100">Giriş Yap</button>
        </form>

        <?php
        if (isset($_GET['error'])) {
            echo '<p class="text-danger mt-3 text-center">Kullanıcı adı veya şifre yanlış!</p>';
        }
        ?>
    </div>
</body>
</html>