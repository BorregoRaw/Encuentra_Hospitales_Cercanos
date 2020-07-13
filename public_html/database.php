<?php

$server = 'localhost';
$username = 'id14287988_jesus';
$password = 'CO=CyV5W-Kk<=9U-';
$database = 'id14287988_php_login';

try {
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) { 
  die('Conexion fallida: ' . $e->getMessage());
}

?>
  