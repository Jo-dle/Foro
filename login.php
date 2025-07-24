<?php 
include_once "./controladores/c.login.php";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title> Inicio de sesíon| Foro </title>
    </head>
    
    <body class="login-page bg-body-secondary">
        <div class="">
            <div class="">
                <div class="card-header">
                    <a class="">
                        <h1 class="">Hola!</b></h1>
                    </a>
            </div>
            <div class="">
                <p class="login-box-msg">Inicia sesión para vomenzar</p>
                <form method="get">
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="loginEmail" name="email" type="email" class="form-control" value="" placeholder="example@example.com"/>
                            <label for ="loginEmail">Email</label>
                        </div>
                        <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                    </div>
            </div>
        </div>
    </body>

</html>
