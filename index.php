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
    <title>Bienvenido o</title>
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
      <h1>Porfavor Logeate o Registrate: </h1>

      <a href="login.php">Logeate </a> , 
      <a href="signup.php">Registrate como hospital</a> o 
      <a href="solicitarCita.php">Solicita una Cita</a>
      
      <h2> </h2>
    <?php endif; ?>
      
      
      <h2>Para que es esta pagina</h2>

      <div style="color: #000; font-style: italic">

        <p>Esta pagina esta consebida para conocer los hospitales cercanos ademas de el cupo total, de los hospitales, esto con fin de evitar visitar lugares donde se anteinde infectados por COVID 19</p>

        <p>-</p><p>-</p><p>-</p>
        

        <p>Ademas de que cada hospital pude mostrar los servicios que puede ofrecer y para los que esta equipado, esto basado en el sistema de atencion TRIAGE por el Instituto Mexicano del Seguro Social</p>

      </div>

      <img src="img/semaforo.jpg">

      <div style="color: #000; font-style: italic">

        <p>Se puede observar que existen diferentes tipos de atencion, dependiendo de la gravedad y situacion en la que se encuentre el solicitante del servicio, es por ello que cada hospital o centro de atencion medica puede ofrecer distinta atencion.</p>

      </div>      
      <h2><a href="lista.php"> Clic aqui para ver la lista de los hospitales registrados </a></h2>

      <!--  
      <div align='center'> 
        <table class="egt">

        <tr>

          <th scope="row">CLUES</th>

          <th>NOMBRE</th>

          <th>Tipo de servicio</th>

          <th>Direccion</th>

          <th>Cupo</th>

          <th>Como llegar</th>
        </tr>

        <tr>

          <th> --- </th>

          <td>---</td>

          <td>---</td>

          <td>---</td>

        </tr>

        <?php 
           $records = $conn->prepare('SELECT  email FROM users');
           $records->execute();
           $results = $records->fetchAll();
          foreach ($results as $hospital) {
            
            //print_r($hospital['email']);
            echo'<tr> <td>'.$hospital['email'].'</td></tr>';
            //
            $records = $conn->prepare('SELECT  nombre, tipoServicio, direccion, cupo FROM infohospitales WHERE clues = :clues');
            $records->bindParam(':clues', $hospital['email']);
            $records->execute();
            $results = $records->fetch(PDO::FETCH_ASSOC);
        
            //$user = null;
        
            if ($results != null) {
              echo'<tr> 
              <td>'.$hospital['email'].'</td>  
              <td>'.$results['nombre'].' </td> 
              <td>'.$results['tipoServicio'].' </td>
              <td>'.$results['direccion'].' </td>
              <td>'.$results['cupo'].' </td>   

              <td>  <a href="https://www.google.com.mx/maps/place/Hospital+'.$results['nombre'].'+'.$results['direccion'].'"> Como llegar </a> </td>
              </tr>';

            }
            //<a href="logout.php"> Salir </a>

          } 

        ?>

        </table>
        -->
      </div>
  </body>
</html>
