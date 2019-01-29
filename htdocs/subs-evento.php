<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscribirse</title>
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
        if (isLogged()){
            echo "<div><h1>Bienvenido " . $_SESSION["username"]. "!</h1></div><br>";
            if($_SESSION["rol"] == "User"){
                if( isset($_POST["ver-evento-user"]) )
                {
                    $sqleventos = "SELECT * FROM `Eventos` WHERE `ID_Evento` ='" . $_POST["evento"] ."'";
                    $resultado = mysqli_query($con,$sqleventos);
                    $fila = mysqli_fetch_array($resultado);
                    $formsubs = "<form action=\"subs-evento.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"evento\" value=\"". $_POST["evento"] . "\"/>" .
                                "<input type=\"hidden\" name=\"user\" value=\"".$_SESSION["iduser"]."\"/>" .
                                "Evento: <br><input type=\"text\" name=\"nombre-evento\" value = \"". $fila["Nombre"] ."\"readonly><br>
                                Usuario:<br> <input type=\"text\" name=\"nombre-user\" value = \"". $_SESSION["username"]."\" readonly><br>
                                Email<br> <input type=\"text\" name=\"email\" value = \"".$_SESSION["email"]."\"><br>
                                <input type=\"submit\" value=\"Inscribirse\" name=\"subs-evento\"/>
                                </form>";
                    echo $formsubs;
                }
                if( isset($_POST["subs-evento"]))
                {
                    $sqlinsert = "INSERT INTO `UsuariosXEvento` (ID_Evento, ID_Usuario)
                    VALUES ('".$_POST["evento"]."', '".$_POST["user"]."')";
                    if(mysqli_query($con,$sqlinsert)){
                        echo "Registro añadido.";
                    }
                    else{
                        echo "Error insertando registro: ".mysqli_error($con);
                    }
                }
            }
            else{
                echo "<div><h2>No tienes acceso a esta página.</h2></div><br>";
            }
        }
        else{
            mysqli_close($con);
            header('Location: '."index.php");
        }
    mysqli_close($con);
    ?>
</body>
</html>
