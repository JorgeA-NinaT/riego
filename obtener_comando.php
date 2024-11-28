<?php
require_once 'includes/config.php';

try {
    // Consultar el estado actual de la bomba
    $sql = "SELECT bomba_activa FROM lecturas ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result !== false) {
        // Devolver el estado como "ACTIVAR" o "DESACTIVAR"
        echo ($result['bomba_activa'] == 1) ? "ACTIVAR" : "DESACTIVAR";
    } else {
        echo "SIN_COMANDO"; // Si no hay registros
    }
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
