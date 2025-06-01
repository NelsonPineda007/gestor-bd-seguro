<?php
// core/db.php

$host = 'localhost:3306';
$dbname = 'gestor_bd_seguro';
$user = 'root';
$pass = 'toor';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,         // Manejo de errores como excepciones
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    // Resultados como arrays asociativos
        PDO::ATTR_EMULATE_PREPARES => false                  // Desactiva emulación de consultas preparadas
    ]);
} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
