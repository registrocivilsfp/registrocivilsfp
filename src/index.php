<?php
require "../conexion.php";
$usuarios = mysqli_query($conexion, "SELECT * FROM usuario");
$total['usuarios'] = mysqli_num_rows($usuarios);
$Nacimiento = mysqli_query($conexion, "SELECT * FROM nacimiento");
$total['Nacimiento'] = mysqli_num_rows($Nacimiento);
$Defuncion = mysqli_query($conexion, "SELECT * FROM defuncion");
$total['Defuncion'] = mysqli_num_rows($Defuncion);
$Matrimonio = mysqli_query($conexion, "SELECT * FROM matrimonio");
$total['Matrimonio'] = mysqli_num_rows($Matrimonio);
$Divorcio = mysqli_query($conexion, "SELECT * FROM divorcio");
$total['Divorcio'] = mysqli_num_rows($Divorcio);
$Reconocimiento = mysqli_query($conexion, "SELECT * FROM reconocimiento");
$total['Reconocimiento'] = mysqli_num_rows($Reconocimiento);

$Constancias_Inexistencia = mysqli_query($conexion, "SELECT * FROM constancias");
$total['Constancias_Inexistencia'] = mysqli_num_rows($Constancias_Inexistencia);

$digitales = mysqli_query($conexion, "SELECT * FROM digital");
$total['digitales'] = mysqli_num_rows($digitales);

$reportes = mysqli_query($conexion, "SELECT * FROM reportes");
$total['reportes'] = mysqli_num_rows($reportes);
session_start();
include_once "includes/header.php";
?>
<!-- Content Row -->
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="fas fa-user fa-2x"></i>
                </div>
                <a href="usuarios.php" class="card-category text-warning font-weight-bold">
                    Usuarios
                </a>
                <h3 class="card-title"><?php echo $total['usuarios']; ?></h3>
            </div>
            <div class="card-footer bg-warning text-white">
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-baby fa-2x"></i>
                </div>
                <a href="Nacimiento.php" class="card-category text-danger font-weight-bold">
                    Actas de Nacimiento 
                </a>
                <h3 class="card-title"><?php echo $total['Nacimiento']; ?></h3>
            </div>
            <div class="card-footer bg-primary">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-skull fa-2x"></i>
                </div>
                <a href="Defuncion.php" class="card-category text-danger font-weight-bold">
                    Actas de Defunción
                </a>
                <h3 class="card-title"><?php echo $total['Defuncion']; ?></h3>
            </div>
            <div class="card-footer bg-primary">
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-ring fa-2x"></i>
                </div>
                <a href="Matrimonio.php" class="card-category text-danger font-weight-bold">
                    Actas de Matrimonio
                </a>
                <h3 class="card-title"><?php echo $total['Matrimonio']; ?></h3>
            </div>
            <div class="card-footer bg-primary">
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-restroom fa-2x"></i>
                </div>
                <a href="Divorcio.php" class="card-category text-danger font-weight-bold">
                    Actas de Divorcio
                </a>
                <h3 class="card-title"><?php echo $total['Divorcio']; ?></h3>
            </div>
            <div class="card-footer bg-primary">
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-file-signature fa-2x"></i>
                </div>
                <a href="Reconocimiento.php" class="card-category text-danger font-weight-bold">
                    Actas de Reconocimiento
                </a>
                <h3 class="card-title"><?php echo $total['Reconocimiento']; ?></h3>
            </div>
            <div class="card-footer bg-primary">
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-file-excel fa-2x"></i>
                </div>
                <a href="Constancias_Inexistencia.php" class="card-category text-danger font-weight-bold">
                    Constancias de Inexistencia
                </a>
                <h3 class="card-title"><?php echo $total['Constancias_Inexistencia']; ?></h3>
            </div>
            <div class="card-footer bg-primary">
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-file-pdf fa-2x"></i>
                </div>
                <a href="digitales.php" class="card-category text-danger font-weight-bold">
                    Actas Digitales
                </a>
                <h3 class="card-title"><?php echo $total['digitales']; ?></h3>
            </div>
            <div class="card-footer bg-primary">
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
                <div class="card-icon">
                    <i class="fa fa-file-pdf fa-2x"></i>
                </div>
                <a href="reportes.php" class="card-category text-danger font-weight-bold">
                    Reportes Mensuales
                </a>
                <h3 class="card-title"><?php echo $total['reportes']; ?></h3>
            </div>
            <div class="card-footer bg-primary">
            </div>
        </div>
    </div>

    

<?php include_once "includes/footer.php"; ?>