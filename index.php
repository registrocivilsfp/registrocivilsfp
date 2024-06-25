<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: src/');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Ingrese usuario y contraseña
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$clave'");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $dato['idusuario'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];
                header('Location: src/');
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Contraseña incorrecta
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                session_destroy();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
	
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div style="display: flex;justify-content: space-between;">
        <div class="container" style="display: none;">
            <center><b class="title label mb-1">Registro Civil</b></center>
            <form action="" id="login-form" method="POST">
                <div class="user-details">
                    <div class="input-box">
                        <label for="usuario" class="input-label">
                            <i class="fas fa-user"></i>
                            Usuario:
                        </label>
                        <input type="text" class="input-field" name="usuario" id="usuario" placeholder="Ingrese usuario" autocomplete="on" required> 
                    </div>
                    <div class="input-box">
                        <label for="clave" class="input-label">
                            <i class="fas fa-lock"></i>
                            Contraseña:
                        </label>
                        <input type="password" class="input-field" name="clave" id="clave" placeholder="Contraseña" autocomplete="off" required>
                    </div>
					<?php echo (isset($alert)) ? $alert : '' ; ?>
                    <div class="button">
                        <input type="submit" value="Ingresar"> 
                        
                    </div>
                </div>
                
            </form>
        </div>

    </div>
	<script src="assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
	<script src="assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    
</body>

</html>