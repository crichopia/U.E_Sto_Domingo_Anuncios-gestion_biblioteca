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
            @media (max-width: 850px) {
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

            @media (max-width: 1154px){
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
            width:100%;
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
            margin-bottom: 10px;
            @media (max-width: 1154px){
                width: 80%;
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
        }

        form textarea{
            border:        none;
            border-radius: 20px;
            margin-bottom: 10px;
            padding:        5px;
            resize:        none;
            /* width:         100%; */
            height:       100px;
        }
        select{
            text-align:          center;
            margin-bottom:         10px;
            background-color: #87cead;
            border-radius:         20px;
            padding:                5px;
            border:                none;
            color:               #fff;
            width:                  100%;

        }

        #botonSubmit{
            background: linear-gradient(135deg, #51e070, #009774);
            color: #fff;
            width:                  100%;
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
            --importance-color: #76b9a4;
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
            max-width: 100%;
        }

        .news_avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
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
            align-items: center;
            gap: 8px;
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
            color: #344b55;
            line-height: 1.5;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
        }

        .news_importance {
            display: inline-block;
            margin-left: auto;
            padding: 3px 9px;
            border-radius: 999px;
            color: #344b55;
            font-size: 12px;
            font-weight: bold;
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
            place-items: center;
            width: 100%;
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
                            <?php
                                $importance = in_array($row['importance'], ['normal', 'importante', 'urgente'], true)
                                    ? $row['importance']
                                    : 'normal';
                            ?>
                            <div class="news_item <?php echo htmlspecialchars($importance, ENT_QUOTES, 'UTF-8'); ?>">
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
                            </div>
                            <?php if (isset($_SESSION['username']) && $_SESSION['username'] === $row['author'] or $_SESSION['role'] === 'admin') { ?>
                                <div class="controlled_new_buttons">
                                    <a href="/controllers/crud_news.php?delId=<?php echo $row['id']; ?> "class="iconLink"><i class="fa-solid fa-trash"></i></a>
                                    <a href="/controllers/crud_news.php?editId=<?php echo $row['id']; ?>"class="iconLink"><i class="fa-solid fa-edit"></i></a>
                                </div>
                            <?php } ?>                                    

                        </div>
                <?php } ?>
            </section>
        </div>
    </article>