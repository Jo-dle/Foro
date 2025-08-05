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
    $stmt = $conexion->prepare("SELECT contenido, likes FROM mensajes WHERE id_pregunta = ? ORDER BY likes DESC");
    $stmt->bind_param("i", $preguntaId);
    $stmt->execute();
    $resultado = $stmt->get_result();

         if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                echo "<div style='margin-bottom:10px; padding:10px; border:1px solid #ccc'>";
                echo "<p>" . htmlspecialchars($fila['contenido']) . "</p>";
                echo "<p><strong>Likes:</strong> " . intval($fila['likes']) . "</p>";
                echo "</div>";
            }
        }   else {
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
