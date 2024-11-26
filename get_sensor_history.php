<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Get last 24 hours of data
$query = "SELECT 
    temperatura, 
    humedad_suelo, 
    DATE_FORMAT(fecha_hora, '%H:%i') as hora
FROM lecturas 
WHERE fecha_hora >= DATE_SUB(NOW(), INTERVAL 24 HOUR) 
ORDER BY fecha_hora ASC";

$result = $conn->query($query);

$temperaturas = [];
$humedades = [];
$horas = [];

while ($row = $result->fetch_assoc()) {
    $temperaturas[] = $row['temperatura'];
    $humedades[] = $row['humedad_suelo'];
    $horas[] = $row['hora'];
}

echo json_encode([
    'temperaturas' => $temperaturas,
    'humedades' => $humedades,
    'horas' => $horas
]);