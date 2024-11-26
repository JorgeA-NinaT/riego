<?php
// Incluir configuración y autenticación
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Verificar que el usuario esté autenticado
requireLogin();

// Establecer la cantidad de registros por página
$registrosPorPagina = 25;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina - 1) * $registrosPorPagina;

// Consultar las tablas
// Consulta de lecturas de sensores con paginación
$queryLecturas = "SELECT * FROM lecturas ORDER BY fecha_hora DESC LIMIT $registrosPorPagina OFFSET $offset";
$resultLecturas = $conn->query($queryLecturas);

// Consulta del estado de la bomba con paginación
$queryEstadoBomba = "SELECT * FROM estado_bomba ORDER BY fecha_hora DESC LIMIT $registrosPorPagina OFFSET $offset";
$resultEstadoBomba = $conn->query($queryEstadoBomba);

// Consulta de comandos pendientes con paginación
$queryComandos = "SELECT * FROM comandos ORDER BY fecha_hora DESC LIMIT $registrosPorPagina OFFSET $offset";
$resultComandos = $conn->query($queryComandos);

// Obtener el número total de registros para paginación
$totalLecturas = $conn->query("SELECT COUNT(*) AS total FROM lecturas")->fetch_assoc()['total'];
$totalEstadoBomba = $conn->query("SELECT COUNT(*) AS total FROM estado_bomba")->fetch_assoc()['total'];
$totalComandos = $conn->query("SELECT COUNT(*) AS total FROM comandos")->fetch_assoc()['total'];

// Calcular el número total de páginas
$totalPaginasLecturas = ceil($totalLecturas / $registrosPorPagina);
$totalPaginasEstadoBomba = ceil($totalEstadoBomba / $registrosPorPagina);
$totalPaginasComandos = ceil($totalComandos / $registrosPorPagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Monitoreo - Sistema de Riego</title>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
    label {
        font-weight: bold;
    }
    input, button {
        padding: 8px 12px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    button {
        background-color: #28a745;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    button:hover {
        background-color: #218838;
    }
</style>
</head>
<body>
<?php include 'partials/header.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center mb-4">Monitoreo del Sistema de Riego</h1>
        
        <!-- Tabla de Lecturas -->
        <h3>Lecturas de Sensores</h3>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Temperatura</th>
                    <th>Humedad del Suelo</th>
                    <th>Bomba Activa</th>
                    <th>Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultLecturas && $resultLecturas->num_rows > 0): ?>
                    <?php while ($row = $resultLecturas->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['temperatura']) ?>°C</td>
                            <td><?= htmlspecialchars($row['humedad_suelo']) ?>%</td>
                            <td><?= $row['bomba_activa'] ? 'Sí' : 'No' ?></td>
                            <td><?= htmlspecialchars($row['fecha_hora']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay datos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Paginación de Lecturas -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($pagina <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=1">Primera</a>
                </li>
                <li class="page-item <?= ($pagina <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                </li>
                <li class="page-item <?= ($pagina >= $totalPaginasLecturas) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                </li>
                <li class="page-item <?= ($pagina >= $totalPaginasLecturas) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $totalPaginasLecturas ?>">Última</a>
                </li>
            </ul>
        </nav>

        <!-- Botones de acción -->
        <div class="text-center mb-4">
            <form action="generar_pdf.php" method="GET">
                <input type="hidden" name="tipo" value="promedio">
                <label for="fecha_inicio">Fecha Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
                <label for="fecha_fin">Fecha Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required>
                <button type="submit">Reporte Promedio</button>
            </form>
            <button class="btn btn-primary" onclick="window.location.reload();">Actualizar Página</button>
            <button class="btn btn-success" onclick="generarReporte('general');">Reporte General</button>
            <button class="btn btn-info" onclick="generarReporte('bomba_activa');">Reporte Bombas Activas</button>
            
            <form action="monitoreo.php" method="POST">
                <input type="hidden" name="eliminar_lecturas" value="true">
                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar todos los registros de lecturas?')">Eliminar Todos los Registros</button>
            </form>
        </div>
        <script>
            // Función para generar reportes específicos
            function generarReporte(tipo) {
                let url = `generar_pdf.php?tipo=${tipo}`;
                if (tipo === 'promedio') {
                    const fechaInicio = prompt('Ingrese la fecha de inicio (YYYY-MM-DD):');
                    const fechaFin = prompt('Ingrese la fecha de fin (YYYY-MM-DD):');
                    if (fechaInicio && fechaFin) {
                        url += `&fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`;
                    } else {
                        alert('Debe ingresar ambas fechas.');
                        return;
                    }
                }
                window.location.href = url; // Redirigir al script PHP para generar el PDF
            }
        </script>
    <?php include 'partials/footer.html'; ?>
</body>
</html>
