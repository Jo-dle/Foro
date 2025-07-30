<?php
include_once("/var/www/html/Foro/db_connect.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_REQUEST["publicar"])) {
    try {
        $mensaje = sanitizar($conexion, $_REQUEST["mensaje"]);
        $idPregunta = intval($_REQUEST["pregunta_id"]);

        $query = "INSERT INTO mensajes (id_pregunta, contenido) VALUES (?, ?);";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("is", $idPregunta, $mensaje);

        if ($stmt->execute()) {
            echo "<script>alert('¡Mensaje publicado correctamente!'); window.location.href='../index.php';</script>";
        }
    } catch (mysqli_sql_exception $e) {
        echo '<div class="alert alert-danger float-right" role="alert">
        <strong>Atención:</strong> no se ha podido crear el mensaje: ' . $e->getMessage() . '</div>';
    }
}
?>
