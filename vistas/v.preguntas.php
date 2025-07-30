<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id'])) {
   header("Location: login.php");
   exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Pregunta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">

    <h2 class="mb-4">Crear nueva pregunta</h2>

    <form method="post" action="../controladores/crear/c.crearpregunta.php">
        <div class="mb-3">
            <label for="contenido" class="form-label">Pregunta</label>
            <textarea class="form-control" id="contenido" name="contenido" rows="5" required></textarea>
        </div>
        <button type="submit" name="publicar" class="btn btn-primary">Publicar</button>
    </form>

</body>
</html>
