<?php

  require 'database.php';

  $message = '';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {

    //va
    $records = $conn->prepare('SELECT  email FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    

    if ($results != null) {
      //$user = $results;

      echo '<script>
      alert("usuario ya existente");
      </script>';
      ///////$sql = "UPDATE infohospitales SET nombre = :nombre, tipoServicio = :tipoServicio, direccion = :direccion , cupo = :cupo WHERE clues = :clues";
    } else {
      $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
      $message = 'Usuario Creado correctamente';
    } else {
      $message = 'Lo sentimos, debe haber habido un problema al crear su cuenta';
    }

    }
    //va
    /*
    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {
      $message = 'Usuario Creado correctamente';
    } else {
      $message = 'Lo sentimos, debe haber habido un problema al crear su cuenta';
    }
    */
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Regístrate</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Regístro Zona Exclusiva para Establecimientos de Salud</h1>
    <span> <a href="login.php">Login</a></span>
    <span>o descubre <a href="http://www.dgis.salud.gob.mx/contenidos/intercambio/clues_gobmx.html">Que es CLUES</a></span>
    <span>y donde <a href="http://salud.hidalgo.gob.mx/?page_id=9">encontrarlo</a></span>

    <form action="signup.php" method="POST">
      <input name="email" type="text" placeholder="Introduce el CLUES de la organizacion">
      <input name="password" type="password" placeholder="Introduce tu contraseña">
      <input name="confirm_password" type="password" placeholder="Confirma tu contraseña">
      <input type="submit" value="Registrate">
    </form>

  </body>
</html>
