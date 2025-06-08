<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']       ?? '';

    // Consulta al usuario en la base de datos
    $stmt = $pdo->prepare("
        SELECT id, nombre, password_hash
        FROM users
        WHERE email = :email
        LIMIT 1
    ");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Credenciales correctas
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        header('Location: index.php');
        exit;
    } else {
        // Usuario o contraseña incorrectos
        $error = "Correo o contraseña inválidos.";
        header("Location: login.php?error=" . urlencode($error));
        exit;
    }
}
