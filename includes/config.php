<?php
$DB_HOST = 'dpg-d4j48ceuk2gs73bcd770-a';  // Cambia el host según el tuyo
$DB_USER = 'base01_user';  // Tu nombre de usuario de la base de datos
$DB_PASS = '7KDyvO3xTEWZeKONUvnSK25c43WmtvET';  // Tu contraseña de la base de datos
$DB_NAME = 'base01';  // El nombre de tu base de datos

try {
    // Usamos PDO para conectar con PostgreSQL
    $conn = new PDO("pgsql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET TIME ZONE 'America/Lima';");
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
