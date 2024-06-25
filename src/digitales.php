<?php
session_start();
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "productos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header('Location: permisos.php');
}
if (!empty($_POST)) {
    $alert = "";
    $id = $_POST['id'];
    $folio = $_POST['folio'];
    $numero = $_POST['numero'];
    $tipo = $_POST['tipo'];
    $libro = $_POST['libro'];
    $año = $_POST['año'];
    $pdf = "";

    if (!empty($_FILES['pdf']['name'])) {
        $pdf_name = $_FILES['pdf']['name'];
        $pdf_temp = $_FILES['pdf']['tmp_name'];
        $pdf_size = $_FILES['pdf']['size'];

        // Define el directorio de destino
        $pdf_folder = "archivos/";
        if (!file_exists($pdf_folder)) {
            mkdir($pdf_folder, 0777, true);
        }

        $pdf_path = $pdf_folder . basename($pdf_name);

        // Verifica el tipo de archivo y su tamaño
        if ($_FILES['pdf']['type'] != "application/pdf" || $pdf_size > 10485760) { // 10MB
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Solo se permiten archivos PDF menores a 10MB
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            if (move_uploaded_file($pdf_temp, $pdf_path)) {
                $pdf = $pdf_path;
            } else {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Error al subir el archivo PDF
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
            }
        }
    }

    if (empty($folio) || empty($numero) || empty($tipo) || empty($libro) || empty($año) || empty($pdf)) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Complete todos los campos
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM digital WHERE folio = '$folio'");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        El folio ya fue registrado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO digital(folio, numero, tipo, libro, año, pdf) VALUES ('$folio', '$numero', '$tipo', '$libro', '$año', '$pdf')");
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
            }
        } else {
            $query_update = mysqli_query($conexion, "UPDATE digital SET folio = '$folio', numero = '$numero', tipo = '$tipo', libro = '$libro', año = '$año', pdf = '$pdf' WHERE coddigital = $id");
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
        <h2 class="titulo-formulario text-center mb-4">Actas Digitales</h2>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" autocomplete="off" enctype="multipart/form-data" id="formulario">
                    <?php echo isset($alert) ? $alert : ''; ?>
                    
                    <div class="card-header-primary row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="folio" class="text-dark font-weight-bold"><i class="fa fa-barcode"></i> Folio</label>
                                <input type="text" placeholder="Ingrese folio del acta" name="folio" id="folio" class="form-control">
                                <input type="hidden" id="id" name="id">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="numero" class="text-dark font-weight-bold"><i class="fas fa-hashtag"></i> Número de Acta</label>
                                <input type="number" placeholder="Ingrese número de acta" name="numero" id="numero" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipo" class="text-dark font-weight-bold"><i class="fas fa-file-alt"></i> Tipo de Acta</label>
                                <input type="text" placeholder="Ingrese tipo de acta" name="tipo" id="tipo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="libro" class="text-dark font-weight-bold"><i class="fas fa-book"></i> Número de Libro</label>
                                <input type="text" placeholder="Ingrese número de libro" name="libro" id="libro" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="año" class="text-dark font-weight-bold"><i class="fas fa-calendar-alt"></i> Año</label>
                                <input type="number" placeholder="Ingrese año" name="año" id="año" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pdf" class="text-dark font-weight-bold"><i class="fas fa-file-pdf"></i> Selecciona un PDF</label>
                                <input type="file" name="pdf" id="pdf" class="form-control" accept="application/pdf">
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
                            <th>Tipo de Acta</th>
                            <th>Número de Libro</th>
                            <th>Año</th>
                            <th>PDF</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../conexion.php";
                        $query = mysqli_query($conexion, "SELECT * FROM digital");
                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?php echo $data['coddigital']; ?></td>
                                    <td><?php echo $data['folio']; ?></td>
                                    <td><?php echo $data['numero']; ?></td>
                                    <td><?php echo $data['tipo']; ?></td>
                                    <td><?php echo $data['libro']; ?></td>
                                    <td><?php echo $data['año']; ?></td>
                                    <td><?php echo $data['pdf']; ?></td>
                                    <td>
                                        <a href="#" onclick="editarDigital(<?php echo $data['coddigital']; ?>)" class="btn btn-primary"><i class='fas fa-edit'></i></a>
                                        <form action="eliminar_digital.php?id=<?php echo $data['coddigital']; ?>" method="post" class="confirmar d-inline">
                                            <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                        </form>
                                        <a href="../src/descargar.php?id= <?php echo $data['coddigital'] ;?>" class="btn btn-primary">
                                      <i class="fas fa-download"></i> </a>
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

<?php include_once "includes/footer.php"; ?>
