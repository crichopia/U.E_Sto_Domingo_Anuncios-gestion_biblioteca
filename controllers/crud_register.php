<?php
require_once '../controllers/validarSesionAdmin.php';
include __DIR__ . '/../config/db.php';
if (isset($_POST['save_user'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // echo $username.$password.$role;
    $query = "INSERT INTO user_data(username, password, role) VALUES ('$username', '$password', '$role')";
    $result = mysqli_query($conn, $query);
    if(!$result){
        die("Query failed");
    }
    header("Location: ../adminDashboards/registerDashboard.php");
    exit;
}

if (isset($_GET['delId'])){
    $id = $_GET['delId'];
    $query = "DELETE FROM user_data WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if(!$result){
        die("Query failed");
    }
    header("Location: ../adminDashboards/registerDashboard.php");
    exit;
}

if (isset($_GET['editId'])){
    $id = $_GET['editId'];
    $query = "SELECT * FROM user_data WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_array($result);
        $username = $row['username'];
        $password = $row['password'];
        $role     = $row['role'];
        // echo $username.$password;
    }
    if(!$result){
        die("Query failed");
    }
}
if (isset($_POST['update'])){
    $id = $_GET['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $query = "UPDATE user_data set username = '$username', password = '$password', role = '$role' WHERE Id = $id";
    mysqli_query($conn, $query);

    header("Location: ../adminDashboards/registerDashboard.php");
    exit;
}

?>

<?php //a partir de aqui solo es un formpulario ?>

<head>
    <title>actualizar datos</title>
    <style>
        body{
        margin:                      0;
        font-family: Arial, sans-serif;
        box-sizing:         border-box;
        background:          #7ce4dc;
        display:                  flex;
        flex-direction:         column;
        justify-content:     center;
        align-items:         center;
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
            display:                  flex;
            flex-direction:         column;
            align-items:            center;
            justify-content:        center;
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
        form{
            background-color: #b5e0c8;
            border: 2px #8abfb7 solid;
            border-radius:         20px;
            padding:          15px 10px;
            display:               flex;
            flex-direction:      column;
            justify-content:     center;
            width: 55%;
            height: 80%;
            /* align-items:         center; */
            @media (max-width: 600px){
                width: 90%;
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
<?php include __DIR__ . '/../views/headerAdmin.php'; ?>
<body>
    <article>

        <h2>Control de usuarios</h2>

        <div id="userControlContainer">
            <form action="../controllers/crud_register.php?id=<?php echo $_GET['editId']?>" method="POST">

                <h3>Usuario</h3>
                <input type="text" name="username" autofocus required=true placeholder="nuevo usuario" value="<?php echo $username ?>">

                <h3>Contraseña</h3>
                <input type="text" name="password" required=true placeholder="nueva contraseña" value="<?php echo $password ?>">

                <select name="role" id="rol" >
                    <option value="profesor">profesor</option>
                    <option value="bibliotecario">bibliotecario</option>
                </select>

                <input id="botonSubmit" type="submit" name="update" value="actualizar datos" >

            </form>

        </div>
    </article>
</body>
</html><?php include __DIR__ . '/../views/footer.php'; ?>
