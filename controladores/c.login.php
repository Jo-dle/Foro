<?php
include_once "./db_connect.php";
session_start();

// Leer cookies si existen
$correoGuardado = $_COOKIE['correo'] ?? '';
$claveGuardada = $_COOKIE['clave'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entrar'])) {
    $id = sanitizar($conexion, $_POST['id']);
    $correo = sanitizar($conexion, $_POST['correo']);
    $clave = $_POST['clave'];
    $recordar = isset($_POST['recordar']);

    try {
        // Buscar usuario en base de datos
        $stmt = $conexion->prepare("SELECT id, nombre, correo, clave FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            $claveHash = $fila['clave'];

            // Verificar contraseña
            if (password_verify($clave, $claveHash)) {
                // Guardar datos en sesión
                $_SESSION['id'] = $fila['id'];
                $_SESSION['nombre'] = $fila['nombre'];
                $_SESSION['correo'] = $fila['correo'];

                // Guardar cookies si se marcó "Recuérdame"
                if ($recordar) {
                    setcookie('correo', $correo, time() + (7 * 24 * 60 * 60), "/");
                    setcookie('clave', $clave, time() + (7 * 24 * 60 * 60), "/");
                } else {
                    setcookie('correo', '', time() - 3600, "/");
                    setcookie('clave', '', time() - 3600, "/");
                }

                header("Location: index.php");
                exit();
            } else {
                $mensajeError = "Contraseña incorrecta.";
            }
        } else {
            $mensajeError = "Usuario no encontrado.";
        }

    } catch (mysqli_sql_exception $e) {
        echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>
