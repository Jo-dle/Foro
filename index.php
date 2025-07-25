<?php
include_once "./db_connect.php";
session_start();
session_regenerate_id(true);

if (!isset($_REQUEST["sesion"])){
    header("Location:login.php");
}

if (isset($_REQUEST["sesion"]) && $_REQUEST ["sesion"] === "cerrar") {
  session_unset();
  session_destroy(); 
  header("Location: login.php");
  exit;
  }
?>

<a href="index.php?sesion=cerrar"  class="nav-link active btn btn-outline-danger"><i class="bi bi-door-open"></i>Cerrar Sesion</a>