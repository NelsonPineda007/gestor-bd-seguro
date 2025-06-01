<?php
require_once __DIR__ . '/../core/CSRF.php';

// Validación CSRF mejorada
if (!CSRF::validarToken($_POST['csrf_token'] ?? '')) {
    header("Location: index.php?error=csrf");
    exit();
}

// Procesamiento seguro del formulario
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// ... tu lógica de procesamiento ...