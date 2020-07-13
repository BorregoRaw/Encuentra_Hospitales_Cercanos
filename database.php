<?php
$server = 'localhost';
$username = 'id14334762_jesus';
$password = 'u|k8{dyL*2Wwco2G';
$database = 'id14334762_php_login';
try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) { 
  die('Conexion fallida: ' . $e->getMessage());
}
?>