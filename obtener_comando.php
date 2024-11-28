<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['manual'])) {
    try {
        $sql = "UPDATE lecturas 
                SET bomba_activa = 1 
                WHERE id = (SELECT MAX(id) FROM lecturas)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        echo "Registro actualizado exitosamente";
    } catch (PDOException $e) {
        echo "Error al actualizar registro: " . $e->getMessage();
    }
} else {
    echo "Solicitud no válida.";
}
?>
