<?php
    // Comprueba si ya existe la cookie 'site_consent'
    $consent = $_COOKIE['site_consent'] ?? null;

    if ($consent === 'yes'): ?>
    <!-- scripts de Analytics solo si el usuario acepta -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=TU-ID-GA"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'TU-ID-GA');
    </script>
<?php endif;
// BANNER DE COOKIES
if ($consent !== 'yes' && $consent !== 'no'): ?>
<div id="cookie-banner" class="cookie-banner">
    <p>Usamos cookies propias y de terceros para mejorar tu experiencia.</p>
    <button id="accept-cookies">Aceptar</button>
    <button id="reject-cookies">Rechazar</button>
</div>
<?php endif; ?>

<!-- Header -->
<header class="header">
    <div class="container">
        <div class="inner">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <img src="media/patrocina/logo_fest_final.svg" alt="Logo">
            </a>
    
            <!-- Enlaces -->
            <div class="nav-links">
                <a href="index.php">Inicio</a>
                <a href="eventos.php">Eventos</a>
                <a href="legales.php">Legales</a>
                <a href="eventos.php#eventos">Comprar entradas</a>
            </div>
        </div>
    </div>
</header>
