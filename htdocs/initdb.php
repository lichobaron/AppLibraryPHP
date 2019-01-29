<?php
    include "config.php";
    $con=mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
    $sql = "";
    $sql = "CREATE TABLE IF NOT EXISTS Usuarios(
        ID_Usuario INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(ID_Usuario),
        Nombre CHAR(15) NOT NULL UNIQUE,
        Correo CHAR(20) NOT NULL UNIQUE,
        Contrasena CHAR(20) NOT NULL,
        Rol CHAR(20) NOT NULL);";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS Salas(
        ID_Sala INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(ID_Sala),
        Nombre CHAR(15) NOT NULL);";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS Eventos(
        ID_Evento INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(ID_Evento),
        Fecha DATE NOT NULL,
        HoraI TIME NOT NULL,
        HoraF TIME NOT NULL,
        Nombre CHAR(15) NOT NULL,
        Lugar CHAR(15),
        ID_Sala INT,
        FOREIGN KEY (ID_Sala) REFERENCES Salas(ID_Sala) ON DELETE CASCADE);";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS UsuariosXEvento(
        ID_Evento INT NOT NULL,
        ID_Usuario INT NOT NULL,
        PRIMARY KEY(ID_Evento, ID_Usuario),
        FOREIGN KEY (ID_Usuario) REFERENCES Usuarios(ID_Usuario) ON DELETE CASCADE,
        FOREIGN KEY (ID_Evento) REFERENCES Eventos(ID_Evento) ON DELETE CASCADE);";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS Libros(
        ID_Libro INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(ID_Libro),
        Titulo CHAR(30) NOT NULL,
        Autor CHAR(30) NOT NULL,
        ISBN CHAR(20) NOT NULL,
        Edicion CHAR(20) NOT NULL,
        Editorial CHAR(30) NOT NULL,
        Paginas INT NOT NULL,
        Copias INT NOT NULL,
        Disponibles INT NOT NULL);";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS Equipos(
        ID_Equipo INT NOT NULL AUTO_INCREMENT,
        PRIMARY KEY(ID_Equipo),
        Nombre CHAR(30) NOT NULL,
        Fabricante CHAR(30) NOT NULL,
        NumSerie CHAR(20) NOT NULL,
        Cantidad INT NOT NULL,
        Disponibles INT NOT NULL);";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS SolicitudEquipo(
        ID_Usuario INT NOT NULL,
        ID_Equipo INT NOT NULL,
        PRIMARY KEY(ID_Usuario,ID_Equipo),
        FOREIGN KEY (ID_Usuario) REFERENCES Usuarios(ID_Usuario) ON DELETE CASCADE,
        FOREIGN KEY (ID_Equipo) REFERENCES Equipos(ID_Equipo) ON DELETE CASCADE,
        Fecha DATETIME NOT NULL,
        Estado ENUM('espera', 'aceptada', 'rechazada') NOT NULL,
        Motivo CHAR(50));";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS PrestamoEquipo(
        ID_Usuario INT NOT NULL,
        ID_Equipo INT NOT NULL,
        PRIMARY KEY(ID_Usuario,ID_Equipo),
        FOREIGN KEY (ID_Usuario) REFERENCES Usuarios(ID_Usuario) ON DELETE CASCADE,
        FOREIGN KEY (ID_Equipo) REFERENCES Equipos(ID_Equipo) ON DELETE CASCADE,
        FechaInicio DATETIME NOT NULL,
        FechaFinal DATETIME NOT NULL,
        Tiempo INT NOT NULL,
        Reporte INT NOT NULL,
        Estado CHAR(15) NOT NULL);";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS SolicitudLibro(
        ID_Usuario INT NOT NULL,
        ID_Libro INT NOT NULL,
        PRIMARY KEY(ID_Usuario,ID_Libro),
        FOREIGN KEY (ID_Usuario) REFERENCES Usuarios(ID_Usuario) ON DELETE CASCADE,
        FOREIGN KEY (ID_Libro) REFERENCES Libros(ID_Libro) ON DELETE CASCADE,
        Fecha DATETIME NOT NULL,
        Estado ENUM('espera', 'aceptada', 'rechazada') NOT NULL,
        Motivo CHAR(50));";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS PrestamoLibro(
        ID_Usuario INT NOT NULL,
        ID_Libro INT NOT NULL,
        PRIMARY KEY(ID_Usuario,ID_Libro),
        FOREIGN KEY (ID_Usuario) REFERENCES Usuarios(ID_Usuario) ON DELETE CASCADE,
        FOREIGN KEY (ID_Libro) REFERENCES Libros(ID_Libro) ON DELETE CASCADE,
        FechaInicio DATETIME NOT NULL,
        FechaFinal DATETIME NOT NULL,
        Tiempo INT NOT NULL,
        Reporte INT NOT NULL);";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS SolicitudSala(
        ID_SolicitudSala INT NOT NULL AUTO_INCREMENT,
        ID_Usuario INT NOT NULL,
        ID_Sala INT NOT NULL,
        PRIMARY KEY(ID_SolicitudSala, ID_Usuario,ID_Sala),
        FOREIGN KEY (ID_Usuario) REFERENCES Usuarios(ID_Usuario) ON DELETE CASCADE,
        FOREIGN KEY (ID_Sala) REFERENCES Salas(ID_Sala) ON DELETE CASCADE,
        Estado ENUM('espera', 'aceptada', 'rechazada') NOT NULL,
        Fecha DATE NOT NULL,
        HoraI TIME NOT NULL,
        HoraF TIME NOT NULL,
        Motivo CHAR(30));";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "CREATE TABLE IF NOT EXISTS PrestamoSala(
        ID_PrestamoSala INT NOT NULL AUTO_INCREMENT,
        ID_Usuario INT NOT NULL,
        ID_Sala INT NOT NULL,
        PRIMARY KEY(ID_PrestamoSala,ID_Usuario,ID_Sala),
        FOREIGN KEY (ID_Usuario) REFERENCES Usuarios(ID_Usuario) ON DELETE CASCADE,
        FOREIGN KEY (ID_Sala) REFERENCES Salas(ID_Sala) ON DELETE CASCADE,
        Fecha DATE NOT NULL,
        HoraI TIME NOT NULL,
        HoraF TIME NOT NULL);";
    if(mysqli_query($con,$sql)){
        echo "Tablas creadas correctamente";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "INSERT INTO `salas` (`ID_Sala`, `Nombre`) VALUES ('1', 'Sala1');";
    if(mysqli_query($con,$sql)){
        echo "Insert exitoso";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }

    $sql = "INSERT INTO `salas` (`ID_Sala`, `Nombre`) VALUES ('2', 'Sala2');";
    if(mysqli_query($con,$sql)){
        echo "Insert exitoso";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "INSERT INTO `salas` (`ID_Sala`, `Nombre`) VALUES ('3', 'Sala3');";
    if(mysqli_query($con,$sql)){
        echo "Insert exitoso";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "INSERT INTO `eventos` (`ID_Evento`, `Fecha`, `HoraI`, `HoraF`, `Nombre`, `Lugar`, `ID_Sala`) VALUES ('1', '2018/06/01', '7:00', '9:00', 'Evento1', NULL, '1');";
    if(mysqli_query($con,$sql)){
        echo "Insert exitoso";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "INSERT INTO `eventos` (`ID_Evento`, `Fecha`, `HoraI`, `HoraF`, `Nombre`, `Lugar`, `ID_Sala`) VALUES ('2', '2018/06/05', '7:00', '8:59', 'Evento2', NULL, '3');";
    if(mysqli_query($con,$sql)){
        echo "Insert exitoso";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "INSERT INTO `eventos` (`ID_Evento`, `Fecha`, `HoraI`, `HoraF`, `Nombre`, `Lugar`, `ID_Sala`) VALUES ('3', '2018/06/20', '9:00', '11:00', 'Evento3', 'lugar1', NULL);";
    if(mysqli_query($con,$sql)){
        echo "Insert exitoso";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "INSERT INTO `usuarios` (`ID_Usuario`, `Nombre`, `Correo`, `Contrasena`, `Rol`) VALUES ('1', 'User1', 'user1@gmail.com', 'user1', 'User');";
    if(mysqli_query($con,$sql)){
        echo "Insert exitoso";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    $sql = "INSERT INTO `usuarios` (`ID_Usuario`, `Nombre`, `Correo`, `Contrasena`, `Rol`) VALUES ('2', 'Admin1', 'admin1@gmail.com', 'admin1', 'Admin');";
    if(mysqli_query($con,$sql)){
        echo "Insert exitoso";
    }
    else{
        echo "Error en la creacion".mysqli_error($con);
    }
    mysqli_close($con);
?>
