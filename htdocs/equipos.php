<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Equipos</title>
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
            //
            if (isset($_POST["solicitarEquipo"])) {
              $idEqui = $_POST["idEquipo"];
              $cantidad = $_POST["disponibles"];
              $idUsuario = $_SESSION["iduser"];
              $mensaje = "";
              $insert = "";
              $ima = date("Y-m-d H:i:s");
              if ($cantidad > 0) {
                $conexion = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $insert .= "INSERT INTO SolicitudEquipo(ID_Usuario, ID_Equipo, Fecha, Estado)
                                    VALUES ($idUsuario, $idEqui, '$ima', 'espera')";
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
                    window.location.href="equipos.php"
                    </script>' ;
            }
            //

            if($_SESSION["rol"] == "Admin"){
              //
              if (isset($_POST["editarEquipo"])) {
                $mensaje = "";
                $idEquipo = $_POST["idEquipo"];
                $nombreEquipo = $_POST["nombreEquipo"];
                $fabricanteEquipo = $_POST["fabricanteEquipo"];
                $numSerieEquipo = $_POST["numSerieEquipo"];
                $cantidadEquipo = $_POST["cantidadEquipo"];
                $disponiblesEquipo = $_POST["disponiblesEquipo"];
                $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $sql = "UPDATE Equipos SET nombre = '$nombreEquipo', fabricante = '$fabricanteEquipo',
                                numSerie = '$fabricanteEquipo', cantidad = $cantidadEquipo,
                                disponibles = $disponiblesEquipo
                                WHERE ID_Equipo = $idEquipo";
                if (mysqli_query($con, $sql)) {
                  $mensaje .= "Se ha editado el Equipo";
                }else {
                  $mensaje .= "No se pudo editar el Equipo";
                }
                mysqli_close($con);
                echo '<script type="text/javascript" >
                      alert("' . $mensaje . '");
                      window.location.href="equipos.php"
                      </script>' ;
              }
              //
              if (isset($_POST["eliminarEquipo"])) {
                $mensaje = "";
                $idEquipo = $_POST["idEquipo"];
                $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
                $sql = "DELETE FROM Equipos WHERE ID_Equipo = $idEquipo";
                if (mysqli_query($con, $sql)) {
                  $mensaje .= "Se ha eliminado el Equipo";
                }else {
                  $mensaje .= "No se pudo elimnar el Equipo";
                }
                mysqli_close($con);
                echo '<script type="text/javascript" >
                      alert("' . $mensaje . '");
                      window.location.href="equipos.php"
                      </script>' ;
              }
              //
            }
            //
            $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
            $estructura = "";
            $sql = "";
            if($_SESSION["rol"] == "Admin"){
              $estructura .= '<form method="post" action="./agregarElemento.php">';
              $estructura .= '<input type="submit" name="solAgregarEquipo" value="agregarEquipo"></form> <br>';
            }
            $estructura .= '<form method="get" action="' . $_SERVER["PHP_SELF"] . '">';
            $estructura .= 'Buscar <input type="text" name="tituloBuscado" required>';
            $estructura .= '<input type="submit" name="buscadorBasico" value="Buscar"></form><br>';

            $estructura .= '<form method="post" action="./buscadorAvanzado.php">';
            $estructura .= '<input type="submit" name="buscarEquipo" value="Busqueda Avanzada"></form> <br><br>';
            $sql = "SELECT * FROM Equipos";
            //
            if (isset($_GET["buscadorBasico"])) {
              $tituloBuscado = trim($_GET["tituloBuscado"]);
              if (empty($tituloBuscado)) {
                echo '<script type="text/javascript" >
                      alert("Se requiere que llene el campo de busqueda");
                      window.location.href="equipos.php"
                      </script>' ;
              }else {
                $sql = "SELECT * FROM Equipos WHERE nombre LIKE '%". $tituloBuscado . "%' ";
              }
            }elseif (isset($_GET["busquedaAvanzada"])) {
              $nombreBuscado = trim($_GET["nombreEquipo"]);
              $fabricanteBuscado = trim($_GET["fabricanteEquipo"]);
              $disponiblesBuscado ="";
              if (isset($_GET["disponiblesEquipo"])) {
                $disponiblesBuscado = $_GET["disponiblesEquipo"];
              }
              $sql = "SELECT * FROM Equipos WHERE nombre LIKE '%". $nombreBuscado . "%' " .
                        "AND fabricante LIKE '%". $fabricanteBuscado ."%'";

              if ($disponiblesBuscado == "si") {
                $sql .= " AND disponibles > 0 ";
              }
            }
            $equipos =  mysqli_query($con, $sql);
            //
            while ($equipo = mysqli_fetch_array($equipos)) {
              $idEquipo = $equipo['ID_Equipo'];
              $nombre =  $equipo['Nombre'];
              $fabricante = $equipo['Fabricante'];
              $numSerie = $equipo['NumSerie'];
              $disponibles = $equipo['Disponibles'];
              $estructura .= '<strong>' . $nombre . '</strong><br>';
              $estructura .=  "Número de serie: $numSerie <br> Fabricante: $fabricante <br> Disponibles: $disponibles <br>";
              $estructura .= '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">';
              $estructura .= '<input type="hidden" name="idEquipo" value="' . $idEquipo . '">';
              $estructura .= '<input type="hidden" name="disponibles" value="' . $disponibles . '">';
              $estructura .= '<input type="submit" name="solicitarEquipo" value="solicitar"> </form>';
              if($_SESSION["rol"] == "Admin"){
                $estructura .= '<form method="post" action="./edicionElemento.php">';
                $estructura .= '<input type="hidden" name="idEquipo" value="'. $idEquipo .'">';
                $estructura .= '<input type="submit" name="solEditarEquipo" value="Editar"></form>';

                $estructura .= '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">';
                $estructura .= '<input type="hidden" name="idEquipo" value="'. $idEquipo .'">';
                $estructura .= '<input type="submit" name="eliminarEquipo" value="Eliminar"></form>';
              }
              $estructura .= '<br><br>';
            }
            echo $estructura;
            //
            if ($_SESSION["rol"]=="Admin") {
              # code...
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
