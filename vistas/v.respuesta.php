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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f7f7f7;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .respuesta {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .sin-respuestas {
            color: #666;
            font-style: italic;
            margin-bottom: 20px;
        }

        form {
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            max-width: 600px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        textarea {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        button {
            margin-top: 12px;
            padding: 10px 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h1>Respuestas al mensaje</h1>

<?php
try {
    $stmt = $conexion->prepare("SELECT id, contenido FROM respuestas WHERE id_mensaje = ? ORDER BY id DESC");
    $stmt->bind_param("i", $mensajeId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<div class='respuesta'>";
            echo "<p>" . htmlspecialchars($fila['contenido']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p class='sin-respuestas'>No hay respuestas aún para este mensaje.</p>";
    }

    $stmt->close();
} catch (mysqli_sql_exception $e) {
    echo "<p class='error'>Error al recuperar respuestas: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<form method="get">
    <input type="hidden" name="id_mensaje" value="<?php echo $mensajeId; ?>">
    
    <label for="respuesta">Tu respuesta:</label>
    <textarea name="respuesta" id="respuesta" rows="4" required></textarea>
    
    <button type="submit" name="publicar">Publicar</button>
</form>
</body>
</html>