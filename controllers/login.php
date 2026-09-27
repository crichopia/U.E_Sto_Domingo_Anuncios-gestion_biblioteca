<?php
include __DIR__ . '/../config/db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para verificar el usuario y la contraseña
    // $query = "SELECT * FROM user_data WHERE username = '$username' AND password = '$password'";
    $query = "SELECT * FROM user_data WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Usuario encontrado, iniciar sesión
        $row = mysqli_fetch_array($result);
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