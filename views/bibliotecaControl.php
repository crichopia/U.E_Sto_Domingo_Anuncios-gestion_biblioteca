<?php 
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/validarSesionBiblioteca.php';
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
                            <option value="2do año">2do Año</option>
                            <option value="3er año">3er Año</option>
                            <option value="4to año">4to Año</option>
                            <option value="5to año">5to Año</option>
                            <option value="1er año">1er Año</option>
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
        <div id="search">
            <input type="text" id="searchInput" placeholder="Buscar por Título">
            <button onclick="filtrarPorTitulo('searchInput', '.controlled_book', '.book_title')">Buscar</button>
        </div>
        
            <?php
                    $query = "SELECT * FROM books ORDER BY id DESC";
                    $result_tasks = $conn->query($query);
                    while ($row = $result_tasks->fetch(PDO::FETCH_ASSOC)) {?>
                <div class="controlled_book">
                    <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_books.php?delId=<?php echo (int) $row['id']; ?>" class="iconLink"><i class="fa-solid fa-trash"></i></a>
                    <div class="bookItem" >
                        <img src="<?php echo $row['img_url']; ?>" alt="Portada del Libro">
                        <div>
                            <h3 class="book_title"><?php echo $row['title']; ?> </h3>

                            <h4>Autor: <?php echo $row['author']; ?></h4>
                            <h4>Editorial: <?php echo $row['publisher']; ?></h4>
                            <h4><span><?php if($row['year'] !== "n/a") { ?><span>Año:</span> <span><?php echo $row['year'];?></span> <?php } ?></span>
                            <span><?php if($row['materia'] !== "n/a") { ?><span>Materia:</span> <span><?php echo $row['materia'];?></span> <?php } ?></span>
                            </h4>
                            <h4> Numero de Copias: <span><?php echo $row['num_copies']; ?></span></h4>
                            <h4>Estado:<span><?php echo ((int) $row['num_copies'] > 0) ? 'disponible' : 'no disponible'; ?></span></h4>
                        </div>
                    </div>
                </div>

            <?php } ?>
            </section>
        </div>
    </article>