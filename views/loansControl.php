<?php 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/validarSesionBiblioteca.php';
?>
<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
<?php
$booksPerPage = 5;
$searchTerm = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : '';
$yearFilter = isset($_GET['año']) && is_string($_GET['año']) ? trim($_GET['año']) : '';
$subjectFilter = isset($_GET['materia']) && is_string($_GET['materia']) ? trim($_GET['materia']) : '';
$page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$page = $page === false ? 1 : $page;

$conditions = [];
$queryParams = [];
if ($searchTerm !== '') {
    $conditions[] = 'title LIKE :title';
    $queryParams[':title'] = '%' . $searchTerm . '%';
}
if ($yearFilter !== '') {
    $conditions[] = '`year` = :year';
    $queryParams[':year'] = $yearFilter;
}
if ($subjectFilter !== '') {
    $conditions[] = 'materia = :materia';
    $queryParams[':materia'] = $subjectFilter;
}
$whereSql = $conditions ? ' WHERE ' . implode(' AND ', $conditions) : '';

$countStmt = $conn->prepare('SELECT COUNT(*) FROM books' . $whereSql);
$countStmt->execute($queryParams);
$totalBooks = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($totalBooks / $booksPerPage));
$page = min($page, $totalPages);
$offset = ($page - 1) * $booksPerPage;

$booksStmt = $conn->prepare(
    'SELECT * FROM books' . $whereSql . ' ORDER BY id DESC LIMIT :limit OFFSET :offset'
);
foreach ($queryParams as $name => $value) {
    $booksStmt->bindValue($name, $value, PDO::PARAM_STR);
}
$booksStmt->bindValue(':limit', $booksPerPage, PDO::PARAM_INT);
$booksStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$booksStmt->execute();
$books = $booksStmt->fetchAll();

$paginationParams = [];
if ($searchTerm !== '') {
    $paginationParams['q'] = $searchTerm;
}
if ($yearFilter !== '') {
    $paginationParams['año'] = $yearFilter;
}
if ($subjectFilter !== '') {
    $paginationParams['materia'] = $subjectFilter;
}
$paginationUrl = htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . '?';
?>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }

        article {
            width: 60vw;
            height: 70vh;
            background: #b5e0c8;
            border: 2px #8abfb7 solid;
            padding: 3%;
            margin-top: 5%;
            margin-bottom: 5%;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            @media (max-width: 1154px) {
                width: 80vw;
                margin-top: 2%;
                margin-bottom: 2%;
            }
        }

        #newsControlContainer {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 5px;
            border: 2px #658291 dashed;
            border-radius: 20px;
            width: 80%;
            min-height: 85%;
            background-color: #c8f7cd;
            padding: 0px 15px;
            padding-right: 0px;
            overflow-y: scroll;
            -ms-overflow-style: none;
            scrollbar-width: none;
            height: 100%;
            @media (max-width: 1154px) {
                display: flex;
                flex-direction:column;
                height: 100%;
                padding: 10px 15px;
                padding-right: 15px;

            }
        }

        #newsControlContainer::-webkit-scrollbar {
            display: none;
        }

        .formularioPrestamos {
            background-color: #b5e0c8;
            border: 2px #8abfb7 solid;
            border-radius: 20px;
            padding: 15px 10px;
            height: min-content;
            display: flex;
            flex-direction: column;
            justify-content: center;

            @media (max-width: 1154px) {
                width: 90%;
                margin-bottom: 10px;
            }
        }
        #formContainer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .formularioPrestamos h3 {
            margin: 0;
            color: #223944;
            margin-bottom: 2px;
        }
        h2 {
            margin: 0;
            color: #223944;
            margin-bottom: 2px;
        }

        .formularioPrestamos input {
            border: none;
            border-radius: 20px;
            margin-bottom: 2px;
            padding: 5px;
            width: 90%;

            @media (max-width: 600px) {
                width: 55vw;
            }
        }

        #botonSubmit {
            background: linear-gradient(135deg, #51e070, #009774);
            color: #fff;
            width: 96%;
            cursor:          pointer;
            margin-top:10px;

            @media (max-width: 600px) {
                width: 57vw;
            }
        }
        .controlarLibro{
            background: linear-gradient(135deg, #51e070, #009774);
            width:              26px;
            height:             26px;
            display:            flex;
            align-items:      center;
            justify-content:  center;
            font-weight:      bolder;
            border:             none;
            border-radius:      100%;
            cursor:          pointer;

            color: #fff;

        }
        #books_container {
            display: flex;
            flex-direction: column;
            padding: 0px 20px;
            overflow-y: scroll;
            -ms-overflow-style: none;
            scrollbar-width: none;

            @media (max-width: 600px) {
                padding: 5px 0px;
            }
        }


        #books_container::-webkit-scrollbar {
            display: none;
        }
        .bookItem {
            border: 2px #658291 dashed;
            border-radius: 20px;
            margin-bottom: 10px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 16px;
            color: #223944;
        }
        .bookItem.hidden {
            display: none;
        }
        .bookItem.disponible {
            background-color: #b3e7d7;
        }
        .bookItem.disponiblent {
            background-color: #fdc9c0;
        }
        .bookItem .book-cover {
            flex-basis: 78px;
            height: 108px;
            border-radius: 10px;
            background-color: #fff;
            overflow: hidden;

        }
        .bookItem .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .bookItem .book-content {
            flex: 1;
            min-width: 0;
        }
        .bookItem .book_title {
            margin: 0 0 8px;
            font-size: 20px;
            line-height: 1.3;
        }
        .bookItem .book-details {
            display: grid;
            gap: 2px;
        }
        .bookItem .book-details h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.4;
        }
        .bookItem .book-details strong {
            display: inline-block;
            min-width: 100px;
            font-weight: 700;
        }
        .bookItem .book-status {
            display: inline-flex;
            width: max-content;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(34, 57, 68, 0.08);
            font-size: 12.8px !important;
            font-weight: 700 !important;
        }
        .bookItem.disponible .book-status {
            color: #0f6f52;
            background: rgba(0, 151, 116, 0.14);
        }
        .bookItem.disponiblent .book-status {
            color: #9d2d22;
            background: rgba(196, 78, 60, 0.12);
        }
        @media (max-width: 700px) {
            .bookItem {
                align-items: flex-start;
                gap: 10px;
                padding: 10px;
            }
            .bookItem .book-details strong {
                min-width: 76px;
            }
        }

        .loanItem {
            border: 2px #658291 solid;
            background-color: #b3e7d7;
            border-radius: 25px;
            margin-bottom: 10px;
            padding: 10px 8px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            color: #223944;
        }

        .loanItem h3 {
            margin: 10px 0px;
        }

        .loanItem h4 {
            margin-top: 0;
            margin-bottom: 0;

            @media (max-width: 900px) {
                font-size: 15px;
            }
        }

        p.loanData {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        p.loanData span {
            margin-left: auto;
            text-align: right;
        }

        .controlled_book {
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .controlled_book a {
            text-decoration: none;
            margin: 0;
            font-size: 20px;

            @media (max-width: 600px) {
                font-size: 15px;
            }
        }

        #search {
            display: flex;
            align-items: stretch;
            margin-bottom: 10px;
            flex-wrap: nowrap;
            gap: 10px;
        }

        #search input {
            padding: 4px 15px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            box-sizing: border-box;
            align-self: stretch;
            flex: 1 1 0;
            min-width: 0;

            @media (max-width: 600px) {
                font-size: 12px;
                padding: 4px 5px;
            }
        }

        .iconLink{
            text-decoration: none;
            color: #223944;

        }
        .loanItem hr{
            color:            #658291;
            background-color: #658291;
            width:           100%;
            margin:          0px;
        }
        .centerTheDamnButton{
            display:                             flex;
            place-items:                       center;
            justify-content:                   center;
            margin-top:    10px;

            @media (max-width: 900px) {
                margin-top:    2px;
            }

        }
.icono-rotar {
    display: none;
    cursor:           pointer;
    color: #223944;
    font-size: 25px;
    align-self: center;
    transition: transform 0.35s ease;
    @media (max-width: 1154px) {
    display: inline-block;

}

}

.rotado{
    transform: rotate(180deg);

}
        #bookFormWrapper {
            width: 100%;
            display: grid;
            grid-template-rows: minmax(0, 1fr);
            opacity: 1;
            transition: grid-template-rows 0.35s ease, opacity 0.35s ease;
        }

        #bookFormWrapper.cerrado {
            grid-template-rows: minmax(0, 0fr);
            opacity: 0;
        }

        #bookFormWrapper > form {
            height: auto;
            min-height: 0;
            overflow: hidden;
        }

        .formDevolverWrapper {
            display: grid;
            grid-template-rows: minmax(0, 1fr);
            opacity: 1;
            transition: grid-template-rows 0.35s ease, opacity 0.35s ease;
        }

        .formDevolverWrapper.cerrado {
            grid-template-rows: minmax(0, 0fr);
            opacity: 0;
        }

        .formDevolverWrapper > form {
            display: flex;
            flex-direction: column;
            min-height: 0;
            overflow: hidden;
            width: 100%;
        }

        @media (prefers-reduced-motion: reduce) {
            #bookFormWrapper,
            .formDevolverWrapper {
                transition: none;
            }
        }
        #navPrestamos{
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            place-items: center;
            padding: 5px 0px;
            margin-bottom: 5px;
        }
        #navPrestamos a{
            color:          #223944;
            display:      inline-flex;
            align-self:        center;
            justify-content:   center;
            cursor:           pointer;
            padding:          4px 5px;
            border-radius:       20px;
            transition: all 0.5s ease;
            width: 70%;
            @media (max-width: 600px) {
            font-size:         16px;
            }
            @media (max-width: 450px) {
            font-size:         14px;
            }

        }
        #pagination a{
            border: none;
            border-radius: 20px;
            padding: 6px 12px;
            background: #009774;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }
        #bookFilters{
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        #bookFilters #search{
            width:80%;
            @media (max-width: 600px){
                width: 100%;
            }
        }
        #search button{
            text-align:          center;
            background-color: #009774;
            border-radius:         20px;
            padding:                5px 10px;
            border:                none;
            color:               #fff;
            cursor:pointer;
            font-size: 16px;
            transition:all 0.3s ease;
            @media (max-width: 600px){
                font-size: 12px;
            }
        }
        #formpc{
            @media (max-width: 1154px) {
            display: none;
            }
        }
        #formcel{
            display: none;
            @media (max-width: 1154px) {
            display: flex;
            }
        }
        #observaciones{
            width: 80%;
            margin-top: 5px;
            align-self: center;
            min-height: 150px;
            border: none;
            border-radius: 25px;
            resize: none;
            padding: 5px 20px;
        }
    </style>
    <article>

        <h2>Prestar Libros</h2>

        <div id="newsControlContainer">
        <div id="formContainer">
        <form id="formpc" class="formularioPrestamos" action="../controllers/crud_loans.php" method="post">

                <h3>Nombre Estudiante:</h3>
                <input type="text" name="nombreE" autofocus required=true placeholder="Nombre del Estudiante">

                <h3>Cedula</h3>
                <input type="text" name="cedulaE" placeholder="Cedula">

                <h3>Bibliotecario</h3>
                <input type="text" name="bibliotecario" required=true placeholder="Bibliotecario" readonly value="<?php echo $_SESSION['username']; ?>">

                <h3>Libro</h3>
                <div style=" display: flex; gap: 5px; align-items: center;">
                <input id="book_name" type="text" name="book_name" placeholder="Nombre del Libro" readonly required style=" width: 80%;">
                <button id="boton_Eliminar" class="controlarLibro" type="button" onclick="eliminarLibroDelPrestamo('book_name', 'book_id'); cambiarBotonPrestamo('boton_Aniadir', 'boton_Eliminar');"><i class="fa-solid fa-minus"></i></button>
                </div>
                <input id="book_id" class="hidden" type="text" name="book_id" readonly >
                <input id="botonSubmit" type="submit" name="save_loan" value="Registrar Prestamo" >

            </form>
        </div>
            <section id="books_container">
                <nav id="navPrestamos">
                    <a onclick="cambiarSeccionPrestamo('seccionLibros', 'seccionPrestamos', 'seccionHistorial');cambiarSeccionSubrayada('añadirLibro', 'prestamosActivos', 'historial')" id="añadirLibro"  class="subrayado">Préstar</a>
                    <a onclick="cambiarSeccionPrestamo('seccionPrestamos', 'seccionLibros', 'seccionHistorial');cambiarSeccionSubrayada('prestamosActivos', 'añadirLibro', 'historial')" id="prestamosActivos" >Activos</a>
                    <a onclick="cambiarSeccionPrestamo('seccionHistorial', 'seccionPrestamos', 'seccionLibros');cambiarSeccionSubrayada('historial', 'añadirLibro', 'prestamosActivos')" id="historial" >Historial</a>
                </nav>
                <div id="seccionLibros">
                    <section id="booksContainer">
                        <div id="bookFormWrapper">    
                            <form id="formcel" class="formularioPrestamos" action="../controllers/crud_loans.php" method="post">

                                    <h3>Nombre Estudiante:</h3>
                                    <input type="text" name="nombreE" autofocus required=true placeholder="Nombre del Estudiante">

                                    <h3>Cedula</h3>
                                    <input type="text" name="cedulaE" placeholder="Cedula">

                                    <h3>Bibliotecario</h3>
                                    <input type="text" name="bibliotecario" required=true placeholder="Bibliotecario" readonly value="<?php echo $_SESSION['username']; ?>">

                                    <h3>Libro</h3>
                                    <div style=" display: flex; gap: 5px; align-items: center;">
                                    <input id="book_name" type="text" name="book_name" placeholder="Nombre del Libro" readonly required style=" width: 80%;">
                                    <button id="boton_Eliminar" class="controlarLibro" type="button" onclick="eliminarLibroDelPrestamo('book_name', 'book_id'); cambiarBotonPrestamo('boton_Aniadir', 'boton_Eliminar');"><i class="fa-solid fa-minus"></i></button>
                                    </div>
                                    <input id="book_id" class="hidden" type="text" name="book_id" readonly >
                                    <input id="botonSubmit" type="submit" name="save_loan" value="Registrar Prestamo" >

                            </form>
                        </div>
                        <div class="centerTheDamnButton"><i class="fa-solid fa-angle-up icono-rotar" onclick="rotarIcono(this); abrirFormulario('bookFormWrapper')"></i></div>
                        <form id="bookFilters" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="page" value="1">
                            <div id="search">
                                <input type="text" id="searchInput" name="q" value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Buscar por Título">
                                <button style="padding: 8px;" type="submit" aria-label="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                        <?php
                            foreach ($books as $row) {
                                $isAvailable = (int) $row['num_copies'] > 0;
                        ?>
                        <div class="bookItem <?php echo ((int) $row['num_copies'] > 0) ? 'disponible' : 'disponiblent'; ?>" data-year="<?php echo htmlspecialchars($row['year'], ENT_QUOTES, 'UTF-8'); ?>" data-materia="<?php echo htmlspecialchars($row['materia'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="book-cover">
                                <img src="<?php echo htmlspecialchars($row['img_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="Portada del libro <?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="book-content">
                                <h2 class="book_title"><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                                <div class="book-details">
                                    <h3><strong>Copias:</strong> <?php echo htmlspecialchars((string) $row['num_copies'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <div style="display: grid;grid-template-columns: 1fr 1fr;place-items: center; width: 100%; margin-top: 8px;">
                                        <h3 class="book-status"><?php echo $isAvailable ? 'Disponible' : 'No disponible'; ?></h3>
                                        <?php if($isAvailable){ ?>
                                            <button class="controlarLibro" type="button" onclick="prestarLibro('book_name', 'book_id', '<?php echo($row['title']); ?>', <?php echo (int) $row['id']; ?>);"><i class="fa-solid fa-check"></i></button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </section>
                    <nav id="pagination" aria-label="Paginación de libros" class="centerTheDamnButton">
                        <?php if ($page > 1) {
                            $previousUrl = $paginationUrl . http_build_query($paginationParams + ['page' => $page - 1]);
                        ?>
                            <a style="padding: 2px 3px;" href="<?php echo htmlspecialchars($previousUrl, ENT_QUOTES, 'UTF-8'); ?>"><i class="fa-solid fa-arrow-left"></i></a>
                        <?php } ?>
                        <span><?php echo $totalBooks === 0 ? 'No hay libros' : 'Página ' . $page . ' de ' . $totalPages . ' (' . $totalBooks . ' libros)'; ?></span>
                        <?php if ($page < $totalPages) {
                            $nextUrl = $paginationUrl . http_build_query($paginationParams + ['page' => $page + 1]);
                        ?>
                            <a style="padding: 2px 3px;" href="<?php echo htmlspecialchars($nextUrl, ENT_QUOTES, 'UTF-8'); ?>"><i class="fa-solid fa-arrow-right"></i></a>
                        <?php } ?>
                    </nav>                
                </div>

                <div id="seccionPrestamos" class="hidden">
                    <?php
                            $query = "SELECT * FROM loans ORDER BY id DESC";
                            $result_tasks = $conn->query($query);

                            while ($row = $result_tasks->fetch(PDO::FETCH_ASSOC)) {?>
                        <div class="controlled_book">
                            <div class="loanItem" >
                                <div style="display: flex; gap: 5px; align-items: baseline;">
                                    <h3 class="loanData"><?php echo $row['student_name']; ?> </span></h3>
                                    <h4><?php echo $row['loan_date']; ?></h4>
                                </div>
                                <hr>
                                <div>
                                    <p class="loanData"><strong>Cedula:</strong> <?php echo $row['cedula']; ?></p>
                                    <p class="loanData"><strong>Libro:</strong> <?php echo $row['book_name']; ?></p>
                                    <p class="loanData"><strong>Bibliotecario:</strong> <?php echo $row['bibliotecario']; ?></p>
                                </div>
                                <div class="centerTheDamnButton" style="margin: 0; gap: 10px;">
                                    <label for="devolver_<?php echo (int) $row['id']; ?>"><strong>Devolver</strong></label>
                                    <input id="devolver_<?php echo (int) $row['id']; ?>" type="checkbox" onchange="abrirFormulario('formDevolverWrapper_<?php echo (int) $row['id']; ?>')">
                                </div>    
                                <div id="formDevolverWrapper_<?php echo (int) $row['id']; ?>" class="formDevolverWrapper cerrado" aria-hidden="true" inert>
                                    <form action="../controllers/crud_loans.php" method="post" id="formDevolver_<?php echo (int) $row['id']; ?>">
                                        <div class="hidden">
                                            <input type="text" name="nombreE"       readonly value="<?php echo $row['student_name']; ?>">
                                            <input type="text" name="cedulaE"       readonly value="<?php echo $row['cedula']; ?>">
                                            <input type="text" name="bibliotecario" readonly value="<?php echo $row['bibliotecario']; ?>">
                                            <input type="text" name="book_name"     readonly value="<?php echo $row['book_name']; ?>">
                                            <input type="text" name="book_id"       readonly value="<?php echo $row['book_id']; ?>">
                                            <input type="text" name="loan_id"       readonly value="<?php echo (int) $row['id']; ?>">
                                            <input type="text" name="loan_date"     readonly value="<?php echo $row['loan_date']; ?>">
                                        </div>
                                        <label for="observation"><strong>Observaciones</strong></label>
                                        <textarea name="observation" id="observaciones" ></textarea>
                                        <input id="botonSubmit" type="submit" name="end_loan" value="Devolver Libro" style="width: min-content; padding: 5px 10px; border:none;border-radius: 20px; align-self: center;" >
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div id="seccionHistorial" class="hidden">
                    <?php
                            $query = "SELECT * FROM ended_loans ORDER BY id DESC";
                            $result_tasks = $conn->query($query);

                            while ($row = $result_tasks->fetch(PDO::FETCH_ASSOC)) {?>
                        <div class="controlled_book">
                            <div class="loanItem" >
                                <div style="display: flex; gap: 5px; align-items: baseline;">
                                    <h3 class="loanData"><?php echo htmlspecialchars((string) $row['student_name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                </div>
                                <hr>
                                <div>
                                    <p class="loanData"><strong>Salida:</strong><span><?php echo htmlspecialchars((string) $row['loan_start'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                    <p class="loanData"><strong>Devolución:</strong><span><?php echo htmlspecialchars((string) $row['loan_end'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                    <p class="loanData"><strong>Cédula:</strong><span><?php echo htmlspecialchars((string) $row['cedula'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                    <p class="loanData"><strong>Libro:</strong><span><?php echo htmlspecialchars((string) $row['book_name'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                    <p class="loanData"><strong>Bibliotecario:</strong><span><?php echo htmlspecialchars((string) $row['bibliotecario'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                                    <p class="loanData"><strong>Observación:</strong></p>
                                    <p style="text-align: justify;">
                                        <?php 
                                            if ($row['observation']){
                                                echo htmlspecialchars((string) $row['observation'], ENT_QUOTES, 'UTF-8'); 
                                            }else{
                                                echo("Sin observaciones");
                                            }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                </section>
            </div>
    </article>

</div>
