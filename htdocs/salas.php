<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Salas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="Calendar/lib/css/SimpleCalendar.css" />
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
            error_reporting(E_ALL ^ E_WARNING);
            require_once('Calendar/lib/donatj/SimpleCalendar.php');
            $calendar = new donatj\SimpleCalendar();
            $calendar->setStartOfWeek('Sunday');
            $sqleventosxsala = "SELECT  Fecha, HoraI, HoraF, Eventos.Nombre AS NEvento, Salas.Nombre AS NSala
                                FROM eventos JOIN salas WHERE eventos.ID_Sala = salas.ID_Sala ORDER BY Fecha, HoraI";
            $resultado = mysqli_query($con,$sqleventosxsala);
            while($fila = mysqli_fetch_array($resultado)){
                $calendar->addDailyHtml( $fila["NEvento"]." ".$fila["NSala"]." ".$fila["HoraI"]."-".$fila["HoraF"], $fila["Fecha"]);
            }

            $sqleventosxsala = "SELECT Fecha, HoraI, HoraF, usuarios.Nombre AS NUsuario, Salas.Nombre AS NSala
            FROM prestamosala JOIN usuarios JOIN salas
            WHERE prestamosala.ID_Usuario= usuarios.ID_Usuario AND prestamosala.ID_Sala = salas.ID_Sala ORDER BY Fecha, HoraI";
            $resultado = mysqli_query($con,$sqleventosxsala);
            while($fila = mysqli_fetch_array($resultado)){
                $calendar->addDailyHtml( $fila["NUsuario"]." ".$fila["NSala"]." ".$fila["HoraI"]."-".$fila["HoraF"], $fila["Fecha"]);
            }

            $calendar->show(true);

            if($_SESSION["rol"] == "Admin"){
                $sqlsalas = "SELECT * FROM `Salas`";
                $resultado = mysqli_query($con,$sqlsalas);
                $inputsalas = "<form action=\"gest-sala.php\" method=\"POST\">
                                Sala <br><select id = \"salas\" name =\"idsala\">";
                while($fila = mysqli_fetch_array($resultado)){
                    $inputsalas = $inputsalas . "<option value=\"". $fila["ID_Sala"] ."\">". $fila["Nombre"] ."</option>";
                }
                $inputsalas = $inputsalas . "</select><br>" .
                            "<input type=\"submit\" value=\"Gestionar-Solicitudes\" name=\"gest-sol\" /></form>";
                echo $inputsalas;
            }
            else if ($_SESSION["rol"] == "User"){
                $sqlsalas = "SELECT * FROM `Salas`";
                $resultado = mysqli_query($con,$sqlsalas);
                $inputsalas = "<form action=\"sol-sala.php\" method=\"POST\">
                                Sala <br><select id = \"salas\" name =\"idsala\">";
                while($fila = mysqli_fetch_array($resultado)){
                    $inputsalas = $inputsalas . "<option value=\"". $fila["ID_Sala"] ."\">". $fila["Nombre"] ."</option>";
                }
                $inputsalas = $inputsalas . "</select><br>" .
                "<input type=\"submit\" value=\"Solicitar-Sala\" name=\"sol-sala\" /></form>";
                echo $inputsalas;
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
