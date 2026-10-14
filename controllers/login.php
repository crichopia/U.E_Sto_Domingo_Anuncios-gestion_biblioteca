<?php
include __DIR__ . '/../config/db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT * FROM user_data WHERE username = ?');
    $stmt->execute([$username]);
    $row = $stmt->fetch();

    if ($row !== false) {
        // Usuario encontrado, iniciar sesión
        $db_username = $row['username'];
        $db_password = $row['password'];
        $role        = $row['role'];
    
        if ($password === $db_password) {
            session_start();
            $_SESSION['username'] = $db_username;
            $_SESSION['role'] = $role;
        } else {
            // Contraseña incorrecta
            echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='../index.php';</script>";
            exit;
        }
        header("Location: ../index.php");
        exit;
    }else {
        // Usuario no encontrado
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='../index.php';</script>";
        exit;
    }
}