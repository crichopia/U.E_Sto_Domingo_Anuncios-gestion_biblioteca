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

            @media (max-width: 800px) {
                width:       80vw;
                margin-top:    2%;
                margin-bottom: 2%;
            }
        }
        article h2{
            margin:           0;
            color:    #223944;
            margin-bottom: 10px;
            @media (max-width: 600px){
                font-size: 20px;
            }
        }
        #news_box{
            display:                flex;
            flex-direction:       column;
            border: 2px #658291 dashed;
            border-radius:          20px;
            width:                   80%;
            height:              85%;
            background-color:  #c8f7cd;
            padding:           10px 30px;
            @media (max-width: 600px){
                width: 90%;
                padding: 10px 10px;
                
            }
        }
        #news_container{
            display:                flex;
            flex-direction:       column;
            align-items:         center;
            overflow-y:           scroll;
            -ms-overflow-style:     none;    /* IE 10+ */
            scrollbar-width:         none;       /* Firefox */
        }
        #news_container::-webkit-scrollbar {
            display: none;               /* Chrome, Safari, Opera */
        }

        #filters{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 5px;
            font-weight: bold;
            color: #223944;
            font-size: 16px;
            place-items: center;
        }

        #modal_recomendar{
            z-index: 3;
            position: fixed;
            width: 60vw;
            min-width: max-content;
            max-width: 600px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            @media (max-width: 600px){
                width: 80vw;
            }

        }
        #formulario_recomendar{
            box-sizing: border-box;
            width: 100%;
            min-height: 40vh;
            background: #b5e0c8;
            border: 2px #8abfb7 solid;
            border-radius: 20px;
            padding: 5%;
            color: #223944;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        #formulario_recomendar h2{
            margin: 10px 0px;
            @media (max-width: 600px){
                font-size: 18px;
            }

        }
        #cerrar_modal_filters{
            box-sizing: border-box;
            padding: 0;
            width: 35px;
            height: 35px;
            text-align: center;
            background: #009774;
            color: #ffffff;
            font-size: 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            position: absolute;
            top: 15px;
            right: 15px;
        }

        .news_item {
            border:       2px #658291 dashed;
            background-color:        #b3e7d7;
            border-radius:                25px;
            margin-bottom:                10px;
            padding:                 10px 20px;
            width:                         80%;
            @media (max-width: 600px){
                width: 85%;
            }
        }

        .news_item .hidden{
            display: none;
        }
        
        .news_item hr{
            color:            #658291;
            background-color: #658291;
            /* height: 1px; */
        }

        .news_item h3{
            margin:           0;
            margin-bottom: 5px ;
            @media (max-width: 600px){
                font-size: 18px;
            }
        }

        .news_item h4{
            margin: 0;
            @media (max-width: 600px){
                font-size: 16px;
            }
        }
        .recommendation_list{
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .recommendation_item{
            display: flex;
            align-items: center;
            width: 100%;
            gap: 12px;
        }
        .recommendation_item + .recommendation_item{
            padding-top: 12px;
            border-top: 1px solid #8abfb7;
        }
        .recommendation_details{
            flex: 1 1 auto;
            width: 100%;
            min-width: 0;
        }
        .recommendation_row{
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 10px;
            width: 100%;
        }
        .recommendation_description{
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }
        .recommendation_description h4{
            min-width: 0;
        }
        .recommendation_item .url{
            max-width: 100%;
        }
        .recommendation_delete{
            flex: 0 0 auto;
        }
        #addRecomendation {
            padding:    5px 8px;
            border:          none;
            border-radius:   25px;
            background: #009774;
            color:          white;
            cursor:       pointer;
            /* margin-bottom:   10px; */
            font-size: 16px;
            @media (max-width: 600px){
                font-size: 12px;
            }
        }
        #openFilters{
            padding: 5px 8px;
            margin:15px 0px;
            border: none;
            border-radius: 25px;
            background: #009774;
            color: white;
            cursor: pointer;
            font-size: 16px;
            width: 15dvw;
            @media (max-width: 600px){
                width: 80%;
                font-size: 14px;
            }
        }
        .new_url{
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 16px;
            border: none;
            width: 20dvw;
            @media (max-width: 600px){
            width: 100%;
                font-size: 12px;
            }
        }
        .url{
            display: inline-block; /* O 'block' según tu diseño */
            max-width: 200px;      /* Define el ancho máximo que deseas */
            overflow: hidden;      /* Esconde el texto que se pasa del límite */
            white-space: nowrap;   /* Evita que el texto salte a la siguiente línea */
            text-overflow: ellipsis; /* Añade los tres puntos (...) al final */
        
        }
        select{
            padding: 5px 8px;
            margin:15px 0px;
            border: none;
            border-radius: 25px;
            text-align:          center;
            background-color: #87cead;
            color: white;
            cursor: pointer;
            font-size: 16px;
            width: 10dvw;
            @media (max-width: 600px){
                width: 80%;
                font-size: 14px;
            }
        }
        .controlled_new a{
            text-decoration: none;
            align-self:flex-end;
            width:100%;
            align-items: center;
            place-items: center;
            font-size: 20px;
            @media (max-width: 600px){
                /* font-size: 15px; */
            }
        }
.iconLink{
    text-decoration: none;
    color: #223944;

}

    </style>

    <article>
        <h2>Paginas Recomendadas:</h2>

        <div id="news_box">
            <div style="display:flex; justify-content:center; gap:5px;">
                <select name="importance" id="importance" onchange="filtrarNoticias()">
                    <option value="">Filtrar</option>
            
                <?php
                    $query = "SELECT username FROM user_data ";
                    $result_tasks = $conn->query($query);
                    while ($row = $result_tasks->fetch(PDO::FETCH_ASSOC)) {?>

                        <option value="<?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php } ?>
                </select>
                <?php if (isset($_SESSION['username'])) {?>
                    <button type="button" id="openFilters" onclick="abrirModal('modal_recomendar')">Recomendar una Página</button>
                <?php } ?>
            </div>
            <section id="news_container">
                <?php
                    $query = "SELECT * FROM recomendations ORDER BY autor ASC, id DESC";
                    $result_tasks = $conn->query($query);
                    $recommendationsByAuthor = [];
                    while ($row = $result_tasks->fetch(PDO::FETCH_ASSOC)) {
                        $recommendationsByAuthor[$row['autor']][] = $row;
                    }

                    foreach ($recommendationsByAuthor as $author => $recommendations) { ?>
                        <div class="news_item" data-author="<?php echo htmlspecialchars($author, ENT_QUOTES, 'UTF-8'); ?>">
                            <h3 class="new_title">Recomendaciones de: <?php echo htmlspecialchars(ucwords($author), ENT_QUOTES, 'UTF-8'); ?></h3>
                            <hr>
                            <ul class="recommendation_list">
                                <?php foreach ($recommendations as $recommendation) { ?>
                                    <li class="recommendation_item">
                                        <div class="recommendation_details">
                                            <div class="recommendation_row">
                                                <div class="recommendation_description">
                                                    <?php if (isset($_SESSION['username']) && ($_SESSION['username'] === $author || (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'))) { ?>
                                                        <a href="/controllers/crud_recomendations.php?delId=<?php echo urlencode($recommendation['id']); ?>" class="iconLink recommendation_delete" aria-label="Eliminar recomendación"><i class="fa-solid fa-trash"></i></a>
                                                    <?php } ?>
                                                    <p><?php echo htmlspecialchars(ucfirst($recommendation['descripcion']), ENT_QUOTES, 'UTF-8'); ?></p>
                                                </div>
                                                <a title="visitar" href="<?php echo htmlspecialchars($recommendation['url_recomendacion'], ENT_QUOTES, 'UTF-8'); ?>" class="url" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-arrow-up-right-from-square"></i> </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
            </section>
        </div>
    </article>

    <div class="overlay hidden"></div>

    <div class="modal hidden" id="modal_recomendar">
        <div id="formulario_recomendar">
            <button type="button" id="cerrar_modal_filters" onclick="cerrarModal('modal_recomendar')"><i class="fa-solid fa-xmark"></i></button>
            <h2 >Recomendar una Página</h2>
            <form id="filters" action="../controllers/crud_recomendations.php" method="post">
                    <input type="text" class="new_url" name="description" placeholder="Descripcion de la página recomendada">
                    <input type="url" class="new_url" name="url" placeholder="URL de la Página Recomendada">
                    <input type="submit" name="save_recomendation" id="addRecomendation" value="Recomendar">
            </form>
        </div>
    </div>
