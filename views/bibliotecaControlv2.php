<?php 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/validarSesionBiblioteca.php';
?>
<?php
$booksPerPage = 10;
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

            @media (max-width: 800px) {
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
            padding: 10px 15px;
            overflow-y: scroll;
            -ms-overflow-style: none;
            scrollbar-width: none;

            @media (max-width: 1154px) {
                display: flex;
                flex-direction:column;
                /* place-items: center; */
                /* height: auto; */
            }
        }

        #newsControlContainer::-webkit-scrollbar {
            display: none;
        }

        article h2 {
            margin: 0;
            color: #223944;
            margin-bottom: 10px;
        }

        form {
            background-color: #b5e0c8;
            border: 2px #8abfb7 solid;
            border-radius: 20px;
            padding: 15px 10px;
            height: min-content;
            display: flex;
            flex-direction: column;
            justify-content: center;

            @media (max-width: 600px) {
                width: 90%;
                margin-bottom: 10px;
            }
        }

        #formContainer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* align-items: center; */
        }


        form h3 {
            margin: 0;
            color: #223944;
            margin-bottom: 2px;
        }

        form input {
            border: none;
            border-radius: 20px;
            margin-bottom: 2px;
            padding: 5px;
            width: 90%;

            @media (max-width: 600px) {
                width: 55vw;
            }
        }

        form textarea {
            border: none;
            border-radius: 20px;
            margin-bottom: 10px;
            padding: 5px;
            resize: none;
            width: 90%;
            height: 100px;

            @media (max-width: 600px) {
                width: 55vw;
                height: 60px;
            }
        }

        select {
            text-align: center;
            margin-bottom: 5px;
            background-color: #87cead;
            border-radius: 20px;
            padding: 2px;
            border: none;
            color: #fff;
            width: 96%;
        }

        #botonSubmit {
            background: linear-gradient(135deg, #51e070, #009774);
            color: #fff;
            width: 96%;

            @media (max-width: 600px) {
                width: 57vw;
            }
        }

        #books_container {
            display: flex;
            flex-direction: column;
            background-color: #c8f7cd;
            padding: 10px 20px;
            overflow-y: scroll;
            -ms-overflow-style: none;
            scrollbar-width: none;

            @media (max-width: 600px) {
                padding: 5px 0px;
                height: 2000px;
            }
        }

        .bookItem {
            border: 2px #658291 dashed;
            background-color: #b3e7d7;
            border-radius: 25px;
            margin-bottom: 10px;
            padding: 10px 10px;
            width: 100%;
            /* padding-right: 0px; */
            display: flex;
            gap: 10px;
            align-items: center;
            color: #223944;
        }

        .bookItem img {
            width: 120px;
            height: 150px;
            border-radius: 10px;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            @media (max-width: 700px) {
            width: 90px;
            height: 120px;
            }

        }

        .bookItem h3 {
            margin: 10px 0px;
        }

        .bookItem h4 {
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 10px;

            @media (max-width: 700px) {
                font-size: 15px;
                margin-left: 0px;
            }
        }

        .select-container {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 5px;
            margin-bottom: 2px;
        }

        #num_copias {
            width: 60%;
            text-align: center;
        }

        .controlled_book {
            padding: 0;
            margin: 0;
            display: flex;
            /* flex-direction: column; */
            align-items: center;

            gap: 5px;
        }

        .controlled_book.hidden {
            display: none;
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
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            flex-wrap: nowrap;
            gap: 10px;
        }

        #search input {
            padding: 4px 15px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            width: 65%;

            @media (max-width: 600px) {
                width: 65%;
                font-size: 12px;
                padding: 4px 5px;
            }
        }

        #search button {
            text-align: center;
            margin-bottom: 10px;
            background-color: #87cead;
            border-radius: 20px;
            padding: 5px 10px;
            border: none;
            color: #fff;
            cursor: pointer;
            height: 100%;
            font-size: 16px;
            transition: all 0.3s ease;

            @media (max-width: 600px) {
                font-size: 12px;
            }
        }

        #search button:hover {
            background-color: #009774;
        }
        #bookFilters {
            width: 100%;
            height: auto;
            padding: 0;
            border: 0;
            background: transparent;
            flex-direction: column;
            align-items: center;
        }
        #bookFilters #search {
            width: 100%;
        }
        #filters {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: nowrap;
            gap: 5px;
            margin-bottom: 10px;
            color: #223944;
            @media (max-width: 800px) {
                gap: 2px; 
                font-size: 14px;
                flex-wrap: wrap;

            }
        }
        #filters select {
            width: auto;
            margin: 0;
            padding: 5px 5px;
        }
        #filters button,
        #pagination a {
            border: 0;
            border-radius: 20px;
            padding: 6px 12px;
            background: #009774;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }
        #books_container {
            max-height: 55vh;
        }
        #pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin: 10px 0;
            color: #223944;
        }
    .iconLink{
    text-decoration: none;
    color: #223944;
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

        @media (prefers-reduced-motion: reduce) {
            #bookFormWrapper {
                transition: none;
            }
        }

    </style>
    <article>

        <h2>Agregar Libros</h2>

        <div id="newsControlContainer">
        <div id="formContainer">    
        <div id="bookFormWrapper">
        <form action="../controllers/crud_books.php" method="post" id="bookForm">

                <h3>Titulo</h3>
                <input type="text" name="title" autofocus required=true placeholder="Titulo">

                <h3>Autor</h3>
                <input type="text" name="author" required=true placeholder="Autor">

                <h3>Editorial</h3>
                <input type="text" name="publisher" required=true placeholder="Editorial">

                <div class="select-container">
                    <div>
                        <label for="año">Año:</label>
                        <select name="año" id="año">
                            <option value="n/a">n/a</option>
                            <option value="1er grado">1er Grado</option>
                            <option value="2do grado">2do Grado</option>
                            <option value="3er grado">3er Grado</option>
                            <option value="4to grado">4to Grado</option>
                            <option value="5to grado">5to Grado</option>
                            <option value="6to grado">6to Grado</option>
                            <option value="1er año">1er Año</option>
                            <option value="2do año">2do Año</option>
                            <option value="3er año">3er Año</option>
                            <option value="4to año">4to Año</option>
                            <option value="5to año">5to Año</option>
                        </select>
                    </div>

                    <div>
                        <label for="materia">Materia:</label>
                        <select name="materia" id="materia">
                            <option value="n/a">n/a</option>
                            <option value="matematicas">Matematicas</option>
                            <option value="biologia">Biologia</option>
                            <option value="quimica">Quimica</option>
                            <option value="fisica">Fisica</option>
                            <option value="educ.fisica">Educ.Fisica</option>
                            <option value="geografia">Geografia</option>
                            <option value="historia">Historia</option>
                            <option value="arte">Arte y Patrimonio</option>
                            <option value="castellano">Castellano</option>
                        </select>
                    </div>
                    <div>
                        <label for="num_copias">Copias:</label>
                        <input type="number" name="num_copias" id="num_copias" min="1" value="1">   
                    </div>
                </div>
                <h3>Url Portada</h3>
                <input type="text" name="img_url" placeholder="URL de la Portada">


                <input id="botonSubmit" type="submit" name="save_book" value="Registrar Libro" >

            </form>
        </div>
            <i class="fa-solid fa-angle-up icono-rotar" onclick="rotarIcono(this); abrirFormulario('bookFormWrapper')"></i>
        </div>
            <section id="books_container">
        <form id="bookFilters" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="page" value="1">
            <div id="search">
                <input type="text" id="searchInput" name="q" value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Buscar por Título">
                <button type="submit" aria-label="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div id="filters">
                <div style="display:flex; flex-wrap:nowrap">
                    <label for="year">Año:</label>
                    <select name="año" id="year">
                        <option value="">Todos</option>
                        <option value="n/a" <?php echo $yearFilter === 'n/a' ? 'selected' : ''; ?>>n/a</option>
                        <option value="ninguno" <?php echo $yearFilter === 'ninguno' ? 'selected' : ''; ?>>ninguno</option>
                        <option value="1er grado" <?php echo $yearFilter === '1er grado' ? 'selected' : ''; ?>>1er Grado</option>
                        <option value="2do grado" <?php echo $yearFilter === '2do grado' ? 'selected' : ''; ?>>2do Grado</option>
                        <option value="3er grado" <?php echo $yearFilter === '3er grado' ? 'selected' : ''; ?>>3er Grado</option>
                        <option value="4to grado" <?php echo $yearFilter === '4to grado' ? 'selected' : ''; ?>>4to Grado</option>
                        <option value="5to grado" <?php echo $yearFilter === '5to grado' ? 'selected' : ''; ?>>5to Grado</option>
                        <option value="6to grado" <?php echo $yearFilter === '6to grado' ? 'selected' : ''; ?>>6to Grado</option>
                        <option value="1er año" <?php echo $yearFilter === '1er año' ? 'selected' : ''; ?>>1er Año</option>
                        <option value="2do año" <?php echo $yearFilter === '2do año' ? 'selected' : ''; ?>>2do Año</option>
                        <option value="3er año" <?php echo $yearFilter === '3er año' ? 'selected' : ''; ?>>3er Año</option>
                        <option value="4to año" <?php echo $yearFilter === '4to año' ? 'selected' : ''; ?>>4to Año</option>
                        <option value="5to año" <?php echo $yearFilter === '5to año' ? 'selected' : ''; ?>>5to Año</option>
                    </select>
                </div>
                <div style="display:flex; flex-wrap:nowrap">
                    <label for="subject">Materia:</label>
                    <select name="materia" id="subject" style="max-width: 95px; text-overflow: ellipsis;">
                        <option value="">Todos</option>
                        <option value="n/a" <?php echo $subjectFilter === 'n/a' ? 'selected' : ''; ?>>n/a</option>
                        <option value="ninguna" <?php echo $subjectFilter === 'ninguna' ? 'selected' : ''; ?>>Ninguna</option>
                        <option value="matematicas" <?php echo $subjectFilter === 'matematicas' ? 'selected' : ''; ?>>Matematicas</option>
                        <option value="biologia" <?php echo $subjectFilter === 'biologia' ? 'selected' : ''; ?>>Biologia</option>
                        <option value="quimica" <?php echo $subjectFilter === 'quimica' ? 'selected' : ''; ?>>Quimica</option>
                        <option value="fisica" <?php echo $subjectFilter === 'fisica' ? 'selected' : ''; ?>>Fisica</option>
                        <option value="educ.fisica" <?php echo $subjectFilter === 'educ.fisica' ? 'selected' : ''; ?>>Educ.Fisica</option>
                        <option value="geografia" <?php echo $subjectFilter === 'geografia' ? 'selected' : ''; ?>>Geografia</option>
                        <option value="historia" <?php echo $subjectFilter === 'historia' ? 'selected' : ''; ?>>Historia</option>
                        <option value="arte" <?php echo $subjectFilter === 'arte' ? 'selected' : ''; ?>>Arte y Patrimonio</option>
                        <option value="castellano" <?php echo $subjectFilter === 'castellano' ? 'selected' : ''; ?>>Castellano</option>
                    </select>
                </div>
                <button type="submit" style="padding: 6px;"><i class="fa-solid fa-filter"></i></button>
            </div>
        </form>
            <?php foreach ($books as $row) {?>
                <div class="controlled_book">
                    <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_books.php?delId=<?php echo (int) $row['id']; ?>" class="iconLink"><i class="fa-solid fa-trash"></i></a>
                    <div class="bookItem" >
                        <img src="<?php echo htmlspecialchars($row['img_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="Portada del Libro">
                        <div>
                            <h3 class="book_title"><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?> </h3>

                            <h4>Autor: <?php echo htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8'); ?></h4>
                            <h4>Editorial: <?php echo htmlspecialchars($row['publisher'], ENT_QUOTES, 'UTF-8'); ?></h4>
                            <h4><span><?php if($row['year'] !== "n/a") { ?><span>Año:</span> <span><?php echo htmlspecialchars($row['year'], ENT_QUOTES, 'UTF-8');?></span> <?php } ?></span>
                            <span><?php if($row['materia'] !== "n/a") { ?><span>Materia:</span> <span><?php echo htmlspecialchars($row['materia'], ENT_QUOTES, 'UTF-8');?></span> <?php } ?></span>
                            </h4>
                            <h4> Numero de Copias: <span><?php echo htmlspecialchars((string) $row['num_copies'], ENT_QUOTES, 'UTF-8'); ?></span></h4>
                            <h4>Estado:<span><?php echo ((int) $row['num_copies'] > 0) ? 'disponible' : 'no disponible'; ?></span></h4>
                        </div>
                    </div>
                </div>

            <?php } ?>
            <nav id="pagination" aria-label="Paginación de libros">
                <span><?php echo $totalBooks === 0 ? 'No hay libros' : 'Página ' . $page . ' de ' . $totalPages . ' (' . $totalBooks . ' libros)'; ?></span>
                <?php if ($page > 1) {
                    $previousUrl = $paginationUrl . http_build_query($paginationParams + ['page' => $page - 1]);
                ?>
                    <a style="padding: 2px 3px;" href="<?php echo htmlspecialchars($previousUrl, ENT_QUOTES, 'UTF-8'); ?>"><i class="fa-solid fa-arrow-left"></i></a>
                <?php } ?>
                <?php if ($page < $totalPages) {
                    $nextUrl = $paginationUrl . http_build_query($paginationParams + ['page' => $page + 1]);
                ?>
                    <a style="padding: 2px 3px;" href="<?php echo htmlspecialchars($nextUrl, ENT_QUOTES, 'UTF-8'); ?>"><i class="fa-solid fa-arrow-right"></i></a>
                <?php } ?>
            </nav>
            </section>
        </div>
    </article>