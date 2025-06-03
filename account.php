<?php
require_once 'config.php';

// 1. Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php?error=' . urlencode('Debes iniciar sesión para ver tu cuenta.'));
    exit;
}

// 2. Obtener datos básicos del usuario
$stmt = $pdo->prepare("SELECT nombre, email, created_at FROM users WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

// 3. Obtener historial de pedidos del usuario (JOIN con shows)
$stmt = $pdo->prepare("
    SELECT 
        o.id AS order_id,
        o.quantity,
        o.amount,
        o.status,
        o.created_at AS order_date,
        s.titulo,
        s.start_datetime
    FROM orders o
    JOIN shows s ON o.show_id = s.id
    WHERE o.user_id = :uid
    ORDER BY o.created_at DESC
");
$stmt->execute(['uid' => $_SESSION['user_id']]);
$ordenes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style/index-style.css" />
  <link rel="stylesheet" href="style/header-style.css" />
  <link rel="stylesheet" href="style/footer-style.css" />
  <link rel="stylesheet" href="style/account-style.css" />
  <script src="modalQR.js"></script>
  <link rel="icon" type="image/svg+xml" href="media/favicon/favicon.svg" />
  <title>Festival Clásico Andaluz</title>
</head>
<body>
  <!-- Header -->
  <?php include 'header.php'; ?>

  <main class="account-container">
    <!-- Sección: Datos de la cuenta -->
    <section class="account-info">
      <h1>Bienvenid@, <?= htmlspecialchars($user['nombre']) ?></h1>
      <h2>Datos de tu cuenta</h2>
      <ul>
        <li><strong>Nombre:</strong> <?= htmlspecialchars($user['nombre']) ?></li>
        <li><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
        <li><strong>Registrado el:</strong> <?= date('d/m/Y', strtotime($user['created_at'])) ?></li>
      </ul>
      <form action="logout.php" method="POST" class="logout-form">
        <button type="submit" class="btn logout-button">Cerrar sesión</button>
      </form>
    </section>

    <!-- Sección: Historial de pedidos -->
    <section class="order-history">
      <h2>Historial de Pedidos</h2>

      <?php if (empty($ordenes)): ?>
        <p>No tienes pedidos realizados hasta el momento.</p>
      <?php else: ?>
        <table class="orders-table">
          <thead>
            <tr>
              <th>Espectáculo</th>
              <th>Fecha del Evento</th>
              <th>Cantidad</th>
              <th>Importe (€)</th>
              <th>Fecha de Compra</th>
              <th>Ticket</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($ordenes as $o): ?>
              <tr>
                <td><?= htmlspecialchars($o['titulo']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($o['start_datetime'])) ?></td>
                <td><?= htmlspecialchars($o['quantity']) ?></td>
                <td><?= number_format($o['amount'], 2, ',', '.') ?></td>
                <td><?= date('d/m/Y H:i', strtotime($o['order_date'])) ?></td>
                <td>
                  <!-- Botón para abrir el modal QR, guardamos order_id en data-attribute -->
                  <button class="qr-button" data-order-id="<?= htmlspecialchars($o['order_id']) ?>">
                    Ver QR
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </section>
  </main>

  <!-- Modal de QR -->
  <div id="qrModal" class="qr-modal-overlay">
    <div class="qr-modal">
      <button class="qr-modal-close">&times;</button>
      <h3>Código QR de tu entrada</h3>
      <img id="qrImage" class="qr-code-img" src="" alt="Código QR">
    </div>
  </div>

  <!-- Footer -->
  <?php include 'footer.php'; ?>
</body>
</html>
