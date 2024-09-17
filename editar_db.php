<?php
include("libreria_db.php");

$message = "";  // Variable para almacenar mensajes

// Bloque para procesar la actualización cuando se envía el formulario
if (isset($_POST['accion']) && $_POST['accion'] == 'Actualizar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];

    // Verificar si el ID no está vacío
    if (!empty($id)) {
        $query = "UPDATE tra_persona SET per_nombre = :nom, per_edad = :edad WHERE per_id = :id";
        $stmt = $pdo->prepare($query);

        // Preparar el array de parámetros para ejecutar la consulta
        $params = [':id' => $id];
        if (!empty($nombre) && !empty($edad)) {
            $params[':nom'] = htmlentities($nombre);
            $params[':edad'] = htmlentities($edad);
                // Ejecutar la consulta de actualización
            $stmt->execute($params);
            // Redirigir al index después de la actualización exitosa
            header("Location: index.php");
            exit();
        } else {
            $message = "Debes ingresar el nombre y la edad.";
        }
    } else {
        $message = "ID no proporcionado.";
    }
}

// Bloque para recuperar el registro a editar y rellenar el formulario
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener el registro
    $stmt = $pdo->prepare("SELECT per_nombre, per_edad FROM tra_persona WHERE per_id = :id");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nombre = $row['per_nombre'];
        $edad = $row['per_edad'];
    } else {
        $message = "Registro no encontrado.";
    }
}
?>

<html>
<head>
   <title>Editar registro en PHP + MySQL</title>
   
   <style>
      body {
         font-family: Arial;
      }
   </style>
</head>
<body>
   <h1>Editar Registro</h1>
   
  
   <form action="editar_db.php" method="post">
      <table>
         <tr>
            <td>Nombre:</td>
            <td><input type="text" name="nombre" size="20" maxlength="30" value="<?php echo htmlentities($nombre); ?>"></td>
         </tr>
         <tr>
            <td>Edad:</td>
            <td><input type="text" name="edad" size="20" maxlength="30" value="<?php echo htmlentities($edad); ?>"></td>
         </tr>
      </table>
      <input type="hidden" name="id" value="<?php echo htmlentities($id); ?>">

       <!-- Mostrar mensaje debajo del formulario si existe -->
        <?php if (!empty($message)) : ?>
            <p style="color:red; margin-top: 5px"><?php echo $message; ?></p>
        <?php endif; ?>
      <input type="submit" name="accion" value="Actualizar" style="margin-top: 10px">
   </form>
   <!-- Botón de regresar -->
   <form action="index.php">
       <button type="submit">Regresar</button>
   </form>
</body>
</html>
