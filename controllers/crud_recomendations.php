<?php

require_once '../controllers/validarSesion.php';
include __DIR__ . '/../config/db.php';
// session_start();

if (isset($_POST['save_recomendation'])) {

    $url = $_POST['url'];
    $description = $_POST['description'];
    $author = $_SESSION['username'];
    echo $url." ".$description." ".$author;
    $stmt = $conn->prepare('INSERT INTO recomendations (url_recomendacion, descripcion, autor) VALUES (?, ?, ?)');
    $stmt->execute([$url, $description, $author]);
    header("Location: ../dashboards/recomenacionesDashboard.php");
    exit;
}

if (isset($_GET['delId'])){
    $id = $_GET['delId'];
    $stmt = $conn->prepare('DELETE FROM recomendations WHERE Id = ?');
    $stmt->execute([$id]);
    header("Location: ../dashboards/recomenacionesDashboard.php");
    exit;
}

if (isset($_GET['editId'])){
    $id = $_GET['editId'];
    $stmt = $conn->prepare('SELECT * FROM announcements WHERE Id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();

    if ($row !== false) {
        $title = $row['title'];
        $content = $row['content'];
        $importance = $row['importance'];
        // echo $title.$content.$importance;
    }
}

if (isset($_POST['update'])){
    $id = $_GET['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $importance = $_POST['importance'];

    $stmt = $conn->prepare('UPDATE announcements SET title = ?, content = ?, importance = ? WHERE Id = ?');
    $stmt->execute([$title, $content, $importance, $id]);

    header("Location: ../adminDashboards/addNewsDashboard.php");
    exit;
}

?>
