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

    $conn = new PDO(cadena, UserServ, PassServ);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare('delete from eventos where idusuario = :idusuario and idevento = :id');

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':idusuario', $usuario);
    $stmt->execute();
    $data = array("msg" => 'OK');
    echo  json_encode($data);

  }catch(Exception $ex){
    $data = array("msg" => 'Error: ' . $ex->getMessage());
    echo  json_encode($data);
  }
}


 ?>
