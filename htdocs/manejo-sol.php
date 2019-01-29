<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Manejo Solicitudes</title>
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
      <a href="ver-eventos.php">Eventos</a>
      <a href="salas.php">Salas</a>
      <a href="equipos.php">Equipos</a>
      <a href="libros.php">Libros</a>
    </div>
    <form action = "index.php" method = "post">
        <button type="submit" name = "logout">Logout</button>
    </form>
    <?php
        if (isLogged() && $_SESSION["rol"]=="Admin"){
            echo "<div><h1>Bienvenido " . $_SESSION["username"]. "!</h1></div><br>";
            if(isset($_POST["apr-sol"])){
                if($_POST["apr-sol"]=="Aprobar-Libro"){
                    if(prestamoPosibleLibro($_POST["idlibro"])){
                        $sqledit = "UPDATE SolicitudLibro SET
                        Motivo = '".$_POST["motivo"]."',
                        Estado = 'aceptada'
                        WHERE SolicitudLibro.ID_Libro = ".$_POST["idlibro"]." AND SolicitudLibro.ID_Usuario = ".$_POST["iduser"];
                        if(mysqli_query($con,$sqledit)){
                            echo "Solicitud aprobada.";
                        }
                        else{
                            echo "Error aprobando: ".mysqli_error($con);
                        }
                        $sqledit = "UPDATE Libros SET
                        Disponibles = Disponibles - 1
                        WHERE Libros.ID_Libro = ".$_POST["idlibro"];
                        if(mysqli_query($con,$sqledit)){
                            echo "Libros actualizados.";
                        }
                        else{
                            echo "Error actualizando libro: ".mysqli_error($con);
                        }
                        $sqlinsert = "INSERT INTO `PrestamoLibro` (ID_Libro, ID_Usuario, FechaInicio, FechaFinal, Tiempo, Reporte)
                        VALUES ('".$_POST["idlibro"]."', '".$_POST["iduser"]."','".$_POST["fecha"]."','".$_POST["fechafin"]."','".$_POST["tiempo"]."','".$_POST["reporte"]."')";
                        if(mysqli_query($con,$sqlinsert)){
                            echo "Prestamo añadido.";
                            sendMail("Solicitud libro","La solicitud del libro " .$_POST["nombre-libro"]. " fue aceptada.",$_POST["email"]);
                        }
                        else{
                            echo "Error insertando prestamo: ".mysqli_error($con);
                        }
                    }
                }
                else{
                    if($_POST["apr-sol"]=="Aprobar-Equipo"){
                        if(prestamoPosibleEquipo($_POST["idequipo"])){
                            $sqledit = "UPDATE SolicitudEquipo SET
                            Motivo = '".$_POST["motivo"]."',
                            Estado = 'aceptada'
                            WHERE SolicitudEquipo.ID_Equipo = ".$_POST["idequipo"]." AND SolicitudEquipo.ID_Usuario = ".$_POST["iduser"];
                            if(mysqli_query($con,$sqledit)){
                                echo "Solicitud aprobada.";
                            }
                            else{
                                echo "Error aprobando: ".mysqli_error($con);
                            }
                            $sqledit = "UPDATE Equipos SET
                            Disponibles = Disponibles - 1
                            WHERE Equipos.ID_Equipo = ".$_POST["idequipo"];
                            if(mysqli_query($con,$sqledit)){
                                echo "Equipos actualizados.";
                            }
                            else{
                                echo "Error actualizando libro: ".mysqli_error($con);
                            }
                            $sqlinsert = "INSERT INTO `PrestamoEquipo` (ID_Equipo, ID_Usuario, FechaInicio, FechaFinal, Tiempo, Reporte)
                            VALUES ('".$_POST["idequipo"]."', '".$_POST["iduser"]."','".$_POST["fecha"]."','".$_POST["fechafin"]."','".$_POST["tiempo"]."','".$_POST["reporte"]."')";
                            if(mysqli_query($con,$sqlinsert)){
                                echo "Equipo añadido.";
                                echo $_POST["email"];
                                sendMail("Solicitud Equipo","La solicitud del equipo " .$_POST["nombre-equipo"]. " fue aceptada.",$_POST["email"]);
                            }
                            else{
                                echo "Error insertando equipo: ".mysqli_error($con);
                            }
                        }
                    }
                }
            }
            elseif (isset($_POST["rec-sol"])) {
                if($_POST["rec-sol"]=="Rechazar-Libro"){
                    $sqledit = "UPDATE SolicitudLibro SET
                    Motivo = '".$_POST["motivo"]."',
                    Estado = 'rechazada'
                    WHERE SolicitudLibro.ID_Libro = ".$_POST["idlibro"]." AND SolicitudLibro.ID_Usuario = ".$_POST["iduser"];
                    if(mysqli_query($con,$sqledit)){
                        echo "Solicitud rechazada.";
                        sendMail("Solicitud libro","La solicitud del libro " .$_POST["nombre-libro"]. " fue rechazada.",$_POST["email"]);
                    }
                    else{
                        echo "Error rechzando: ".mysqli_error($con);
                    }
                }
                else{
                    $sqledit = "UPDATE SolicitudEquipo SET
                    Motivo = '".$_POST["motivo"]."',
                    Estado = 'rechazada'
                    WHERE SolicitudEquipo.ID_Libro = ".$_POST["idlibro"]." AND SolicitudEquipo.ID_Usuario = ".$_POST["iduser"];
                    if(mysqli_query($con,$sqledit)){
                        echo "Solicitud rechazada.";
                        sendMail("Solicitud equipo","La solicitud del equipo " .$_POST["nombre-equipo"]. " fue rechazada.",$_POST["email"]);
                    }
                    else{
                        echo "Error rechzando: ".mysqli_error($con);
                    }
                }
            }
        }
    mysqli_close($con);
    ?>
</body>
</html>
