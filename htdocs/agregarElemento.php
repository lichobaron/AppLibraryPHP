<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agregar Elemento</title>
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
              if ( isset($_POST["solAgregarLibro"]) ) {
                ?>
                Agregar Libro <br>
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" >
                  Titulo: <input type="text" name="titulo"  maxlength="29"> <br>
                  Autor: <input type="text" name="autor" maxlength="29"> <br>
                  ISBN: <input type="text" name="isbn" maxlength="19"> <br>
                  Edición: <input type="text" name="edicion" maxlength="19"> <br>
                  Editorial: <input type="text" name="editorial" maxlength="29"> <br>
                  Número de paginas: <input type="number" name="paginas"> <br>
                  Número de copias: <input type="number" name="copias"> <br>
                  <input type="submit" name="agregarlibro" value="Agregar">
                </form>
                <?php
              }else if (isset($_POST["solAgregarEquipo"]) ) {
                ?>
                Agregar Equipo
                <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" >
                  Nombre: <input type="text" name="nombre" maxlength="30"> <br>
                  Fabricante: <input type="text" name="fabricante" maxlength="30"> <br>
                  Número de serie: <input type="text" name="numSerie" maxlength="30"> <br>
                  Cantidad: <input type="number" name="cantidad"> <br>
                  <input type="submit" name="agregarequipo" value="Agregar">
                </form>
                <?php
              }elseif (isset($_POST["agregarlibro"])) {
                $titulo = $_POST["titulo"];
                $autor = $_POST["autor"];
                $isbn = $_POST["isbn"];
                $edicion = $_POST["edicion"];
                $editorial = $_POST["editorial"];
                $paginas = $_POST["paginas"];
                $copias = $_POST["copias"];
                $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $sql = "INSERT INTO Libros(Titulo, Autor, ISBN, Edicion, Editorial, Paginas, Copias, Disponibles)
                                  VALUES ('$titulo', '$autor', '$isbn', '$edicion', '$editorial',
                                  $paginas, $copias, $copias)";
                if (mysqli_query($con, $sql)) {
                  echo '<script type="text/javascript" >
                        alert("Se ha agregado el libro' .$titulo.' ");
                        window.location.href="libros.php"
                        </script>' ;
                }else {
                  echo '<script type="text/javascript" >
                        alert("Error insertando' .$titulo.' ");
                        window.location.href="libros.php"
                        </script>' ;
                }
                mysqli_close($con);
              }elseif (isset($_POST["agregarequipo"])) {
                $nombre = $_POST["nombre"];
                $fabricante = $_POST["fabricante"];
                $numSerie = $_POST["numSerie"];
                $cantidad = $_POST["cantidad"];
                $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $sql = "INSERT INTO Equipos(Nombre, Fabricante, NumSerie, Cantidad, Disponibles)
                                  VALUES ('$nombre', '$fabricante', '$numSerie', $cantidad, $cantidad)";
                if (mysqli_query($con, $sql)) {
                  echo '<script type="text/javascript" >
                        alert("Se ha insertado el equipo' .$nombre.' ");
                        window.location.href="equipos.php"
                        </script>' ;
                }else {
                  echo '<script type="text/javascript" >
                        alert("Error insertando' .$nombre. '");
                        window.location.href="equipos.php"
                        </script>' ;
                }
                mysqli_close($con);
              }
            }
            else if($_SESSION["rol"] == "User"){
              echo "No tiene permisos para accerder a esta pagina";
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
