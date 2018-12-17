<?php
session_start();
include("./Configuracion.php");

if (!isset($_SESSION["usuario"])){
  $data = array("msg" => 'El tiempo de conexion expiro. Inicie sesion nuevamente');
  echo  json_encode($data);
}else {
  try {
    $usuario = $_SESSION["usuario"];
    $titulo = $_POST["titulo"];
    $fechainicio = $_POST["start_date"];
    $horainicio = $_POST["start_hour"];
    $fechafinal = $_POST["end_date"];
    $horafinal = $_POST["end_hour"];

    if ($titulo == ""){
      $data = array("msg" => 'Dede colocar un titulo para el evento.');
      echo  json_encode($data);
      exit;
    }elseif($fechainicio == ""){
      $data = array("msg" => 'Dede indicar una fecha de inicio para el evento.');
      echo  json_encode($data);
      exit;
    }
    $allday = 0;
    if($_POST["allDay"] == "true"){
      $allday = 1;
    }else {
      if ($horainicio == ""){
        $data = array("msg" => 'Cuando dia entero no esta marcado debe indicar hora de inicio.');
        echo  json_encode($data);
        exit;
      }elseif($fechafinal == ""){
        $data = array("msg" => 'Cuando dia entero no esta marcado debe indicar fecha fin.');
        echo  json_encode($data);
        exit;
      }elseif($horafinal == ""){
        $data = array("msg" => 'Cuando dia entero no esta marcado debe indicar hora fin.');
        echo  json_encode($data);
        exit;
      }elseif ($fechainicio == $fechafinal){
        if ($horainicio == $horafinal){
          $data = array("msg" => 'La hora de inicio no puede ser igual a la hora fin.');
          echo  json_encode($data);
          exit;
        }
      }
    }
    $conn = new PDO(cadena, UserServ, PassServ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('insert into eventos (idusuario, titulo, fechainicio, horainicio, fechafinal, horafinal, allday) values (:idusuario, :titulo, :fechainicio, :horainicio, :fechafinal, :horafinal, :allday)');
    $stmt->bindParam(':idusuario', $usuario);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':fechainicio', $fechainicio);
    $stmt->bindParam(':horainicio', $horainicio);
    $stmt->bindParam(':fechafinal', $fechafinal);
    $stmt->bindParam(':horafinal', $horafinal);
    $stmt->bindParam(':allday', $allday);
    $stmt->execute();
    $data = array("msg" => 'OK');
    echo  json_encode($data);


  }catch(Exception $ex){
    $data = array("msg" => 'Error: ' . $ex->getMessage());
    echo  json_encode($data);
  }
}



 ?>
