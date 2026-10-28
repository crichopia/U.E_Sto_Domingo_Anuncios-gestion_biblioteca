<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
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
    $conditions[] = 'year = :year';
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
        body{
        margin:                      0;
        font-family: Arial, sans-serif;
        box-sizing:         border-box;
        }
        article{
            /* box-sizing:         border-box; */
            width:                 60vw;
            height:                85dvh;
            background:       #b5e0c8;
            border: 2px #8abfb7 solid;
            padding:                 3% 5%;
            margin-top:              5%;
            margin-bottom:           5%;
            border-radius:         20px;
            display:               flex;
            flex-direction:      column;
            /* justify-content:     center; */
            align-items:         center;
            @media (max-width: 1154px) {
                width:       80vw;
                margin-top:    2%;
                margin-bottom: 2%;
            }
        }

        article h2{
            margin:           0;
            color:    #223944;
            margin-bottom: 15px;
        }

        #booksContainer{
            display:                grid;
            grid-template-columns: 1fr ;
            gap: 5px;
            width: 90%;

            border: 2px #658291 dashed;
            border-radius:          20px;
            height:              80%;
            background-color:  #c8f7cd;
            padding:           10px 20px;
            overflow-y:           scroll;
            -ms-overflow-style:     none;    /* IE 10+ */
            scrollbar-width:         none;       /* Firefox */
            @media (max-width: 1200px){
            display:flex;
            flex-direction: column;
                width: 90%;
                /* height: auto; */
            }
            /* display:                  flex; */
            /* flex-direction:       column; */
            /* min-width:                   80%; */

        }
        #booksContainer::-webkit-scrollbar {
            display: none;               /* Chrome, Safari, Opera */
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
            height: max-content;
        }
        .bookItem.hidden {
            display: none;
        }
        .bookItem.disponible {
            background-color:        #b3e7d7;
        }
        .bookItem.disponiblent {
            background-color:        #fdc9c0;
        }

        .bookItem .book-cover {
            flex: 0 0 110px;
            height: 150px;
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
            margin-top: 8px !important;
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
            .bookItem .book-cover {
                flex-basis: 78px;
                height: 108px;
            }
            .bookItem .book-details strong {
                min-width: 76px;
            }
        }
        #titulo{
            display:                  flex;
            gap:                      10px;
            align-items:            center;
            @media (max-width: 600px){
                font-size: 14px;
            }

        }
        #addBooks {
            padding:    5px 5px;
            border:          none;
            border-radius:   25px;
            background: #009774;
            color:          white;
            cursor:       pointer;
            margin-bottom:   10px;
            font-size: 16px;
        }
        #search{
            display:          flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            flex-wrap:nowrap;
            gap: 10px;
        }
        #search input{
            padding: 4px 15px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            width: 80%;
            @media (max-width: 600px){
                width: 65%;
                font-size: 12px;
                padding: 4px 5px;
            }

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
            margin-bottom:         10px;
            background-color: #009774;
            border-radius:         20px;
            padding:                5px 10px;
            border:                none;
            color:               #fff;
            cursor:pointer;
            height: 100%;
            font-size: 16px;
            transition:all 0.3s ease;
            @media (max-width: 600px){
                font-size: 12px;
            }
        }
        #search button:hover{
            background-color: #009774;
        }
        #filters{
            display:flex;
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
        select{
            text-align:          center;
            margin-bottom:         10px;
            background-color: #87cead;
            border-radius:         20px;
            padding:                5px;
            border:                none;
            color:               #fff;
            cursor:pointer;

            /* width:                  10%; */
            /* font-weight:           bold; */
            @media (max-width: 600px){
                /* width: 57vw; */
            }
        }
        #pagination{
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 10px 0;
            color: #223944;
        }
        #pagination a,
        #filters button{
            border: none;
            border-radius: 20px;
            padding: 6px 12px;
            background: #009774;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

    </style>

    <article>
        <div id="titulo">
            <h2>Consultar Biblioteca</h2>
            <?php if (isset($_SESSION['username'])) {?>
                <?php if ($_SESSION['role'] === 'bibliotecario' or $_SESSION['role'] === 'admin') {?>
                    <button id="addBooks" onclick="window.location.href='/adminDashboards/addBooksDashboard.php'"><i class="fa-solid fa-plus"></i></button>
                <?php } ?>
            <?php } ?>
        </div>
        <form id="bookFilters" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="page" value="1">
            <div id="search">
                <input type="text" id="searchInput" name="q" value="<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>" placeholder="Buscar por Título">
                <button type="submit" aria-label="Buscar"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>

            <div id="filters">
            <div style="display:flex; flex-wrap:nowrap;">
                <label for="año">Año:</label>
                <select name="año" id="year">
                    <option value="">Todos</option>
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

            <div style="display:flex; flex-wrap:nowrap;">
                <label for="materia">Materia:</label>
                <select name="materia" id="materia" style="max-width: 95px; text-overflow: ellipsis;">
                    <option value="">Todos</option>
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
        <section id="booksContainer">
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
                        <h3><strong>Autor:</strong> <?php echo htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <h3><strong>Editorial:</strong> <?php echo htmlspecialchars($row['publisher'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <h3><strong>Año:</strong> <?php echo htmlspecialchars($row['year'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <h3><strong>Materia:</strong> <?php echo htmlspecialchars($row['materia'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <h3><strong>Copias:</strong> <?php echo htmlspecialchars((string) $row['num_copies'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <h3 class="book-status"><?php echo $isAvailable ? 'Disponible' : 'No disponible'; ?></h3>
                    </div>
                </div>
            </div>
            <?php } ?>

        </section>
        <nav id="pagination" aria-label="Paginación de libros">
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
    </article>
