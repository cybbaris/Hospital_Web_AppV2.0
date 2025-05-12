<?php
session_start();
require_once '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: admin.php');
            exit;
        } else {
            header('Location: login.php?error=1');
            exit;
        }
    } catch(PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        header('Location: login.php?error=1');
        exit;
    }
}
?> 