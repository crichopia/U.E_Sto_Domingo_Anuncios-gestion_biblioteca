<?php include __DIR__ . '/../config/db.php';?>
<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php include __DIR__ . '/../views/html-head.php';?>

<body>
    <?php include __DIR__ . '/../views/headerAdmin.php'; ?>
    <main id="main">
        <?php include __DIR__ . '/../views/recomendaciones.php'; ?>
    </main>
    <?php include __DIR__ . '/../views/modalLogin.php'; ?>
    <?php include __DIR__ . '/../views/footer.php'; ?>
<?php include __DIR__ . '/../views/html-footer.php';?>
