<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eventos</title>
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
      <a href="index.php">Inicio</a>
      <a class="active" href="ver-eventos.php">Eventos</a>
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
            if(isset($_POST["sfecha"])){
                echo $_POST["fecha"];
                $sqleventos = "SELECT * FROM `Eventos` WHERE `Fecha` ='" . $_POST["fecha"] ."';";
                $resultado = mysqli_query($con,$sqleventos);
                $formeventos = "<ul>";
                if($_SESSION["rol"] == "Admin"){
                    while($fila = mysqli_fetch_array($resultado)){
                        $formeventos = $formeventos .
                                        "<li><form action=\"crud-evento.php\" method=\"POST\">" .
                                        "<input type=\"hidden\" name=\"evento\" value=\"". $fila["ID_Evento"] . "\"/>" .
                                        $fila["Nombre"] ." Lugar: ".$fila["Lugar"]." HoraI: ".$fila["HoraI"] ." HoraF: ".$fila["HoraF"] .
                                        "<input type=\"submit\" value=\"Ver-Evento\" name=\"ver-evento-admin\"/></form>
                                        </li>";
                    }
                }
                else{
                    while($fila = mysqli_fetch_array($resultado)){
                        $formeventos = $formeventos .
                                        "<li><form action=\"subs-evento.php\" method=\"POST\">" .
                                        "<input type=\"hidden\" name=\"evento\" value=\"". $fila["ID_Evento"] . "\"/>" .
                                        $fila["Nombre"] ." Lugar: ".$fila["Lugar"]." HoraI: ".$fila["HoraI"] ." HoraF: ".$fila["HoraF"] .
                                        "<input type=\"submit\" value=\"Ver-Evento\" name=\"ver-evento-user\"/>
                                        </form>
                                        </li>";
                    }
                }
                $formeventos = $formeventos . "</ul>";
                echo $formeventos;
            }
            else{
                $sqlfechas = "SELECT DISTINCT `Fecha` FROM `Eventos`";
                $resultado = mysqli_query($con,$sqlfechas);
                $formfechas = "<form action=\"ver-eventos.php\" method=\"POST\"><select \" name =\"fecha\">";
                while($fila = mysqli_fetch_array($resultado)){
                    $formfechas = $formfechas . "<option value=\"". $fila["Fecha"] ."\">". $fila["Fecha"] ."</option>";
                }
                $formfechas = $formfechas . "</select><input type=\"submit\" value=\"Seleccionar-Fecha\" name=\"sfecha\"/></form>";
                echo $formfechas;
                if($_SESSION["rol"] == "Admin"){
                    echo "<form action=\"add-evento.php\" method=\"POST\">
                            <input type=\"submit\" value=\"Crear-Evento\" name=\"crear-evento\"/>
                        </form>";
                }
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
