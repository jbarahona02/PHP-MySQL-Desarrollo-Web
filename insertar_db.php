<?php
include("libreria_db.php");
session_start();  // Iniciar sesión para almacenar el mensaje

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] == 'Grabar') {
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];

    // Verificar si los campos están vacíos
    if (empty($nombre) || empty($edad)) {
        // Guardar el mensaje de error en la sesión
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        
        // Redirigir de nuevo a index.php
        header("Location: index.php");
        exit();
    } else {
        // Si los campos no están vacíos, realizar la inserción en la base de datos
        $stmt = $pdo->prepare("INSERT INTO tra_persona (per_nombre, per_edad) VALUES (:nom, :edad)");
        $stmt->execute([
            ':nom' => htmlentities($nombre),
            ':edad' => htmlentities($edad)
        ]);

        // Redirigir de nuevo al index.php después de insertar el registro
        header("Location: index.php");
        exit();
    }
}
