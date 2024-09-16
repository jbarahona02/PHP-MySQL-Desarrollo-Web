<?php
    require_once "libreria_db.php";
    $id=$_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM tra_persona WHERE per_id = :id;');
    $stmt->execute(array(':id' => htmlentities($id)));
    header('Location: index.php');
?>