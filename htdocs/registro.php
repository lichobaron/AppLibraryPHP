<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="registro.js"></script>
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
        $admin = false;
        if (isLogged() && $_SESSION["rol"] == "Admin"){
            echo "<div><h1>Bienvenido " . $_SESSION["username"]. "!</h1></div><br>";
            $admin = true;
        }
        if(isset($_POST["reg"])){
            $sqluser = "SELECT * FROM `Usuarios` WHERE `Nombre` ='" . $_POST["nombre"] ."'";
            $sqlmail = "SELECT * FROM `Usuarios` WHERE `Correo` ='" . $_POST["correo"] ."'";
            $succes = true;
            $resultado = mysqli_query($con,$sqluser);
            $fila = mysqli_fetch_array($resultado);
            if (mysqli_num_rows($resultado)==1)
            {
                $succes = false;
                echo "<div><h3>Usuario en uso</h3></div>";
            }
            $resultado = mysqli_query($con,$sqlmail);
            $fila = mysqli_fetch_array($resultado);
            if (mysqli_num_rows($resultado)==1)
            {
                $succes = false;
                echo "<div><h3>Correo en uso</h3></div>";
            }
            if ($succes){
                if($admin){
                    $sqlinsert = "INSERT INTO `Usuarios` (Nombre, Correo, Contrasena, Rol)
                    VALUES ('".$_POST["nombre"]."', '".$_POST["correo"]."','".$_POST["pass"]."','Admin')";
                    if(mysqli_query($con,$sqlinsert)){
                        echo "<div><h3>Admin Insertado.</h3></div>";
                    }
                    else{
                        echo "<div><h3>Error insertando usuario: ".mysqli_error($con)."</h3></div>";
                    }
                }
                else{
                    $sqlinsert = "INSERT INTO `Usuarios` (Nombre, Correo, Contrasena, Rol)
                    VALUES ('".$_POST["nombre"]."', '".$_POST["correo"]."','".$_POST["pass"]."','User')";
                    if(mysqli_query($con,$sqlinsert)){
                        $sqlmail = "SELECT * FROM `Usuarios` WHERE `Correo` ='" . $_POST["correo"] ."'";
                        $resultado = mysqli_query($con,$sqlmail);
                        $fila = mysqli_fetch_array($resultado);
                        login($fila["Nombre"],$fila["ID_Usuario"],$fila["Rol"],$fila["Correo"]);
                        mysqli_close($con);
                        header('Location: '."index.php");
                    }
                    else{
                        echo "<div><h3>Error insertando usuario: ".mysqli_error($con)."</h3></div>";
                    }
                }
            }
        }
        $formreg =
        "<form action=\"registro.php\" method=\"POST\">
            Nombre de usuario: <br><input type=\"text\" name=\"nombre\" required><br>
            E-mail: <br><input type=\"text\" name=\"correo\" required><br>
            Contraseña: <br><input type=\"password\" name=\"pass\" required><br>
            Confirmar contraseña: <br><input type=\"password\" name=\"pass2\" required><br>
            <input type=\"submit\" value=\"Registrar\" name=\"reg\" />
        </form>";
        echo $formreg;
        mysqli_close($con);
    ?>
</body>
</html>
