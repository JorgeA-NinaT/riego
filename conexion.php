<?php
try {
    // Configuración de la conexión
    $host = 'dpg-ct33nf3qf0us73a4m0jg-a.oregon-postgres.render.com'; // Cambia al host externo o interno proporcionado
    $dbname = 'riego';
    $user = 'riego_user';
    $password = 'hPZGQbOwfxJeOKbSGQ9IfCl3weGSeTNI';

    // Usamos PDO para la conexión
    $dsn = "pgsql:host=$host;port=5432;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Manejo de errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo de fetch
    ]);

    echo "Conexión exitosa a la base de datos.";

    // Si deseas probar una consulta, puedes hacerlo aquí
    $query = $pdo->query("SELECT NOW() AS fecha_hora_actual;");
    $result = $query->fetch();
    echo "<br>Fecha y hora actual en la base de datos: " . $result['fecha_hora_actual'];

} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
