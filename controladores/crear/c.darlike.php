<?php
session_start();
include_once("../db_connect.php");

if (!isset($_SESSION['id']) || !isset($_POST['id_mensaje'])) {
    header("Location: ../../index.php");
    exit;
}

$idUsuario = intval($_SESSION['id']);
$idMensaje = intval($_POST['id_mensaje']);


$stmt = $conexion->prepare("SELECT 1 FROM likes WHERE id_usuario = ? AND id_mensaje = ?");
$stmt->bind_param("ii", $idUsuario, $idMensaje);
$stmt->execute();
$yaDioLike = $stmt->get_result()->num_rows > 0;
$stmt->close();

if (!$yaDioLike) {
    $stmt = $conexion->prepare("INSERT INTO likes (id_usuario, id_mensaje) VALUES (?, ?)");
    $stmt->bind_param("ii", $idUsuario, $idMensaje);
    $stmt->execute();
    $stmt->close();

    $conexion->query("UPDATE mensajes SET likes = likes + 1 WHERE id = $idMensaje");
}

header("Location: " . $_SERVER["HTTP_REFERER"]);
exit;
