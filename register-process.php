<?php
require_once 'config.php';

// Solo aceptar peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

// Recoger y sanear datos
$nombre           = trim($_POST['nombre'] ?? '');
$email            = trim($_POST['email'] ?? '');
$password         = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

// 1. Validar que los campos no estén vacíos
if (empty($nombre) || empty($email) || empty($password) || empty($password_confirm)) {
    $error = "Todos los campos son obligatorios.";
    header("Location: register.php?error=" . urlencode($error));
    exit;
}

// 2. Validar que las contraseñas coincidan
if ($password !== $password_confirm) {
    $error = "Las contraseñas no coinciden.";
    header("Location: register.php?error=" . urlencode($error));
    exit;
}

// 3. Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Formato de correo no válido.";
    header("Location: register.php?error=" . urlencode($error));
    exit;
}

// 4. Comprobar si el email ya existe en la base de datos
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
$stmt->execute(['email' => $email]);
if ($stmt->fetch()) {
    $error = "Este correo ya está registrado.";
    header("Location: register.php?error=" . urlencode($error));
    exit;
}

// 5. Hashear la contraseña con BCRYPT
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// 6. Insertar el nuevo usuario en la tabla 'users'
$stmt = $pdo->prepare("
    INSERT INTO users (nombre, email, password_hash)
    VALUES (:nombre, :email, :password_hash)
");

try {
    $stmt->execute([
        'nombre'        => $nombre,
        'email'         => $email,
        'password_hash' => $password_hash
    ]);
} catch (Exception $e) {
    $error = "Error al registrar el usuario. Intenta nuevamente más tarde.";
    header("Location: register.php?error=" . urlencode($error));
    exit;
}

// 7. Registro exitoso: iniciar sesión automáticamente
$newUserId = $pdo->lastInsertId();

// Guardar datos en la sesión
$_SESSION['user_id']   = $newUserId;
$_SESSION['user_name'] = $nombre;
$_SESSION['user_role'] = 'user';

// 8. Redirigir a la página principal (o a “Mi cuenta”)
header('Location: index.php');
exit;
