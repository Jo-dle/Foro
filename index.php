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

    </body>
</html>