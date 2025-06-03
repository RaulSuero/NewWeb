<?php
    require_once 'config.php';
    if (isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit;
    }
    $error   = $_GET['error']   ?? '';
    $success = $_GET['success'] ?? '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style/index-style.css" />
    <link rel="stylesheet" href="style/header-style.css" />
    <link rel="stylesheet" href="style/footer-style.css" />
    <link rel="stylesheet" href="style/auth-style.css" />
    <link rel="icon" type="image/svg+xml" href="media/favicon/favicon.svg" />
    <title>Festival Clásico Andaluz</title>
</head>
<body>
    <!-- Header -->
    <?php include 'header.php'; ?>

    <main class="auth-container">
        <div class="login-box">
            <h2 class="auth-title">Iniciar Sesión</h2>

            <!-- Formulario de login -->
            <form action="login-process.php" method="POST" class="login-form">
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

                <button type="submit" class="btn auth-button">Entrar</button>
            </form>

            <p class="auth-footer-text">
                ¿No tienes cuenta?
                <a href="register.php" class="auth-link">Regístrate aquí</a>
            </p>
        </div>
    </main>

    <!-- Footer común -->
    <?php include 'footer.php'; ?>
</body>
</html>
