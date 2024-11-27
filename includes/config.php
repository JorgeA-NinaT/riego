<?php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'sistema_riego';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Verificar si el usuario quiere eliminar los registros de lecturas
if (isset($_POST['eliminar_lecturas']) && $_POST['eliminar_lecturas'] == 'true') {
    // Verificar que el usuario esté autenticado y tenga permisos
    if (isset($_SESSION['usuario_id'])) {
        // Ejecutar la consulta para eliminar todos los registros de la tabla 'lecturas'
        $queryEliminar = "DELETE FROM lecturas";
        if ($conn->query($queryEliminar) === TRUE) {
            // Mostrar mensaje de éxito
            echo "<script>alert('Todos los registros de lecturas han sido eliminados.'); window.location.href = 'monitoreo.php';</script>";
        } else {
            // Mostrar mensaje de error
            echo "<script>alert('Hubo un error al eliminar los registros.');</script>";
        }
    } else {
        // Si no está autenticado, redirigir a la página de login
        header("Location: login.php");
        exit();
    }
}
?>