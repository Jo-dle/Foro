<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("../controladores/crear/c.crearmensaje.php");

if (!isset($_SESSION['id'])) {
   header("Location: login.php");
   exit;
}

$preguntaId = isset($_GET['pregunta_id']) ? intval($_GET['pregunta_id']) : 0;
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
     $stmt = $conexion->prepare("SELECT m.id, m.contenido, COUNT(l.id) AS likes FROM mensajes m LEFT JOIN likes l ON m.id = l.id_mensaje WHERE m.id_pregunta = ? GROUP BY m.id ORDER BY COUNT(l.id) DESC");
    $stmt->bind_param("i", $preguntaId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
    $mensajeId = $fila['id'];

    
    $likeCheck = $conexion->prepare("SELECT 1 FROM likes WHERE id_usuario = ? AND id_mensaje = ?");
    $likeCheck->bind_param("ii", $_SESSION['id'], $mensajeId);
    $likeCheck->execute();
    $yaDioLike = $likeCheck->get_result()->num_rows > 0;
    $likeCheck->close();

    echo "<div style='margin-bottom:10px; padding:10px; border:1px solid #ccc'>";
    echo "<p>" . htmlspecialchars($fila['contenido']) . "</p>";
    echo "<p><strong>Likes:</strong> " . intval($fila['likes']) . "</p>";

   
    if (!$yaDioLike) {
        echo "<form method='post' action='../controladores/crear/c.darlike.php' style='display:inline'>";
        echo "<input type='hidden' name='id_mensaje' value='" . $mensajeId . "'>";
        echo "<button type='submit'> Me gusta</button>";
        echo "</form>";
    } else {
          echo "<form method='post' action='../controladores/crear/c.quitarlike.php' style='display:inline'>";
          echo "<input type='hidden' name='id_mensaje' value='" . $mensajeId . "'>";
          echo "<input type='hidden' name='pregunta_id' value='" . $preguntaId . "'>";
          echo "<button type='submit'>Quitar me gusta</button>";
          echo "</form>";
    }

    echo " <a href='../vistas/v.respuesta.php?mensaje_id=" . intval($mensajeId) . "' class='btn btn-sm btn-primary'>Ver respuestas</a>";
    echo "</div>";
}

    } else {
        echo "<p>No hay mensajes aún para esta pregunta.</p>";
    }

    $stmt->close();
} catch (mysqli_sql_exception $e) {
    echo "<p>Error al recuperar mensajes: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<form method="post">
    <input type="hidden" name="id_pregunta" value="<?php echo $preguntaId; ?>">
    
    <label for="mensaje">Tu mensaje:</label><br>
    <textarea name="mensaje" id="mensaje" rows="4" required></textarea><br>
    
    <button type="submit" name="publicar">Publicar</button>
</form>
</body>
</html>
