<?php
include_once "./db_connect.php";
session_start();
session_regenerate_id(true); // Protege contra fijación de sesión

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
   header("Location: login.php");
   exit;
}
/* prueba para ver si funka

if (isset($_SESSION['nombre'])) {
    echo "Bienvenido, " . htmlspecialchars($_SESSION['nombre']);
}
    */
?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <a href="index.php?sesion=cerrar">Cerrar sesión</a>
<?php
// Cerrar sesión si se solicita
if (isset($_REQUEST["sesion"]) && $_REQUEST["sesion"] === "cerrar") {
    session_unset();
    session_destroy(); 
    header("Location: login.php");
    exit;
    
}
?>


    <?php
    if(isset($_REQUEST["pregunta"]) && $_REQUEST["pregunta"] === "crear"){
        header("Location: ./vistas/v.preguntas.php");
    }
    ?>
    <a href="index.php?pregunta=crear"> Crear Pregunta</a>

    <h2>Preguntas Publicadas</h2>

<?php


try {
    $sql = "SELECT id, contenido FROM preguntas ORDER BY id ASC";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";
            echo "<p><strong>Pregunta #" . $fila['id'] . "</strong></p>";
            echo "<p>" . htmlspecialchars($fila['contenido']) . "</p>";
            
            // Botón de enviar mensaje (redirige con el ID de la pregunta)
            echo "<a href='./vistas/v.mensaje.php?pregunta_id=" . $fila['id'] . "' class='btn btn-sm btn-primary'>Enviar mensaje</a>";
            
            echo "</div>";
        }
    } else {
        echo "<p>No hay preguntas publicadas aún.</p>";
    }
} catch (mysqli_sql_exception $e) {
    echo "<p>Error al recuperar preguntas: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>





    </body>
</html>