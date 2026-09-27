<?php include __DIR__ . '/../config/db.php';?>
<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
        margin:                      0;
        font-family: Arial, sans-serif;
        box-sizing:         border-box;
        }
        article{
            /* box-sizing:         border-box; */
            width:                 60vw;
            height:                70vh;
            background:       #b5e0c8;
            border: 2px #8abfb7 solid;
            padding:                 5% 5%;
            margin-top:              5%;
            margin-bottom:           5%;
            border-radius:         20px;
            display:               flex;
            flex-direction:      column;
            /* justify-content:     center; */
            align-items:         center;
            @media (max-width: 970px) {
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
            grid-template-columns: 1fr 1fr;
            gap: 5px;
            width: 90%;

            border: 2px #658291 dashed;
            border-radius:          20px;
            height:              85%;
            background-color:  #c8f7cd;
            padding:           10px 20px;
            overflow-y:           scroll;
            -ms-overflow-style:     none;    /* IE 10+ */
            scrollbar-width:         none;       /* Firefox */
            @media (max-width: 970px){
                grid-template-columns: 1fr;
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
            border:       2px #658291 dashed;
            background-color:        #b3e7d7;
            border-radius:                25px;
            margin-bottom:                10px;
            padding:                 10px 10px;
            display:                      flex;
            height:min-content;
            gap:                          10px;
            align-items:                center;
            color:                   #223944;

        }
        .bookItem.hidden {
            display: none;
        }
        .bookItem img{
            width:             110px;
            height:            150px;
            border-radius:      10px;
            background-color: #fff;
            display:            flex;
            align-items:      center;
            justify-content:  center;
        }
        .bookItem h3{
            margin: 10px;
        }
        .bookItem h4{
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 10px;
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
            padding:    5px 8px;
            border:          none;
            border-radius:   25px;
            background: #009774;
            color:          white;
            cursor:       pointer;
            margin-bottom:   10px;
            font-size: 16px;
            @media (max-width: 600px){
                font-size: 12px;
            }
        }
        #search{
            display:          flex;
            margin-bottom: 10px;
            flex-wrap:nowrap;
            gap: 10px;
        }
        #search input{
            padding: 2px 15px;
            border-radius: 20px;
            border: none;
            width: 40dvw;
            @media (max-width: 600px){
                width: 50dvw;
                font-size: 12px;
                padding: 2px 5px;
            }

        }
        #search button{
            text-align:          center;
            margin-bottom:         10px;
            background-color: #87cead;
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
            flex-wrap:nowrap;
            gap:10px;
            align-items: center;
            @media (max-width: 600px){
                font-size: 14px;
            }

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

    </style>

</head>
<body>
    <article>
        <div id="titulo">
            <h2>Consultar biblioteca</h2>
            <?php if (isset($_SESSION['username'])) {?>
                <?php if ($_SESSION['role'] === 'bibliotecario' or $_SESSION['role'] === 'admin') {?>
                    <button id="addBooks" onclick="window.location.href='/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/adminDashboards/addBooksDashboard.php'">Añadir Libros</button>
                <?php } ?>
            <?php } ?>
        </div>
        <div id="search">
            <input type="text" id="searchInput" placeholder="Buscar por título">
            <button onclick="filtrarPorTitulo('searchInput', '.bookItem', '.book_title')">Buscar</button>

        </div>

        <div id="filters">
            <label for="año">Año:</label>
            <select name="año" id="year" onchange="filtrarLibros()">
                <option value="">todos</option>
                <option value="1er grado">1er grado</option>
                <option value="2do grado">2do grado</option>
                <option value="3er grado">3er grado</option>
                <option value="4to grado">4to grado</option>
                <option value="5to grado">5to grado</option>
                <option value="6to grado">6to grado</option>
                <option value="1er año">1er año</option>
                <option value="2do año">2do año</option>
                <option value="3er año">3er año</option>
                <option value="4to año">4to año</option>
                <option value="5to año">5to año</option>
                <option value="n/a">n/a</option>
            </select>

            <label for="materia">Materia:</label>
            <select name="materia" id="materia" onchange="filtrarLibros()">
                <option value="">todos</option>
                <option value="ninguna">n/a</option>
                <option value="matematicas">matematicas</option>
                <option value="biologia">biologia</option>
                <option value="quimica">quimica</option>
                <option value="fisica">fisica</option>
                <option value="educ.fisica">educ.fisica</option>
                <option value="geografia">geografia</option>
                <option value="historia">historia</option>
                <option value="arte">arte y patrimonio</option>
                <option value="castellano">castellano</option>
            </select>
        </div>
        <section id="booksContainer">
            <!-- <div class="bookItem" >
                <img src="" alt="portada del libro">
                <div>
                    <h3 class="book_title">El Cardenalito</h3>
                    <h4>autor:</h4>
                    <h4>editorial:</h4>
                    <h4><span>año:</span> <span>materia:</span></h4>
                    <h4>estado:<span></span></h4>
                    <h4> numero de copias: <span>2</span></h4>
                </div>
            </div> -->
            <?php
                $query = "SELECT * FROM books ORDER BY id DESC";
                $result_tasks  = mysqli_query($conn, $query);

                while($row = mysqli_fetch_array($result_tasks)){?>
            <div class="bookItem" data-year="<?php echo htmlspecialchars($row['year'], ENT_QUOTES, 'UTF-8'); ?>" data-materia="<?php echo htmlspecialchars($row['materia'], ENT_QUOTES, 'UTF-8'); ?>">
                <img src="<?php echo $row['img_url']; ?>" alt="portada del libro">
                <div>
                    <h3 class="book_title"><?php echo $row['title']; ?></h3>

                    <!-- <h4>autor: <?php echo $row['author']; ?></h4> -->
                    <!-- <h4>editorial: <?php echo $row['publisher']; ?></h4> -->
                    <h4><span>año:</span> <span><?php echo $row['year']; ?></span>
                    <span>materia:</span> <span><?php echo $row['materia']; ?></span></h4>
                    </h4>
                    <h4>estado:<span><?php echo $row['status']; ?></span></h4>
                    <h4> numero de copias: <span><?php echo $row['num_copies']; ?></span></h4>
                </div>
            </div>
            <?php } ?>

        </section>
    </article>
</body>
</html>
