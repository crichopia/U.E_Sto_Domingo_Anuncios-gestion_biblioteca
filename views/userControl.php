<?php 
require_once __DIR__ . '/../config/db.php';
// require_once __DIR__ . '/../controllers/validarSesionAdmin.php';
?>
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
            @media (max-width: 1154px) {
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

            @media (max-width: 1154px){
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

        .users-list {
            display: grid;
            align-content: start;
            gap: 10px;
        }

        .user-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 16px;
            border: 2px #658291 solid;
            border-radius: 16px;
            background-color: aliceblue;
            color: #223944;
        }

        .user-info {
            min-width: 0;
            display: grid;
            gap: 5px;
        }

        .user-info h3,
        .user-info p {
            margin: 0;
            overflow-wrap: anywhere;
        }

        .user-info h3 {
            font-size: 17px;
        }

        .user-info p {
            font-size: 14px;
        }

        .user-actions {
            display: flex;
            flex-shrink: 0;
            gap: 12px;
        }

        .user-actions a {
            font-size: 18px;
        }

        .empty-users {
            margin: 0;
            padding: 12px;
            border-radius: 12px;
            background-color: aliceblue;
            color: #223944;
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
            @media (max-width: 1154px){
                width: 90%;
            }

        }
        #formContainer{
            display:               flex;
            flex-direction:      column;
            justify-content:     center;
            align-items:         center;
            width:                 100%;
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

        }

        select{
            text-align:          center;
            margin-bottom:         10px;
            background-color: #87cead;
            border-radius:         20px;
            padding:                5px;
            border:                none;
            color:               #fff;
            width:                  90%;
            /* font-weight:           bold; */

        }

        #botonSubmit{
            background: linear-gradient(135deg, #51e070, #009774);
            color: #fff;
            width:                  90%;

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
        #userFormWrapper {
            display: grid;
            grid-template-rows: minmax(0, 1fr);
            opacity: 1;
            transition: grid-template-rows 0.35s ease, opacity 0.35s ease;
            width: 100%;
        }

        #userFormWrapper.cerrado {
            grid-template-rows: minmax(0, 0fr);
            opacity: 0;
        }

        #userFormWrapper > form {
            height: auto;
            min-height: 0;
            overflow: hidden;
        }

        @media (prefers-reduced-motion: reduce) {
            #userFormWrapper {
                transition: none;
            }
        }

</style>
    <article>

        <h2>Control de usuarios</h2>

        <div id="userControlContainer">
            
        <div id="formContainer">
        <div id="userFormWrapper">
        <form action="../controllers/crud_register.php" method="post">

                <h3>Usuario</h3>
                <input type="text" name="username" autofocus required=true placeholder="Usuario">

                <h3>Contraseña</h3>
                <input type="text" name="password" required=true placeholder="Contraseña" >

                <select name="role" id="rol">
                    <option value="profesor">Profesor</option>
                    <option value="bibliotecario">Bibliotecario</option>
                </select>

                <input id="botonSubmit" type="submit" name="save_user" value="Registrar Usuario" >

            </form>
        </div>
            <i class="fa-solid fa-angle-up icono-rotar" onclick="rotarIcono(this); abrirFormulario('userFormWrapper')"></i>
        </div>
            <div class="users-list">
                <?php
                    $query = 'SELECT id, username, password, role FROM user_data';
                    $result_tasks = $conn->query($query);

                    while ($row = $result_tasks->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <section class="user-card">
                        <div class="user-info">
                            <h3><?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p><strong>Rol:</strong> <?php echo htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Contraseña: </strong><?php echo htmlspecialchars($row['password'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <?php if (strtolower($row['role']) !== 'admin') { ?>
                            <div class="user-actions">
                                <a href="/controllers/crud_register.php?delId=<?php echo (int) $row['id']; ?>" class="iconLink" aria-label="Eliminar usuario <?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?>"><i class="fa-solid fa-trash"></i></a>
                                <a href="/controllers/crud_register.php?editId=<?php echo (int) $row['id']; ?>" class="iconLink" aria-label="Editar usuario <?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?>"><i class="fa-solid fa-edit"></i></a>
                            </div>
                        <?php } ?>
                    </section>
                <?php } ?>
            </div>
        </div>
    </article>