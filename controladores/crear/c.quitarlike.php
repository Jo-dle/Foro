<?php
session_start();
include_once("../../db_connect.php");

if (!isset($_SESSION['id']) || !isset($_POST['id_mensaje'])) {
    header("Location: ../../vistas/login.php");
    exit;
}

$id_usuario = $_SESSION['id'];
$id_mensaje = intval($_POST['id_mensaje']);
$preguntaId = intval($_POST['pregunta_id']); 

try {
    $stmt = $conexion->prepare("DELETE FROM likes WHERE id_usuario = ? AND id_mensaje = ?");
    $stmt->bind_param("ii", $id_usuario, $id_mensaje);
    $stmt->execute();
    $stmt->close();

    header("Location: ../../vistas/v.mensaje.php?pregunta_id=" . $preguntaId);

    exit;
} catch (mysqli_sql_exception $e) {
    echo "Error al quitar el like: " . $e->getMessage();
}
