<?php
session_start();
include("./Configuracion.php");

if (!isset($_SESSION["usuario"])){
  $data = array("msg" => 'El tiempo de conexion expiro. Inicie sesion nuevamente');
  echo  json_encode($data);
}else {
  try {
    $usuario = $_SESSION["usuario"];
    $conn = new PDO(cadena, UserServ, PassServ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('select idevento, idusuario, titulo, fechainicio, horainicio, fechafinal, horafinal, allday from eventos where idusuario = :idusuario');
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->bindParam(':idusuario', $usuario);
    $stmt->execute();

$contador = 0;
    while ($row = $stmt->fetch()){
      if ($row['allday'] == 1){
        $jsonArr[] = array("id" =>  $row['idevento'], "title" =>  $row['titulo'],  "start" => $row['fechainicio'], "allday" => $row['allday']);
      }else {
        $jsonArr[] = array("id" =>  $row['idevento'], "title" =>  $row['titulo'],  "start" => $row['fechainicio'] . ' ' . $row['horainicio'] , "allday" => $row['allday'], "end" => $row['fechafinal'] . ' ' . $row['horafinal']);
      }
      $contador  = $contador + 1;
    }
    if ($contador > 0 ) {
      $data = array("msg" => "OK", "eventos" => $jsonArr);
      echo  json_encode($data);
    }else {
      $data = array("msg" => "OK");
      echo  json_encode($data);
    }


  }catch(Exception $ex){
    $data = array("msg" => 'Error: ' . $ex->getMessage());
    echo  json_encode($data);
  }
}


 ?>
