<?php
session_start();
require("../conexion.php");

// Verificar si el usuario tiene permiso para eliminar usuarios
$id_user = $_SESSION['idUser'];
$permiso = "usuarios";
$sql_permisos = "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'";
$resultado_permisos = mysqli_query($conexion, $sql_permisos);

// Si no tiene permisos, redirige a la página de permisos
if (!$resultado_permisos || mysqli_num_rows($resultado_permisos) == 0) {
    header("Location: permisos.php");
    exit;
}

// Verificar si se recibió el ID del usuario a eliminar por parámetro GET
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario de la tabla usuario
    $sql_delete = "DELETE FROM usuario WHERE idusuario = $id";
    $query_delete = mysqli_query($conexion, $sql_delete);

    if ($query_delete) {
        echo "Usuario con ID $id eliminado correctamente.<br>";

        // Resetear el conteo de IDs en la tabla usuario
        $sql_reset_ids_1 = "SET @num := 0;";
        $sql_reset_ids_2 = "UPDATE usuario SET idusuario = @num := (@num + 1);";
        $sql_reset_ids_3 = "ALTER TABLE usuario AUTO_INCREMENT = 1;";

        // Ejecutar las consultas una por una
        if (mysqli_query($conexion, $sql_reset_ids_1) &&
            mysqli_query($conexion, $sql_reset_ids_2) &&
            mysqli_query($conexion, $sql_reset_ids_3)) {
            echo "IDs reiniciados correctamente en la tabla usuario.<br>";
        } else {
            echo "Error al reiniciar los IDs en la tabla usuario: " . mysqli_error($conexion) . "<br>";
        }
    } else {
        echo "Error al eliminar el usuario con ID $id: " . mysqli_error($conexion) . "<br>";
    }

    mysqli_close($conexion);
    header("Location: usuarios.php");
    exit;
}
?>
