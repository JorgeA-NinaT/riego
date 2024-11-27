<?php
require_once 'includes/config.php'; // Conexión a la base de datos
require_once 'includes/auth.php';   // Verifica si el usuario está autenticado

requireAdmin(); // Asegura que solo los administradores accedan

// Manejo de acciones (agregar, editar, eliminar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            // Agregar usuario
            $username = $_POST['nombre_usuario'];
            $password = $_POST['contraseña'];
            $role = $_POST['rol'];

            $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, contraseña, rol) VALUES (:username, :password, :role)");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
        } elseif ($action === 'edit') {
            // Editar usuario
            $id = $_POST['id'];
            $username = $_POST['nombre_usuario'];
            $password = $_POST['contraseña'];
            $role = $_POST['rol'];

            $stmt = $conn->prepare("UPDATE usuarios SET nombre_usuario = :username, contraseña = :password, rol = :role WHERE id = :id");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':role', $role, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } elseif ($action === 'delete') {
            // Eliminar usuario
            $id = $_POST['id'];

            $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
}

// Obtener todos los usuarios para mostrarlos
$stmt = $conn->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Cambiado de fetch_all()
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body >
    <!-- Header -->
    <?php include 'partials/header.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestión de Usuarios</h1>

        <!-- Formulario de Agregar Usuario -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5>Agregar Usuario</h5>
            </div>
            <div class="card-body">
                <form method="post" class="row g-3">
                    <input type="hidden" name="action" value="add">
                    <div class="col-md-4">
                        <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                        <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" placeholder="Ingrese nombre" required>
                    </div>
                    <div class="col-md-4">
                        <label for="contraseña" class="form-label">Contraseña</label>
                        <input type="text" id="contraseña" name="contraseña" class="form-control" placeholder="Ingrese contraseña" required>
                    </div>
                    <div class="col-md-4">
                        <label for="rol" class="form-label">Rol</label>
                        <select id="rol" name="rol" class="form-select" required>
                            <option value="user">Usuario</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">Agregar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5>Lista de Usuarios</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre de Usuario</th>
                            <th>Contraseña</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario) : ?>
                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td><?php echo $usuario['nombre_usuario']; ?></td>
                                <td><?php echo $usuario['contraseña']; ?></td>
                                <td><?php echo $usuario['rol']; ?></td>
                                <td>
                                    <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <form action="crud.php" method="POST" class="d-inline">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'partials/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
