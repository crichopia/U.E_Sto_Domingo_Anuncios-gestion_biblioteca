<?php 
include __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/validarSesionBiblioteca.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

            @media (max-width: 600px) {
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
            height: 85%;
            background-color: #c8f7cd;
            padding: 10px 15px;
            overflow-y: scroll;
            -ms-overflow-style: none;
            scrollbar-width: none;

            @media (max-width: 1154px) {
                display: grid;
                grid-template-columns: 1fr;
                /* place-items: center; */
                height: auto;
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

        form h3 {
            margin: 0;
            color: #223944;
            margin-bottom: 2px;
        }
        h2 {
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
        .controlarLibro:hover {
            background-color: #009774;
        }
        .controlarLibro.hidden {
            display: none;
        }

        #books_container {
            display: flex;
            flex-direction: column;
            /* background-color: #c8f7cd; */
            padding: 10px 20px;
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
            background-color: #b3e7d7;
            border-radius: 25px;
            margin-bottom: 10px;
            padding: 10px 10px;
            /* padding-right: 0px; */
            display: flex;
            gap: 10px;
            align-items: center;
            color: #223944;
        }
        .bookItem.hidden {
            display: none;
        }


        .bookItem h3{
            margin: 0;
        }

        .bookItem h4{
            margin: 0;
        }
        .bookItem img {
            width: 120px;
            height: 150px;
            border-radius: 10px;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            @media (max-width: 800px) {
                width: 100px;
                height: 120px;            }

        }

        .loanItem {
            border: 2px #658291 dashed;
            background-color: #b3e7d7;
            border-radius: 25px;
            margin-bottom: 10px;
            padding: 10px 25px;
            /* padding-right: 0px; */
            display: flex;
            flex-direction: column;
            gap: 5px;
            /* align-items: center; */
            color: #223944;
        }

        .loanItem h3 {
            margin: 10px 0px;
        }

        .loanItem h4 {
            margin-top: 0;
            margin-bottom: 0;
            /* margin-left: 10px; */

            @media (max-width: 900px) {
                font-size: 15px;
                margin-left: 0px;
            }
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
            margin-bottom: 10px;
            flex-wrap: nowrap;
            gap: 10px;
        }

        #search input {
            padding: 4px 15px;
            border-radius: 20px;
            border: none;
            font-size: 16px;
            width: 96%;

            @media (max-width: 600px) {
                width: 85%;
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
            /* height: 1px; */
        }
    #modal_libros {
        z-index:                        3;
        position:                   fixed;
        width:                       60vw;
        max-width:                  600px;
        top:                          50%;
        left:                         50%;
        transform:  translate(-50%, -50%);
    }
        #formulario_libros{
            width:                      50vw;
            max-height:                 70vh;
            background:            #b5e0c8;
            border:      2px #8abfb7 solid;
            color:                 #000000;
            padding:                      5%;
            margin-top:                   5%;
            margin-bottom:                5%;
            border-radius:              20px;
            display:                    flex;
            flex-direction:           column;
            justify-content:          center;
            align-items:              center;
            position:               absolute;
            top:                         50%;
            left:                        50%;
            transform: translate(-50%, -50%);
            box-sizing:           border-box;

            @media (max-width: 600px) {
                width:       80vw;
                margin-top:    2%;
                margin-bottom: 2%;
            }
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
        #cerrarModar{
            background: none;
            border: none;
            cursor: pointer; 
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px; 
            align-self: flex-end;
            color: #223944;

        }
    </style>
</head>
<body>
    <article>

        <h2>Agregar libros</h2>

        <div id="newsControlContainer">
        <div id="formContainer">    
        <form action="../controllers/crud_loans.php" method="post">

                <h3>Nombre estudiante:</h3>
                <input type="text" name="nombreE" autofocus required=true placeholder="Nombre del estudiante">

                <h3>Cedula</h3>
                <input type="text" name="cedulaE" placeholder="Cedula">

                <h3>Bibliotecario</h3>
                <input type="text" name="bibliotecario" required=true placeholder="Bibliotecario" readonly value="<?php echo $_SESSION['username']; ?>">

                <h3>Libro</h3>
                <div style=" display: flex; gap: 5px; align-items: center;">
                <input id="book_name" type="text" name="book_name" placeholder="nombre del libro" readonly required style=" width: 80%;">
                <button id="boton_Aniadir" class="controlarLibro" type="button" onclick="abrirModal('modal_libros')"><i class="fa-solid fa-plus"></i></button>
                <button id="boton_Eliminar" class="controlarLibro hidden" type="button" onclick="eliminarLibroDelPrestamo('book_name', 'book_id'); cambiarBotonPrestamo('boton_Aniadir', 'boton_Eliminar');"><i class="fa-solid fa-minus"></i></button>
                </div>
                <input id="book_id" class="hidden" type="text" name="book_id" readonly >
                <input id="botonSubmit" type="submit" name="save_loan" value="Registrar libro" >

            </form>
        </div>
            <section id="books_container">
            <?php
                    $query = "SELECT * FROM loans ORDER BY id DESC";
                    $result_tasks  = mysqli_query($conn, $query);

                    while($row = mysqli_fetch_array($result_tasks)){?>
                <div class="controlled_book">
                    <div class="loanItem" >
                        <div style="display: flex; gap: 5px; align-items: baseline;">
                            <h3 class="loanData"><?php echo $row['student_name']; ?> </span></h3>
                            <h4><?php echo $row['loan_date']; ?></h4>
                            <a class="iconLink" href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_loans.php?delId=<?php echo (int) $row['id']; ?>"><i class="fa-solid fa-trash"></i></a>
                        </div>
                        <hr>
                        <div>
                            <h4 class="loanData">Cedula: <?php echo $row['cedula']; ?></h4>
                            <h4 class="loanData">Libro: <?php echo $row['book_name']; ?></h4>
                            <h4 class="loanData">Bibliotecario: <?php echo $row['bibliotecario']; ?></h4>
                        </div>
                    </div>
                </div>

            <?php } ?>
            </section>
        </div>
    </article>

    <div class="overlay hidden"></div>

    <div class="modal hidden" id="modal_libros">
        <div id="formulario_libros">

            <button id="cerrarModar" onclick="cerrarModal('modal_libros')"><i class="fa-solid fa-xmark"></i></button>

            <h2>Libros</h2>
        <div id="search">
            <input type="text" id="searchInput" placeholder="Buscar por título" oninput="filtrarPorTitulo('searchInput', '#modal_libros .bookItem', '.book_title') ">
        </div>

            <section id="books_container">
                <?php
                    $query = "SELECT * FROM books ORDER BY id DESC";
                    $result_tasks  = mysqli_query($conn, $query);

                    while($row = mysqli_fetch_array($result_tasks)){?>
                <div class="controlled_book">
                <div class="bookItem" id="<?php echo $row['id']; ?>" data-year="<?php echo htmlspecialchars($row['year'], ENT_QUOTES, 'UTF-8'); ?>" data-materia="<?php echo htmlspecialchars($row['materia'], ENT_QUOTES, 'UTF-8'); ?>">
                    <img src="<?php echo $row['img_url']; ?>" alt="portada dellibro">
                    <div style="display: flex; width:100%; flex-direction: column; gap: 5px;">
                        <h3 class="book_title"><?php echo $row['title']; ?></h3>
                        <h4>Año: <?php echo $row['year']; ?></h4>
                        <h4>Materia: <?php echo $row['materia']; ?></h4>
                        <?php if ($row['num_copies'] > 0) { ?>
                        <div class="centerTheDamnButton">
                            <button class="controlarLibro" type="button" onclick="cerrarModal('modal_libros'); prestarLibro('book_name', 'book_id', '<?php echo($row['title']); ?>', <?php echo (int) $row['id']; ?>); cambiarBotonPrestamo('boton_Aniadir', 'boton_Eliminar');"><i class="fa-solid fa-check"></i></button>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                </div>
                <?php } ?>
            </section>
        </div>
</body>
</html>
