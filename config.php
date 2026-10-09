<?php
// Configuración de Conexión compatible con Local (XAMPP) y Producción (Railway / MySQL Cloud)
$host = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: "localhost";
$user = getenv('MYSQLUSER') ?: getenv('DB_USER') ?: "root";
$pass = getenv('MYSQLPASSWORD') ?: getenv('DB_PASSWORD') ?: "";
$db   = getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: "ferremax";
$port = getenv('MYSQLPORT') ?: getenv('DB_PORT') ?: 3306;

// Desactivar reporte automático de excepciones de mysqli
if (function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_OFF);
}

try {
    $conn = @new mysqli($host, $user, $pass, $db, (int)$port);
    if ($conn && !$conn->connect_errno) {
        $db_connected = true;
        $conn->set_charset("utf8mb4");
    } else {
        $db_connected = false;
    }
} catch (Throwable $e) {
    $db_connected = false;
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
