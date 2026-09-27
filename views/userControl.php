<?php 
include __DIR__ . '/../config/db.php';
// require_once __DIR__ . '/../controllers/validarSesionAdmin.php';
?>
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
        #userControlContainer{
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
                grid-template-columns: 1fr;
            }
        }
        #userControlContainer::-webkit-scrollbar {
            display: none;               /* Chrome, Safari, Opera */
        }

        article h2{
            margin:           0;
            color:    #223944;
            margin-bottom: 10px;
        }

        table{
            /* display: flex;
            flex-direction: column; */
            background-color: aliceblue;
            border: 2px #658291 solid;
            border-radius:         20px;
            padding: 5px;
            @media (max-width: 600px){
                font-size: 12px;
                padding: 2px;
            }

        }

        thead th{
            min-height:                   40px;
            height:                       40px;
            padding:                  8px 10px;
            border-bottom: 2px #658291 solid;
            border-right:  2px #658291 solid;
            box-sizing:             border-box;

            @media (max-width: 600px){
                font-size: 12px;
            padding:   5px 8px;
            }

        }

        tbody td{
            border-right: 2px #658291 solid;
            padding: 8px;
        }

        tr th:last-child{
            border-right: none;
        }

        tbody td:last-child{
            border-right: none;
        }

        form{
            background-color: #b5e0c8;
            border: 2px #8abfb7 solid;
            border-radius:         20px;
            padding:          15px 10px;
            display:               flex;
            flex-direction:      column;
            justify-content:     center;
            gap: 10px;
            /* align-items:         center; */
            @media (max-width: 600px){
                width: 90%;
            }

        }
        #formContainer{
            display:               flex;
            flex-direction:      column;
            justify-content:     center;
            align-items:         center;
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

        table a{
            text-decoration: none;
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


</style>
</head>
<body>
    <article>

        <h2>Control de usuarios</h2>

        <div id="userControlContainer">
            
        <div id="formContainer">    
        <form action="../controllers/crud_register.php" method="post">

                <h3>Usuario</h3>
                <input type="text" name="username" autofocus required=true placeholder="usuario">

                <h3>Contraseña</h3>
                <input type="text" name="password" required=true placeholder="contraseña" >

                <select name="role" id="rol">
                    <option value="profesor">profesor</option>
                    <option value="bibliotecario">bibliotecario</option>
                </select>

                <input id="botonSubmit" type="submit" name="save_user" value="Registrar Usuario" >

            </form>
        </div>
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>rol</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                        $query = "SELECT * FROM user_data";
                        $result_tasks  = mysqli_query($conn, $query);

                        while($row = mysqli_fetch_array($result_tasks)){?>
                        
                            <tr class="dataUser">
                                <td><?php echo $row['username']?></td>
                                <td><?php echo $row['password']?></td>
                                <td><?php echo $row['role']?></td>
                                <td>
                                    <?php if (strtolower($row['role']) !== 'admin') { ?>
                                        <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_register.php?delId=<?php echo $row['id']; ?>">🗑️</a>
                                        <a href="/U.E_Sto_Domingo_Anuncios-gestion_biblioteca/controllers/crud_register.php?editId=<?php echo $row['id']; ?>">✏️</a>
                                    <?php } ?>                                    
                                </td>

                            </tr>
                        
                        <?php } ?>
                    

                </tbody>
            </table>
        </div>
    </article>
</body>
</html>