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
  if (!empty($_POST['curp']) && !empty($_POST['nombreCita']) && !empty($_POST['telefono']) ) {


      $sql = "INSERT INTO citas (curp, nombreCita, telefono, fecha, nombreHospitalCita) VALUES (:curp, :nombreCita, :telefono, :fecha, :nombreHospitalCita)";

      echo '<script>
      alert("Datos ingresados");
      </script>';
  
    ///////////////

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':curp', $_POST['curp']); //asignacion de parametro
 
    $stmt->bindParam(':nombreCita', $_POST['nombreCita']); 
    $stmt->bindParam(':telefono', $_POST['telefono']);
    $stmt->bindParam(':fecha', $_POST['fecha']);
    $stmt->bindParam(':nombreHospitalCita', $_POST['nombreHospitalCita']);


    echo $_POST['nombreHospitalCita'];
    if ($stmt->execute()) {
        //cupo - 1
        $sqlActualizarCupo = "UPDATE infohospitales SET cupo = (cupo - 1) WHERE nombre = :nombreHospitalCita";
        $stmt = $conn->prepare($sqlActualizarCupo);
        $stmt->bindParam(':nombreHospitalCita', $_POST['nombreHospitalCita']);
        if($stmt->execute()){
            echo '<script>
      alert("update");
      </script>';
        }


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
      

      <h1>Solicita una cita</h1>

      <form action="solicitarCita.php" method="POST">

      <input name = "curp" type = "text" placeholder= "Escribe tu CURP" required>
      <!--input name = "tipoServicio" type = "text" placeholder = "Escribe el tipo de servcio especializado " required-->
      <input name = "nombreCita" type = "text" placeholder= "Escribe tu nombre completo" required>
      <input name = "telefono" type = "text" placeholder= "Escribe tu numero de telefono" required>
      <label for="start">Dia de solicitud de cita:</label>

        <input type="date" id="start" name="fecha"
       value="2020-07-14"
       min="2020-07-01" max="2021-12-31">

       <br><br>
      <!-- The second value will be selected initially -->
      <select name="nombreHospitalCita">

      <?php 
      $records = $conn->prepare('SELECT nombre, cupo FROM infohospitales WHERE cupo > 0');
        $records->execute();
        $results = $records->fetchAll();
        foreach ($results as $hospital) {
            echo '<option value = "'.$hospital["nombre"].'"> '.$hospital["nombre"].' con cupo de: '.$hospital["cupo"].'</option>';
        }
        ?>

      </select>
      <br><br><br><br><br><br>
      <input type = "submit" value = "Ingresa los datos">

    </form>

  </body>
</html>
