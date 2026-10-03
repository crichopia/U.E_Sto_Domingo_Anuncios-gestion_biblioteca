<!-- <?php session_start(); ?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            margin:                      0;
            font-family: Arial, sans-serif;
            box-sizing:         border-box;
            font-size:                18px;
            

        }
        header {
            box-sizing:                                    border-box;
            background: linear-gradient(135deg, #51e070, #009774);
            width:                                               100%; 
            color:                                            white;
            padding-top:                                          5px;
            padding-bottom:                                       0px;
            padding-left:                                        10px;
            padding-right:                                       10px;
            text-align:                                        center;
            @media (max-width: 600px){
                font-size:                                       14px;
                padding-top:                                      8px;
                padding-bottom:                                   8px;
                gap:                                             10px;
            }
            
        }

        #principal{
            display:                                             grid;
            place-items:                                       center;
            grid-template-columns:                        1fr 1fr 1fr;
        }

        nav{
            box-sizing:         border-box;
            display:           flex;
            flex-wrap:         wrap;
            justify-content: center;
            align-items:     center;
            gap:               5px;
        }

        nav a{
            text-decoration:         none;
            color:                 #fff;
            display:                flex;
            justify-content:       center;
            align-items:           center;
            padding:                 2px 5px;
            height:                  30px;
            box-sizing:         border-box;
            transition:     all 0.3s ease;
        }

        nav a:hover{
            background-color: #71f9b1;
            color:#fff;
            scale: 1.1;
            box-shadow: 0px 0px 10px rgb(163, 255, 224);
        }

        h1{
            margin:0px;
        }

        p{
            margin:0px;
        }

        a{
            font-weight: bold;
        }
        #logo {
            width:             65px;
            height:            65px;
            display:           flex;
            align-items:     center;
            justify-content: center;
            @media (min-width: 600px){
                width:         80px;
                height:        80px;
            }
        }

        #logo_menu{
            display:                  grid;
            place-items:            center;
            grid-template-columns: 1fr 1fr;
            gap:                       3vw;
        }

        #rayas{
            display:          flex;
            flex-direction: column;
            align-items:    center;
            justify-content:center;
            gap:               5px;
        }

        .raya{
            width :                           60px;
            height:                           10px;
            border-radius:                     5px;
            background-color: rgb(255, 255, 255);
            @media (max-width: 600px){
                width:         45px;
                height:        8px;
            }

        }

        #rayas:hover{
            .raya{
            
                background-color:        rgb(193, 255, 230);
                box-shadow: 0px 0px 10px rgb(163, 255, 224);

            }

        }

        #admin-btn{
            background: linear-gradient(135deg, #51e070, #009774);
            border:                               2px #8abfb7 solid;
            border-radius:                                       25px;
            color:                                            white;
            padding:                                          8px 20px;
            display:                                         flex;
            flex-wrap:                                         wrap;
            font-size:                                           18px;
            margin:                                               0px;
            @media (max-width: 800px){
                font-size:                                       14px;
            }
        }

        #admin-btn:hover{
            background: linear-gradient(135deg, #36b565, #00807b);
        }
    </style>

</head>
<body>

    <header>
        <div id="principal">
            <div id="logo_menu">
            <img id="logo" src="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/assets/logo_stoDomingo.png" alt="Logo de la escuela">
            </div>

            <div>
                <h1>U.E Sto Domingo</h1>
                <?php if (isset($_SESSION['username'])){ ?>
                    <p>Administración</p>
                <?php } ?>
            </div>
            <?php
                if (isset($_SESSION['username'])) {?>
                    <button class="btnMenu" id="admin-btn" onclick="window.location.href='/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/logout.php'">Cerrar sesión</button>
            <?php } else {?>
                    <button class="btnMenu" id="admin-btn" onclick="abrirModal('modal_login') ">Acceso administrador</button>
            <?php } ?>

        </div>
        <nav>
            <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/dashboards/newsDashboard.php">Noticias</a>
            <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/dashboards/bibliotecaDashboard.php">Biblioteca</a>
            <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/index.php">Páginas recomendadas</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' || isset($_SESSION['role']) && $_SESSION['role'] === 'bibliotecario') { ?>
            <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/adminDashboards/loansDashboard.php">Libros prestados</a>
            <?php } ?>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
            <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/adminDashboards/registerDashboard.php">Añadir nuevo usuario</a>
            <?php } ?>

        </nav>
    </header>

</body>
</html>