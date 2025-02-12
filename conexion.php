<?php
$host = 'dpg-cum9pelumphs738fb720-a';
$dbname = 'riego_s6ej';
$user = 'riego_s6ej_user';
$password = '3VOWAFCIY4VulC6nHSkJo2bUpulNGhMW';

try {
    // Conexión con PDO para PostgreSQL
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    // Establece el modo de errores a excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
