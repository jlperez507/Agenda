<?php
include("./Configuracion.php");
header('Content-Type: application/json');
session_start();
try {
  $user = $_POST["username"];
  $pass =$_POST["password"];

  $conn = new PDO(cadena, UserServ, PassServ);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare('select * from usuario where idusuario = :user');
  $stmt->bindParam(':user', $user);
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $stmt->execute();
  $existe = 0;
  $nuser = "";
  while ($row = $stmt->fetch()){
      $hash = $row['password'];
      if (password_verify($pass, $hash)){
        $existe = 1;
        $nuser = $row['nombre'];
      }
  }
  if ($existe == 1) {
      $_SESSION["usuario"] = $user;
      $_SESSION["nusuario"] = $nuser;
      $data = array("msg" => 'OK');
      echo  json_encode($data);
  } else {
      $data =  array("msg" => 'Usuario No Valido');
      echo  json_encode($data);
  }
} catch (Exception $ex) {
   $conn = null;
   $data = array("msg" => 'Error: ' . $ex->getMessage());
   echo  json_encode($data);
}


 ?>
