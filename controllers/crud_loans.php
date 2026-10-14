<?php
require_once __DIR__ . '/validarSesionBiblioteca.php';
require_once __DIR__ . '/../config/db.php';

if (isset($_POST['save_loan'])) {
    $studentName = trim((string) ($_POST['nombreE'] ?? ''));
    $cedula = trim((string) ($_POST['cedulaE'] ?? ''));
    $bibliotecario = trim((string) ($_POST['bibliotecario'] ?? ''));
    $bookName = trim((string) ($_POST['book_name'] ?? ''));
    $bookId = filter_var(
        $_POST['book_id'] ?? null,
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]
    );

    if ($studentName === '' || $bibliotecario === '' || $bookName === '' || $bookId === false) {
        http_response_code(400);
        exit('Verifica los datos del préstamo y selecciona un libro.');
    }

    try {
        $conn->beginTransaction();

        $updateCopies = $conn->prepare(
            'UPDATE books SET num_copies = num_copies - 1 WHERE id = ? AND num_copies > 0'
        );
        $updateCopies->execute([$bookId]);
        $hasAvailableCopy = $updateCopies->rowCount() === 1;

        if (!$hasAvailableCopy) {
            $conn->rollBack();
            http_response_code(409);
            exit('El libro no existe o no tiene copias disponibles.');
        }

        $insertLoan = $conn->prepare(
            'INSERT INTO loans (student_name, cedula, bibliotecario, book_id, book_name) VALUES (?, ?, ?, ?, ?)'
        );
        $insertLoan->execute([$studentName, $cedula, $bibliotecario, $bookId, $bookName]);

        $conn->commit();
    } catch (Throwable $error) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        http_response_code(500);
        exit('Ocurrió un error al registrar el préstamo.');
    }

    header('Location: ../adminDashboards/loansDashboard.php');
    exit;
}

if (isset($_GET['delId'])) {
    $loanId = filter_var($_GET['delId'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($loanId === false || $loanId === null) {
        http_response_code(400);
        exit('Identificador de préstamo no válido.');
    }

    try {
        $conn->beginTransaction();

        $findLoan = $conn->prepare('SELECT book_id FROM loans WHERE id = ? FOR UPDATE');
        $findLoan->execute([$loanId]);
        $bookId = $findLoan->fetchColumn();

        if ($bookId === false) {
            $conn->rollBack();
            http_response_code(404);
            exit('No se encontró el préstamo.');
        }

        $deleteLoan = $conn->prepare('DELETE FROM loans WHERE id = ?');
        if (!$deleteLoan->execute([$loanId]) || $deleteLoan->rowCount() !== 1) {
            throw new RuntimeException('No se pudo eliminar el préstamo.');
        }

        $restoreCopy = $conn->prepare('UPDATE books SET num_copies = num_copies + 1 WHERE id = ?');
        if (!$restoreCopy->execute([$bookId]) || $restoreCopy->rowCount() !== 1) {
            throw new RuntimeException('No se pudo devolver la copia al inventario.');
        }

        $conn->commit();
    } catch (Throwable $error) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        http_response_code(500);
        exit('Ocurrió un error al eliminar el préstamo.');
    }

    header('Location: ../adminDashboards/loansDashboard.php');
    exit;
}

http_response_code(400);
exit('No se indicó una acción válida para préstamos.');
