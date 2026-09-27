<?php
require_once __DIR__ . '/validarSesionBiblioteca.php';
require_once __DIR__ . '/../config/db.php';

if (isset($_POST['save_announcement']) || isset($_POST['save_book'])) {
    $title = trim((string) ($_POST['title'] ?? ''));
    $author = trim((string) ($_POST['author'] ?? ''));
    $publisher = trim((string) ($_POST['publisher'] ?? ''));
    $year = trim((string) ($_POST['año'] ?? 'n/a'));
    $materia = trim((string) ($_POST['materia'] ?? 'n/a'));
    $imgUrl = trim((string) ($_POST['img_url'] ?? ''));
    $numCopies = filter_var(
        $_POST['num_copias'] ?? null,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    if ($title === '' || $author === '' || $publisher === '' || $numCopies === false) {
        http_response_code(400);
        exit('Verifica los datos del libro y la cantidad de copias.');
    }

    $stmt = $conn->prepare(
        'INSERT INTO books (img_url, title, author, publisher, `year`, materia, num_copies) VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    if (!$stmt) {
        http_response_code(500);
        exit('No se pudo preparar el registro del libro.');
    }

    $stmt->bind_param('ssssssi', $imgUrl, $title, $author, $publisher, $year, $materia, $numCopies);
    if (!$stmt->execute()) {
        http_response_code(500);
        exit('No se pudo registrar el libro.');
    }

    $stmt->close();
    header('Location: ../adminDashboards/addBooksDashboard.php');
    exit;
}

if (isset($_GET['delId'])) {
    $id = filter_var($_GET['delId'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($id === false || $id === null) {
        http_response_code(400);
        exit('Identificador de libro no válido.');
    }

    $stmt = $conn->prepare('DELETE FROM books WHERE id = ?');
    if (!$stmt) {
        http_response_code(500);
        exit('No se pudo preparar la eliminación del libro.');
    }

    $stmt->bind_param('i', $id);
    if (!$stmt->execute()) {
        http_response_code(500);
        exit('No se pudo eliminar el libro.');
    }

    $stmt->close();
    header('Location: ../adminDashboards/addBooksDashboard.php');
    exit;
}

http_response_code(400);
exit('No se indicó una acción válida para libros.');

