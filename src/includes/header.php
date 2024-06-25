<?php
if (empty($_SESSION['active'])) {
    header('Location: ../');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Registro Civil</title>
    <link href="../assets/css/material-dashboard.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/stilestitles.css">
    <link href="../assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/js/jquery-ui/jquery-ui.min.css">
    <script src="../assets/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper ">
        <div class="sidebar" data-color="purple" data-background-color="black" data-image="../assets/img/ayun.png">
            <div class="logo"><a href="./" class="simple-text logo-normal">
                    REGISTRO CIVIL 
                </a></div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link d-flex" href="usuarios.php">
                            <i class="fas fa-user mr-2 fa-2x"></i>
                            <p> Usuarios</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex" href="config.php">
                            <i class="fas fa-info-circle mr-2 fa-2x"></i>
                            <p> Información</p>
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex dropdown-toggle" href="#" id="actasDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-file-alt mr-2 fa-2x"></i>
                            <p>Actas</p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="actasDropdown">
                            <a class="dropdown-item dropdown-item-dark" href="Nacimiento.php">
                                <i class="fa fa-baby mr-2 fa-2x"></i>
                                Acta de Nacimiento
                            </a>
                            <a class="dropdown-item dropdown-item-dark" href="Defuncion.php">
                                <i class="fa fa-skull mr-2 fa-2x"></i>
                                Acta de Defunción
                            </a>
                            <a class="dropdown-item dropdown-item-dark" href="Matrimonio.php">
                                <i class="fa fa-ring mr-2 fa-2x"></i>
                                Acta de Matrimonio
                            </a>
                            <a class="dropdown-item dropdown-item-dark" href="Divorcio.php">
                                <i class="fa fa-restroom mr-2 fa-2x"></i>
                                Acta de Divorcio
                            </a>
                            <a class="dropdown-item dropdown-item-dark" href="Reconocimiento.php">
                                <i class="fa fa-file-signature mr-2 fa-2x"></i>
                                Acta de Reconocimiento
                            </a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex" href="Constancias_Inexistencia.php">
                            <i class="fa fa-file-excel mr-2 fa-2x"></i>
                            <p>Constancias de Inexistencia</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex" href="digitales.php">
                            <i class="fa fa-file-pdf mr-2 fa-2x"></i>
                            <p>Actas Digitales</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link d-flex" href="reportes.php">
                            <i class="fa fa-file-pdf mr-2 fa-2x"></i>
                            <p>Reportes</p>
                        </a>
                    </li>
                    
                </ul>
            </div>
              
        </div>
        
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top bg-dark">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <a class="navbar-brand" href="javascript:;">Formularios de Registro Civil</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">

                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dark-mode" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user"></i>
                                    <p class="d-lg-none d-md-block">
                                        Cuenta
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dark-mode" aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item dark-mode-item" href="#" data-toggle="modal" data-target="#nuevo_pass">Perfil</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item dark-mode-item" href="salir.php">Cerrar Sesión</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">