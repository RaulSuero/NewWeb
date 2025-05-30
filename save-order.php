<?php
header('Content-Type: application/json');

// Leer el cuerpo de la petición
$input = file_get_contents('php://input');
$data  = json_decode($input, true);

// Validaciones básicas
if (
    empty($data['order_id']) ||
    empty($data['payer_id']) ||
    empty($data['show_id']) ||
    empty($data['quantity']) ||
    empty($data['amount']) ||
    empty($data['currency']) ||
    empty($data['status'])
) {
    http_response_code(400);
    echo json_encode([
        'ok'    => false,
        'error' => 'Datos incompletos'
    ]);
    exit;
}

// Conexión a la base de datos
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=festival_clasico_andaluz;charset=utf8mb4',
        'root',
        'root',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'ok'    => false,
        'error' => 'Error de conexión a la base de datos'
    ]);
    exit;
}

// Preparar e insertar, ignorando duplicados por order_id
$sql = "
    INSERT IGNORE INTO orders
      (order_id, payer_id, show_id, quantity, amount, currency, status)
    VALUES
      (:order_id, :payer_id, :show_id, :quantity, :amount, :currency, :status)
";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':order_id'  => $data['order_id'],
        ':payer_id'  => $data['payer_id'],
        ':show_id'   => $data['show_id'],
        ':quantity'  => $data['quantity'],
        ':amount'    => $data['amount'],
        ':currency'  => $data['currency'],
        ':status'    => $data['status'],
    ]);

    echo json_encode(['ok' => true]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'ok'    => false,
        'error' => 'Error al guardar la orden: ' . $e->getMessage()
    ]);
}
