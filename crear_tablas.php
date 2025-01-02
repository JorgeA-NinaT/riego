<?php
// Conexión a la base de datos PostgreSQL
$host = 'dpg-ctqvhrrqf0us73fgp3mg-a';
$dbname = 'dbriego';
$user = 'dbriego_user';
$password = 'dpg-ctqvhrrqf0us73fgp3mg-a';
$port = "5432";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear tabla `lecturas`
    $sql_lecturas = "
    CREATE TABLE IF NOT EXISTS lecturas (
        id SERIAL PRIMARY KEY,
        temperatura FLOAT NOT NULL,
        humedad_suelo INT NOT NULL,
        bomba_activa BOOLEAN NOT NULL,
        fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    );";
    $pdo->exec($sql_lecturas);

    // Crear tabla `usuarios`
    $sql_usuarios = "
    CREATE TABLE IF NOT EXISTS usuarios (
        id SERIAL PRIMARY KEY,
        nombre_usuario VARCHAR(255) NOT NULL,
        contraseña VARCHAR(255) NOT NULL,
        rol VARCHAR(10) DEFAULT 'user',
        creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    );";
    $pdo->exec($sql_usuarios);

    // Insertar datos iniciales en la tabla `usuarios`
    $sql_insert_usuarios = "
    INSERT INTO usuarios (nombre_usuario, contraseña, rol, creado_en) VALUES
    ('admin', 'admin', 'admin', '2024-11-18 13:57:16'),
    ('user', 'user', 'user', '2024-11-18 13:57:16')
    ON CONFLICT DO NOTHING;";
    $pdo->exec($sql_insert_usuarios);

    echo "Tablas creadas e inicializadas correctamente.";
} catch (PDOException $e) {
    echo "Error al conectar o ejecutar la consulta: " . $e->getMessage();
}
?>
