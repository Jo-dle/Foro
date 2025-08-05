<?php

include_once("../db_connect.php");

if(isset($_GET["publicar"])){
    try {
        $respuesta = sanitizar($conexion, $_REQUEST["respuesta"]);
        $id_mensaje = isset($_GET["id_mensaje"]) ? intval($_GET["id_mensaje"]) : 0;
         if (empty($respuesta) || $id_mensaje <= 0) {
            throw new Exception("Mensaje no válido");
        }
        $query = "INSERT INTO respuestas (contenido, id_mensaje) values (?,?);";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("si",$respuesta, $id_mensaje);
        if($stmt->execute()){
             echo "<script>alert('¡Mensaje publicado correctamente!'); window.location.href='../index.php';</script>";
        }
    } catch(mysqli_sql_exception $e){
        echo'<div class="alert alert-danger float-right" role="alert">
        <strong>Atencion! no se ha podido crear el mensaje: ' . $e ->getMessage() . '</strong> </div>'; 

    }
}


?>