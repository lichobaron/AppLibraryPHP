<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buscador Avanzado</title>
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
            if (isset($_POST["buscarEquipo"])){ ?>
              <h1>Busqueda Avanzada: Equipo</h1>
              <form method="get" action="./equipos.php">
                <label for="nombreEquipo">Nombre</label>
                <input type="text" name="nombreEquipo" id="nombreEquipo"><br>
                <label for="fabricanteEquipo">Fabricante</label>
                <input type="text" name="fabricanteEquipo" id="fabricanteEquipo"><br>
                <label for="disponiblesEquipo">Solo equipos disponibles</label>
                <input type="checkbox" name="disponiblesEquipo" id="disponiblesEquipo" value="si" checked><br>
                <input type="submit" name="busquedaAvanzada">
              </form>
            <?php
          }elseif (isset($_POST["buscarLibro"])) {
            ?>
            <form method="get" action="./libros.php">
              <label for="tituloLibro">Titulo</label>
              <input type="text" name="tituloLibro" id="tituloLibro"><br>
              <label for="autorLibro">Autor</label>
              <input type="text" name="autorLibro" id="autorLibro"><br>
              <label for="editorialLibro">Editorial</label>
              <input type="text" name="editorialLibro" id="editorialLibro"><br>
              <label for="disponiblesLibro">Solo libros disponibles</label>
              <input type="checkbox" name="disponiblesLibro" id="disponiblesLibro" value="si" checked><br>
              <input type="submit" name="busquedaAvanzada">
            </form>
            <?php
          }

            if($_SESSION["rol"] == "Admin"){

            }
            else if($_SESSION["rol"] == "User"){

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
