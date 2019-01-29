<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mensajes</title>
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
                if(isset($_POST["crear"])){
                    if(fechaValida($_POST["fecha"])){
                        if(horasValidas($_POST["horai"],$_POST["horaf"])){
                            if( (empty($_POST["check1"]) && !empty($_POST["lugar"])) || (!empty($_POST["check1"]) && !empty($_POST["idsala"])) ){
                                if(empty($_POST["check1"]) && !empty($_POST["lugar"])){
                                    $sqlinsert = "INSERT INTO `Eventos` (Fecha, HoraI, HoraF, Nombre, Lugar)
                                    VALUES ('".$_POST["fecha"]."', '".$_POST["horai"]."','".$_POST["horaf"]."','".$_POST["evento"]."','".$_POST["lugar"]."')";
                                    if(mysqli_query($con,$sqlinsert)){
                                        echo "<div><h4>Evento añadido.</h4></div><br>";
                                    }
                                    else{
                                        echo "<div><h4>Error insertando evento: ".mysqli_error($con)."</h4></div><br>";
                                    }
                                }
                                else{
                                    if(salaLibre($_POST["idsala"],$_POST["fecha"],$_POST["horai"],$_POST["horaf"])){
                                        $sqlinsert = "INSERT INTO `Eventos` (Fecha, HoraI, HoraF, Nombre ,ID_Sala)
                                        VALUES ('".$_POST["fecha"]."', '".$_POST["horai"]."','".$_POST["horaf"]."','".$_POST["evento"]."','".$_POST["idsala"]."')";
                                        if(mysqli_query($con,$sqlinsert)){
                                            echo "<div><h4>Evento añadido.</h4></div><br>";
                                        }
                                        else{
                                            echo "<div><h4>Error insertando evento: ".mysqli_error($con)."</h4></div><br>";
                                        }
                                    }
                                    else{
                                        echo "<div><h4>Sala ocupada.</h4></div><br>";
                                    }
                                }
                            }
                            else{
                                echo "<div><h4>Algo salió mal!.</h4></div><br>";
                            }
                        }
                        else{
                            echo "<div><h4>Problema con las horas!</h4></div><br>";
                        }
                    }
                    else{
                        echo "<div><h4>Fecha inválida (Formato: yyyy/mm/dd).</h4></div><br>";
                    }
                }
                $formadd = "<form action=\"add-evento.php\" method=\"POST\">
                        Evento:<br><input type=\"text\" name=\"evento\" required><br>
                        Fecha: <br><input type=\"text\" name=\"fecha\" required><br>
                        Hora Inicio: <br><input type=\"text\" name=\"horai\" required><br>
                        Hora Fin: <br><input type=\"text\" name=\"horaf\" required><br>
                        Lugar: <br><input id = \"lugar\" type=\"text\" name=\"lugar\" style=\"display: block\"><br>
                        Lugar biblioteca?<br><input type=\"checkbox\" name=\"check1\" onclick=\"mostrarSalas(this)\"><br>";
                        $sqlsalas = "SELECT * FROM `Salas`";
                        $resultado = mysqli_query($con,$sqlsalas);
                        $inputsalas = " Sala: <br><select id = \"salas\" name =\"idsala\" style=\"display: none\">";
                        while($fila = mysqli_fetch_array($resultado)){
                            $inputsalas = $inputsalas . "<option value=\"". $fila["ID_Sala"] ."\">". $fila["Nombre"] ."</option>";
                        }
                        $inputsalas = $inputsalas . "</select><br>";
                        $formadd = $formadd . $inputsalas;
                $formadd = $formadd . "<input type=\"submit\" value=\"Crear-Evento\" name=\"crear\"/></form>";
                echo $formadd;
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
