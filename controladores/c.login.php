<?php
include_once "./dbconnect.php";
session_start();

if($_SERVER['REQUEST_METOHD'] === 'GET' && isset($_GET ["entrar"])){
    $email = sanitizar($conexion, $_REQUEST['correo']);
    $pass = hash("sha256", sanitizar($conexion, $_REQUEST['clave']));

    try{
        $query = "SELECT * FROM usuarios WHERE correo='$email' and clave='$pass'";
        $resultset = mysqli_query($conexion, $query);
        $row = $resultset->fetch_assoc();
        if($row){
            $_SESSION["id"] = $row["id"];
            $_SESSION["nombre"] = $row["nombre"];
            $_SESSION["correo"] = $row["correo"];
            header("location: index.php");
        } else {
            $errorlogin = true;
            echo 'Usuario no registrado';
        }
    } catch(mysqli_sql_exception $e){
        echo '<div class="alert alert-danger">Error ' . htmlspecialchars($e->getMessage()) . '<div>';
    }
}