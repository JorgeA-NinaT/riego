<?php
require_once 'includes/config.php';

try {
    // Consultar el estado más reciente de la bomba
    $sql = "SELECT bomba_activa FROM lecturas ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Determinar el comando basado en el estado de la bomba
        $comando = $result['bomba_activa'] ? "ACTIVAR" : "DESACTIVAR";
        echo $comando;
    } else {
        echo "SIN_COMANDO"; // En caso de no encontrar registros
    }
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
