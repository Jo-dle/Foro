<?php
include_once "../db_connect.php"; // Ruta corregida

if (isset($_GET['busqueda']) && !empty(trim($_GET['busqueda']))) {
    $busqueda = $conexion->real_escape_string(trim($_GET['busqueda']));
    $query = "SELECT id, contenido FROM preguntas WHERE contenido LIKE ? LIMIT 5";
    $stmt = $conexion->prepare($query);
    $like = "%$busqueda%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($fila = $result->fetch_assoc()) {
            $id = (int)$fila['id'];
            $contenido = htmlspecialchars($fila['contenido']);
            // Mostrar solo una parte del contenido (ej: primeros 80 caracteres)
            $resumen = mb_substr($contenido, 0, 80);
            echo "<a href='./vistas/v.pregunta.php?id=$id' class='list-group-item list-group-item-action'>$resumen...</a>";
        }
    } else {
        echo "<div class='list-group-item'>No se encontraron discusiones.</div>";
    }
}
?>
