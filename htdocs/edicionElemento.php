<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edicion Elemento</title>
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
              if ( isset($_POST["solEditarEquipo"]) ){
                $idEquipo = $_POST["idEquipo"]; ?>
                <h1>Editar Equipo</h1>
                <form method="post" action="./equipos.php">
                  <input type="hidden" name="idEquipo" value="<?php echo $idEquipo; ?>">
                  <label for="nombreEquipo">Nombre</label>
                  <input type="text" name="nombreEquipo" id="nombreEquipo" required><br>
                  <label for="fabricanteEquipo">Fabricante</label>
                  <input type="text" name="fabricanteEquipo" id="fabricanteEquipo" required><br>
                  <label for="numSerieEquipo">Numero de serie</label>
                  <input type="text" name="numSerieEquipo" id="numSerieEquipo" required><br>
                  <label for="cantidadEquipo">Cantidad</label>
                  <input type="number" name="cantidadEquipo" id="cantidadEquipo" required><br>
                  <label for="disponiblesEquipo">Disponibles</label>
                  <input type="number" name="disponiblesEquipo" id="disponiblesEquipo" required><br>
                  <input type="submit" name="editarEquipo" value="Editar">
                </form>
            <?php
              } elseif ( isset($_POST["solEditarLibro"]) ) {
                echo "entro";
                  $idLibro = $_POST["idLibro"];
            ?>
            <h1>Editar Libro</h1>
            <form method="post" action="./libros.php">
              <input type="hidden" name="idLibro" value="<?php echo $idLibro; ?>">
              <label for="tituloLibro">Título</label>
              <input type="text" name="tituloLibro" id="tituloLibro" required><br>
              <label for="autorLibro">Autor</label>
              <input type="text" name="autorLibro" id="autorLibro" required><br>
              <label for="isbnLibro">ISBN</label>
              <input type="text" name="isbnLibro" id="isbnLibro" required><br>
              <label for="edicionLibro">Edición</label>
              <input type="text" name="edicionLibro" id="edicionLibro" required><br>
              <label for="editorialLibro">Editorial</label>
              <input type="text" name="editorialLibro" id="editorialLibro" required><br>
              <label for="paginasLibro">Páginas</label>
              <input type="number" name="paginasLibro" id="paginasLibro" required><br>
              <label for="copiasLibro">Copias</label>
              <input type="number" name="copiasLibro" id="copiasLibro" required><br>
              <label for="disponiblesLibro">Disponibles</label>
              <input type="number" name="disponiblesLibro" id="disponiblesLibro" required><br>
              <input type="submit" name="editarLibro" value="Editar">
            </form>
            <?php
            }
          }
            else if($_SESSION["rol"] == "User"){
              echo "No tiene permisos para accerder a esta pagina";
            }
            else{
                echo "<div><h2>No tienes acceso a esta página.</h2></div><br>";
            }
        }else{
            mysqli_close($con);
            header('Location: '."index.php");
        }

    mysqli_close($con);
    ?>
</body>
</html>
