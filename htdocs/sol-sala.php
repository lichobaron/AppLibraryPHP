<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitar Sala</title>
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
                if(isset($_POST["env-sol"])){
                    if(salaLibre($_POST["idsala"],$_POST["fecha"],$_POST["horai"],$_POST["horaf"])){
                        $sqlinsert = "INSERT INTO `SolicitudSala` (ID_Usuario, ID_Sala, Fecha, HoraI ,HoraF, Estado)
                                        VALUES ('".$_POST["iduser"]."', '".$_POST["idsala"]."','".$_POST["fecha"].
                                        "','".$_POST["horai"]."','".$_POST["horaf"]."','espera')";
                        if(mysqli_query($con,$sqlinsert)){
                            echo "Solicitud añadida.";
                        }
                        else{
                            echo "Error insertando solicitud: ".mysqli_error($con);
                        }
                    }
                    else{
                        echo "<div><h4>Sala ocupada.</h4></div><br>";
                    }
                }
                else if(isset($_POST["sol-sala"]))
                {
                    $sqlsala = "SELECT Nombre FROM `Salas` WHERE `ID_Sala` ='" . $_POST["idsala"] ."'";
                    $resultado = mysqli_query($con,$sqlsala);
                    $fila = mysqli_fetch_array($resultado);
                    $formsol = "<form action=\"sol-sala.php\" method=\"POST\">
                                    <input type=\"hidden\" name=\"idsala\" value=\"". $_POST["idsala"] . "\"/>" .
                                    "<input type=\"hidden\" name=\"iduser\" value=\"". $_SESSION["iduser"]."\"/>" .
                                    "Sala: <br><input type=\"text\" name=\"nombre-sala\" value = \"". $fila["Nombre"] ."\"readonly><br>
                                    Usuario:<br> <input type=\"text\" name=\"nombre-user\" value = \"". $_SESSION["username"]."\" readonly><br>
                                    Email: <br><input type=\"text\" name=\"email\" value = \"". $_SESSION["email"]."\"><br>
                                    Fecha:<br><input type=\"text\" name=\"fecha\"><br>
                                    Hora Inicio: <br><input type=\"text\" name=\"horai\"><br>
                                    Hora Fin: <br> <input type=\"text\" name=\"horaf\"><br>
                                    <input type=\"submit\" value=\"Enviar-Solicitud\" name=\"env-sol\"/>
                                </form>";
                    echo $formsol;

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
