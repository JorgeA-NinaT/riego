<?php
// Incluir la librería FPDF
require('fpdf186/fpdf.php');
require_once 'includes/config.php';

// Capturar el tipo de reporte
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'general';

// Crear una nueva instancia de FPDF
$pdf = new FPDF();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Configuración según el tipo de reporte
if ($tipo === 'general') {
    $titulo = 'Reporte General de Lecturas de Sensores';
    $query = "SELECT * FROM lecturas ORDER BY fecha_hora DESC";
} elseif ($tipo === 'bomba_activa') {
    $titulo = 'Reporte de Lecturas con Bomba Activa';
    $query = "WITH cambios_estado AS (
    SELECT 
        id, 
        temperatura, 
        humedad_suelo, 
        bomba_activa, 
        fecha_hora,
        LAG(bomba_activa) OVER (ORDER BY fecha_hora ASC) AS estado_anterior
    FROM 
        lecturas
)
SELECT 
    id, 
    temperatura, 
    humedad_suelo, 
    fecha_hora 
FROM 
    cambios_estado
WHERE 
    bomba_activa = 1 AND estado_anterior = 0
ORDER BY 
    fecha_hora ASC;
";
} elseif ($tipo === 'promedio') {
    $titulo = 'Reporte de Promedios por Periodo';
    $fechaInicio = $_GET['fecha_inicio'];
    $fechaFin = $_GET['fecha_fin'];
    $query = "
        SELECT 
            AVG(temperatura) AS promedio_temperatura, 
            AVG(humedad_suelo) AS promedio_humedad, 
            DATE_FORMAT(fecha_hora, '%Y-%m-%d %H:00:00') AS periodo
        FROM lecturas
        WHERE fecha_hora BETWEEN '$fechaInicio' AND '$fechaFin'
        GROUP BY periodo
        ORDER BY periodo ASC
    ";
} else {
    die('Tipo de reporte no válido.');
}

// Título del reporte
$pdf->Cell(200, 10, $titulo, 0, 1, 'C');
$pdf->Ln(10);

// Encabezados de columnas
$pdf->SetFont('Arial', 'B', 12);
if ($tipo === 'promedio') {
    $pdf->Cell(70, 10, 'Periodo', 1);
    $pdf->Cell(60, 10, 'Prom. Temperatura', 1);
    $pdf->Cell(60, 10, 'Prom. Humedad', 1);
} else {
    $pdf->Cell(30, 10, 'ID', 1);
    $pdf->Cell(35, 10, 'Temperatura', 1);
    $pdf->Cell(35, 10, 'Humedad Suelo', 1);
    if ($tipo !== 'bomba_activa') {
        $pdf->Cell(35, 10, 'Bomba Activa', 1);
    }
    $pdf->Cell(50, 10, 'Fecha y Hora', 1);
}
$pdf->Ln();

// Ejecutar la consulta y llenar los datos
$result = $conn->query($query);
$pdf->SetFont('Arial', '', 12);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($tipo === 'promedio') {
            $pdf->Cell(70, 10, $row['periodo'], 1);
            $pdf->Cell(60, 10, number_format($row['promedio_temperatura'], 2) . ' Centigrados', 1);
            $pdf->Cell(60, 10, number_format($row['promedio_humedad'], 2) . ' %', 1);
        } else {
            $pdf->Cell(30, 10, $row['id'], 1);
            $pdf->Cell(35, 10, $row['temperatura'] . ' Centigrados', 1);
            $pdf->Cell(35, 10, $row['humedad_suelo'] . '%', 1);
            if ($tipo !== 'bomba_activa') {
                $pdf->Cell(35, 10, $row['bomba_activa'] ? 'Si' : 'No', 1);
            }
            $pdf->Cell(50, 10, $row['fecha_hora'], 1);
        }
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No hay datos disponibles.', 1, 1, 'C');
}

// Generar y mostrar el PDF
$pdf->Output();

?>
