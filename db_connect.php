<?php
 $db_host = "192.168.1.154";
 $db_user = "adminforo";
 $db_pass = "1234";
 $db_database = "foro";
 $db_port = "3306";

 function sanitizar($conexion, $datos){
return mysqli_real_escape_string($conexion,htmlspecialchars(trim(strip_tags($datos ?? ""))));
}

function mostrarAlertaMensaje()
{
    if (!empty($_GET['mensaje'])) {
        $mensaje = htmlspecialchars($_GET['mensaje'], ENT_QUOTES, 'UTF-8');
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> ' . $mensaje . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
        ';
    }
}
?>