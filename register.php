<?php
require_once 'config.php';

// Si ya hay sesión iniciada, redirige a la página principal
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Recoger posibles mensajes de error o éxito pasados por GET
$error   = $_GET['error']   ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style/header-style.css" />
  <link rel="stylesheet" href="style/footer-style.css" />
  <link rel="stylesheet" href="style/auth-style.css" />
  <link rel="icon" type="image/svg+xml" href="media/favicon/favicon.svg" />
  <title>Festival Clásico Andaluz</title>
</head>
<body>
  <!-- Header -->
  <?php include 'header.php'; ?>

  <!-- Contenedor centrado -->
  <main class="auth-container">
    <div class="login-box">
      <h2 class="auth-title">Registro de Usuario</h2>

      <!-- Mostrar mensajes -->
      <?php if ($error): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
      <?php elseif ($success): ?>
        <p class="success-message"><?= htmlspecialchars($success) ?></p>
      <?php endif; ?>

      <!-- Formulario de registro -->
      <form action="register-process.php" method="POST" class="login-form">
        <label for="nombre">Nombre Completo</label>
        <input
          type="text"
          id="nombre"
          name="nombre"
          placeholder="Nombre completo"
          required
        />

        <label for="email">Correo Electrónico</label>
        <input
          type="email"
          id="email"
          name="email"
          placeholder="tucorreo@ejemplo.com"
          required
        />

        <label for="password">Contraseña</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="********"
          required
        />

        <label for="password_confirm">Confirmar Contraseña</label>
        <input
          type="password"
          id="password_confirm"
          name="password_confirm"
          placeholder="Repetir contraseña"
          required
        />

        <button type="submit" class="btn auth-button">Registrar</button>
      </form>

      <p class="auth-footer-text">
        ¿Ya tienes cuenta?
        <a href="login.php" class="auth-link">Iniciar sesión</a>
      </p>
    </div>
  </main>

  <!-- Footer -->
  <?php include 'footer.php'; ?>
</body>
</html>
