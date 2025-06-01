<?php
session_start();
require_once __DIR__ . '/db.php';

/**  Escribe una línea en core/debug_log.txt */
function escribir_log(string $mensaje): void
{
    $archivo = __DIR__ . '/debug_log.txt';
    $hora    = date('Y-m-d H:i:s');
    file_put_contents($archivo, "[$hora] $mensaje" . PHP_EOL, FILE_APPEND);
}

// Inicializar contador de intentos si no existe
if (!isset($_SESSION['intentos_login'])) {
    $_SESSION['intentos_login'] = 0;
}

// Verificar intentos fallidos antes de procesar el login
if ($_SESSION['intentos_login'] > 3) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    escribir_log("Demasiados intentos fallidos desde IP: $ip");
    $_SESSION['error'] = "Demasiados intentos fallidos. Intente más tarde.";
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /** ───── 1.  Datos del formulario ───── */
    $usuario  = $_POST['usuario']  ?? '';
    $password = $_POST['password'] ?? '';

    escribir_log("=== procesar_login.php llamado ===");
    escribir_log("Usuario recibido: $usuario");

    try {
        /** ───── 2.  Definir IP para los triggers ───── */
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $pdo->exec("SET @ip_actual = '$ip'");

        /** ───── 3.  Consultar al usuario (sin desencriptar la contraseña) ───── */
        $sql  = "SELECT id, nombre_usuario, contrasena, id_rol
                 FROM usuarios
                 WHERE nombre_usuario = :usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);
        $usuarioDB = $stmt->fetch();
        escribir_log("Contraseña ingresada: $password");
        escribir_log("Hash desde DB: " . ($usuarioDB['contrasena'] ?? 'No encontrado'));

        /** ───── 4.  Verificar contraseña con password_verify() ───── */
        if ($usuarioDB && password_verify($password, $usuarioDB['contrasena'])) {
            // Resetear contador de intentos fallidos
            $_SESSION['intentos_login'] = 0;

            escribir_log("Contraseña correcta para $usuario");

            /* Mapeo de id_rol a nombre de rol */
            $roles = [
                1 => 'admin',
                2 => 'auditor',
                3 => 'usuario'
            ];
            $rolNombre = $roles[$usuarioDB['id_rol']] ?? 'usuario';

            /* Guardar información en la sesión */
            $_SESSION['usuario'] = [
                'id'             => $usuarioDB['id'],
                'nombre_usuario' => $usuarioDB['nombre_usuario'],
                'rol'            => $rolNombre
            ];

            // Iniciar sesión segura
            if (function_exists('iniciarSesionSegura')) {
                iniciarSesionSegura();
            }

            escribir_log("Sesión iniciada | usuario: {$usuarioDB['nombre_usuario']} | rol: $rolNombre | ip: $ip");

            header("Location: ../dashboard.php");
            exit();
        }

        /* Usuario no encontrado o contraseña incorrecta */
        $_SESSION['intentos_login']++;
        escribir_log("Login fallido para $usuario. Intento #{$_SESSION['intentos_login']}");
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: ../index.php");
        exit();

    } catch (Exception $e) {
        escribir_log("ERROR: " . $e->getMessage());
        $_SESSION['error'] = "Ocurrió un error inesperado.";
        header("Location: ../index.php");
        exit();
    }
}

/* Si el acceso no es por POST, redirigir a index */
header("Location: ../index.php");
exit();