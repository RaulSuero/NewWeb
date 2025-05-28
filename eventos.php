<?php
    require_once 'config.php';

    // 1) Preparamos y ejecutamos la consulta
    $stmt = $pdo->query("SELECT * FROM shows ORDER BY start_datetime");

    // 2) Obtenemos todos los registros
    $shows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/eventos-style.css">
    <link rel="stylesheet" href="style/header-style.css">
    <link rel="stylesheet" href="style/footer-style.css">
    <link rel="stylesheet" href="style/modal-style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="animacionTarjetas.js"></script>
    <script src="buscador.js"></script>
    <script src="modal.js"></script>
    <script src="modalPaypal.js"></script>
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
                Eventos 2025
            </h1>

            <!-- Subtítulo -->
            <p class="hero_subtitle">
                Infórmate y compra tu entrada.
            </p>
        </div>
    </section>


    <!-- Eventos -->
    <section class="grid-wrapper" id="eventos">
        <!-- Buscador -->
        <div class="search-container">
            <input
                type="search"
                id="event-search"
                placeholder="Buscar evento…"
                aria-label="Buscar evento"
            >

            <input
                type="date"
                id="date-filter"
                aria-label="Filtrar por fecha"
            >

            <button type="button" id="clear-filters" class="clear-button">Limpiar</button>
        </div>

        <div class="grid-container">
            <?php foreach ($shows as $show): ?>
            <div
                class="card"
                style="background-image: url('<?= htmlspecialchars($show['bg_image'], ENT_QUOTES) ?>')"
                data-title="<?= htmlspecialchars($show['titulo'], ENT_QUOTES) ?>"
                data-subtitle="<?= htmlspecialchars($show['artista'], ENT_QUOTES) ?>"
                data-location="<?= htmlspecialchars($show['ubicacion'], ENT_QUOTES) ?>"
                data-datetime="<?= date('d/m/Y H:i', strtotime($show['start_datetime'])) ?>"
                data-description="<?= nl2br(htmlspecialchars($show['descripcion'], ENT_QUOTES)) ?>"
                data-image="<?= htmlspecialchars($show['info_image'], ENT_QUOTES) ?>"
                data-price="<?= number_format($show['precio'], 2, '.', '') ?>"
            >
                <div class="card-text">
                    <h3 class="card-name"><?= htmlspecialchars($show['titulo'], ENT_QUOTES) ?></h3>
                    <p class="card-role">
                        <?= htmlspecialchars($show['ubicacion'], ENT_QUOTES) ?>
                        <?= date('d/m/Y H:i', strtotime($show['start_datetime'])) ?>
                    </p>
                </div>
                <div class="card-actions">
                    <button type="button" class="info_button">Información</button>
                    <button
                        type="button"
                        class="buy_button"
                        data-price="<?= number_format($show['precio'], 2, '.', '') ?>"
                    >Comprar</button>
                </div>
            </div>
            <?php endforeach; ?>
        
        </div>
        <div class="back-to-top">
            <a href="#eventos">Volver arriba</a>
        </div>
    </section>


    <!-- Modal informacion-->
    <div id="event-modal" class="modal-overlay" hidden>
        <div class="modal">
            <button class="modal-close">&times;</button>
            <div class="modal-content">
                <div class="modal-image-container">
                    <img src="" alt="" class="modal-image">
                </div>
                <div class="modal-details">
                    <h2 class="modal-title"></h2>
                    <p class="modal-subtitle"></p>
            
                    <div class="modal-meta">
                        <span class="modal-location"></span>
                        <span class="modal-datetime"></span>
                    </div>

                    <p class="modal-description"></p>

                    <p class="modal-price"></p>

                    <button class="modal-buy">Comprar</button>
                </div>
            </div>
        </div>
    </div>
      

    <!-- Modal PayPal -->
    <div id="paypalCheckoutModal" class="paypal-modal-overlay" hidden>
        <div class="paypal-modal">
            <button class="paypal-modal-close">&times;</button>
            <div class="paypal-modal-body">
                <!-- Selector de cantidad -->
                <div class="quantity-group">
                    <label for="paypal-quantity">Cantidad:</label>
                    <input type="number" id="paypal-quantity" min="1" value="1">
                </div>
                <!-- Contenedor del botón PayPal -->
                <div id="paypal-button-container-checkout"></div>
            </div>
        </div>
    </div>


    <!-- Footer-->
    <?php
        include 'footer.php';
    ?>


    <!-- paypal -->
    <!-- carga del SDK con tu Client-ID de Sandbox -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=ARLEHJk-zLao4Ee_VJ2srEY7AhcN2kNlIqB94OMLRNl7eAbgVhr0kAQA7KbqafVtirDgeEydIINMGv4U&currency=EUR"
        data-sdk-integration-source="button-factory">
    </script>


    <!-- retardo para scroll navbar comprar entradas -->
    <script>
        window.addEventListener('load', () => {
            if (location.hash === '#eventos') {
                const target = document.getElementById('eventos');

                if (target) {
                    // un retardo mínimo garantiza que todo el layout esté listo
                    setTimeout(() => {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }, 50);
                }
            }
        });
    </script>
        
</body>
</html>