<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style> 
        body{
            box-sizing:         border-box;
            font-family: Arial, sans-serif;
            margin:                      0;
            padding:                     0;

        }

        #modalMenu_container{
            background: linear-gradient(135deg, #51e070, #009774);
            margin:                                                  0;
            padding:                                              20px;
            width:                                                40vw;
            height:                                              100vh;
            display:                                              flex;
            flex-direction:                                     column;
            align-items:                                        center;
            position:                                            fixed;
            z-index:                                                 2;
            top:                                                     0;
            @media (max-width: 600px) {
                width:                                            65vw;
            }
        }
        #modalMenu_content{
            width:              80%;
            display:           flex;
            flex-direction:  column;
            justify-content: center;
            align-items:     center;
            gap:               20px;
        }
        .btnMenu{
            width:            65%;
            max-width:       65% ;
            border:          none;
            border-radius:   25px;
            background: #009774;
            color:        white;
            font-size:       24px;
            cursor:       pointer;
            padding:       0 20px;

            @media (max-width: 600px) {
                width:       60vw;
                font-size:   16px;
                padding: 5px 10px;
            }
        }

        #btn_cerrar_menu{
            box-sizing: border-box;
            border:           none;
            border-radius:    25px;
            padding:             0;
            width:            35px;
            height:           35px;
            text-align:     center;
            background:  #009774;
            color:       #ffffff;
            font-size:        25px;
            position:     relative;
            top:               0px;
            right:            -55%;
        }

        #modalMenu_container h2{
            color:  white;
            margin:       0;
            margin-top:   0;
            font-size: 42px;
        }
        #modalMenu_container hr{
            width:                                   100%;
            border:                                  none;
            border-top: 2px solid rgba(255,255,255,0.7);
            margin:                                 8px 0;
        }

        #bntNuevoUsuario{
            text-decoration:  none;
            display:          flex;
            flex-direction: column;
            align-items:    center;
            justify-content:center;
        }
    </style>
</head>

<body>
    <?php session_start(); ?>

    <div class="modal hidden" id="modal_menu">
        <div id="modalMenu_container">
            <div id="modalMenu_content">
                <button id="btn_cerrar_menu" onclick="cerrarModal('modal_menu')">x</button>
                <h2>- Menu -</h2>
                <hr>
                <button class="btnMenu"  onclick="cerrarModal('modal_menu'),loadElement('main', '/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/views/newsDashboard.php');">Anuncios</button>
                <button class="btnMenu" onclick="window.location.href='/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/adminDashboards/bibliotecaDashboard.php'">Biblioteca</button>

                <button class="btnMenu"  onclick="cerrarModal('modal_menu'),loadElement('main', '/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/views/workinprogress.php');">Recomendaciones de <br>los profesores</button>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                    <button class="btnMenu" onclick="window.location.href='/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/adminDashboards/registerDashboard.php'">Añadir nuevo <br>usuario</button>
                <?php } ?>

                <?php
                if (isset($_SESSION['username'])) {?>
                    <button class="btnMenu" id="admin-btn" onclick="window.location.href='/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/logout.php'">Cerrar sesión</button>
                <?php } else {?>
                    <button class="btnMenu" id="admin-btn" onclick="cerrarModal('modal_menu'),abrirModal('modal_login') ">Acceso <br>administrador</button>
                <?php } ?>
            </div>
        </div>
    </div>
<script src="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/public/controllers/login.js"></script>

</body>
</html>