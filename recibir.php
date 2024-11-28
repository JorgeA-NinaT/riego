<!DOCTYPE html>
<html>
<body>
    <h1>Datos Recibidos</h1>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $valor = $_POST['valor'];
        echo "<p>Valor recibido: <strong>" . htmlspecialchars($valor) . "</strong></p>";
        date_default_timezone_set('America/La_Paz');
        echo "<p>Fecha y hora: " . date('Y-m-d H:i:s') . "</p>";
    } else {
        echo "<p>No se han recibido datos</p>";
    }
    ?>
</body>
</html>