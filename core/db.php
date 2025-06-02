<?php
// core/db.php

$host = 'localhost:3306';
$dbname = 'gestor_bd_seguro';
$user = 'root';
$pass = 'toor';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
    
    // Configurar variables de sesión para triggers (solo si hay sesión activa)
    if (session_status() === PHP_SESSION_ACTIVE) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $userId = $_SESSION['user_id'] ?? 0;
        $username = $_SESSION['username'] ?? 'system';
        
        $stmt = $pdo->prepare("
            SET @current_user_id = :user_id,
                @current_username = :username,
                @ip_actual = :ip
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':username' => $username,
            ':ip' => $ip
        ]);
    }
} catch (PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die("Error al conectar con la base de datos. Por favor intente más tarde.");
}