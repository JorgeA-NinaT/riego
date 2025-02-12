<?php
$DB_HOST = 'dpg-cum9pelumphs738fb720-a';  // Cambia el host según el tuyo
$DB_USER = 'riego_s6ej_user';  // Tu nombre de usuario de la base de datos
$DB_PASS = '3VOWAFCIY4VulC6nHSkJo2bUpulNGhMW';  // Tu contraseña de la base de datos
$DB_NAME = 'riego_s6ej';  // El nombre de tu base de datos

try {
    // Usamos PDO para conectar con PostgreSQL
    $conn = new PDO("pgsql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET TIME ZONE 'America/Lima';");
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
