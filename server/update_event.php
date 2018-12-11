<?php

session_start();
include("./Configuracion.php");

if (!isset($_SESSION["usuario"])){
  $data = array("msg" => 'El tiempo de conexion expiro. Inicie sesion nuevamente');
  echo  json_encode($data);
}else {
  try {
    $usuario = $_SESSION["usuario"];
    $id = $_POST["id"];
    $fechainicio = $_POST["start_date"];
    $horainicio = $_POST["start_hour"];
    $fechafinal = $_POST["end_date"];
    $horafinal = $_POST["end_hour"];

    $conn = new PDO(cadena, UserServ, PassServ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('update eventos set fechainicio = :fechainicio, horainicio = :horainicio, fechafinal = :fechafinal, horafinal = :horafinal where idusuario = :idusuario and idevento = :id');

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':idusuario', $usuario);
    $stmt->bindParam(':fechainicio', $fechainicio);
    $stmt->bindParam(':horainicio', $horainicio);
    $stmt->bindParam(':fechafinal', $fechafinal);
    $stmt->bindParam(':horafinal', $horafinal);
    $stmt->execute();
    $data = array("msg" => 'OK');
    echo  json_encode($data);

  }catch(Exception $ex){
    $data = array("msg" => 'Error: ' . $ex->getMessage());
    echo  json_encode($data);
  }
}


 ?>
