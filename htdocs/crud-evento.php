<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crud Evento</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="add-evento.js"></script>
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
                if( isset($_POST["editar"])){
                  $sqledit = "";
                    if(salaLibreEdit($_POST["idsala"],$_POST["fecha"],$_POST["horai"],$_POST["horaf"])){
                        if(horasValidas($_POST["horai"], $_POST["horaf"])){
                            $sqledit = "UPDATE Eventos SET
                            Fecha = '".$_POST["fecha"]."',
                            HoraI = '".$_POST["horai"]."',
                            HoraF = '".$_POST["horaf"]."',
                            Nombre = '".$_POST["nombre"]."',
                            Lugar = '".$_POST["lugar"]."',
                            ID_Sala = '".$_POST["idsala"]."'
                            WHERE Eventos.ID_Evento = ".$_POST["evento"].";";
                        }
                        else{
                            echo "<div><h4>Problema con las horas!</h4></div><br>";
                        }
                    if(mysqli_query($con,$sqledit)){
                        echo "Evento actualizado.";
                    }
                    else{
                        echo "Error actualizando: ".mysqli_error($con);
                    }
                    }
                    else{
                        echo "<div><h4>Sala ocupada.</h4></div><br>";
                    }
                }
                if( isset($_POST["eliminar"])){
                    $sqldelete = "DELETE FROM Eventos WHERE ID_Evento =". $_POST["evento"];
                    if(mysqli_query($con,$sqldelete)){
                        echo "Evento eliminado.";
                    }
                    else{
                        echo "Error eliminando: ".mysqli_error($con);
                    }
                }
                if( isset($_POST["ver-evento-admin"]) )
                {
                    $sqleventos = "SELECT * FROM `Eventos` WHERE `ID_Evento` ='" . $_POST["evento"] ."'";
                    $resultado = mysqli_query($con,$sqleventos);
                    $formevento = "<form action=\"crud-evento.php\" method=\"POST\">";
                    $fila = mysqli_fetch_array($resultado);
                    $formevento =  $formevento .
                                    "<input type=\"hidden\" name=\"evento\" value = \"". $_POST["evento"] ."\"><br>
                                    Evento:<br> <input type=\"text\" name=\"nombre\" value = \"". $fila["Nombre"] ."\"required><br>
                                    Fecha:<br> <input type\"text\" name=\"fecha\" value = \"". $fila["Fecha"] ."\" required><br>
                                    Hora Inicio <br> <input type=\"text\" name=\"horai\" value = \"". $fila["HoraI"] ."\"required><br>
                                    Hora Fin <br> <input type=\"text\" name=\"horaf\" value = \"". $fila["HoraF"] ."\"required><br>
                                    Lugar: <br> <input id = \"lugar\" type=\"text\" name=\"lugar\" value = \"". $fila["Lugar"] ."\"style=\"display: block\"><br>
                                    ";
                    $formevento = $formevento . "Lugar biblioteca?<br><input type=\"checkbox\" name=\"check1\" onclick=\"mostrarSalas(this)\"><br>";
                    $sqlevento = "SELECT * FROM `Salas` WHERE `ID_Sala` ='" . $fila["ID_Sala"] ."'";
                    $resultado = mysqli_query($con,$sqlevento);
                    $fila = mysqli_fetch_array($resultado);
                    $formevento =   $formevento .
                                    "Sala <select id = \"salas\" name =\"idsala\" style=\"display: none\">
                                    <option value=\"". $fila["ID_Sala"] ."\">". $fila["Nombre"] ."</option>";
                    $sqlsalas = "SELECT * FROM `Salas` WHERE `ID_Sala` <>'" . $fila["ID_Sala"] ."'";
                    $resultado = mysqli_query($con,$sqlsalas);
                    while($fila = mysqli_fetch_array($resultado)){
                        $formevento = $formevento . "<option value=\"". $fila["ID_Sala"] ."\">". $fila["Nombre"] ."</option>";
                    }
                    $formevento = $formevento . "</select><br>";
                    $formevento = $formevento . "<input type=\"submit\" value=\"Editar-Evento\" name=\"editar\"/>";
                    $formevento = $formevento . "<input type=\"submit\" value=\"Eliminar-Evento\" name=\"eliminar\"/></form>";
                    echo $formevento;
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
