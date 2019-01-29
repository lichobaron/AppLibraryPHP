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
              if(isset($_POST["registrar-reporte"])){
                $sqledit = "UPDATE PrestamoEquipo SET
                Estado = '".$_POST["estado"]."'
                WHERE PrestamoEquipo.ID_Equipo = ".$_POST["idequipo"]." AND PrestamoEquipo.ID_Usuario = ".$_POST["iduser"];
                if(mysqli_query($con,$sqledit)){
                    echo "Estado actualizado.";
                }
                else{
                    echo "Error en el estado: ".mysqli_error($con);
                }
                if($_POST["estado"]=="devuelto"){
                  $sqledit = "UPDATE Equipos SET
                  Disponibles = Disponibles + 1
                  WHERE Equipos.ID_Equipo = ".$_POST["idequipo"];
                  if(mysqli_query($con,$sqledit)){
                      echo "Equipos actualizados.";
                  }
                  else{
                      echo "Error actualizando equipos: ".mysqli_error($con);
                  }
                }
              }
              if (isset($_POST["iduser"])) {
                $formreporte = "<ul>";
                $idUs = $_POST["iduser"];
                $sql = "SELECT Usuarios.Nombre AS UNombre, Usuarios.ID_Usuario, Equipos.ID_Equipo, Equipos.Nombre AS ENombre
                FROM PrestamoEquipo JOIN Equipos JOIN Usuarios WHERE PrestamoEquipo.ID_Usuario = $idUs AND
                          PrestamoEquipo.ID_Equipo = Equipos.ID_Equipo AND PrestamoEquipo.ID_Usuario = Usuarios.ID_Usuario";
                $resultado = mysqli_query($con, $sql);
                while($fila = mysqli_fetch_array($resultado)){
                    $formreporte = $formreporte .
                                    "<li><form action=\"reporte.php\" method=\"POST\">" .
                                    "<input type=\"hidden\" name=\"idequipo\" value=\"". $fila["ID_Equipo"] . "\"/>" .
                                    "<input type=\"hidden\" name=\"iduser\" value=\"". $fila["ID_Usuario"] . "\"/>" .
                                    "Usuario: <input type=\"text\" name=\"user\" value=\"". $fila["UNombre"] . "\"/><br>" .
                                    "Elemento: <input type=\"text\" name=\"user\" value=\"". $fila["ENombre"] . "\"/><br>" .
                                    'Estado: <select name = "estado">
                                     <option value="excelente">Excelente</option>
                                     <option value="bueno">Bueno</option>
                                     <option value="regular">Regular</option>
                                     <option value="danado">Dañado</option>
                                     <option value="devuelto">Devuelto</option>
                                    </select>
                                    <input type="submit" value="Registrar-Reporte" name="registrar-reporte"/>
                                    </form>
                                    </li><br>';
                }
                $formreporte = $formreporte . "</ul>";
                echo $formreporte;
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
