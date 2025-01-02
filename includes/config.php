<?php
$DB_HOST = 'dpg-ctqvhrrqf0us73fgp3mg-a';  // Cambia el host según el tuyo
$DB_USER = 'dbriego_user';  // Tu nombre de usuario de la base de datos
$DB_PASS = '4W5SBYfNgao6E2vKqtiMirHRGSxT2YCS';  // Tu contraseña de la base de datos
$DB_NAME = 'dbriego';  // El nombre de tu base de datos

try {
    // Usamos PDO para conectar con PostgreSQL
    $conn = new PDO("pgsql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET TIME ZONE 'America/Lima';");
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>