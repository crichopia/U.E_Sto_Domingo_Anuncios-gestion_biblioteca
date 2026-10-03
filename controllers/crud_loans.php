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
        $conn->begin_transaction();

        $updateCopies = $conn->prepare(
            'UPDATE books SET num_copies = num_copies - 1 WHERE id = ? AND num_copies > 0'
        );
        if (!$updateCopies) {
            throw new RuntimeException('No se pudo preparar la actualización de existencias.');
        }
        $updateCopies->bind_param('i', $bookId);
        if (!$updateCopies->execute()) {
            throw new RuntimeException('No se pudieron actualizar las existencias.');
        }
        $hasAvailableCopy = $updateCopies->affected_rows === 1;
        $updateCopies->close();

        if (!$hasAvailableCopy) {
            $conn->rollback();
            http_response_code(409);
            exit('El libro no existe o no tiene copias disponibles.');
        }

        $insertLoan = $conn->prepare(
            'INSERT INTO loans (student_name, cedula, bibliotecario, book_id, book_name) VALUES (?, ?, ?, ?, ?)'
        );
        if (!$insertLoan) {
            throw new RuntimeException('No se pudo preparar el registro del préstamo.');
        }
        $insertLoan->bind_param('sssis', $studentName, $cedula, $bibliotecario, $bookId, $bookName);
        if (!$insertLoan->execute()) {
            throw new RuntimeException('No se pudo registrar el préstamo.');
        }
        $insertLoan->close();

        if (!$conn->commit()) {
            throw new RuntimeException('No se pudo confirmar el préstamo.');
        }
    } catch (Throwable $error) {
        $conn->rollback();
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
        $conn->begin_transaction();

        $findLoan = $conn->prepare('SELECT book_id FROM loans WHERE id = ? FOR UPDATE');
        if (!$findLoan) {
            throw new RuntimeException('No se pudo buscar el préstamo.');
        }
        $findLoan->bind_param('i', $loanId);
        if (!$findLoan->execute()) {
            throw new RuntimeException('No se pudo buscar el préstamo.');
        }
        $bookId = 0;
        $findLoan->bind_result($bookId);
        $loanExists = $findLoan->fetch();
        $findLoan->close();

        if (!$loanExists) {
            $conn->rollback();
            http_response_code(404);
            exit('No se encontró el préstamo.');
        }

        $deleteLoan = $conn->prepare('DELETE FROM loans WHERE id = ?');
        if (!$deleteLoan) {
            throw new RuntimeException('No se pudo preparar la eliminación del préstamo.');
        }
        $deleteLoan->bind_param('i', $loanId);
        if (!$deleteLoan->execute() || $deleteLoan->affected_rows !== 1) {
            throw new RuntimeException('No se pudo eliminar el préstamo.');
        }
        $deleteLoan->close();

        $restoreCopy = $conn->prepare('UPDATE books SET num_copies = num_copies + 1 WHERE id = ?');
        if (!$restoreCopy) {
            throw new RuntimeException('No se pudo preparar la devolución de la copia.');
        }
        $restoreCopy->bind_param('i', $bookId);
        if (!$restoreCopy->execute() || $restoreCopy->affected_rows !== 1) {
            throw new RuntimeException('No se pudo devolver la copia al inventario.');
        }
        $restoreCopy->close();

        if (!$conn->commit()) {
            throw new RuntimeException('No se pudo confirmar la eliminación del préstamo.');
        }
    } catch (Throwable $error) {
        $conn->rollback();
        http_response_code(500);
        exit('Ocurrió un error al eliminar el préstamo.');
    }

    header('Location: ../adminDashboards/loansDashboard.php');
    exit;
}

http_response_code(400);
exit('No se indicó una acción válida para préstamos.');

