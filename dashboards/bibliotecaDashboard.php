<?php include __DIR__ . '/../config/db.php';?>
<?php include __DIR__ . '/../views/html-head.php';?>

<body>
    <div id="header"></div>
    <div id="main"></div>
    <div id="footer"></div>
    <div id="modalLoginPlaceholder"></div>
    <!-- <div id="modalMenuPlaceholder"></div> -->
    

    <script src="../controllers/load_element.js"></script>
    <script src="../controllers/modal_controller.js"></script>
    <script src="../controllers/login.js"></script>

    <script>
        loadElement('header', '../views/headerAdmin.php');
        loadElement('main', '../views/biblioteca.php');
        loadElement('footer', '../views/footer.php');
        loadElement('modalLoginPlaceholder', '../views/modalLogin.php');
        //loadElement('modalMenuPlaceholder', '../views/modalMenu.php');
    </script>
</body>
<?php include __DIR__ . '/../views/html-footer.php';?>
