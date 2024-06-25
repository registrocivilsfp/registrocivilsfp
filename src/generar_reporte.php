<?php
require_once(__DIR__ . '/fpdf/fpdf.php');  // Ruta corregida
include "../conexion.php";

date_default_timezone_set('America/Mexico_City');


class PDF extends FPDF {

    // Dibujar margen
    function DrawMargin() {
        $this->SetDrawColor(0, 0, 0); // Establecer color de dibujo a negro
        $this->Rect(5, 5, 200, 287);  // Dibujar un rectángulo alrededor de la página (A4)
    }
    
    // Cabecera de página
    function Header() {
        global $fechaReporte;
        $this->SetFont('Arial','',10);
        $this->Cell(0,10,'                                                                    Fecha de Generacion: ' . $fechaReporte,0,1,'C');
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'REGISTRO CIVIL                        OFICIALIA 01',0,1,'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Pag '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Tabla simple
    function BasicTable($header, $data) {
        // Convertir encabezados a mayúsculas
        $header = array_map('strtoupper', $header);

        foreach($header as $col)
            $this->Cell(38.5,6,$col,1);
        $this->Ln();
        foreach($data as $row) {
            foreach($row as $col)
                $this->Cell(38.5,6,$col,1);
            $this->Ln();
        }
    }

    // Sobrescribir AddPage para incluir DrawMargin
    function AddPage($orientation = '', $size = '', $rotation = 0) {
        parent::AddPage($orientation, $size, $rotation);
        $this->DrawMargin();
    }
}

function generarPDF($nombreReporte, $tipoActa, $fechaReporte, $data) {
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',12);

    $header = array_keys($data[0]);

    $pdf->BasicTable($header, $data);
    $filePath = 'reportes_pdf/reporte_' . uniqid() . '.pdf'; // Generar un nombre de archivo único
    $pdf->Output('F', $filePath);
    
    return $filePath;
}

if (isset($_POST['generar_reporte'])) {
    $nombreReporte = $_POST['nombre_reporte'];
    $tipoActa = $_POST['tipo_acta'];
    $fechaReporte = date('Y-m-d');
    
    
    $query = mysqli_query($conexion, "SELECT * FROM $tipoActa");
    $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
    
    $filePath = generarPDF($nombreReporte, $tipoActa, $fechaReporte, $data);
    
    $stmt = $conexion->prepare("INSERT INTO reportes (nombre_reporte, tipo_acta, fecha_reporte, archivo_pdf) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $nombreReporte, $tipoActa, $fechaReporte, $filePath);
    $stmt->execute();
    header("Location: reportes.php");
}
?>
