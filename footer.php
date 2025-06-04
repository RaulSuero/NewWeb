<!-- Footer-->
<footer class="footer">
    <div class="footer-container">
        <!-- Top: logo + links -->
        <div class="footer-top">
            <div class="footer-logo">
                <a href="index.php">
                    <img src="media/patrocina/logo_fest_final blanco.svg" alt="Logo">
                </a>
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h4><a href="legales.php">Legal</a></h4>
                    <ul>
                        <li><a href="legales.php#aviso">Aviso legal</a></li>
                        <li><a href="legales.php#cookies">Política de cookies</a></li>
                        <li><a href="legales.php#privacidad">Política de privacidad</a></li>
                    </ul>
                </div>
            </div>
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