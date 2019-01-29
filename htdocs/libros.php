<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Libros</title>
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
            //Funciones basicas de libros
            if (isset($_POST["solicitarLibro"])) {
              $idLib = $_POST["idLibro"];
              $cantidad = $_POST["disponibles"];
              $idUsuario = $_SESSION["iduser"];
              $mensaje = "";
              $insert = "";
              $ima = date("Y-m-d H:i:s");
              if ($cantidad > 0) {
                $conexion = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $insert .= "INSERT INTO SolicitudLibro(ID_Usuario, ID_Libro, Fecha, Estado)
                                    VALUES ($idUsuario, $idLib, '$ima', 'espera')";
                if (mysqli_query($conexion, $insert)) {
                  $mensaje .= "Se ha realizado la solicitud";
                }else {
                  $mensaje .= "No se pudo realizar la solicitud";
                }
                mysqli_close($conexion);
              }else {
                $mensaje .= "No hay ejemplares disponibles actualmente";
              }
              echo '<script type="text/javascript" >
                    alert("' . $mensaje . '");
                    window.location.href="libros.php"
                    </script>' ;
            }
            if (isset($_POST["editarLibro"])) {
              $mensaje = "";
              $idLibro = $_POST["idLibro"];
              $tituloLibro = $_POST["tituloLibro"];
              $autorLibro = $_POST["autorLibro"];
              $isbnLibro = $_POST["isbnLibro"];
              $edicionLibro = $_POST["edicionLibro"];
              $editorialLibro = $_POST["editorialLibro"];
              $paginasLibro = $_POST["paginasLibro"];
              $copiasLibro = $_POST["copiasLibro"];
              $disponiblesLibro = $_POST["disponiblesLibro"];
              $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
              $sql = "UPDATE Libros SET titulo = '$tituloLibro', autor = '$autorLibro',
                              isbn = '$isbnLibro', edicion = '$edicionLibro',
                              editorial = '$editorialLibro', paginas = $paginasLibro,
                              copias = $copiasLibro, disponibles = $disponiblesLibro
                              WHERE ID_Libro = $idLibro";
              if (mysqli_query($con, $sql)) {
                $mensaje .= "Se ha editado el Libro";
              }else {
                $mensaje .= "No se pudo editar el Libro";
              }
              mysqli_close($con);
              echo '<script type="text/javascript" >
                    alert("' . $mensaje . '");
                    window.location.href="libros.php"
                    </script>' ;
            }
            if (isset($_POST["eliminarLibro"])) {
              $mensaje = "";
              $idLibro = $_POST["idLibro"];
              $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
              $sql = "DELETE FROM Libros WHERE ID_Libro = $idLibro";
              if (mysqli_query($con, $sql)) {
                $mensaje .= "Se ha eliminado el Libro";
              }else {
                $mensaje .= "No se pudo elimnar el Libro";
              }
              mysqli_close($con);
              echo '<script type="text/javascript" >
                    alert("' . $mensaje . '");
                    window.location.href="libros.php"
                    </script>' ;
            }
            //Buscador
            $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
            $estructura = "";
            $sql = "";
            if($_SESSION["rol"] == "Admin"){
              $estructura .= '<form method="post" action="./agregarElemento.php">';
              $estructura .= '<input type="submit" name="solAgregarLibro" value="agregarLibro"></form> <br>';
            }
            $estructura .= '<form method="get" action="' . $_SERVER["PHP_SELF"] . '">';
            $estructura .= 'Buscar <input type="text" name="tituloBuscado" required>';
            $estructura .= '<input type="submit" name="buscadorBasico" value="Buscar"></form><br>';

            $estructura .= '<form method="post" action="./buscadorAvanzado.php">';
            $estructura .= '<input type="submit" name="buscarLibro" value="Busqueda Avanzada"></form> <br><br>';
            $sql = "SELECT * FROM Libros";
            if (isset($_GET["buscadorBasico"])) {
              $tituloBuscado = trim($_GET["tituloBuscado"]);
              if (empty($tituloBuscado)) {
                echo '<script type="text/javascript" >
                      alert("Se requiere que llene el campo de busqueda");
                      window.location.href="libros.php"
                      </script>' ;
              }else {
                $sql = "SELECT * FROM Libros WHERE titulo LIKE '%". $tituloBuscado . "%' ";
              }
            }elseif (isset($_GET["busquedaAvanzada"])) {
              $tituloBuscado = trim($_GET["tituloLibro"]);
              $autorBuscado = trim($_GET["autorLibro"]);
              $editorialBuscada = trim($_GET["editorialLibro"]);
              $disponiblesBuscado ="";
              if (isset($_GET["disponiblesLibro"])) {
                $disponiblesBuscado = $_GET["disponiblesLibro"];
              }
              $sql = "SELECT * FROM Libros WHERE titulo LIKE '%". $tituloBuscado . "%' " .
                        "AND autor LIKE '%". $autorBuscado ."%' " .
                        "AND editorial LIKE '%" . $editorialBuscada . "%' ";

              if ($disponiblesBuscado == "si") {
                $sql .= " AND disponibles > 0 ";
              }
            }
            //Lista
            $libros =  mysqli_query($con, $sql);
            while ($libro = mysqli_fetch_array($libros)) {
              $idLibro = $libro['ID_Libro'];
              $titulo =  $libro['Titulo'];
              $autor = $libro['Autor'];
              $edicion = $libro['Edicion'];
              $editorial = $libro['Editorial'];
              $disponibles = $libro['Disponibles'];
              $estructura .= '<strong>' . $titulo . '</strong><br>';
              $estructura .=  "$autor <br> $edicion <br> Editorial: $editorial <br> Disponibles: $disponibles <br>";
              $estructura .= '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">';
              $estructura .= '<input type="hidden" name="idLibro" value="' . $idLibro . '">';
              $estructura .= '<input type="hidden" name="disponibles" value="' . $disponibles . '">';
              $estructura .= '<input type="submit" name="solicitarLibro" value="solicitar"> </form>';
              if($_SESSION["rol"] == "Admin"){
                $estructura .= '<form method="post" action="./edicionElemento.php">';
                $estructura .= '<input type="hidden" name="idLibro" value="'. $idLibro .'">';
                $estructura .= '<input type="submit" name="solEditarLibro" value="Editar"></form>';

                $estructura .= '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">';
                $estructura .= '<input type="hidden" name="idLibro" value="'. $idLibro .'">';
                $estructura .= '<input type="submit" name="eliminarLibro" value="Eliminar"></form>';
              }
              else if($_SESSION["rol"] == "User"){

              }
            }
              $estructura .= '<br><br>';
              echo $estructura;
        }
        else{
            mysqli_close($con);
            header('Location: '."index.php");
        }
    mysqli_close($con);
    ?>
</body>
</html>
