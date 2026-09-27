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
        }
        #adminNewsButtons{
            display:       flex;
            margin-bottom: 10px;
            gap:           10px;
            @media (max-width:600px) {
                gap: 5px;
            }
        }

        #adminNewsButtons button{
            padding:    5px 30px;
            border:          none;
            border-radius:   25px;
            background: #009774;
            color:        white;
            font-size:       18px;
            cursor:       pointer;

            @media (max-width: 600px) {
                font-size:   16px;
                padding: 5px 20px;
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
            padding:           10px 20px;
        }
        #news_container{
            display:                flex;
            flex-direction:       column;
            overflow-y:           scroll;
            -ms-overflow-style:     none;    /* IE 10+ */
            scrollbar-width:         none;       /* Firefox */
        }
        #news_container::-webkit-scrollbar {
            display: none;               /* Chrome, Safari, Opera */
        }
        select{
            text-align:          center;
            margin-bottom:         10px;
            background-color: #87cead;
            border-radius:         20px;
            padding:                5px;
            border:                none;
            color:               #fff;
            /* width:                  10%; */
            /* font-weight:           bold; */
            @media (max-width: 600px){
                /* width: 57vw; */
            }
        }

        .newsNavBtn {
            text-decoration:         none;
            font-weight:             bold;
            color:              #223944;
            background-color: transparent;
            border:                  none;
            cursor:               pointer;
            font-size:               16px;
        }

        #filters{
            display:         flex;
            align-items:    center;
            justify-content:     center;
            /* height: 5%; */
            gap:             10px;
            padding:  5px 15px ;
            font-weight:             bold;
            color:              #223944;
            font-size:               16px;
            place-items: center;

        }


        .news_item {
            border:       2px #658291 dashed;
            border-radius:                25px;
            margin-bottom:                10px;
            padding:                 10px 10px;
        }

        .news_ite .hidden{
            display: none;
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
        #addNews {
            padding:    5px 8px;
            border:          none;
            border-radius:   25px;
            background: #009774;
            color:          white;
            cursor:       pointer;
            margin-bottom:   10px;
            font-size: 16px;
        }

    </style>

</head>
<body>
    <article>
        <h2>Noticias</h2>

        <div id="news_box">
            <nav id="filters">
                <!-- <hr> -->
                <label for="importance">Filtrar</label>
                <select name="importance" id="importance" onchange="filtrarNoticias()">
                    <option value="">n/a</option>
                    <option value="normal">normal</option>
                    <option value="importante">importante</option>
                    <option value="urgente">urgente</option>
                </select>

                <?php if (isset($_SESSION['username'])) {?>
                    <button id="addNews" onclick="window.location.href='/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/adminDashboards/addNewsDashboard.php'">Nueva Noticia</button>
                <?php } ?>

                <!-- <hr> -->
            </nav>

            <section id="news_container">
                <?php
                    $query = "SELECT * FROM announcements ORDER BY id DESC";
                    $result_tasks  = mysqli_query($conn, $query);

                    while($row = mysqli_fetch_array($result_tasks)){?>
                        <div class="news_item <?php echo $row['importance']; ?>">
                            <h3 class="new_title" id="title_new-1"><?php echo $row['title']; ?></h3>
                            <h4><span id="new_author"><?php echo $row['author']; ?></span> <span id="new_date"><?php echo $row['announcement_date']; ?></span></h4>
                            <hr>
                            <p class="new_content" id="new-1_content"><?php echo $row['content']; ?></p>
                        </div>
                <?php } ?>

            </section>
        </div>

    </article>
</body>
</html>