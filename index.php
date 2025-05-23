<?php
    require_once 'config.php';

    // Obtenemos los 3 (limit 3) siguientes eventos por fecha
    $stmt = $pdo->prepare("
        SELECT titulo, artista, bg_image, start_datetime
        FROM shows
        WHERE start_datetime >= NOW()
        ORDER BY start_datetime
        LIMIT 3
    ");
    $stmt->execute();
    $events = $stmt->fetchAll();

    // Obtenemos las ubicaciones desde la base de datos
    $stmt   = $pdo->query("SELECT name, image, map_link FROM venues ORDER BY name");
    $venues = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/index-style.css">
    <link rel="stylesheet" href="style/header-style.css">
    <link rel="stylesheet" href="style/footer-style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="carousel.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="animacionUbicaciones.js"></script>
    <title>Festival Clásico Andaluz</title>
</head>
<body>
    <!-- Header -->
    <?php
        include 'header.php';
    ?>


    <!-- Hero -->
    <section class="hero">
        <div class="hero_overlay"></div>
        <div class="hero_content">
            <!-- Título -->
            <h1 class="hero_title">
                Festival Clásico Andaluz
            </h1>

            <!-- Subtítulo -->
            <p class="hero_subtitle">
                Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo.
            </p>

            <!-- Botón único -->
            <a href="eventos.php#eventos" class="hero_button">
                Comprar entradas
            </a>
        </div>
    </section>


    <!-- Eventos -->
    <section class="events-section">
        <div class="events-header">
            <h2>Próximos eventos</h2>
            <p>Descubre nuestras actividades y no te pierdas nada.</p>
        </div>
      
        <!-- Carrusel -->
        <div class="carousel-container">
            <button class="carousel-btn prev">&larr;</button>
            <div class="carousel-track-wrapper">
            <div class="carousel-track">
                <?php foreach ($events as $event): ?>
                <article class="event-card">
                <img 
                    src="<?= htmlspecialchars($event['bg_image'], ENT_QUOTES) ?>" 
                    alt="Imagen de <?= htmlspecialchars($event['titulo'], ENT_QUOTES) ?>"
                >
                <div class="event-content">
                    <div class="event-meta">
                        <time 
                            datetime="<?= date('Y-m-d', strtotime($event['start_datetime'])) ?>"
                        >
                            <?= date('d M, Y', strtotime($event['start_datetime'])) ?>
                        </time>
                    </div>
                    <h3 class="event-title">
                    <?= htmlspecialchars($event['titulo'], ENT_QUOTES) ?>
                    </h3>
                    <div class="name">
                        <?= htmlspecialchars($event['artista'], ENT_QUOTES) ?>
                    </div>
                </div>
                </article>
                <?php endforeach; ?>
                </div>
            </div>
            <button class="carousel-btn next">&rarr;</button>
        </div>
        <div class="all-events">
            <a href="eventos.php">Ver todos los eventos</a>
        </div>
    </section>


    <!-- Ubicaciones -->
    <section class="ubications">
        <div class="ubications-header">
            <h2>Ubicaciones</h2>
            <p>Conoce la ubicación de nuestros espectáculos.</p>
        </div>
        <div class="ubications-list">
            <?php foreach ($venues as $venue): ?>
            <div class="ubication">
                <a href="<?= htmlspecialchars($venue['map_link'], ENT_QUOTES) ?>" target="_blank">
                    <img
                        src="<?= htmlspecialchars($venue['image'], ENT_QUOTES) ?>"
                        alt="<?= htmlspecialchars($venue['name'], ENT_QUOTES) ?>"
                    >
                    <h3><?= htmlspecialchars($venue['name'], ENT_QUOTES) ?></h3>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
      
      
    <!-- Patrocinadores -->
    <section class="sponsors">
        <article class="patrocinio">
            <h2>Patrocinadores</h2>
            <ul>
                <li>
                    <a href="https://www.europafm.com/" target="_blank">
                        <img src="media/patrocina/europa-fm-g.svg" alt="logo sponsor">
                    </a>
                </li>
                <li>
                    <a href="https://www.juntadeandalucia.es/" target="_blank">
                        <img src="media/patrocina/logo-andalucia-tierra-festivales.svg" alt="logo sponsor">
                    </a>
                </li>
                <li>
                    <a href="https://www.apple.com/es/" target="_blank">
                        <img src="media/patrocina/apple-11.svg" alt="logo sponsor">
                    </a>
                </li>
                <li>
                    <a href="https://www.cervezavictoria.es/es" target="_blank">
                        <img src="media/patrocina/victoria-cerveza-g.svg" alt="logo sponsor">
                    </a>
                </li>
                <li>
                    <a href="https://www.diariosur.es/" target="_blank">
                        <img src="media/patrocina/sur-logo-g.svg" alt="logo sponsor">
                    </a>
                </li>
            </ul>
        </article>

        <article class="ben&org">
            <div class="organizador">
                <h2>Organizador</h2>
                <ul>
                    <li>
                        <img src="media/patrocina/logo_fest_final.svg" alt="logo festival">
                    </li>
                </ul>
            </div>
            <div class="beneficio">
                <h2>Beneficiario</h2>
                <ul>
                    <li>
                        <a href="https://www.juegaterapia.org/" target="_blank">
                            <img src="media//patrocina/juegaterapia.svg" alt="logo juegaterapia">
                        </a>
                    </li>
                </ul>
            </div>
        </article>
    </section>
    

    <!-- Footer-->
    <?php
        include 'footer.php';
    ?>
</body>
</html>