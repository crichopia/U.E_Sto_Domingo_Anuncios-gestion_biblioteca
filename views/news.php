<?php require_once __DIR__ . '/../config/db.php'; ?>
<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>
    <style>
        body{
        margin:                      0;
        font-family: Arial, sans-serif;
        box-sizing:         border-box;
        }

        .news_panel{
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
        .news_panel h2{
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
            padding:  5px 5px ;
            font-weight:             bold;
            color:              #223944;
            font-size:               16px;
            place-items: center;

        }


        .news_item {
            --importance-color: #76b9a4;
            /* display: grid;
            grid-template-columns: 42px minmax(0, 1fr); */
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 12px;
            padding: 14px;
            border: 1px solid #d8e4e7;
            border-left: 4px solid var(--importance-color);
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(34, 57, 68, 0.08);
        }

        .news_avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #d9f2e8;
            color: #08785f;
            font-size: 18px;
        }

        .news_item.normal {
            --importance-color: #58a98d;
        }

        .news_item.importante {
            --importance-color: #e1b52c;
        }

        .news_item.urgente {
            --importance-color: #d66c5d;
        }

        .news_item.normal .news_importance {
            background: #e2f3ed;
        }

        .news_item.importante .news_importance {
            background: #fff5cc;
        }

        .news_item.urgente .news_importance {
            background: #fbe5e1;
        }

        .news_item_body {
            min-width: 0;
        }

        .news_item_header {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            gap: 4px 8px;
            margin-bottom: 8px;
        }

        .news_item_header h3 {
            margin: 0;
            color: #223944;
            font-size: 16px;
        }

        .news_item_header time {
            color: #6d7f87;
            font-size: 13px;
        }

        .news_item_body h4 {
            margin: 0 0 6px;
            color: #223944;
            font-size: 18px;
        }

        .news_content {
            margin: 0;
            padding: 0;
            text-align: justify;
            color: #344b55;
            line-height: 1.5;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .news_importance {
            display: inline-block;
            margin-top: 10px;
            padding: 3px 9px;
            border-radius: 999px;
            color: #344b55;
            font-size: 12px;
            font-weight: bold;
        }
        #addNews {
            padding:    5px 5px;
            border:          none;
            border-radius:   25px;
            background: #009774;
            color:          white;
            cursor:       pointer;
            margin-bottom:   10px;
            font-size: 16px;
        }
    </style>

    <article class="news_panel">
        <h2>Noticias</h2>

        <div id="news_box">
            <nav id="filters">
                <!-- <hr> -->
                <label for="importance">Filtrar</label>
                <select name="importance" id="importance" onchange="filtrarNoticias()">
                    <option value="">n/a</option>
                    <option value="normal">Normal</option>
                    <option value="importante" class="importante">Importante</option>
                    <option value="urgente" class="urgente">Urgente</option>
                </select>

                <?php if (isset($_SESSION['username'])) {?>
                    <button id="addNews" onclick="window.location.href='/adminDashboards/addNewsDashboard.php'"><i class="fa-solid fa-plus"></i></button>
                <?php } ?>

                <!-- <hr> -->
            </nav>

            <section id="news_container">
                <?php
                    $query = "SELECT * FROM announcements ORDER BY id DESC";
                    $result_tasks = $conn->query($query);

                    while ($row = $result_tasks->fetch(PDO::FETCH_ASSOC)) {?>
                        <?php
                            $importance = in_array($row['importance'], ['normal', 'importante', 'urgente'], true)
                                ? $row['importance']
                                : 'normal';
                        ?>
                        <article class="news_item <?php echo htmlspecialchars($importance, ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="news_item_body">
                                <div class="news_item_header">
                                    <span class="news_avatar" aria-hidden="true"><i class="fa-solid fa-user"></i></span>
                                    <h3><?php echo htmlspecialchars(ucwords($row['author']), ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <time><?php echo htmlspecialchars($row['announcement_date'], ENT_QUOTES, 'UTF-8'); ?></time>
                                    <span class="news_importance"><?php echo ucfirst(htmlspecialchars($importance, ENT_QUOTES, 'UTF-8')); ?></span>
                                </div>
                                <h4><?php echo htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'); ?></h4>
                                <p class="news_content"><?php echo htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                        </article>
                <?php } ?>

            </section>
        </div>

    </article>