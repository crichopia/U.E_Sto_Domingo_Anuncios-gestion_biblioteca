<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #formulario_admin{
            width:                      60vw;
            min-height:                 60vh;
            background:            #b5e0c8;
            border:      2px #8abfb7 solid;
            color:                 #000000;
            padding:                      5%;
            margin-top:                   5%;
            margin-bottom:                5%;
            border-radius:              20px;
            display:                    flex;
            flex-direction:           column;
            justify-content:          center;
            align-items:              center;
            position:               absolute;
            top:                         50%;
            left:                        50%;
            transform: translate(-50%, -50%);
            box-sizing:           border-box;

            @media (max-width: 600px) {
                width:       80vw;
                margin-top:    2%;
                margin-bottom: 2%;
            }

            #login-form{
                box-sizing:  border-box;
                display:           flex;
                flex-direction:  column;
                place-items:     center;
                justify-content: center;
                gap:               20px;

            }
            h2,p{
                font-family: Arial, sans-serif;
            }
            p{
                text-align: center;
                color:   #353936;
            }
            input{
                width:        20vw ;
                height:         5vh;
                border:        none;
                border-radius: 25px;
                padding:     0 15px;

                @media (max-width: 600px) {
                    width:       60vw;
                    height:       4vh;

                }
            }


            button{
                width:          15vw ;
                height:           5vh;
                border:          none;
                border-radius:   25px;
                background: #009774;
                color:        white;
                font-size:       18px;
                cursor:       pointer;
                padding:       0 15px;

                @media (max-width: 600px) {
                    width:       60vw;
                    height:       4vh;
                    font-size:   16px;

                }

            }

            #cerrar_modal_login{
                box-sizing: border-box;
                padding:             0;
                width:            35px;
                height:           35px;
                text-align:     center;
                background:  #009774;
                color:       #ffffff;
                font-size:        25px;
                position:     absolute;
                top:              25px;
                right:            45px;
            }

            #loginButton{
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    
    <div class="overlay hidden"></div>
    
    <div class="modal hidden" id="modal_login">
        <div id="formulario_admin">

            <button id="cerrar_modal_login" onclick="cerrarModal('modal_login')">x</button>

            <h2>Acceso administrador</h2>

            <form id="login-form" action="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/login.php" method="POST">
                <input type="text"     name="username" class="form-imput" id="usernameInput" placeholder="Usuario" autofocus required>
                <input type="password" name="password" class="form-imput" id="passwordInput" placeholder="Contraseña" required>
                <button type="submit" name="login" id="loginButton">Ingresar</button>
            </form>

            <!-- <button onclick="verificarCredenciales('/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/config/adminConfig.json')" id="loginButton">Ingresar</button> -->
            
            <p>*usuario y contraseña de prueba:<br>admin / 123456</p>
            <p id="login-error" style="color: red;"></p>


        </div>
    </div>
    <script>
        document.getElementById('usernameInput').value = '';
        document.getElementById('passwordInput').value = '';
    </script>
    <script src="controllers/login.js"></script>
    <script src="controllers/login.js"></script>

</body>
</html>

