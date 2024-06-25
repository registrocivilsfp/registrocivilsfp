<?php
session_start();
require("../conexion.php");

// Verificar si el usuario tiene permiso para eliminar todos los registros
$id_user = $_SESSION['idUser'];
$permiso = "Nacimiento";
$sql_permisos = "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'";
$resultado_permisos = mysqli_query($conexion, $sql_permisos);

if (!$resultado_permisos || mysqli_num_rows($resultado_permisos) == 0) {
    header('Location: permisos.php');
    exit;
}

// Eliminar todos los registros de la tabla nacimiento
$sql_delete_all = "DELETE FROM nacimiento";
$query_delete_all = mysqli_query($conexion, $sql_delete_all);

if ($query_delete_all) {
    echo "Todos los registros de la tabla nacimiento han sido eliminados correctamente.<br>";

    // Resetear el conteo de IDs en la tabla nacimiento
    $sql_reset_ids_1 = "SET @num := 0;";
    $sql_reset_ids_2 = "UPDATE nacimiento SET codnacimiento = @num := (@num + 1);";
    $sql_reset_ids_3 = "ALTER TABLE nacimiento AUTO_INCREMENT = 1;";

    // Ejecutar las consultas una por una
    if (mysqli_query($conexion, $sql_reset_ids_1) &&
        mysqli_query($conexion, $sql_reset_ids_2) &&
        mysqli_query($conexion, $sql_reset_ids_3)) {
        echo "IDs reiniciados correctamente en la tabla nacimiento.<br>";
    } else {
        echo "Error al reiniciar los IDs en la tabla nacimiento: " . mysqli_error($conexion) . "<br>";
    }
} else {
    echo "Error al intentar eliminar todos los registros de la tabla nacimiento.<br>";
}

mysqli_close($conexion);
header('Location: Nacimiento.php');
exit;
?>
