<?php

include_once("../../db_connect.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_REQUEST["publicar"])){
    try {
        $pregunta = sanitizar($conexion, $_REQUEST["contenido"]);
        $query = "INSERT INTO preguntas (contenido) values (?);";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("s",$pregunta);
        
        if($stmt->execute()){
             echo "<script>alert('¡Pregunta publicada correctamente!'); window.location.href='../../index.php';</script>";
        }
    } catch(mysqli_sql_exception $e){
        echo'<div class="alert alert-danger float-right" role="alert">
        <strong>Atencion! no se ha podido crear la pregunta: ' . $e ->getMessage() . '</strong> </div>'; 

    }
}
?>