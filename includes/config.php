<?php
$DB_HOST = 'dpg-ct33nf3qf0us73a4m0jg-a.oregon-postgres.render.com';  // Cambia el host según el tuyo
$DB_USER = 'riego_user';  // Tu nombre de usuario de la base de datos
$DB_PASS = 'hPZGQbOwfxJeOKbSGQ9IfCl3weGSeTNI';  // Tu contraseña de la base de datos
$DB_NAME = 'riego';  // El nombre de tu base de datos

try {
    // Usamos PDO para conectar con PostgreSQL
    $conn = new PDO("pgsql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Verificar si el usuario quiere eliminar los registros de lecturas
if (isset($_POST['eliminar_lecturas']) && $_POST['eliminar_lecturas'] == 'true') {
    // Verificar que el usuario esté autenticado y tenga permisos
    if (isset($_SESSION['usuario_id'])) {
        // Ejecutar la consulta para eliminar todos los registros de la tabla 'lecturas'
        $queryEliminar = "DELETE FROM lecturas";
        try {
            $stmt = $conn->prepare($queryEliminar);
            $stmt->execute();
            echo "<script>alert('Todos los registros de lecturas han sido eliminados.'); window.location.href = 'monitoreo.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Hubo un error al eliminar los registros.');</script>";
        }
    } else {
        // Si no está autenticado, redirigir a la página de login
        header("Location: login.php");
        exit();
    }
}
?>

