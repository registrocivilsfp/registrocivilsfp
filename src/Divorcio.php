<?php
session_start();
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "Divorcio";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}
if (!empty($_POST)) {
    $alert = "";
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $divonum = $_POST['divonum'];
    $precio = $_POST['precio'];
    $fecha = $_POST['fecha'];
    if (empty($codigo) || empty($divonum) || empty($precio) || $precio <  0 || empty($fecha) || strtotime($fecha) === false) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Complete todos los campos
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM divorcio WHERE codigo = '$codigo'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        El folio ya fue registrado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO divorcio(codigo,numero,precio,fecha) values ('$codigo', '$divonum', '$precio', '$fecha')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Acta registrada
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else {
                    $alert = '<div class="alert alert-danger" role="alert">
                    Error al registrar el producto
                  </div>';
                }
            }
        } else {
            $query_update = mysqli_query($conexion, "UPDATE divorcio SET codigo = '$codigo', numero = '$divonum', precio= $precio, fecha = '$fecha' WHERE coddivorcio = $id");
            if ($query_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Acta Modificada
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
        <h2 class="titulo-formulario text-center mb-4 ">Actas de Divorcio</h2>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" autocomplete="off" id="formulario">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    
                    <div class="card-header-primary row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="codigo" class=" text-dark font-weight-bold"><i class="fa fa-barcode"></i> Folio</label>
                                <input type="text" placeholder="Ingrese folio del acta" name="codigo" id="codigo" class="form-control">
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="divonum" class=" text-dark font-weight-bold"><i class="fas fa-hashtag"></i>Número de Acta</label>
                                <input type="number" placeholder="Ingrese numero de acta" name="divonum" id="divonum" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="precio" class=" text-dark font-weight-bold"><i class="fa fa-dollar-sign"></i> Precio</label>
                                <input type="number" placeholder="Ingrese precio" class="form-control" name="precio" id="precio">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha" class=" text-dark font-weight-bold"><i class="fa fa-calendar"></i> Fecha de Divorcio</label>
                                <input type="date"  class="form-control" name="fecha" id="fecha" placeholder="YYYY-MM-DD" onchange="validarYEnviarFecha()">
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
                            <th>Folio</th>
                            <th>No. de Acta</th>
                            <th>Precio</th>
                            <th>Fecha de Registro</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        include "../conexion.php";

                        $query = mysqli_query($conexion, "SELECT * FROM divorcio");
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?php echo $data['coddivorcio']; ?></td>
                                    <td><?php echo $data['codigo']; ?></td>
                                    <td><?php echo $data['numero']; ?></td>
                                    <td><?php echo $data['precio']; ?></td>
                                    <td><?php echo $data['fecha']; ?></td>
                                    <td>
                                        <a href="#" onclick="editarDivorcio(<?php echo $data['coddivorcio']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>

                                        <form action="eliminar_divorcio.php?id=<?php echo $data['coddivorcio']; ?>" method="post" class="confirmar d-inline">
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
                ¿Desea vaciar la tabla Actas de Divorcio?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                <form action="eliminar_tabladivorcio.php" method="post" class="d-inline">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Vaciar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>