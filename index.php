<?php
include_once "./db_connect.php";
session_start();
session_regenerate_id(true);

if (!isset($_REQUEST["sesion"])){
    header("Location:login.php");
}
?>