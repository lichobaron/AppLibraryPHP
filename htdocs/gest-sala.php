<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestionar Salas</title>
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
            if($_SESSION["rol"] == "Admin"){
                if(isset($_POST["gest-sol"])){
                    $sqlsolicitud = "SELECT  usuarios.Nombre AS UNombre, salas.Nombre as SNombre, Fecha, HoraI, HoraF, Correo, usuarios.ID_Usuario
                                    FROM `solicitudsala` JOIN `salas` JOIN `usuarios`
                                    WHERE solicitudsala.ID_Sala = salas.ID_Sala AND solicitudsala.ID_Usuario = usuarios.ID_Usuario
                                    AND solicitudsala.Estado = 'espera' AND solicitudsala.ID_Sala ='". $_POST["idsala"] . "';";
                    $resultado = mysqli_query($con,$sqlsolicitud);
                    $formsolicitud = "<ul>";
                    while($fila = mysqli_fetch_array($resultado)){
                        $formsolicitud = $formsolicitud .
                        "<li><form action=\"gest-sala.php\" method=\"POST\">
                            <input type=\"hidden\" name=\"idsala\" value=\"". $_POST["idsala"] . "\"/>" .
                            "<input type=\"hidden\" name=\"iduser\" value=\"". $fila["ID_Usuario"] ."\"/>" .
                            "Sala <input type=\"text\" name=\"nombre-sala\" value = \"". $fila["SNombre"] ."\"readonly><br>
                            Usuario <input type=\"text\" name=\"nombre-user\" value = \"". $fila["UNombre"] ."\" readonly><br>
                            Email <input type=\"text\" name=\"email\" value = \"". $fila["Correo"] ."\" readonly><br>
                            Fecha <input type=\"text\" name=\"fecha\" value = \"". $fila["Fecha"] ."\"readonly><br>
                            HoraI <input type=\"text\" name=\"horai\" value = \"". $fila["HoraI"] ."\"readonly><br>
                            HoraF <input type=\"text\" name=\"horaf\" value = \"". $fila["HoraF"] ."\"readonly><br>
                            Motivo <input type=\"text\" name=\"motivo\"><br>
                            <input type=\"submit\" value=\"Aprobar-Solicitud\" name=\"apr-sol\"/>
                            <input type=\"submit\" value=\"Rechazar-Solicitud\" name=\"rec-sol\"/>
                        </li></form>";
                    }
                    $formsolicitud = $formsolicitud . "</ul>";
                    echo $formsolicitud;
                }
                else if(isset($_POST["apr-sol"])){
                    $sqledit = "UPDATE SOLICITUDSALA SET
                    Motivo = '".$_POST["motivo"]."',
                    Estado = 'aceptada'
                    WHERE SOLICITUDSALA.ID_SolicitudSala = ".$_POST["idsolsala"];
                    if(mysqli_query($con,$sqledit)){
                        echo "Solicitud aprobada.";
                    }
                    else{
                        echo "Error aprobando: ".mysqli_error($con);
                    }
                    $sqlinsert = "INSERT INTO `PRESTAMOSALA` (ID_Sala, ID_Usuario, Fecha, HoraI, HoraF)
                    VALUES ('".$_POST["idsala"]."', '".$_POST["iduser"]."','".$_POST["fecha"]."','".$_POST["horai"]."','".$_POST["horaf"]."')";
                    if(mysqli_query($con,$sqlinsert)){
                        echo "Prestamo añadido.";
                        sendMail("Solicitud sala","La solicitud de la sala " .$_POST["nombre-sala"]. " fue aceptada.",$_POST["email"]);
                    }
                    else{
                        echo "Error insertando prestamo: ".mysqli_error($con);
                    }
                }
                else if(isset($_POST["rec-sol"])){
                        $sqledit = "UPDATE SOLICITUDSALA SET
                        Motivo = '".$_POST["motivo"]."',
                        Estado = 'rechazada'
                        WHERE SOLICITUDSALA.ID_SolicitudSala = ".$_POST["idsolsala"];
                        if(mysqli_query($con,$sqledit)){
                            echo "Solicitud rechazada.";
                            sendMail("Solicitud sala","La solicitud de la sala " .$_POST["nombre-sala"]. " fue rechazada.",$_POST["email"]);
                        }
                        else{
                            echo "Error rechzando: ".mysqli_error($con);
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
