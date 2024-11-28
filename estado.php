<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Ensure only authenticated users can access
requireLogin();

// File to store the current command
$command_file = 'data/current_command.txt';

// Ensure data directory exists
if (!file_exists('data')) {
    mkdir('data', 0755, true);
}

// Handle different HTTP methods
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // When ESP32 requests the current command
    if (file_exists($command_file)) {
        $current_command = trim(file_get_contents($command_file));
        echo $current_command;
        
        // Reset command after reading to prevent repeated execution
        file_put_contents($command_file, '');
        exit;
    } else {
        echo '';  // No command
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // When dashboard sends a new command
    if (isset($_POST['comando'])) {
        $comando = $_POST['comando'];
        
        // Validate command
        if (in_array($comando, ['ACTIVAR', 'DESACTIVAR'])) {
            // Store command in file for ESP32 to read
            file_put_contents($command_file, $comando);
            echo 'Comando guardado: ' . $comando;
        } else {
            http_response_code(400);
            echo 'Comando inválido';
        }
        exit;
    } else {
        http_response_code(400);
        echo 'No se proporcionó comando';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Riego Automatizado</title>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Estilos anteriores se mantienen igual */
    </style>
</head>
<body>
<?php include 'partials/header.php'; ?>
<div class="container-fluid">
    <div class="main-container">
        <div class="control-container">
            <div class="h1-container">
                <h1 class="h2">Control de Bomba de Agua</h1>
            </div>

            <div class="estado-bomba mb-4">
                <h4>Estado de la Bomba</h4>
                <p id="estado-bomba">Cargando...</p>
                <div id="circle-progress" class="progress-circle">0%</div>
            </div>

            <div class="botones-control">
                <button onclick="enviarComando('ACTIVAR')" class="btn btn-lg btn-success">
                    Activar Bomba
                </button>
                <button onclick="enviarComando('DESACTIVAR')" class="btn btn-lg btn-danger">
                    Desactivar Bomba
                </button>
            </div>
        </div>

        <!-- Nueva sección de activación manual -->
        <div class="control-container">
            <h4>Activación Manual de la Bomba</h4>
            <button onclick="activarManual()" class="btn btn-lg btn-primary">
                Activar Manualmente
            </button>
        </div>
    </div>
</div>


    <script>
    function enviarComando(comando) {
        fetch('estado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'comando=' + comando
        })
        .then(response => response.text())
        .then(data => {
            alert('Comando ' + comando + ' enviado');
            actualizarEstado();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function actualizarEstado() {
        fetch('get_latest_data.php')
            .then(response => response.json())
            .then(data => {
                const estadoBomba = document.getElementById('estado-bomba');
                const circleProgress = document.getElementById('circle-progress');
                
                if (data.bomba_activa) {
                    estadoBomba.textContent = 'Bomba Activa';
                    estadoBomba.style.color = '#28a745';
                    circleProgress.style.background = 'conic-gradient(#28a745 0% 100%)';
                    circleProgress.textContent = 'Encendido';
                } else {
                    estadoBomba.textContent = 'Bomba Inactiva';
                    estadoBomba.style.color = '#dc3545';
                    circleProgress.style.background = 'conic-gradient(#dc3545 0% 100%)';
                    circleProgress.textContent = 'Apagado';
                }
            })
            .catch(error => {
                console.error('Error al obtener el estado:', error);
            });
    }

    function activarManual() {
        fetch('activar_manual.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'manual=true'
        })
        .then(response => response.text())
        .then(data => {
            alert('Bomba activada manualmente');
            actualizarEstado();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    setInterval(actualizarEstado, 5000);
    actualizarEstado();
</script>

<?php include 'partials/footer.html'; ?>
</body>
</html>


