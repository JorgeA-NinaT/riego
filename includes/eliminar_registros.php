<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario tiene permisos de administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Acceso Denegado");
}

// Incluir la configuración de la base de datos
include 'config.php'; // Asegúrate de que config.php tenga la conexión correcta

// Verificar si se presionó el botón para eliminar los registros
if (isset($_POST['eliminar'])) {
    try {
        // Desactivar las comprobaciones de claves foráneas para evitar errores al borrar registros relacionados
        $conn->exec("SET FOREIGN_KEY_CHECKS = 0");

        // Eliminar registros de las tablas
        $conn->exec("DELETE FROM lecturas"); // Eliminar los registros de la tabla 'lecturas'

        // Si tienes otras tablas que también necesiten ser limpiadas, agrega las sentencias DELETE aquí.
        // $conn->exec("DELETE FROM otra_tabla");

        // Volver a activar las comprobaciones de claves foráneas
        $conn->exec("SET FOREIGN_KEY_CHECKS = 1");

        echo "Todos los registros han sido eliminados exitosamente.";
    } catch (PDOException $e) {
        echo "Error al eliminar los registros: " . $e->getMessage();
    }
} else {
    echo "No se ha enviado la solicitud de eliminación.";
}
?>
