<?php
require_once 'config.php';

$stmt = $pdo->prepare("
SELECT 
    s.titulo, 
    s.artista, 
    s.bg_image, 
    s.start_datetime, 
    s.ubicacion,
    v.image AS venue_image
FROM shows s
LEFT JOIN venues v ON s.ubicacion = v.name
WHERE s.start_datetime >= NOW()
ORDER BY s.start_datetime
LIMIT 1
");
$stmt->execute();
$event = $stmt->fetch();

// Si no existe imagen para la ubicación en venues, fallback:
if (empty($event['venue_image'])) {
    $event['venue_image'] = 'https://tudominio.com/media/ubicaciones/default.jpg';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Festival Clásico Andaluz – Newsletter</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        .btn-eventos {
            background-color: #6366f1;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .btn-eventos:hover {
            background-color: #4f46e5;
        }
    </style>
</head>
<body style="margin:0;padding:0;background:#f5f5f5;
            font-family:Arial,sans-serif;color:#1a1a2e;
            display:flex;justify-content:center;">

    <table width="600" cellspacing="0" cellpadding="0" border="0"
            style="background:#fff;border-radius:8px;overflow:hidden;
                    margin:20px 0;">
        <!-- Cabecera con logo -->
        <tr>
            <td align="center" style="background:#1a1a2e;padding:20px;">
                <img src="media/patrocina/logo_fest_final.svg"
                    alt="Festival Clásico Andaluz" width="50px"
                    style="display:block;">
            </td>
        </tr>

        <!-- Próximo evento -->
        <tr>
            <td style="padding:15px 20px;">
                <h2 style="margin:0 0 10px;font-size:20px;color:#1a1a2e;text-align:center;">
                    Próximo evento
                </h2>
                <img src="<?=htmlspecialchars($event['bg_image'], ENT_QUOTES)?>"
                    alt="<?=htmlspecialchars($event['titulo'], ENT_QUOTES)?>"
                    width="50%"
                    style="border-radius:6px;display:block;margin:0 auto 10px;">
                <p style="margin:0;font-size:16px;font-weight:bold;color:#1a1a2e;text-align:center;">
                    <?=htmlspecialchars($event['titulo'], ENT_QUOTES)?>
                </p>
                <p style="margin:4px 0;font-size:14px;color:#4a4a6a;text-align:center;">
                    <?=htmlspecialchars($event['artista'], ENT_QUOTES)?> •
                <time datetime="<?=date('Y-m-d', strtotime($event['start_datetime']))?>">
                    <?=date('d M, Y • H:i', strtotime($event['start_datetime']))?>
                </time>
                </p>
            </td>
        </tr>

        <!-- Botón ver más -->
        <tr>
            <td align="center" style="padding:0 20px 30px;">
                <a href="eventos.php" class="btn-eventos">
                    Ver todos los eventos
                </a>
            </td>
        </tr>

        <!-- Ubicación del próximo evento -->
        <tr>
            <td align="center" style="padding:15px 20px 30px;">
                <h2 style="margin:0 0 8px;font-size:20px;color:#1a1a2e;">Ubicación</h2>
                <p style="margin:0 0 10px;font-size:14px;color:#4a4a6a;">
                    <?=htmlspecialchars($event['ubicacion'], ENT_QUOTES)?>
                </p>
                <img src="<?=htmlspecialchars($event['venue_image'], ENT_QUOTES)?>"
                    alt="<?=htmlspecialchars($event['ubicacion'], ENT_QUOTES)?>"
                    width="100%"
                    style="max-width:360px;height:200px;border-radius:6px;display:block;margin:0 auto;">
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center"
                style="background:#ececec;padding:12px;font-size:12px;color:#666;">
                © 2025 Festival Clásico Andaluz<br>
                Si no deseas recibir más emails,
                <a href="%%unsubscribe%%" style="color:#5d3fd3;text-decoration:none;">
                    darse de baja
                </a>.
            </td>
        </tr>
    </table>
</body>
</html>
