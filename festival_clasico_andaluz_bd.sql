-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 04-06-2025 a las 10:21:22
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `festival_clasico_andaluz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int UNSIGNED NOT NULL,
  `order_id` varchar(64) NOT NULL,
  `payer_id` varchar(64) NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `show_id` int NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` char(3) NOT NULL,
  `status` varchar(32) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `payer_id`, `user_id`, `show_id`, `quantity`, `amount`, `currency`, `status`, `created_at`) VALUES
(1, '7JL76887414049638', '55QR3XJWRCWZ6', NULL, 3, 1, 20.00, 'EUR', 'COMPLETED', '2025-05-30 10:49:01'),
(2, '0BD53344B3675650U', '55QR3XJWRCWZ6', NULL, 4, 1, 12.00, 'EUR', 'COMPLETED', '2025-05-30 10:51:04'),
(3, '9SE95196MG430162Y', '55QR3XJWRCWZ6', NULL, 5, 1, 18.00, 'EUR', 'COMPLETED', '2025-05-30 11:33:56'),
(4, '9CX95648S6188833B', '55QR3XJWRCWZ6', NULL, 2, 2, 56.00, 'EUR', 'COMPLETED', '2025-06-03 10:37:57'),
(5, '0CV040529R5634309', '55QR3XJWRCWZ6', NULL, 8, 1, 30.00, 'EUR', 'COMPLETED', '2025-06-03 12:40:31'),
(6, '41L718996J505724H', '55QR3XJWRCWZ6', 1, 2, 1, 28.00, 'EUR', 'COMPLETED', '2025-06-03 12:51:17'),
(7, '50F02500GB669203S', '55QR3XJWRCWZ6', 1, 1, 1, 25.00, 'EUR', 'COMPLETED', '2025-06-03 16:47:31'),
(8, '06J34248MJ260984K', '55QR3XJWRCWZ6', 1, 3, 1, 20.00, 'EUR', 'COMPLETED', '2025-06-03 17:34:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shows`
--

CREATE TABLE `shows` (
  `id` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `artista` varchar(255) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `descripcion` text,
  `bg_image` varchar(255) DEFAULT NULL,
  `info_image` varchar(255) DEFAULT NULL,
  `precio` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `shows`
--

INSERT INTO `shows` (`id`, `titulo`, `artista`, `ubicacion`, `start_datetime`, `descripcion`, `bg_image`, `info_image`, `precio`) VALUES
(1, 'Lorca y la Pasión', 'Marina Heredia', 'Castillo Santa Catalina', '2025-06-18 22:30:00', 'Adéntrate en un viaje escénico apasionado donde Marina Heredia convierte la poesía de Federico García Lorca en pura emoción flamenca. Entre las piedras milenarias del Castillo de Santa Catalina, el cante y el baile se entrelazan con la fuerza dramática de los versos lorquianos, desatando el duende y el sentimiento más profundo de Andalucía. Una velada única que funde literatura, música y danza en un espectáculo lleno de intensidad y belleza.', 'media/lorca/lorcaGrid.jpg', 'media/lorca/lorca.jpg', 25.00),
(2, 'Ballet Flamenco de Andalucía', 'Instituto Andaluz del Flamenco', 'Castillo Santa Catalina', '2025-06-19 22:30:00', 'Sumérgete en la maestría y la pasión del Ballet Flamenco de Andalucía, la compañía oficial del Instituto Andaluz del Flamenco. Sobre el escenario mágico del Castillo de Santa Catalina, sus bailarines entrelazan la tradición más pura con coreografías renovadoras, creando un diálogo vibrante entre cuerpo y emoción. Cada zapateado, cada desplante y cada giro despliegan el duende y la elegancia de Andalucía, ofreciendo un espectáculo que celebra la riqueza cultural de nuestra tierra con ritmo, potencia y belleza.', 'media/balletFlamenco/balletGrid.jpg', 'media/balletFlamenco/ballet.jpg', 28.00),
(3, 'Pansequito', 'Pansequito', 'Castillo San Sebastián', '2025-06-20 21:30:00', 'Sumérgete en la esencia del cante flamenco más puro junto a José Cortés “Pansequito”, una leyenda viva que ha marcado generaciones con su voz cargada de duende. En el marco histórico del Castillo de San Sebastián, Pansequito despliega su maestría dominando tonás, seguiriyas y bulerías con una pasión visceral. Acompañado por la guitarra que acuna cada compás, su recital se convierte en un inolvidable ritual de emoción y autenticidad, un homenaje vibrante a la tradición andaluza.', 'media/pansequito/panseGrid.jpg', 'media/pansequito/panse.jpg', 20.00),
(4, 'Pase Modelo Amparo Macia', 'Amparo Macia', 'Parque Alameda', '2025-06-21 12:30:00', 'Descubre el arte del traje flamenco en movimiento con Amparo Macia, la musa que da vida a cada volante y bordado. Bajo la sombra de los naranjos del Parque Alameda, desfilará su última colección inspirada en la tradición andaluza, donde siluetas contemporáneas y tejidos clásicos se funden en un homenaje al color y la elegancia. Una pasarela única que celebra la fusión de moda y cultura, mostrando la fuerza, el ritmo y la gracia de la mujer flamenca.', 'media/amparo/amparoGrid.jpg', 'media/amparo/ampar.webp', 12.00),
(5, 'Cancanilla de Marbella', 'Cancanilla de Marbella', 'Castillo San Sebastián', '2025-06-21 21:30:00', 'Vive la fuerza del cante jondo con Cancanilla de Marbella, un artista que encarna la pureza y la hondura del flamenco tradicional. En el emblemático Castillo de San Sebastián, su voz profunda y desgarrada recorre palos como la seguiriya, la soleá y la bulería, desatando el duende en cada compás. Acompañado por la guitarra que intensifica cada matiz, este recital se convierte en un encuentro íntimo con las raíces andaluzas, donde emoción y autenticidad se funden en una noche inolvidable.', 'media/cancanilla/cancanillaGrid.jpg', 'media/cancanilla/cancanilla.jpg', 18.00),
(6, 'Pasión', 'Teatro Flamenco de Sevilla', 'Castillo Santa Catalina', '2025-06-22 22:30:00', 'Déjate envolver por “Pasión”, una creación magistral del Teatro Flamenco de Sevilla donde la tradición jonda se viste de innovación escénica. Sobre el lienzo oscuro del Castillo de Santa Catalina, los bailaores narran historias de amor, duelo y redención con cada taconeo y braceo, mientras la luz juega con sus siluetas. Una propuesta vibrante que fusiona cante, baile y gesto teatral, despertando el duende más profundo y convirtiendo cada compás en un latido compartido con el público.', 'media/teatro/teatroGrid.jpg', 'media/teatro/teatro.jpg', 24.00),
(7, 'Israel Fernández', 'Israel Fernández', 'Castillo San Sebastián', '2025-06-23 21:30:00', 'Disfruta de la frescura y la raíz del joven prodigio jerezano Israel Fernández, cuya voz limpia y arrolladora renueva el flamenco sin perder su hondura. En el entorno íntimo del Castillo de San Sebastián, Israel recorre cantes clásicos como la caña, la soleá y la seguiriya, matizando cada nota con sensibilidad y duende. Acompañado por una guitarra que dibuja paisajes sonoros envolventes, su recital es un puente entre la tradición centenaria y la pasión del presente, un encuentro emocionante con la esencia de Andalucía.', 'media/israel/israelGrid.jpg', 'media/israel/israel.jpg', 22.00),
(8, 'Gala Cantes de Mujer', 'María Vargas, Juana la del Pipa, Herminia Borja, Dolores Agujetas, Mari Peña, La Nitra, Chonchi Heredia, Rocío Segura, Anabel Valencia, Lela Soto', 'Castillo Santa Catalina', '2025-06-24 22:30:00', 'Vive una noche histórica en la Gala Cantes de Mujer, donde las voces más auténticas y poderosas del flamenco femenino se juntan bajo el embrujo del Castillo de Santa Catalina. Desde la elegancia de María Vargas hasta la hondura desgarrada de Dolores Agujetas, pasando por la fuerza lírica de Juana la del Pipa y el duende vibrante de Rocío Segura, cada cantaora aporta su propio universo de palos: seguiriyas, tonás, bulerías y más. Un recorrido único por la tradición y la innovación, un homenaje colectivo a la maestría, la sensibilidad y la resistencia de la mujer en el arte jondo.', 'media/cantesMujer/mujerGrid.jpg', 'media/cantesMujer/mujer.jpg', 30.00),
(9, 'El Cigala', 'Diego el Cigala', 'Castillo Santa Catalina', '2025-06-25 22:30:00', 'Déjate llevar por la voz inconfundible de Diego “El Cigala”, un artista que ha revolucionado el flamenco con su fusión de raíces gitanas, bolero y jazz. En el abrazo monumental del Castillo de Santa Catalina, su cante abraza palos como la bulería y la seguiriya con una pasión visceral y una elegancia innata. Acompañado por músicos que realzan cada matiz de su timbre rasgado, El Cigala te invita a un viaje sensorial donde tradición y modernidad coexisten en un duende que trasciende fronteras.', 'media/cigala/cigalaGrid.jpg', 'media/cigala/cigala.jpg', 35.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confirmation_token` varchar(64) DEFAULT NULL,
  `subscribed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `is_confirmed`, `confirmation_token`, `subscribed_at`, `confirmed_at`) VALUES
(3, 'raulsuerogarcia@gmail.com', 0, 'dc7e242776f2bff3677e937fb8a46e112478656af478774cc9b40020206630e0', '2025-05-29 18:24:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `email`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'raul suero', 'raulsuerogarcia@gmail.com', '$2y$10$Q8DV3cZpQ.32IXx8rmeBjuRRvVV2wemHVK64.n7yRKOjdBJxhMsYu', 'user', '2025-06-03 12:08:44', '2025-06-03 12:08:44'),
(2, 'alejandra', 'alejandra@gmail.com', '$2y$10$Ecap10pNk0Uv239LCRe8c.FW1H8sX3rZZAfk1rbygfTnNiVQMEnsq', 'user', '2025-06-03 12:20:41', '2025-06-03 12:20:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venues`
--

CREATE TABLE `venues` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `map_link` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `venues`
--

INSERT INTO `venues` (`id`, `name`, `image`, `map_link`, `created_at`) VALUES
(1, 'Castillo Santa Catalina', 'media/ubicaciones/catalina.jpg', 'https://www.google.com/maps/dir//C.+Campo+de+las+Balas,+s%2Fn,+11002+C%C3%A1diz/@36.5328574,-6.3905621,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0xd0dd159141d9353:0xb23c64fcb59193e0!2m2!1d-6.308161!2d36.5328857?entry=ttu&g_ep=EgoyMDI1MDUxMy4xIKXMDSoASAFQAw%3D%3D', '2025-05-23 08:23:00'),
(2, 'Castillo San Sebastián', 'media/ubicaciones/sebastian.jpg', 'https://www.google.com/maps/dir//P.%C2%BA+Fernando+Qui%C3%B1ones,+s%2Fn,+11002+C%C3%A1diz/@36.527986,-6.3976215,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0xd0dd3fdf94108df:0xd843a6005175bffd!2m2!1d-6.3152204!2d36.5280143?entry=ttu&g_ep=EgoyMDI1MDUxMy4xIKXMDSoASAFQAw%3D%3D', '2025-05-23 08:23:00'),
(3, 'Parque Alameda Apodaca', 'media/ubicaciones/alameda.jpg', 'https://www.google.com/maps/dir//del+1+al+12,+Alameda+Hermanas+Carvia+Bernal,+11003+C%C3%A1diz/@36.5372586,-6.3814242,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0xd0dd166fceb2323:0x981edc95c5f3360c!2m2!1d-6.2990231!2d36.5372869?hl=es&entry=ttu&g_ep=EgoyMDI1MDUxMy4xIKXMDSoASAFQAw%3D%3D', '2025-05-23 08:23:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_order` (`order_id`),
  ADD KEY `fk_orders_shows_idx` (`show_id`),
  ADD KEY `fk_orders_users_idx` (`user_id`);

--
-- Indices de la tabla `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_email` (`email`);

--
-- Indices de la tabla `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `shows`
--
ALTER TABLE `shows`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `venues`
--
ALTER TABLE `venues`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_shows` FOREIGN KEY (`show_id`) REFERENCES `shows` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
