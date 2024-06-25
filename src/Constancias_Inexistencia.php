<?php
session_start();
include "../conexion.php";

// Verificación de permisos
$id_user = $_SESSION['idUser'];
$permiso = "Constancias_Inexistencia";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
    exit;
}

$alert = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $tipo_acta = $_POST['tipo_acta'];
    $precio = $_POST['precio'];
    $fecha = $_POST['fecha'];
    if (empty($tipo_acta) || empty($precio) || $precio < 0 || empty($fecha) || strtotime($fecha) === false) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Complete todos los campos
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        if (empty($id)) {
            $query_insert = mysqli_query($conexion, "INSERT INTO constancias(tipo_acta, precio, fecha) VALUES ('$tipo_acta', '$precio', '$fecha')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Acta registrada
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                    Error al registrar el acta
                </div>';
            }
        } else {
            $query_update = mysqli_query($conexion, "UPDATE constancias SET tipo_acta = '$tipo_acta', precio = '$precio', fecha = '$fecha' WHERE codinex = $id");
            if ($query_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Acta modificada
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            } else {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Error al modificar
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            }
        }
    }
    // Redireccionar para evitar reenvío de formulario
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

include_once "includes/header.php";
?>
<link rel="stylesheet" href="fontawesome/css/all.css">
<link rel="stylesheet" href="assets/css/stilestitles.css">
<style>
    .titulo-formulario {
        font-family: 'Courier New', Courier, monospace;
    }
</style>

<div class="card shadow-lg">
    <div class="card-body">
        <h2 class="titulo-formulario text-center mb-4 ">Constancias de Inexistencia</h2>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" autocomplete="off" id="formulario">
                    <?php echo $alert; ?>
                    
                    <div class="card-header-primary row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo_acta" class="text-dark font-weight-bold"><i class="fa fa-file-alt"></i> Tipo de Acta</label>
                                <select name="tipo_acta" id="tipo_acta" class="form-control">
                                    <option value="">Seleccione tipo de acta</option>
                                    <option value="nacimiento">Nacimiento</option>
                                    <option value="defuncion">Defunción</option>
                                    <option value="matrimonio">Matrimonio</option>
                                    <option value="divorcio">Divorcio</option>
                                    <option value="reconocimiento">Reconocimiento</option>
                                </select>
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="precio" class="text-dark font-weight-bold"><i class="fa fa-dollar-sign"></i> Precio</label>
                                <input type="number" placeholder="Ingrese precio" class="form-control" name="precio" id="precio" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha" class="text-dark font-weight-bold"><i class="fa fa-calendar"></i> Fecha de Registro</label>
                                <input type="date" class="form-control" name="fecha" id="fecha">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" id="btnAccion">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                            <button type="button" onclick="limpiar()" class="btn btn-success" id="btnNuevo">
                                <i class="fas fa-eraser"></i> Limpiar Formulario
                            </button>
                        </div>
                    </div>
                </form>
                <div class="text-right mt-3">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal"><i class="fa fa-trash"></i> Vaciar Tabla</button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="tbl">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Tipo de Acta</th>
                            <th>Precio</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conexion, "SELECT * FROM constancias");
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?php echo $data['codinex']; ?></td>
                                    <td><?php echo ucfirst($data['tipo_acta']); ?></td>
                                    <td><?php echo $data['precio']; ?></td>
                                    <td><?php echo $data['fecha']; ?></td>
                                    <td>
                                        

                                        <form action="eliminar_constancia.php?id=<?php echo $data['codinex']; ?>" method="post" class="confirmar d-inline">
                                            <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                        </form>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas vaciar la tabla Constancias de Inexistencia?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <form action="eliminar_tablaconstancias.php" method="post" class="d-inline">
                    <button type="submit" class="btn btn-danger">Vaciar Tabla</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
