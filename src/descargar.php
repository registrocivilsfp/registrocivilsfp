<?php
// Incluir el archivo de conexión
include "../conexion.php";

// Establecer las cabeceras de respuesta para indicar que se está enviando un archivo PDF
header('Content-Type: application/pdf');

// Verificar si se ha enviado un ID válido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para obtener la ruta del archivo PDF del registro con el ID especificado
    $query = "SELECT pdf FROM digital WHERE coddigital = $id";

    // Ejecutar la consulta
    $result = mysqli_query($conexion, $query);

    if ($result) {
        // Obtener la ruta del archivo PDF del registro
        $data = mysqli_fetch_assoc($result);
        $pdf_path = $data['pdf'];

        // Obtener el nombre del archivo a partir de la ruta
        $file_name = basename($pdf_path);

        // Establecer el encabezado Content-Disposition con el nombre del archivo
        header('Content-Disposition: attachment; filename="' . $file_name . '"');

        // Leer el archivo PDF y enviar su contenido al navegador
        readfile($pdf_path);
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
} else {
    echo "ID no proporcionado";
}

// Cerrar la conexión después de usarla
mysqli_close($conexion);
?>
