<?php
   require_once "libreria_db.php";
   $nombre = $_GET['nombre'];
   $edad = $_GET['edad'];
   $stmt = $pdo->prepare('INSERT INTO tra_persona (per_nombre, per_edad) VALUES (:nom, :edad);');
   $stmt->execute(array(
      ':nom' => htmlentities($nombre),
      ':edad' => htmlentities($edad)
   ));
   header('Location: index.php');
?>