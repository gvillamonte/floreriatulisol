<?php
// ========================================================
// Database Connection Singleton (PDO) - Florería Tulisol
// ========================================================

class Database {
    private static ?PDO $instance = null;

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            $hostHeader = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? '');

            // Detección infalible de entorno:
            // Laragon corre siempre sobre Windows; InfinityFree corre sobre Linux.
            $isLocal = (
                PHP_OS_FAMILY === 'Windows' ||
                php_sapi_name() === 'cli' ||
                empty($hostHeader) ||
                str_contains($hostHeader, 'localhost') ||
                str_contains($hostHeader, '127.0.0.1') ||
                str_ends_with($hostHeader, '.test') ||
                str_ends_with($hostHeader, '.local')
            );

            if ($isLocal) {
                // Entorno Local (Laragon)
                $host = '127.0.0.1';
                $db   = 'dbfloreriatulisol';
                $user = 'root';
                $pass = '';
            } else {
                // Entorno Produccion (InfinityFree)
                $host = 'sql204.infinityfree.com';
                $db   = 'if0_42248182_Floreriatulisol';
                $user = 'if0_42248182';
                $pass = 'Hj5iUMKrAbiGGQ';
            }

            $charset = 'utf8mb4';
            $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
