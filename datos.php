<?php
// datos.php
include 'conexion.php';

// Obtener los valores enviados por POST
$temperatura = $_POST['temperatura'];
$humedad_suelo = $_POST['humedad_suelo'];
$bomba_activa = $_POST['bomba_activa'];

// Preparar la consulta SQL para insertar los datos en la tabla 'lecturas'
$sql = "INSERT INTO lecturas (temperatura, humedad_suelo, bomba_activa) 
        VALUES (:temperatura, :humedad_suelo, :bomba_activa)";

// Preparar la declaración
$stmt = $pdo->prepare($sql);

// Enlazar los parámetros
$stmt->bindParam(':temperatura', $temperatura, PDO::PARAM_STR);
$stmt->bindParam(':humedad_suelo', $humedad_suelo, PDO::PARAM_INT);
$stmt->bindParam(':bomba_activa', $bomba_activa, PDO::PARAM_INT);

// Ejecutar la consulta
$stmt->execute();

echo "Datos recibidos correctamente";
?>
