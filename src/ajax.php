<?php
require_once "../conexion.php";
session_start();


if (isset($_GET['dig'])) {
    $datos = array();
    $nombre = $_GET['dig'];
    $numero = mysqli_query($conexion, "SELECT * FROM digital WHERE folio LIKE '%" . $nombre . "%' OR numero LIKE '%" . $nombre . "%'");
    while ($row = mysqli_fetch_assoc($numero)) {
        $data['id'] = $row['coddigital'];
        $data['label'] = $row['folio'] . ' - ' .$row['numero'];
        $data['value'] = $row['numero'];
        $data['tipo'] = $row['tipo'];
        $data['libro'] = $row['libro'];
        $data['año'] = $row['año'];
        $data['pdf'] = $row['pdf'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();

} else if (isset($_GET['nac'])) {
    $datos = array();
    $nombre = $_GET['nac'];
    $nacinum = mysqli_query($conexion, "SELECT * FROM nacimiento WHERE codigo LIKE '%" . $nombre . "%' OR numero LIKE '%" . $nombre . "%'");
    while ($row = mysqli_fetch_assoc($nacinum)) {
        $data['id'] = $row['codnacimiento'];
        $data['label'] = $row['codigo'] . ' - ' .$row['numero'];
        $data['value'] = $row['numero'];
        $data['precio'] = $row['precio'];
        $data['fecha'] = $row['fecha'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();

} else if (isset($_GET['def'])) {
    $datos = array();
    $nombre = $_GET['def'];
    $defunum = mysqli_query($conexion, "SELECT * FROM defuncion WHERE codigo LIKE '%" . $nombre . "%' OR numero LIKE '%" . $nombre . "%'");
    while ($row = mysqli_fetch_assoc($defunum)) {
        $data['id'] = $row['coddefuncion'];
        $data['label'] = $row['codigo'] . ' - ' .$row['numero'];
        $data['value'] = $row['numero'];
        $data['precio'] = $row['precio'];
        $data['fecha'] = $row['fecha'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
} else if (isset($_GET['mat'])) {
    $datos = array();
    $nombre = $_GET['mat'];
    $matrinum = mysqli_query($conexion, "SELECT * FROM matrimonio WHERE codigo LIKE '%" . $nombre . "%' OR numero LIKE '%" . $nombre . "%'");
    while ($row = mysqli_fetch_assoc($matrinum)) {
        $data['id'] = $row['codmatrimonio'];
        $data['label'] = $row['codigo'] . ' - ' .$row['numero'];
        $data['value'] = $row['numero'];
        $data['precio'] = $row['precio'];
        $data['fecha'] = $row['fecha'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
} else if (isset($_GET['div'])) {
    $datos = array();
    $nombre = $_GET['div'];
    $divonum = mysqli_query($conexion, "SELECT * FROM divorcio WHERE codigo LIKE '%" . $nombre . "%' OR numero LIKE '%" . $nombre . "%'");
    while ($row = mysqli_fetch_assoc($divonum)) {
        $data['id'] = $row['coddivorcio'];
        $data['label'] = $row['codigo'] . ' - ' .$row['numero'];
        $data['value'] = $row['numero'];
        $data['precio'] = $row['precio'];
        $data['fecha'] = $row['fecha'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
} else if (isset($_GET['rec'])) {
    $datos = array();
    $nombre = $_GET['rec'];
    $reconum = mysqli_query($conexion, "SELECT * FROM reconocimiento WHERE codigo LIKE '%" . $nombre . "%' OR numero LIKE '%" . $nombre . "%'");
    while ($row = mysqli_fetch_assoc($reconum)) {
        $data['id'] = $row['codreco'];
        $data['label'] = $row['codigo'] . ' - ' .$row['numero'];
        $data['value'] = $row['numero'];
        $data['precio'] = $row['precio'];
        $data['fecha'] = $row['fecha'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();

} else if (isset($_GET['con'])) {
    $datos = array();
    $nombre = $_GET['con'];
    $tipo_acta = mysqli_query($conexion, "SELECT * FROM constancias WHERE tipo_acta LIKE '%" . $nombre . "%' OR precio LIKE '%" . $nombre . "%'");
    while ($row = mysqli_fetch_assoc($tipo_acta)) {
        $data['id'] = $row['codinex'];
        $data['label'] = $row['tipo_acta'] . ' - ' .$row['precio'];
        $data['value'] = $row['precio'];
        $data['fecha'] = $row['fecha'];
        array_push($datos, $data);
    }
    echo json_encode($datos);
    die();
    



} else if (isset($_GET['editarUsuario'])) {
    $idusuario = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM usuario WHERE idusuario = $idusuario");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if(isset($_GET['editarDefuncion']))  {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM defuncion WHERE coddefuncion = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if(isset($_GET['editarMatrimonio']))  {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM matrimonio WHERE codmatrimonio = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;

} else if(isset($_GET['editarDivorcio']))  {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM divorcio WHERE coddivorcio = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if(isset($_GET['editarReconocimiento']))  {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM reconocimiento WHERE codreco = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;
} else if(isset($_GET['editarNacimiento']))  {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM nacimiento WHERE codnacimiento = $id");
    $data = mysqli_fetch_array($sql);
    echo json_encode($data);
    exit;

} else if (isset($_GET['editarDigital'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM digital WHERE coddigital = $id");
    $data = mysqli_fetch_array($sql);
    
    // Agregar el campo pdf al array de datos
    $data['pdf'] = $data['pdf'];

    echo json_encode($data);
    exit;
    

}else if (isset($_POST['cambio'])) {
    if (empty($_POST['actual']) || empty($_POST['nueva'])) {
        $msg = 'Los campos estan vacios';
    } else {
        $id = $_SESSION['idUser'];
        $actual = md5($_POST['actual']);
        $nueva = md5($_POST['nueva']);
        $consulta = mysqli_query($conexion, "SELECT * FROM usuario WHERE clave = '$actual' AND idusuario = $id");
        $result = mysqli_num_rows($consulta);
        if ($result == 1) {
            $query = mysqli_query($conexion, "UPDATE usuario SET clave = '$nueva' WHERE idusuario = $id");
            if ($query) {
                $msg = 'ok';
            }else{
                $msg = 'error';
            }
        } else {
            $msg = 'dif';
        }
        
    }
    echo $msg;
    die();
    
}

