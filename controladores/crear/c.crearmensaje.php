<?php
include_once("./db_connect.php");

if(isset($_REQUEST["publicar"])){
    try {
        $mensaje = sanitizar($conexion, $_REQUEST["contenido"]);
        $query = "INSERT INTO mensajes (contenido) values (?);";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s",$mensaje);
        
        if($stmt->execute()){
             echo "<script>alert('¡Mensaje publicado correctamente!'); window.location.href='../../index.php';</script>";
        }
    } catch(mysqli_sql_exception $e){
        echo'<div class="alert alert-danger float-right" role="alert">
        <strong>Atencion! no se ha podido crear el mensaje: ' . $e ->getMessage() . '</strong> </div>'; 

    }
}
?>