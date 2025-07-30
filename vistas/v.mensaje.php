<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("../controladores/crear/c.crearmensaje.php");

if (!isset($_SESSION['id'])) {
   header("Location: login.php");
   exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head></head>
<body>
<form method="post" >
    <input type="hidden" name="pregunta_id" value="<?php echo $preguntaId; ?>">
    <label for="mensaje">Tu mensaje:</label>
    <textarea name="mensaje" id="mensaje" rows="4" required></textarea><br>
    <button type="submit" name="publicar">Publicar</button>
</form>
</body>
</html>
