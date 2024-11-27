<?php
$host = 'dpg-ct33nf3qf0us73a4m0jg-a';
$dbname = 'riego';
$user = 'riego_user';
$password = 'hPZGQbOwfxJeOKbSGQ9IfCl3weGSeTNI';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    // Establece el modo de errores a excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos";
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
