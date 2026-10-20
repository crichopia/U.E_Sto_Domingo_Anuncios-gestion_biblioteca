<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
    <style>
        body{
        margin:                      0;
        font-family: Arial, sans-serif;
        box-sizing:         border-box;
        }
        article{
            width:                 60vw;
            height:                70vh;
            background:       #b5e0c8;
            border: 2px #8abfb7 solid;
            padding:                 3%;
            margin-top:              5%;
            margin-bottom:           5%;
            border-radius:         20px;
            display:               flex;
            flex-direction:      column;
            justify-content:     center;
            align-items:         center;
            @media (max-width: 600px) {
                width:       80vw;
                margin-top:    2%;
                margin-bottom: 2%;
            }
        }
        #newsControlContainer{
            display:                  grid;
            grid-template-columns: 1fr 2fr;
            gap: 5px;
            /* flex-direction:       column; */
            border:   2px #658291 dashed;
            border-radius:            20px;
            width:                     80%;
            min-height:                85%;
            background-color:    #c8f7cd;
            padding:             10px 15px;
            overflow-y:             scroll;
            -ms-overflow-style:       none;    /* IE 10+ */
            scrollbar-width:          none;       /* Firefox */

            @media (max-width: 600px){
                /* grid-template-columns: 1fr; */
                display: flex;
                flex-direction: column;
                /* height: auto; */
            }
        }
        #newsControlContainer::-webkit-scrollbar {
            display: none;               /* Chrome, Safari, Opera */
        }

        article h2{
            margin:           0;
            color:    #223944;
            margin-bottom: 10px;
        }
        #formContainer{
            display:               flex;
            flex-direction:      column;
            justify-content:     center;
            align-items:         center;
        }
        form{
            background-color: #b5e0c8;
            border: 2px #8abfb7 solid;
            border-radius:         20px;
            padding:          15px 10px;
            display:               flex;
            flex-direction:      column;
            justify-content:     center;
            height:min-content;
            /* align-items:         center; */
            @media (max-width: 600px){
                width: 90%;
                margin-bottom: 10px;
            }

        }

        form h3{
            margin:           0;
            color:    #223944;
            margin-bottom: 10px;
        }

        form input{
            border:        none;
            border-radius: 20px;
            margin-bottom: 10px;
            padding:        5px;
            width:          90%;
            @media (max-width: 600px){
                width: 55vw;
            }
        }

        form textarea{
            border:        none;
            border-radius: 20px;
            margin-bottom: 10px;
            padding:        5px;
            resize: none;
            width:          90%;
            height:         100px;
            @media (max-width: 600px){
                width: 55vw;
                height: 60px;
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
            width:                  96%;
            /* font-weight:           bold; */
            @media (max-width: 600px){
                width: 57vw;
            }

        }

        #botonSubmit{
            background: linear-gradient(135deg, #51e070, #009774);
            color: #fff;
            width:                  96%;
            @media (max-width: 600px){
                width: 57vw;
            }

        }
        #news_container{
            display:                flex;
            flex-direction:       column;
            background-color:  #c8f7cd;
            padding:           10px 20px;
            overflow-y:           scroll;
            -ms-overflow-style:     none;    /* IE 10+ */
            scrollbar-width:         none;       /* Firefox */
            @media (max-width: 600px){
                padding: 5px 0px;
            }
        }

        #news_box::-webkit-scrollbar {
            display: none;               /* Chrome, Safari, Opera */
        }

        .news_item {
            border:       2px #658291 dashed;
            background-color:        #b3e7d7;
            border-radius:                25px;
            margin-bottom:                10px;
            padding:                 10px 10px;
            max-width:                100%;
        }

        .news_item hr{
            color:            #658291;
            background-color: #658291;
            /* height: 1px; */
        }

        .news_item h3{
            margin:           0;
            margin-bottom: 5px ;
        }

        .news_item h4{
            margin: 0;
        }

        .controlled_new{
            display: grid;
            grid-template-columns: 10fr 1fr;
            align-items: center;
            gap: 10px;
        }
        .controlled_new a{
            text-decoration: none;
            font-size: 20px;
            @media (max-width: 600px){
                font-size: 15px;
            }
        }

        .controlled_new_buttons{
            display: grid;
            height: 90%;
            grid-template-rows: 1fr 1fr;
            place-items: center;
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
        #booksFormWrapper {
            display: grid;
            grid-template-rows   : minmax(0, 1fr);
            opacity: 1;
            transition: grid-template-rows 0.35s ease, opacity 0.35s ease;
        }

        #booksFormWrapper.cerrado {
            grid-template-rows: minmax(0, 0fr);
            opacity: 0;
        }

        #booksFormWrapper > form {
            height: auto;
            min-height: 0;
            overflow: hidden;
        }

        @media (prefers-reduced-motion: reduce) {
            #booksFormWrapper {
                transition: none;
            }
        }
        .normal{
                background-color:        #b3e7d7;
            }
        .importante{
                background-color:        #f9e98f;
            }
        .urgente{
                background-color:        #e4a69b;
            }

</style>
    <article>

        <h2>Control de Noticias</h2>

        <div id="newsControlContainer">
            <div id="formContainer">
                <div id="booksFormWrapper">
                <form action="../controllers/crud_news.php" method="post">
    
                    <h3>Titulo</h3>
                    <input type="text" name="title" autofocus required=true placeholder="Titulo">
    
                    <h3>Contenido</h3>
                    <textarea name="content" required=true placeholder="Contenido"></textarea>
    
                    <select name="importance" id="materia">
                        <option value="normal">Normal</option>
                        <option value="importante">Importante</option>
                        <option value="urgente">Urgente</option>
                    </select>
                    <input id="botonSubmit" type="submit" name="save_announcement" value="Registrar Aviso" >
    
                </form>
                </div>
            <i class="fa-solid fa-angle-up icono-rotar" onclick="rotarIcono(this); abrirFormulario('booksFormWrapper')"></i>
            </div>

            <section id="news_container">
                <?php
                    $query = "SELECT * FROM announcements ORDER BY id DESC";
                    $result_tasks = $conn->query($query);
                    while ($row = $result_tasks->fetch(PDO::FETCH_ASSOC)) {?>
                        <div class="controlled_new">
                            <div class="news_item <?php echo $row['importance']; ?>">
                                <h3 class="new_title" id="title_new-1"><?php echo $row['title']; ?></h3>
                                <h4><span id="new_author"><?php echo $row['author']; ?></span> <span id="new_date"><?php echo $row['announcement_date']; ?></span></h4>
                                <hr>
                                <p class="new_content" id="new-1_content"><?php echo $row['content']; ?></p>
                            </div>
                            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $row['author'] or $_SESSION['role'] === 'admin') { ?>
                                <div class="controlled_new_buttons">
                                    <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_news.php?delId=<?php echo $row['id']; ?> "class="iconLink"><i class="fa-solid fa-trash"></i></a>
                                    <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_news.php?editId=<?php echo $row['id']; ?>"class="iconLink"><i class="fa-solid fa-edit"></i></a>
                                </div>
                            <?php } ?>                                    

                        </div>
                <?php } ?>
            </section>
        </div>
    </article>