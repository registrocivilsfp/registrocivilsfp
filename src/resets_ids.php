<?php
// Importar la conexión desde el archivo de conexión
require("../conexion.php");

function borrarRegistroYResetearID($tabla, $id_nombre, $id_a_borrar) {
    global $conexion; // Acceder a la conexión global definida en conexion.php

    // Consulta para borrar el registro
    $sql_borrar = "DELETE FROM $tabla WHERE $id_nombre = ?";
    $stmt = $conexion->prepare($sql_borrar);
    $stmt->bind_param('i', $id_a_borrar);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Registro borrado correctamente en la tabla $tabla.<br>";

        // Consultas para reiniciar los IDs
        $sql_reset_ids = "
            SET @num := 0;
            UPDATE $tabla SET $id_nombre = @num := (@num + 1);
            ALTER TABLE $tabla AUTO_INCREMENT = 1;
        ";

        // Ejecutar las consultas
        if ($conexion->multi_query($sql_reset_ids)) {
            echo "IDs reiniciados correctamente en la tabla $tabla.<br>";
            // Consumir los resultados de las múltiples consultas para permitir nuevas consultas
            do {
                if ($resultado = $conexion->store_result()) {
                    $resultado->free();
                }
            } while ($conexion->more_results() && $conexion->next_result());
        } else {
            echo "Error al reiniciar los IDs en la tabla $tabla: " . $conexion->error . "<br>";
        }
    } else {
        echo "No se encontró el registro o no se pudo borrar en la tabla $tabla.<br>";
    }

    // Cerrar la declaración preparada
    $stmt->close();
}

// Ejemplos de uso (comenta o elimina las líneas que no necesitas para cada prueba)
borrarRegistroYResetearID('nacimiento', 'codnacimiento', 1);
borrarRegistroYResetearID('defuncion', 'coddefuncion', 1);
borrarRegistroYResetearID('matrimonio', 'codmatrimonio', 1);
borrarRegistroYResetearID('divorcio', 'coddivorcio', 1);
borrarRegistroYResetearID('reconocimiento', 'codreco', 1);
borrarRegistroYResetearID('digital', 'coddigital', 1);
borrarRegistroYResetearID('constancias', 'codinex', 1);

// Cerrar la conexión al finalizar el script, si es necesario
$conexion->close();
?>
