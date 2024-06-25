<?php
session_start();
include "../conexion.php";
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
        <h2 class="titulo-formulario text-center mb-4">Generar Reportes PDF</h2>
        <form action="generar_reporte.php" method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombre_reporte" class="text-dark font-weight-bold">Nombre del Reporte</label>
                        <input type="text" name="nombre_reporte" id="nombre_reporte" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipo_acta" class="text-dark font-weight-bold">Tipo de Actas</label>
                        <select name="tipo_acta" id="tipo_acta" class="form-control" required>
                            <option value="Nacimiento">Nacimiento</option>
                            <option value="Defuncion">Defunción</option>
                            <option value="Matrimonio">Matrimonio</option>
                            <option value="Divorcio">Divorcio</option>
                            <option value="Reconocimiento">Reconocimiento</option>
                            <option value="Constancias_Inexistencia">Constancias de Inexistencia</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" name="generar_reporte" class="btn btn-primary mt-4">
                        <i class="fa fa-file-pdf"></i> Generar Reporte
                    </button>
                </div>
            </div>
        </form>
        <div class="text-right mt-3">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal"><i class="fa fa-trash"></i> Vaciar Tabla</button>
        </div>
        
        <h2 class="titulo-formulario text-center mt-4 mb-4">Reportes Generados</h2>
        <div class="form-group row">
            <div class="col-md-6">
                <input type="text" class="form-control" id="buscar" placeholder="Buscar en la tabla">
            </div>
            <div class="col-md-6">
                <select class="form-control" id="filas">
                    <option value="5">5 filas</option>
                    <option value="10">10 filas</option>
                    <option value="20">20 filas</option>
                    <option value="50">50 filas</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="tblReportes">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre del Reporte</th>
                        <th>Tipo de acta</th>
                        <th>Fecha del Reporte</th>
                        <th>Archivo PDF</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obtener los datos de la tabla filtrados según la búsqueda
                    $query = "SELECT * FROM reportes";
                    $result = mysqli_query($conexion, $query);
                    $total_filas = mysqli_num_rows($result);
                    while ($data = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['nombre_reporte']; ?></td>
                            <td><?php echo $data['tipo_acta']; ?></td>
                            <td><?php echo $data['fecha_reporte']; ?></td>
                            <td>
                                <a href="<?php echo $data['archivo_pdf']; ?>" target="_blank" class="btn btn-primary"><i class='fas fa-file-pdf'></i> Ver PDF</a>
                                <form action="eliminar_reportes.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                                    <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Función para realizar la búsqueda
        $('#buscar').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#tblReportes tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Función para cambiar el número de filas mostradas
        $('#filas').on('change', function() {
            var num_filas = $(this).val();
            $.ajax({
                url: 'obtener_filas.php',
                type: 'post',
                data: {
                    num_filas: num_filas
                },
                success: function(response) {
                    $('#tblReportes tbody').html(response);
                }
            });
        });
    });
</script>

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
                ¿Desea vaciar la tabla Reportes Generados?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"></i> Cancelar</button>
                <form action="eliminar_tablareportes.php" method="post" class="d-inline">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Vaciar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>
