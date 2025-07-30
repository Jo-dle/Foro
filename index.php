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
        <link rel="stylesheet" href="./estilos/botones.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <!-- estilos personalizados (temporal)-->
         <style>
            /* Estilo top menú */
        #top-menu {
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            }

        .menu-item {
            margin: 0 10px;
            }
            /* estilo sidebar */
        #sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            height: 80vh; 
            position: fixed;
            top: 80px; 
            left: 20px; 
            overflow-y: auto;
        }

        #content {
            margin-left: 290px; 
            padding: 20px;
        }

        .search-box {
            margin-bottom: 20px;
        }
    </style>
    </head>
    <body>
        <!--Top Menú-->
        <div id="top-menu">      
            <div class="menu-item">
                <a class="boton boton-neutro" href="index.php?pregunta=crear">Crear Pregunta</a>
            </div>
            <div class="menu-item">
                <h2>Bienvenido a L.I.T</h2>
            </div>
            <div class="menu-item dropdown" id="perfil">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="perfilMenu" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                </button>
                <!--DropDown Del Perfil-->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilMenu">
                    <li><a class="dropwdown-item" href="./vistas/v.perfil.php">Ver Perfíl</a></li><!--Arreglar vista del link-->
                    <li><a class="dropdown-item" href="index.php?sesion=cerrar">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
        <!--Menú Lateral izquierdo-->
        <div id="sidebar">
            <div class="search-box">
                <input type="text" id="buscarPregunta" class="form-control" placeholder="Buscar preguntas...">
             </div>
            <h5>Discusiones Más Relevantes</h5>
            <ul class="list-group" id="listaPreguntas">
                <!--Lista de discusiones más relevantes con vista en mariadb-->
                <?php 
                $query = "SELECT contenido FROM top_discusiones";
                $stmt = $conexion->prepare($query);
                $stmt->execute();
                
                $result = $stmt -> get_result();
                while ($fila = $result->fetch_assoc()){
                    $titulo = htmlspecialchars($fila['contenido']);
                    echo "<li class='list-group-item'>$titulo</li>";
                }
                ?>
            </ul>
        </div>
        <div id="Contenido">

        </div>

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
 
<!--Scripts-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

    </body>
</html>