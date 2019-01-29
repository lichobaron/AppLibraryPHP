<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
        include "config.php";
        include "utils.php";
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        session_start();
    ?>
    <div class="topnav">
      <a class="active" href="index.php">Inicio</a>
      <a href="ver-eventos.php">Eventos</a>
      <a href="salas.php">Salas</a>
      <a href="equipos.php">Equipos</a>
      <a href="libros.php">Libros</a>
    </div>
    <form action = "index.php" method = "post">
        <button type="submit" name = "logout">Logout</button>
    </form>
    <?php
        if(isset($_POST["logout"])){
            logout();
        }
        if (isLogged()){
            echo "<div><h1>Bienvenido " . $_SESSION["username"]. "!</h1></div><br>";
            if($_SESSION["rol"] == "Admin"){
                header('Location: '."mensajes.php");
            }
        }
        else{
            if(isset($_POST["login"])){
                $sqluser = "SELECT * FROM `Usuarios` WHERE `Correo` ='" . $_POST["uname"] ."'";
                $resultado = mysqli_query($con,$sqluser);
                $fila = mysqli_fetch_array($resultado);
                if (mysqli_num_rows($resultado)==1)
                {
                    if($fila["Contrasena"] == $_POST["psw"]){
                        login($fila["Nombre"],$fila["ID_Usuario"],$fila["Rol"],$fila["Correo"]);
                        header('Location: '."index.php");
                    }
                    else{
                        echo "<div><h2>Contraseña Inválida</h2></div>";
                        $loginform =
                        "<form action=\"index.php\" method=\"POST\">
                                <label for=\"uname\"><b>Email</b></label>
                                <input type=\"text\" placeholder=\"Digita tu correo\" name=\"uname\" required>
                                <label for=\"psw\"><b>Contraseña</b></label>
                                <input type=\"password\" placeholder=\"Digita tu contraseña\" name=\"psw\" required>
                                <button type=\"submit\" name = \"login\">Login</button>
                        </form>";
                        echo $loginform;
                    }

                }
                else{
                    echo "<div><h2>Usuario no encontrado</h2></div>";
                    echo "<form action = \"registro.php\" method = \"post\">
                        <button type=\"submit\" name = \"regi\">Registrarse</button>
                    </form>";
                }
            }
            else{
                $loginform =
                "<form action=\"index.php\" method=\"POST\">
                    <label for=\"uname\"><b>Email</b></label>
                    <input type=\"text\" placeholder=\"Digita tu correo\" name=\"uname\" required>
                    <label for=\"psw\"><b>Contraseña</b></label>
                    <input type=\"password\" placeholder=\"Digita tu contraseña\" name=\"psw\" required>
                    <button type=\"submit\" name = \"login\">Login</button>
                </form>";
                echo $loginform;
                echo "<form action = \"registro.php\" method = \"post\">
                        <button type=\"submit\" name = \"regi\">Registrarse</button>
                    </form>";
            }
        }
    mysqli_close($con);
    ?>
</body>
</html>
