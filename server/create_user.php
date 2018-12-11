<?php
include("./Configuracion.php");

$user ="toua507@gmail.com";
$nombre = "Jose Luis Perez";
$pass = password_hash('0190', PASSWORD_DEFAULT);
$fechanac = "1990-03-01";
$conn = new PDO(cadena, UserServ, PassServ);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare('insert into usuario (idusuario, nombre, password, fechanacimiento) values (:idusuario,:nombre, :password, :fechanac)');
$stmt->bindParam(':idusuario', $user);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':password', $pass);
$stmt->bindParam(':fechanac', $fechanac);
$stmt->execute();

$user ="info@gmail.com";
$nombre = "Admin";
$pass = password_hash('admin', PASSWORD_DEFAULT);
$fechanac = "1990-03-01";
$stmt->execute();

$user ="global@gmail.com";
$nombre = "global";
$pass = password_hash('global', PASSWORD_DEFAULT);
$fechanac = "1990-03-01";
$stmt->execute();
 ?>
