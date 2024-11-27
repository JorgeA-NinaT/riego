<?php
require_once 'includes/config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['manual'])) {
    $sql = "UPDATE lecturas SET bomba_activa = 1 WHERE id = (SELECT MAX(id) FROM lecturas)";
    if ($conn->query($sql) === TRUE) {
        echo "Registro actualizado exitosamente";
    } else {
        echo "Error al actualizar registro: " . $conn->error;
    }
}
?>