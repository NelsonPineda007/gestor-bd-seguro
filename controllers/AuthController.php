<?php
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../core/session.php';

function login($nombre_usuario, $contrasena)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT u.id, u.nombre_usuario, u.contrasena, r.nombre AS rol 
                           FROM usuarios u 
                           JOIN roles r ON u.id_rol = r.id 
                           WHERE u.nombre_usuario = :nombre_usuario");
    $stmt->execute(['nombre_usuario' => $nombre_usuario]);
    $usuario = $stmt->fetch();

    if ($usuario && $usuario['contrasena']) {
        $clave = "clave_secreta"; // Debes mantenerla segura

        $stmt = $pdo->prepare("SELECT AES_DECRYPT(:password, :key) as decrypted");
        $stmt->execute([
            'password' => $usuario['contrasena'],
            'key' => $clave
        ]);
        $decrypted = $stmt->fetchColumn();

        if ($decrypted === $contrasena) {
            iniciarSesion($usuario['id'], $usuario['nombre_usuario'], $usuario['rol']);
            return true;
        }
    }

    return false;
}
