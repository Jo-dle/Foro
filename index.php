<?php
include_once "./db_connect.php";
session_start();
session_regenerate_id(true); // Protege contra fijación de sesión

// Cerrar sesión si se solicita
if (isset($_REQUEST["sesion"]) && $_REQUEST["sesion"] === "cerrar") {
    session_unset();
    session_destroy(); 
    header("Location: login.php");
    exit;
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Redireccionamiento a preguntas
if (isset($_REQUEST["pregunta"]) && $_REQUEST["pregunta"] === "crear") {
    header("Location: ./vistas/v.preguntas.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
    <head> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <!--botones personalizados-->
        <link rel="stylesheet" href="./estilos/botones.css"/>
        <!-- estilos personalizados (temporal)-->
         <style>

       /* --- Top menú --- */
#top-menu {
    background-color: #f8f9fad2;
    padding: 10px 20px;
    border-bottom: 1px solid #000000ff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1050;
}

.menu-item-pregunta {
    margin-left: 10px;
}

.menu-item-perfil {
    margin-right: 20px;
}


/* --- Sidebar (izquierdo y derecho) --- */
#sidebar-iz,
#sidebar-der {
    width: 250px;
    background-color: #ffffff;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    height: 80vh; 
    position: fixed;
    top: 80px;
    overflow-y: auto;
    z-index: 1000;
}

/* Sidebar izquierdo a la izquierda */
#sidebar-iz {
    left: 20px; 
}

/* Sidebar derecho a la derecha */
#sidebar-der {
    right: 20px;
}

/* --- Contenido principal --- */

/* Bloque central */
#main-block {
    margin-left: 280px;
    margin-top: 15px;
    margin-right: 280px;
    padding: 20px;
    height: 610px;
    background-color: #f0f2f5;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    overflow-y: auto;  
}
 /* mensajes de preguntas */
.mensajes {
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #ffffff;
    padding: 10px 15px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    word-break: break-word;
    max-width: auto;
    box-sizing: border-box;
}

/*  Buscador */
.search-box-wrapper {
    position: relative;
}

#resultadosBusqueda {
    position: absolute;
    top: 100%; 
    left: 0;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    background-color: #fff;
    border: 1px solid #ccc;
    border-top: none;
    z-index: 1050;
    display: none; 
}

/* --- Botones y bloques de interacción --- */
#crear-pregunta {
    text-align: center;
    margin-bottom: 10px;
}

#boton-pregunta {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

#ultimas-preguntas {
    margin-top: 30px;
}


#boton-enviar-m {
    margin-bottom: 30px;
}

/* --- Responsividad --- */
@media (max-width: 992px) {
    #sidebar-iz, #sidebar-der {
        display: none;
    }

}


</style>
    </head>
    <body>
        <!--Top Menú-->
        <div id="top-menu">  
            <!--boton crear pregunta-->    
            <div class="menu-item-pregunta">
                <a class="boton boton-neutro" href="index.php?pregunta=crear">Crear Pregunta</a>
            </div>
            <!-- Mensaje bienvenida-->
            <div class="menu-item-bienvenida">
                <h2>Bienvenido a L.I.T</h2>
            </div>
             <!-- DropDown del Perfil --> <!--Arreglar-->
           <div id="perfil">
                <a class="boton boton-info" href="./vistas/v.perfil.php">Perfil</a>
                <a class="boton boton-cerrar" href="index.php?sesion=cerrar">Cerrar sesión</a>
        </div>

           
        </div>
        <!--Menú Lateral izquierdo-->
        <div id="sidebar-iz">
           <div class="search-box-wrapper">
                <input type="text" id="buscarPregunta" class="form-control" placeholder="Buscar Discusiones...">
                <div id="resultadosBusqueda" class="list-group"></div>
            </div>
                <br><br>
        
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
        <!--Menú lateral derecha-->
        <div id="sidebar-der">
             <h2>(Placeholder)</h2>   
        </div>
        <!--Bloque Principal de contenido-->
        <div id="main-block">
            <div id="top-boton">
                <div id="crear-pregunta">
                    <h3> ¿Tienes algo en mente?</h3>
                    
                </div>
                <div id="boton-pregunta">
                    <a class="boton boton-neutro" href="index.php?pregunta=crear">Compartelo</a>  
                </div>
            </div>
            <hr></hr>
            <div id="ultimas-preguntas">
                <div id="titulo">
                    
                    
                </div>
                <?php
                   try {
                        $sql = "SELECT id, contenido FROM preguntas ORDER BY id ASC";
                        $resultado = $conexion->query($sql);

                        if ($resultado->num_rows > 0) {
                            while ($fila = $resultado->fetch_assoc()) {
                                $preguntaId = $fila['id'];
                                echo "<p><strong>Pregunta #" . $fila['id'] . "</strong></p>";
                                echo "<p>" . htmlspecialchars($fila['contenido']) . "</p>";
                ?>

               
                                <?php
                                $stmt = $conexion->prepare("SELECT contenido, likes FROM mensajes WHERE id_pregunta = ? ORDER BY likes DESC LIMIT 1");
                                $stmt->bind_param("i", $preguntaId);
                                $stmt->execute();
                                $mensajes = $stmt->get_result();

                                echo "<div class='mensajes'>";
                                    if ($mensajes->num_rows > 0) {
                                        while ($msg = $mensajes->fetch_assoc()) {
                                            echo "<p>- " . htmlspecialchars($msg['contenido']) . "</p>";
                                        }
                                    } else {
                                        echo "<p style='margin-left:20px; color:gray;'>No hay mensajes aún.</p>";
                                    }
                                    echo "</div>";
                                 
                                ?>
            
                <div id="boton-enviar-m">
                    <?php
                    // Botón de enviar mensaje (redirige con el ID de la pregunta)
                    echo "<a href='./vistas/v.mensaje.php?pregunta_id=" . $fila['id'] . "' class='btn btn-sm btn-primary'>Enviar mensaje</a>";
                    ?>
                </div>
                    <?php        
                                }    
                            } else {
                                echo "<p>No hay preguntas publicadas aún.</p>";
                            } 
                      }
                    catch (mysqli_sql_exception $e) {
                        echo "<p>Error al recuperar preguntas: " . htmlspecialchars($e->getMessage()) . "</p>";
                      }
                    ?>
            </div>
        </div>
    
    

        <?php
        //redireccionamiento a preguntas
        if(isset($_REQUEST["pregunta"]) && $_REQUEST["pregunta"] === "crear"){
            header("Location: ./vistas/v.preguntas.php");
            }
        ?>
        
        <!--Scripts-->

            <!--buscador de preguntas-->
        <script>
        const inputBusqueda = document.getElementById('buscarPregunta');
        const resultadosDiv = document.getElementById('resultadosBusqueda');

        inputBusqueda.addEventListener('input', function () {
            const query = this.value.trim();

            if (query.length === 0) {
                resultadosDiv.innerHTML = '';
                resultadosDiv.style.display = 'none';
                return;
            }

            const xhr = new XMLHttpRequest();
        xhr.open('GET', './controladores/buscador.php?busqueda=' + encodeURIComponent(query), true);
            xhr.onload = function () {
                if (this.status === 200) {
                    resultadosDiv.innerHTML = this.responseText;
                    resultadosDiv.style.display = 'block';
                }
            };
            xhr.send();
        });

        // Cerrar el popup si haces clic fuera
        document.addEventListener('click', function (e) {
            if (!inputBusqueda.contains(e.target) && !resultadosDiv.contains(e.target)) {
                resultadosDiv.style.display = 'none';
            }
        });
        </script>

       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-o+RDsa0u4zyB1N6xGyAIIDZgRXjB9Fa4K/Rp0fEjrYwoTHD+IYZv0P8Tu3XjDCH7" crossorigin="anonymous"></script>
      
    </body>
</html>