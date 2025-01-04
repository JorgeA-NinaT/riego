<?php
$host = 'dpg-ctqvhrrqf0us73fgp3mg-a';
$dbname = 'dbriego';
$user = 'dbriego_user';
$password = '4W5SBYfNgao6E2vKqtiMirHRGSxT2YCS';

try {
    // Conexión con PDO para PostgreSQL
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    // Establece el modo de errores a excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
