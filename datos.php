<?php
// datos.php
include 'conexion.php';

$temperatura = $_POST['temperatura'];
$humedad_suelo = $_POST['humedad_suelo'];
$bomba_activa = $_POST['bomba_activa'];

$sql = "INSERT INTO lecturas (temperatura, humedad_suelo, bomba_activa) 
        VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("dii", $temperatura, $humedad_suelo, $bomba_activa);
$stmt->execute();

echo "Datos recibidos correctamente";
?>