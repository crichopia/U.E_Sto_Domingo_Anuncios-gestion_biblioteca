<?php include __DIR__ . '/../config/db.php';?>
<?php include __DIR__ . '/../views/html-head.php';?>

<body>
    <div id="header"></div>
    <div id="main"></div>
    <div id="footer"></div>
    <div id="modalLoginPlaceholder"></div>

    <script>
        loadElement('header', '../views/headerAdmin.php');
        loadElement('main', '../views/news.php');
        loadElement('footer', '../views/footer.php');
        loadElement('modalLoginPlaceholder', '../views/modalLogin.php');
    </script>
</body>
<?php include __DIR__ . '/../views/html-footer.php';?>
