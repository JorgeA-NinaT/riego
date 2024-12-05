<?php
$DB_HOST = 'dpg-ct33nf3qf0us73a4m0jg-a.oregon-postgres.render.com';  // Cambia el host según el tuyo
$DB_USER = 'riego_user';  // Tu nombre de usuario de la base de datos
$DB_PASS = 'hPZGQbOwfxJeOKbSGQ9IfCl3weGSeTNI';  // Tu contraseña de la base de datos
$DB_NAME = 'riego';  // El nombre de tu base de datos

try {
    // Usamos PDO para conectar con PostgreSQL
    $conn = new PDO("pgsql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurar zona horaria
    $conn->exec("SET TIME ZONE 'America/Lima';");
    
    // Opcional: Configuración de PHP
    date_default_timezone_set('America/Lima');
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
?>
?>