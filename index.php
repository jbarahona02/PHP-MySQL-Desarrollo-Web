<?php
include("libreria_db.php");
session_start();  // Iniciar la sesión para acceder al mensaje

// Verificar si hay un mensaje de error en la sesión
$message = "";
if (isset($_SESSION['error'])) {
    $message = $_SESSION['error'];
    unset($_SESSION['error']);  // Limpiar el mensaje de la sesión después de mostrarlo
}
?>

<html>
<head>
   <title>Edición de registros en PHP + MySQL</title>
</head>
<body>
   <h1>PHP + MySQL</h1>

   <form action="insertar_db.php" method="post">
      <table>
         <tr>
            <td>Nombre:</td>
            <td><input type="text" name="nombre" size="20" maxlength="30"></td>
         </tr>
         <tr>
            <td>Edad:</td>
            <td><input type="text" name="edad" size="20" maxlength="30"></td>
         </tr>
      </table>
      <input type="submit" name="accion" value="Grabar">
   </form>
   
   <!-- Mostrar mensaje de error si existe -->
   <?php if (!empty($message)) : ?>
      <p style="color:red;"><?php echo $message; ?></p>
   <?php endif; ?>
   
   <hr>
   <!-- Código para mostrar la tabla de registros -->
   <?php
      $stmt = $pdo->query("SELECT per_nombre, per_edad, per_id FROM tra_persona");
   ?>
   <table border=1 cellspacing=1 cellpadding=1>
      <tr>
         <td>&nbsp;<b>Nombre</b>&nbsp;</td> 
         <td>&nbsp;<b>Edad</b>&nbsp;</td>
         <td>&nbsp;<b>Acciones</b>&nbsp;</td>
      </tr>
      <?php
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            printf("<tr><td>&nbsp;%s</td> <td>&nbsp;%s&nbsp;</td>
               <td><a href=\"borrar_db.php?id=%d\">Eliminar</a> | 
                   <a href=\"editar_db.php?id=%d\">Editar</a></td>
            </tr>", $row["per_nombre"], $row["per_edad"], $row["per_id"], $row["per_id"]);
         }
      ?>
   </table>
</body>
</html>
