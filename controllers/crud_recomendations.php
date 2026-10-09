<?php

require_once '../controllers/validarSesion.php';
include __DIR__ . '/../config/db.php';
// session_start();

if (isset($_POST['save_recomendation'])) {

    $url = $_POST['url'];
    $description = $_POST['description'];
    $author = $_SESSION['username'];
    echo $url." ".$description." ".$author;
    $query = "INSERT INTO recomendations(url_recomendacion, descripcion, autor) VALUES ('$url', '$description',  '$author')";
    $result = mysqli_query($conn, $query);
    if(!$result){
        die("Query failed");
    }
    header("Location: ../dashboards/recomenacionesDashboard.php");
    exit;
}

if (isset($_GET['delId'])){
    $id = $_GET['delId'];
    $query = "DELETE FROM recomendations WHERE Id = '$id'";

    $result = mysqli_query($conn, $query);

    if(!$result){
        die("Query failed");
    }
    header("Location: ../dashboards/recomenacionesDashboard.php");
    exit;
}

if (isset($_GET['editId'])){
    $id = $_GET['editId'];
    $query = "SELECT * FROM announcements WHERE Id = '$id'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_array($result);
        $title = $row['title'];
        $content = $row['content'];
        $importance = $row['importance'];
        // echo $title.$content.$importance;
    }
    if(!$result){
        die("Query failed");
    }
}

if (isset($_POST['update'])){
    $id = $_GET['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $importance = $_POST['importance'];

    $query = "UPDATE announcements set title = '$title', content = '$content', importance = '$importance' WHERE Id = $id";
    mysqli_query($conn, $query);

    header("Location: ../adminDashboards/addNewsDashboard.php");
    exit;
}

?>

