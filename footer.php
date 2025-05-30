<!-- NEWSLETTER -->
<?php
require_once 'config.php';

$success = '';
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Validar email
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $error = 'Por favor introduce un email válido.';
    } else {
        // 2) Comprobar si ya existe
        $stmt = $pdo->prepare("SELECT * FROM subscribers WHERE email = ?");
        $stmt->execute([$email]);
        $sub = $stmt->fetch();

        if (!$sub) {
            // Nuevo suscriptor -> insert + generar token
            $token = bin2hex(random_bytes(32));
            $ins = $pdo->prepare("
                INSERT INTO subscribers (email, confirmation_token)
                VALUES (:email, :token)
            ");
            $ins->execute(['email' => $email, 'token' => $token]);
        } elseif (!$sub['is_confirmed']) {
            // Ya existe pero no confirmado -> reusar o regenerar token
            $token = $sub['confirmation_token']
                   ?: bin2hex(random_bytes(32));
            if (!$sub['confirmation_token']) {
                $pdo->prepare("
                    UPDATE subscribers
                    SET confirmation_token = ?
                    WHERE id = ?
                ")->execute([$token, $sub['id']]);
            }
        } else {
            // Ya existe y confirmado
            $error = 'Esta dirección ya está suscrita.';
        }
    }

    // 3) Si no hay error, enviamos el email de confirmación
    if (!$error) {
        // Apunta a tu servidor local
        $confirmLink = sprintf(
            'http://localhost:8000/confirm.php?token=%s',
            $token
        );
        $subject = 'Confirma tu suscripción al Festival Clásico Andaluz';
        $message = "¡Hola!\n\n"
                 . "Para completar tu suscripción, haz clic en este enlace:\n\n"
                 . $confirmLink . "\n\n"
                 . "Si no fuiste tú, ignora este mensaje.";
        // From local
        $headers = "From: no-reply@localhost\r\n"
                 . "Content-Type: text/plain; charset=UTF-8";

        // Parámetro -f para envelope-from
        $params = '-fno-reply@localhost';

        if (mail($email, $subject, $message, $headers, $params)) {
            $success = '¡Gracias! Revisa tu email para confirmar tu suscripción.';
        } else {
            $error = 'Error enviando el email de confirmación. Inténtalo de nuevo más tarde.';
        }
    }
}
?>


<!-- Footer-->
<footer class="footer">
    <div class="footer-container">
        <!-- Top: logo + links -->
        <div class="footer-top">
            <div class="footer-logo">
                <img src="media/patrocina/logo_fest_final blanco.svg" alt="Logo">
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="legales.php#aviso">Aviso legal</a></li>
                        <li><a href="legales.php#cookies">Política de cookies</a></li>
                        <li><a href="legales.php#privacidad">Política de privacidad</a></li>
                    </ul>
                </div>
            </div>
        </div>
    
        <hr class="footer-divider">

        <!-- Newsletter -->
        <div class="footer-newsletter">
            <div class="newsletter-text">
                <h3>Suscríbete a nuestra Newsletter</h3>
                <p>Próximos eventos y recursos.</p>
            </div>

            <?php if ($success): ?>
                <p class="newsletter-success"><?= $success ?></p>
            <?php elseif ($error): ?>
                <p class="newsletter-error"><?= $error ?></p>
            <?php endif; ?>

            <form class="newsletter-form" method="post" action="">
                <input
                    type="email"
                    name="email"
                    placeholder="Email"
                    required
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                >
                <button type="submit">Suscríbete</button>
            </form>
        </div>

        <hr class="footer-divider">
    
        <!-- Bottom: copyright + social -->
        <div class="footer-bottom">
            <p>© 2025 Festival Clásico Andaluz, todos los derechos reservados.</p>
            <ul class="social-icons">
            <li><a href="https://www.facebook.com/" target="_blank"><img src="media/patrocina/facebook-2020-1-1.svg" alt="Facebook"></a></li>
                    <li><a href="https://www.instagram.com/" target="_blank"><img src="media/patrocina/instagram-2016-5.svg" alt="Instagram"></a></li>
                    <li><a href="https://x.com/" target="_blank"><img src="media/patrocina/x_white.svg" alt="X"></a></li>
                    <li><a href="https://www.youtube.com/" target="_blank"><img src="media/patrocina/youtube-icon-5.svg" alt="YouTube"></a></li>
            </ul>
        </div>
    </div>
</footer>


<!-- COOKIES -->
<script>
    function setCookie(name, value, days) {
        const expires = new Date(Date.now() + days*864e5).toUTCString();
        document.cookie = name + '=' + value + '; expires=' + expires + '; path=/';
    }
    function getCookie(name) {
        return document.cookie.split('; ').reduce((r, v) => {
            const parts = v.split('=');
            return parts[0] === name ? decodeURIComponent(parts[1]) : r
        }, '');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const banner = document.getElementById('cookie-banner');
        if (!banner) return;

        document.getElementById('accept-cookies').addEventListener('click', () => {
            setCookie('site_consent', 'yes', 365);
            banner.remove();
            // Recarga la página para que header.php detecte el cambio y cargue GA
            location.reload();
        });
        document.getElementById('reject-cookies').addEventListener('click', () => {
            setCookie('site_consent', 'no', 365);
            banner.remove();
        });
    });
</script>