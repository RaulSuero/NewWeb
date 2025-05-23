<?php
    // Ajusta estos valores según tu servidor
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'festival_clasico_andaluz');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');

    try {
        $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4';
        // Opciones para lanzar excepciones y usar FETCH_ASSOC
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        // En producción podrías loguear esto en lugar de mostrarlo
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
