<?php
session_start();
require_once __DIR__ . '/db.php';

/** Escribe una línea en core/debug_log.txt */
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

// Verificar intentos fallidos
if ($_SESSION['intentos_login'] > 3) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    escribir_log("Demasiados intentos fallidos desde IP: $ip");
    $_SESSION['error'] = "Demasiados intentos fallidos. Intente más tarde.";
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /** ───── 1. Datos del formulario ───── */
    $usuario  = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    escribir_log("=== Intento de login ===");
    escribir_log("Usuario recibido: $usuario");

    try {
        /** ───── 2. Configurar IP para triggers ───── */
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $pdo->exec("SET @ip_actual = '$ip'");

        /** ───── 3. Consultar usuario con todos los datos necesarios ───── */
        $sql = "SELECT u.id, u.nombre_usuario, u.contrasena, u.nombre_completo, 
                       u.id_rol, r.nombre as rol_nombre, u.estado
                FROM usuarios u
                JOIN roles r ON u.id_rol = r.id
                WHERE u.nombre_usuario = :usuario AND u.estado = 'activo'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);
        $usuarioDB = $stmt->fetch();
        escribir_log("Datos obtenidos de BD: " . print_r($usuarioDB, true));

        /** ───── 4. Verificar credenciales ───── */
        if ($usuarioDB && password_verify($password, $usuarioDB['contrasena'])) {
            // Resetear contador de intentos
            $_SESSION['intentos_login'] = 0;

            /** ───── 5. Establecer todas las variables de sesión necesarias ───── */
            $_SESSION['user_id'] = $usuarioDB['id'];
            $_SESSION['username'] = $usuarioDB['nombre_usuario'];
            $_SESSION['nombre_completo'] = $usuarioDB['nombre_completo'];
            $_SESSION['rol'] = $usuarioDB['rol_nombre'];
            $_SESSION['estado'] = $usuarioDB['estado'];

            // Para compatibilidad con código existente
            $_SESSION['usuario'] = [
                'id' => $usuarioDB['id'],
                'nombre_usuario' => $usuarioDB['nombre_usuario'],
                'rol' => $usuarioDB['rol_nombre']
            ];

            // Establecer contexto para triggers
            $pdo->exec("
                SET @current_user_id = {$usuarioDB['id']},
                    @current_username = '{$usuarioDB['nombre_usuario']}'
            ");

            // Registrar login exitoso en auditoría
            $sqlAudit = "INSERT INTO auditoria (
                usuario_sesion, id_usuario, ip_origen, operacion, 
                tabla_afectada, valores_despues
            ) VALUES (
                :username, :user_id, :ip, 'LOGIN',
                'sistema', :extra_data
            )";

            $stmtAudit = $pdo->prepare($sqlAudit);
            $stmtAudit->execute([
                ':username' => $usuarioDB['nombre_usuario'],
                ':user_id' => $usuarioDB['id'],
                ':ip' => $ip,
                ':extra_data' => json_encode([
                    'tipo' => 'login_exitoso',
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
                ])
            ]);

            escribir_log("Login exitoso para: {$usuarioDB['nombre_usuario']} (ID: {$usuarioDB['id']})");
            escribir_log("Variables de sesión establecidas: " . print_r($_SESSION, true));

            header("Location: ../dashboard.php");
            exit();
        }

        /** ───── 6. Login fallido ───── */
        $_SESSION['intentos_login']++;
        escribir_log("Login fallido para $usuario. Intento #{$_SESSION['intentos_login']}");

        // Registrar intento fallido en auditoría si el usuario existe
        if ($usuarioDB) {
            $sqlAudit = "INSERT INTO auditoria (
                usuario_sesion, id_usuario, ip_origen, operacion, 
                tabla_afectada, valores_despues
            ) VALUES (
                :username, :user_id, :ip, 'LOGIN_FAIL',
                'sistema', :extra_data
            )";

            $stmtAudit = $pdo->prepare($sqlAudit);
            $stmtAudit->execute([
                ':username' => $usuarioDB['nombre_usuario'],
                ':user_id' => $usuarioDB['id'],
                ':ip' => $ip,
                ':extra_data' => json_encode([
                    'tipo' => 'login_fallido',
                    'intentos' => $_SESSION['intentos_login']
                ])
            ]);
        }

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

// Redirigir si no es POST
header("Location: ../index.php");
exit();
