<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Get latest sensor reading
$query = "SELECT 
    temperatura, 
    humedad_suelo, 
    bomba_activa, 
    fecha_hora 
FROM lecturas 
ORDER BY fecha_hora DESC 
LIMIT 1";

$result = $conn->query($query);
$data = $result->fetch_assoc();

echo json_encode([
    'temperatura' => round($data['temperatura'], 1),
    'humedad_suelo' => round($data['humedad_suelo'], 1),
    'bomba_activa' => (bool) $data['bomba_activa'],  // Asegúrate de convertirlo a un valor booleano
    'timestamp' => $data['fecha_hora']
]);
