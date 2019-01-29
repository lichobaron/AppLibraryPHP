<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mensajes</title>
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
                $sqlsolicitud = "SELECT  ID_SolicitudSala, Usuarios.ID_Usuario AS ID_Usuario, Salas.ID_Sala AS ID_Sala,
                    Estado, Fecha, HoraI, HoraF, Motivo, Usuarios.Nombre AS UNombre, Salas.Nombre AS SNombre, Correo
                    FROM `solicitudsala` JOIN `salas` JOIN `usuarios`
                    WHERE solicitudsala.ID_Sala = salas.ID_Sala AND solicitudsala.ID_Usuario = usuarios.ID_Usuario
                    AND solicitudsala.Estado = 'espera';";
                $resultado = mysqli_query($con,$sqlsolicitud);
                $formsolicitud = "<ul><h2>Solicitudes Salas</h2>";
                while($fila = mysqli_fetch_array($resultado)){
                    $formsolicitud = $formsolicitud .
                    "<li><form action=\"gest-sala.php\" method=\"POST\">
                        <input type=\"hidden\" name=\"idsolsala\" value=\"". $fila["ID_SolicitudSala"] . "\"/>
                        <input type=\"hidden\" name=\"iduser\" value=\"". $fila["ID_Usuario"] . "\"/>
                        <input type=\"hidden\" name=\"idsala\" value=\"". $fila["ID_Sala"] . "\"/>
                        Sala <input type=\"text\" name=\"nombre-sala\" value = \"". $fila["SNombre"] ."\"readonly><br>
                        Usuario <input type=\"text\" name=\"nombre-user\" value = \"". $fila["UNombre"] ."\" readonly><br>
                        Email <input type=\"text\" name=\"email\" value = \"". $fila["Correo"] ."\" readonly><br>
                        Fecha <input type=\"text\" name=\"fecha\" value = \"". $fila["Fecha"] ."\"readonly><br>
                        HoraI <input type=\"text\" name=\"horai\" value = \"". $fila["HoraI"] ."\"readonly><br>
                        HoraF <input type=\"text\" name=\"horaf\" value = \"". $fila["HoraF"] ."\"readonly><br>
                        Motivo <input type=\"text\" name=\"motivo\"><br>
                        <input type=\"submit\" value=\"Aprobar-Sala\" name=\"apr-sol\"/>
                        <input type=\"submit\" value=\"Rechazar-Sala\" name=\"rec-sol\"/>
                    </li></form>";
                }
                $formsolicitud = $formsolicitud . "</ul>";
                echo $formsolicitud;
                $sqlsolicitud = "SELECT Usuarios.ID_Usuario AS ID_Usuario, libros.ID_Libro AS ID_Libro, Estado, Fecha, Motivo,
                Usuarios.Nombre AS UNombre, libros.Titulo AS LNombre, Correo
                FROM `SolicitudLibro` JOIN `libros` JOIN `usuarios`
                WHERE SolicitudLibro.ID_Libro = libros.ID_Libro AND SolicitudLibro.ID_Usuario = usuarios.ID_Usuario
                AND SolicitudLibro.Estado = 'espera';";
                $resultado = mysqli_query($con,$sqlsolicitud);
                $formsolicitud = "<ul><h2>Solicitudes Libros</h2>";
                while($fila = mysqli_fetch_array($resultado)){
                    $formsolicitud = $formsolicitud .
                    "<li><form action=\"manejo-sol.php\" method=\"POST\">
                        <input type=\"hidden\" name=\"iduser\" value=\"". $fila["ID_Usuario"] . "\"/>
                        <input type=\"hidden\" name=\"idlibro\" value=\"". $fila["ID_Libro"] . "\"/>
                        Libro <input type=\"text\" name=\"nombre-libro\" value = \"". $fila["LNombre"] ."\"readonly><br>
                        Usuario <input type=\"text\" name=\"nombre-user\" value = \"". $fila["UNombre"] ."\" readonly><br>
                        Email <input type=\"text\" name=\"email\" value = \"". $fila["Correo"] ."\" readonly><br>
                        Fecha <input type=\"text\" name=\"fecha\" value = \"". $fila["Fecha"] ."\"readonly><br>
                        Fecha Fin <input type=\"text\" name=\"fechafin\"  required><br>
                        Motivo <input type=\"text\" name=\"motivo\"><br>
                        Reporte <input type=\"text\" name=\"reporte\" required><br>
                        Tiempo <input type=\"text\" name=\"tiempo\" required><br>
                        <input type=\"submit\" value=\"Aprobar-Libro\" name=\"apr-sol\"/>
                        <input type=\"submit\" value=\"Rechazar-Libro\" name=\"rec-sol\"/>
                    </li></form>";
                }
                $formsolicitud = $formsolicitud . "</ul>";
                echo $formsolicitud;
                $sqlsolicitud = "SELECT Usuarios.ID_Usuario AS ID_Usuario, equipos.ID_Equipo AS ID_Equipo, Estado, Fecha, Motivo, Usuarios.Nombre
                AS UNombre, equipos.Nombre AS ENombre, Correo
                FROM `SolicitudEquipo` JOIN `equipos` JOIN `usuarios`
                WHERE SolicitudEquipo.ID_Equipo = equipos.ID_Equipo AND SolicitudEquipo.ID_Usuario = usuarios.ID_Usuario AND SolicitudEquipo.Estado = 'espera'";
                $resultado = mysqli_query($con,$sqlsolicitud);
                $formsolicitud = "<ul><h2>Solicitudes Equipos</h2>";
                while($fila = mysqli_fetch_array($resultado)){
                    $formsolicitud = $formsolicitud .
                    "<li><form action=\"manejo-sol.php\" method=\"POST\">
                        <input type=\"hidden\" name=\"iduser\" value=\"". $fila["ID_Usuario"] . "\"/>
                        <input type=\"hidden\" name=\"idequipo\" value=\"". $fila["ID_Equipo"] . "\"/>
                        Equipo <input type=\"text\" name=\"nombre-equipo\" value = \"". $fila["ENombre"] ."\"readonly><br>
                        Usuario <input type=\"text\" name=\"nombre-user\" value = \"". $fila["UNombre"] ."\" readonly><br>
                        Email <input type=\"text\" name=\"email\" value = \"". $fila["Correo"] ."\" readonly><br>
                        Fecha <input type=\"text\" name=\"fecha\" value = \"". $fila["Fecha"] ."\"readonly><br>
                        Fecha Fin <input type=\"text\" name=\"fechafin\" required><br>
                        Motivo <input type=\"text\" name=\"motivo\"><br>
                        Reporte <input type=\"text\" name=\"reporte\" required><br>
                        Tiempo <input type=\"text\" name=\"tiempo\" required><br>
                        <input type=\"submit\" value=\"Aprobar-Equipo\" name=\"apr-sol\"/>
                        <input type=\"submit\" value=\"Rechazar-Equipo\" name=\"rec-sol\"/>
                    </li></form>";
                }
                echo $formsolicitud;
                echo "<br><h4>Registrar Nuevo Administrador</h4>";
                echo "<form action = \"registro.php\" method = \"post\">
                        <button type=\"submit\" name = \"regi\">Registrar Admin</button>
                    </form>";
                    //REPORTES
                    echo "<h4>Reportes Usuario</h4>";
                    $formreportes = "<form action = \"reporte.php\" method = \"post\">";
                    $sqleventos = "SELECT * FROM `Usuarios`;";
                    $resultado = mysqli_query($con,$sqleventos);
                    $formreportes = $formreportes . "<select name =\"iduser\">";
                    while($fila = mysqli_fetch_array($resultado)){
                        $formreportes = $formreportes . "<option value=\"". $fila["ID_Usuario"] ."\">". $fila["Nombre"] ."</option>";
                    }
                    $formreportes = $formreportes . "</select><input type=\"submit\" value=\"Seleccionar-Usuario\" name=\"suser\"/></form>";
                    echo $formreportes;
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
