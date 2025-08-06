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

$stmt = $conexion->prepare("SELECT contenido FROM preguntas WHERE id = ?");
$stmt->bind_param("i", $preguntaId);
$stmt->execute();
$resultado = $stmt->get_result();

$preguntatitulo = "";
if ($fila = $resultado->fetch_assoc()) {
    $preguntatitulo = $fila['contenido'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Responder Pregunta</title>

    <style>
    .titulo-pregunta {
        background-color: #e7e7e7ff;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-weight: bold;
        font-size: 1.2rem;
        color: #333;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    .main-block {
        max-width: 800px;  
        margin: 0 auto;    
        padding: 20px;     
        background-color: #ffffff;  
        border: 1px solid #ddd;     
        border-radius: 10px;        
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); 
    }
    .mensaje-container {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .mensaje-contenido {
        flex: 1;
        margin-right: 15px;
    }

    .likes-box {
        min-width: 80px;
        text-align: center;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }

    .likes-box form {
        margin-top: 10px;
    }

    .emoji-btn {
        background-color: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        transition: transform 0.2s ease, filter 0.2s ease;
    }

    .emoji-btn:hover {
        transform: scale(1.2);
        filter: brightness(1.2);
    }

    .respuestas p {
        margin-left: 20px;
        font-style: italic;
        color: #666;
        margin-bottom: 5px;
    }

    /* Formulario fijo inferior */
    .form-mensaje {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #ffffff;
        border-top: 1px solid #ccc;
        padding: 15px 20px;
        box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        z-index: 1000;
        display: flex;
        justify-content: center;
    }

    .form-mensaje-inner {
        width: 100%;
        max-width: 800px;
        display: flex;
        flex-direction: column;
    }

    .form-mensaje-inner label {
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .form-mensaje-inner textarea {
        width: 100%;
        resize: vertical;
        box-sizing: border-box;
        font-size: 1rem;
        padding: 8px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
    }

    .form-mensaje-inner button[name="publicar"] {
        align-self: flex-end;
        padding: 6px 12px;
        background-color: #28a745;
        border: none;
        color: white;
        font-size: 0.9rem;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-mensaje-inner button[name="publicar"]:hover {
        background-color: #1e7e34;
    }

    /* Para que el contenido no quede oculto debajo del formulario fijo */
    body {
        padding-bottom: 150px;
    }
    </style>
</head>
<body>

<div class="titulo-pregunta">
    <h1><?php echo htmlspecialchars($preguntatitulo); ?></h1>
</div>

<div class="main-block">
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
?>
    <div class="mensaje-container">
        <div class="mensaje-contenido">
            <p><?php echo htmlspecialchars($fila['contenido']); ?></p>
            <div class="respuestas">
                <?php
                $stmtResp = $conexion->prepare("SELECT contenido FROM respuestas WHERE id_mensaje = ? ORDER BY id DESC LIMIT 10");
                $stmtResp->bind_param("i", $mensajeId);
                $stmtResp->execute();
                $respuesta = $stmtResp->get_result();
                if ($respuesta->num_rows > 0) {
                    while ($msg = $respuesta->fetch_assoc()) {
                        echo "<p>- " . htmlspecialchars($msg['contenido']) . "</p>";
                    }
                } else {
                    echo "<p style='margin-left:20px; color:gray;'>No hay respuestas aún.</p>";
                }
                $stmtResp->close();
                ?>
            </div>
            <a href="../vistas/v.respuesta.php?mensaje_id=<?php echo intval($mensajeId); ?>" class="btn btn-sm btn-primary">Ver respuestas</a>
        </div>
        <div class="likes-box">
            <p><strong><?php echo intval($fila['likes']); ?> Likes </strong></p>

            <?php if (!$yaDioLike): ?>
                <form method="post" action="../controladores/crear/c.darlike.php">
                    <input type="hidden" name="id_mensaje" value="<?php echo $mensajeId; ?>">
                    <button type="submit" name="dar_like" class="emoji-btn">👍</button>
                </form>
            <?php else: ?>
                <form method="post" action="../controladores/crear/c.quitarlike.php">
                    <input type="hidden" name="id_mensaje" value="<?php echo $mensajeId; ?>">
                    <input type="hidden" name="pregunta_id" value="<?php echo $preguntaId; ?>">
                    <button type="submit" name="quitar_like" class="emoji-btn">👎</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php
        }
    } else {
        echo "<p>No hay mensajes aún para esta pregunta.</p>";
    }
    $stmt->close();
} catch (mysqli_sql_exception $e) {
    echo "<p>Error al recuperar mensajes: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
</div>

<!-- 🔁 FORMULARIO FIJO DE MENSAJE AL FINAL -->
<form method="post" action="../controladores/crear/c.crearmensaje.php" class="form-mensaje">
    <div class="form-mensaje-inner">
        <input type="hidden" name="id_pregunta" value="<?php echo $preguntaId; ?>">
        <label for="mensaje"><?php echo htmlspecialchars($_SESSION['nombre']); ?> dice:</label>
        <textarea name="mensaje" id="mensaje" rows="3" required></textarea>
        <button type="submit" name="publicar">Publicar</button>
    </div>
</form>

</body>
</html>
