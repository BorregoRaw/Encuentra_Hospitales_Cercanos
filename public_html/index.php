<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Bienvenido</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css"> 
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($user)): ?>
      <br> Bienvenido. <?= $user['email']; ?>
      <br>Has iniciado sesión correctamente
      <a href="logout.php">
        Salir
      </a>
    <?php else: ?>
      <h1>Porfavor Logeate o Registrate</h1>

      <a href="login.php">Logeate </a> o
      <a href="signup.php">Registrate</a>
      
      
      <h2> </h2>
    <?php endif; ?>
      
      
      <h2>Para que es esta pagina</h2>

      <div style="color: #000; font-style: italic">

        <p>Esta pagina esta consebida para conocer los hospitales cercanos ademas de el cupo total, de los hospitales, esto con fin de evitar visitar lugares donde se anteinde infectados por COVID 19</p>

        <p>Ademas de que cada hospital pude mostrar los servicios que puede ofrecer y para los que esta equipado, esto basado en el sistema de atencion TRIAGE por el Instituto Mexicano del Seguro Social</p>

      </div>

      <img src="img/semaforo.jpg">

      <div style="color: #000; font-style: italic">

        <p>Se puede observar que existen diferentes tipos de atencion, dependiendo de la gravedad y situacion en la que se encuentre el solicitante del servicio, es por ello que cada hospital o centro de atencion medica puede ofrecer distinta atencion.</p>

        

      </div>      


  </body>
</html>
