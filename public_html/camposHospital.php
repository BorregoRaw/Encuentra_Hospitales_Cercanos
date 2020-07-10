<?php
  session_start();

  require 'database.php';


  ///////sesion iniciada?
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
  //////////////////////////termina sesion iniciada


  ///entra submit
  if (!empty($_POST['nombre']) && !empty($_POST['tipoServicio']) && !empty($_POST['direccion']) && !empty($_POST['cupo']) ) {
    /*
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    */
    $message = ''; 

    ///////////////
    $records = $conn->prepare('SELECT  nombre, cupo FROM infohospitales WHERE clues = :clues');
    $records->bindParam(':clues', $user['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    //$user = null;

    if ($results != null) {
      //$user = $results;

      echo '<script>
      alert("Datos actualizados");
      </script>';
      $sql = "UPDATE infohospitales SET nombre = :nombre, tipoServicio = :tipoServicio, direccion = :direccion , cupo = :cupo WHERE clues = :clues";
    } else {
      $sql = "INSERT INTO infohospitales (clues, nombre, tipoServicio, direccion, cupo) VALUES (:clues, :nombre, :tipoServicio, :direccion, :cupo)";

      echo '<script>
      alert("Datos ingresados");
      </script>';
    }
    ///////////////

    //$sql = "UPDATE infohospitales SET nombre = :nombre, tipoServicio = :tipoServicio, direccion = :direccion , cupo = :cupo WHERE clues = :clues";
    

    //$sql = "INSERT INTO infohospitales (clues, nombre, tipoServicio, direccion, cupo) VALUES (:clues, :nombre, :tipoServicio, :direccion, :cupo)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':clues', $user['email']); //asignacion de parametro
    //$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    //$stmt->bindParam(':password', $password)

    //asignacion d eparametros
    $stmt->bindParam(':nombre', $_POST['nombre']); 
    $stmt->bindParam(':tipoServicio', $_POST['tipoServicio']);
    $stmt->bindParam(':direccion', $_POST['direccion']);
    $stmt->bindParam(':cupo', $_POST['cupo']);

    //echo '<script>
    //alert("algo!");
    //</script>';


    if ($stmt->execute()) {
      //$message = 'Datos recibidos';
      echo '<script>
      alert("Datos recibidos");
      </script>';

    } else {
      //$message = 'Lo sentimos, debe haber habido un problema al ingresar los datos, compruebelo!';
      echo '<script>
      alert("Lo sentimos, debe haber habido un problema al ingresar los datos, compruebelo!");
      </script>';
    }

    

  }

  /////////////////////////// termina submit

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
    <?php endif; ?>
      

      <h1>Llenado de campos</h1>

      <form action="camposHospital.php" method="POST">

      <input name = "nombre" type = "text" placeholder= "Escribe el nombre del hospital" required>
      <!--input name = "tipoServicio" type = "text" placeholder = "Escribe el tipo de servcio especializado " required-->

      <!-- The second value will be selected initially -->
      <select name="tipoServicio">
        <option value="Azul: No Urgente"> Azul: No Urgente</option> 
        <option value="Verde: Situacion Normal" selected>Verde: Situaciones Normales </option>
        <option value="Amarillo: Urgente">Amarillo: Urgente</option>
        <option value="Naranjo: Situacion Muy Urgente">Naranjo: Situacion Muy Urgente</option>
        <option value="Rojo: Situacion Muy Grave">Rojo: Situacion Muy Grave</option>

      </select>


      <input name = "direccion" type = "text" placeholder = "Escribe la direccion del hospital" required>
      <input name = "cupo" type = "text" placeholder = "Anota el cupo total del centro" required>
      <input type = "submit" value = "Ingresa los datos">

    </form>

  </body>
</html>
