<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}else if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>
