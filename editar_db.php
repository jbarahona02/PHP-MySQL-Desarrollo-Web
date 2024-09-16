<?php
include("libreria_db.php");

// Bloque para procesar la actualización cuando se envía el formulario
if (isset($_POST['accion']) && $_POST['accion'] == 'Actualizar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];

    // Verificar si se proporcionaron datos válidos
    if (!empty($nombre) && !empty($edad) && !empty($id)) {
        // Consulta para actualizar el registro
        $stmt = $pdo->prepare("UPDATE tra_persona SET per_nombre = :nom, per_edad = :edad WHERE per_id = :id");

        // Usamos htmlentities para escapar los valores antes de pasarlos
        $stmt->execute(array(
            ':nom' => htmlentities($nombre), // Sanitizar el nombre
            ':edad' => htmlentities($edad),  // Sanitizar la edad
            ':id' => $id                     // El ID no necesita htmlentities porque es un número
        ));

        echo "Registro actualizado con éxito";
    } else {
        echo "Todos los campos son obligatorios";
    }

    // Redirigir de nuevo al index.php para ver los cambios
    header("Location: index.php");
    exit();
}

// Bloque para cargar los datos en el formulario si se accede con un ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para obtener los datos del registro
    $stmt = $pdo->prepare("SELECT per_nombre, per_edad FROM tra_persona WHERE per_id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nombre = $row['per_nombre'];
        $edad = $row['per_edad'];
    } else {
        echo "Registro no encontrado";
        exit;
    }
} else {
    echo "ID no proporcionado";
    exit();
}
?>

<html>
<head>
   <title>Editar registro en PHP + MySQL</title>
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
      <input type="hidden" name="id" value="<?php echo $id; ?>">
      <input type="submit" name="accion" value="Actualizar">
   </form>
</body>
</html>
