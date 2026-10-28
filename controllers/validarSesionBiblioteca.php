<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}else if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'bibliotecario') {
    header("Location: ../index.php");
    exit;
}
?>
