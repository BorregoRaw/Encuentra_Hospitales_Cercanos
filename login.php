<?php

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];

      header("Location: camposHospital.php");


     // echo '<script> alert("ingreso"); </script>';

    } else {
      $message = 'Sorry, those credentials do not match';

      echo '<script> alert("NONO"); </script>';
    }
  }

  

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>Logeate </h1>
    <span>o <a href="signup.php">Regístrate</a></span>

    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Introduce CLUES del establecimeinto" required> 
      <input name="password" type="password" placeholder="Introduce tu contraseña" required>
      <input type="submit" value="Ingresa">
    </form>
  </body>
</html>
 