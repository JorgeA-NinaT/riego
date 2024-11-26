// conexion.php - Configuración de la conexión a la base de datos
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_riego";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>