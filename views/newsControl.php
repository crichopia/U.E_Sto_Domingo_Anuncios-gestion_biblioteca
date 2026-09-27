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
            height:                    85%;
            background-color:    #c8f7cd;
            padding:             10px 15px;
            overflow-y:             scroll;
            -ms-overflow-style:       none;    /* IE 10+ */
            scrollbar-width:          none;       /* Firefox */

            @media (max-width: 600px){
                /* grid-template-columns: 1fr; */
                display: block;
                height: auto;
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
</style>
</head>
<body>
    <article>

        <h2>Control de usuarios</h2>

        <div id="newsControlContainer">
            <div id="formContainer">
                
                <form action="../controllers/crud_news.php" method="post">
    
                    <h3>Titulo</h3>
                    <input type="text" name="title" autofocus required=true placeholder="titulo">
    
                    <h3>Contenido</h3>
                    <textarea name="content" required=true placeholder="contenido"></textarea>
    
                    <select name="importance" id="materia">
                        <option value="normal">normal</option>
                        <option value="importante">importante</option>
                        <option value="urgente">urgente</option>
                    </select>
                    <input id="botonSubmit" type="submit" name="save_announcement" value="Registrar aviso" >
    
                </form>
            </div>

            <section id="news_container">
                <?php
                    $query = "SELECT * FROM announcements ORDER BY id DESC";
                    $result_tasks  = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($result_tasks)){?>
                        <div class="controlled_new">
                            <div class="news_item <?php echo $row['importance']; ?>">
                                <h3 class="new_title" id="title_new-1"><?php echo $row['title']; ?></h3>
                                <h4><span id="new_author"><?php echo $row['author']; ?></span> <span id="new_date"><?php echo $row['announcement_date']; ?></span></h4>
                                <hr>
                                <p class="new_content" id="new-1_content"><?php echo $row['content']; ?></p>
                            </div>
                            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $row['author'] or $_SESSION['role'] === 'admin') { ?>
                                <div class="controlled_new_buttons">
                                    <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_news.php?delId=<?php echo $row['id']; ?>">🗑️</a>
                                    <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_news.php?editId=<?php echo $row['id']; ?>">✏️</a>
                                </div>
                            <?php } ?>                                    

                        </div>
                <?php } ?>
            </section>
        </div>
    </article>
</body>
</html>