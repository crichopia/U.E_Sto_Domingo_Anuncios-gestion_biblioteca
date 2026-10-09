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
            width: 80%;
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
        }

        .news_item h4{
            margin: 0;
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

    </style>

</head>
<body>
    <article>
        <h2>Paginas Recomendadas:</h2>

        <div id="news_box">
            <div style="display:flex; justify-content:center; gap:5px;">
                <select name="importance" id="importance" onchange="filtrarNoticias()">
                    <option value="">n/a</option>
            
                <?php
                    $query = "SELECT * FROM user_data ";
                    $result_tasks = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result_tasks)) {?>

                        <option value="<?php 
                        $autor = $row['username'];
                        $sin_espacios = str_replace(' ', '', $autor);
                        echo($sin_espacios);?>">
                            <?php echo($row['username']);?>
                        </option>
                    <?php } ?>
                </select>

                <button type="button" id="openFilters" onclick="abrirModal('modal_recomendar')">Recomendar una Página</button>
            </div>
            <section id="news_container">
                <?php
                    $query = "SELECT * FROM recomendations ORDER BY autor DESC";
                    $result_tasks  = mysqli_query($conn, $query);

                    while($row = mysqli_fetch_array($result_tasks)){?>
                        <div class="news_item <?php
                        $autor = $row['autor'];
                        $sin_espacios = str_replace(' ', '', $autor);
                        echo ($sin_espacios); ?>">

                        <div style="display:flex; gap:20px;">
                            <h3 class="new_title" id="title_new-1">Recomendacion de: <?php echo $row['autor']; ?></h3>
                            <?php if (isset($_SESSION['username'])) { ?>
                                <?php if (($_SESSION['username'] === $row['autor'] || $_SESSION['role'] === 'admin')){?>
                                <div class="controlled_new">
                                    <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_recomendations.php?delId=<?php echo $row['id']; ?>">🗑️</a>
                                </div>
                                <?php } ?>
                            <?php } ?>                                    
                        </div>
                            <hr>
                            <h4><?php echo $row['descripcion']; ?></h4>
                            <a href="<?php echo $row['url_recomendacion']; ?>" target="_blank"><?php echo $row['url_recomendacion']; ?></a>
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
</body>
</html>