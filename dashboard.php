<?php
session_start();

// Verifica que haya sesión activa
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Obtiene el rol del usuario desde la sesión
$rol = $_SESSION['usuario']['rol']; // Ej: 'admin', 'auditor', 'usuario'

// Redirige a la vista según el rol
switch ($rol) {
    case 'administrador':
        header("Location: views/admin.php");
        break;
    case 'auditor':
        header("Location: views/auditor.php");
        break;
    case 'usuario':
        header("Location: views/usuario.php");
        break;
    default:
        echo "Rol no válido.";
        session_destroy();
        break;
}
