<?php
session_start();
require("../conexion.php");

$id_user = $_SESSION['idUser'];
$permiso = "digitales";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
    exit;
}

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eliminar el registro específico de la tabla digital
    $query_delete = mysqli_query($conexion, "DELETE FROM digital WHERE coddigital = $id");
    
    if ($query_delete) {
        echo "Registro con ID $id eliminado correctamente.<br>";

        // Resetear el conteo de IDs en la tabla digital
        $sql_reset_ids_1 = "SET @num := 0;";
        $sql_reset_ids_2 = "UPDATE digital SET coddigital = @num := (@num + 1);";
        $sql_reset_ids_3 = "ALTER TABLE digital AUTO_INCREMENT = 1;";

        // Ejecutar las consultas una por una
        if (mysqli_query($conexion, $sql_reset_ids_1) &&
            mysqli_query($conexion, $sql_reset_ids_2) &&
            mysqli_query($conexion, $sql_reset_ids_3)) {
            echo "IDs reiniciados correctamente en la tabla digital.<br>";
        } else {
            echo "Error al reiniciar los IDs en la tabla digital: " . mysqli_error($conexion) . "<br>";
        }
    } else {
        echo "Error al intentar eliminar el registro con ID $id.<br>";
    }

    mysqli_close($conexion);
    header("Location: digitales.php");
    exit;
}
?>
