<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("../controladores/crear/c.crearrespuesta.php");

if (!isset($_SESSION['id'])) {
   header("Location: login.php");
   exit;
}

$mensajeId = isset($_GET['mensaje_id']) ? intval($_GET['mensaje_id']) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responder Pregunta</title>
</head>
<body>
 <?php
    try {
     $stmt = $conexion->prepare("SELECT id, contenido FROM respuestas WHERE id_mensaje = ? ORDER BY id DESC");
    $stmt->bind_param("i", $mensajeId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<div style='margin-bottom:10px; padding:10px; border:1px solid #ccc'>";
            echo "<p>" . htmlspecialchars($fila['contenido']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay respuestas aún para este mensaje.</p>";
    }

    $stmt->close();
} catch (mysqli_sql_exception $e) {
    echo "<p>Error al recuperar respuestas: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<form method="get">
    <input type="hidden" name="id_mensaje" value="<?php echo $mensajeId; ?>">
    
    <label for="respuesta">Tu respuesta:</label><br>
    <textarea name="respuesta" id="respuesta" rows="4" required></textarea><br>
    
    <button type="submit" name="publicar">Publicar</button>
</form>
</body>
</html>