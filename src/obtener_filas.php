<?php
// Incluir archivo de conexión a la base de datos
include "../conexion.php";

// Obtener el número de filas seleccionado por el usuario
$num_filas = $_POST['num_filas'];

// Construir la consulta SQL para obtener las filas limitadas por el número seleccionado
$query = "SELECT * FROM reportes LIMIT $num_filas";

// Ejecutar la consulta
$result = mysqli_query($conexion, $query);

// Verificar si hay resultados
if (mysqli_num_rows($result) > 0) {
    // Construir el HTML de las filas
    while ($data = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $data['id'] . "</td>";
        echo "<td>" . $data['nombre_reporte'] . "</td>";
        echo "<td>" . $data['tipo_acta'] . "</td>";
        echo "<td>" . $data['fecha_reporte'] . "</td>";
        echo "<td>";
        echo "<a href='" . $data['archivo_pdf'] . "' target='_blank' class='btn btn-primary'><i class='fas fa-file-pdf'></i> Ver PDF</a>";
        echo "<form action='eliminar_reportes.php?id=" . $data['id'] . "' method='post' class='confirmar d-inline'>";
        echo "<button class='btn btn-danger' type='submit'><i class='fas fa-trash-alt'></i></button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    // Si no hay resultados, mostrar un mensaje de error o no hay filas disponibles
    echo "<tr><td colspan='5'>No hay filas disponibles</td></tr>";
}
?>
