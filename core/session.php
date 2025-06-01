<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function iniciarSesion($usuario_id, $nombre_usuario, $rol)
{
    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['nombre_usuario'] = $nombre_usuario;
    $_SESSION['rol'] = $rol;
}

function iniciarSesionSegura()
{
    // Regenerar ID de sesión para prevenir fixation
    session_regenerate_id(true);

    // Configurar cookies seguras
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        session_id(),
        [
            'lifetime' => $params['lifetime'],
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => true,  // Solo HTTPS
            'httponly' => true, // No accesible por JS
            'samesite' => 'Strict'
        ]
    );
}

function cerrarSesion()
{
    session_unset();
    session_destroy();
}

function usuarioAutenticado()
{
    return isset($_SESSION['usuario_id']);
}

function obtenerRolUsuario()
{
    return $_SESSION['rol'] ?? null;
}

function verificarTiempoInactividad($limite_minutos = 15)
{
    $limite_segundos = $limite_minutos * 60;

    if (isset($_SESSION['ultimo_acceso'])) {
        $inactivo = time() - $_SESSION['ultimo_acceso'];
        if ($inactivo > $limite_segundos) {
            cerrarSesion();
            header("Location: index.php?mensaje=sesion_expirada");
            exit();
        }
    }

    $_SESSION['ultimo_acceso'] = time();
}

function verificarSesionActiva()
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Verificar tiempo de inactividad
    verificarTiempoInactividad();

    // Verificar que el usuario esté autenticado
    if (!usuarioAutenticado()) {
        header("Location: index.php?error=no_autenticado");
        exit();
    }

    // Verificar que el agente de usuario no haya cambiado
    if (!isset($_SESSION['user_agent'])) {
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    } elseif ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        cerrarSesion();
        header("Location: index.php?error=session_hijacking");
        exit();
    }
}