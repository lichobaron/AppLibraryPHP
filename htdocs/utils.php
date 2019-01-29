<?php
require_once('PHPMailer/PHPMailerAutoload.php');

    function login($username, $iduser, $rol, $email){
        if(!isset($_SESSION['username'])){
            $_SESSION['username']=$username;
        }
        if(!isset($_SESSION['iduser'])){
            $_SESSION['iduser']=$iduser;
        }
        if(!isset($_SESSION['rol'])){
            $_SESSION['rol']=$rol;
        }
        if(!isset($_SESSION['email'])){
            $_SESSION['email']=$email;
        }
    }
    function logout(){
        if(isset($_SESSION['username'])){
            unset($_SESSION['username']);
        }
        if(isset($_SESSION['iduser'])){
            unset($_SESSION['iduser']);
        }
        if(isset($_SESSION['rol'])){
            unset($_SESSION['rol']);
        }
        if(isset($_SESSION['email'])){
            unset($_SESSION['email']);
        }
    }

    function isLogged(){
        if(isset($_SESSION['username'])){
            return true;
        }
        return false;
    }

    function sendMail($subject,$body,$omail){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '465';
        $mail->isHTML();
        $mail->Username = 'bibliotecaphp2018@gmail.com';
        $mail->Password = 'b1232018';
        $mail->SetFrom('no-reply@biblioteca.edu.co');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($omail);
        $mail->Send();
    }
    function fechaValida($fecha){
        $date = DateTime::createFromFormat('Y/m/d', $fecha);

        $current_date = new DateTime();
        $date->setTime(23,59);
        $date_errors = DateTime::getLastErrors();
        if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) {
            return false;
        }
        if ($date < $current_date){
            return false;
        }
        return true;
    }
    function horaValida($hora){
        $dateObj = DateTime::createFromFormat('H:i', $hora);
        if ($dateObj !== false && $dateObj && $dateObj->format('G') ==
            intval($hora)){
            return true;
        }
        else{
          return false;
        }
    }
    function horasValidas($hora1,$hora2){
        if(horaValida($hora1) && horaValida($hora1)){
            if ($hora1 < $hora2){
                return true;
            }
            return false;
        }
        else{
            return false;
        }
    }
    function salaLibre($idsala,$fecha,$horai,$horaf){
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sqlpro =
        "SELECT  salas.ID_Sala
        FROM `salas` JOIN `prestamosala`
        WHERE prestamosala.ID_Sala = salas.ID_Sala AND salas.ID_Sala = '".$idsala."'
        AND prestamosala.Fecha = '".$fecha."'
        AND( prestamosala.HoraI > '".$horai."' AND prestamosala.HoraF <= '".$horaf."'
        OR prestamosala.HoraF > '".$horai."' AND prestamosala.HoraF <= '".$horaf."'
        OR prestamosala.HoraI > '".$horai."' AND prestamosala.HoraI <= '".$horaf."')
        UNION
        SELECT  salas.ID_Sala
        FROM `salas` JOIN `eventos`
        WHERE eventos.ID_Sala = salas.ID_Sala AND salas.ID_Sala = '".$idsala."'
        AND eventos.Fecha = '".$fecha."'
        AND( eventos.HoraI > '".$horai."' AND eventos.HoraF <= '".$horaf."'
        OR eventos.HoraF > '".$horai."' AND eventos.HoraF <= '".$horaf."'
        OR eventos.HoraI > '".$horai."' AND eventos.HoraI <= '".$horaf."')";
        $resultado = mysqli_query($con,$sqlpro);
        if (mysqli_num_rows($resultado)>0)
        {
           return false;
        }
        return true;
    }
    function salaLibreEdit($idsala,$fecha,$horai,$horaf){
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sqlpro =
        "SELECT  salas.ID_Sala
        FROM `salas` JOIN `prestamosala`
        WHERE prestamosala.ID_Sala = salas.ID_Sala AND salas.ID_Sala = '".$idsala."'
        AND prestamosala.Fecha = '".$fecha."'
        AND( prestamosala.HoraI > '".$horai."' AND prestamosala.HoraF <= '".$horaf."'
        OR prestamosala.HoraF > '".$horai."' AND prestamosala.HoraF <= '".$horaf."'
        OR prestamosala.HoraI > '".$horai."' AND prestamosala.HoraI <= '".$horaf."')
        UNION
        SELECT  salas.ID_Sala
        FROM `salas` JOIN `eventos`
        WHERE eventos.ID_Sala = salas.ID_Sala AND salas.ID_Sala = '".$idsala."'
        AND eventos.Fecha = '".$fecha."'
        AND( eventos.HoraI > '".$horai."' AND eventos.HoraF <= '".$horaf."'
        OR eventos.HoraF > '".$horai."' AND eventos.HoraF <= '".$horaf."'
        OR eventos.HoraI > '".$horai."' AND eventos.HoraI <= '".$horaf."')";
        $resultado = mysqli_query($con,$sqlpro);
        if (mysqli_num_rows($resultado)>1)
        {
           return false;
        }
        return true;
    }
    function prestamoPosibleLibro($idlibro){
      $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Libros WHERE ID_Libro ='".$idlibro."'";
        $resultado = mysqli_query($con,$sql);
        $fila = mysqli_fetch_array($resultado);
        if ($fila["Disponibles"]>0){
            return true;
        }
        return false;
    }
    function prestamoPosibleEquipo($idequipo){
      $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Equipos WHERE ID_Equipo ='".$idequipo."'";
        $resultado = mysqli_query($con,$sql);
        $fila = mysqli_fetch_array($resultado);
        if ($fila["Disponibles"]>0){
            return true;
        }
        return false;
    }
?>
