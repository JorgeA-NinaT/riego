<?php
session_start();

function login($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, nombre_usuario, contraseña, rol FROM usuarios WHERE nombre_usuario = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Simple password comparison without hashing
        if ($password === $row['contraseña']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['nombre_usuario'];
            $_SESSION['role'] = $row['rol'];
            return true;
        }
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function requireAdmin() {
    requireLogin();
    if ($_SESSION['role'] !== 'admin') {
        die("Access Denied");
    }
}
?>