<?php
require_once '../core/db.php';

class AdminController
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getUsuariosConRoles($limit = 3, $offset = 0)
    {
        $query = "SELECT 
                u.id, 
                u.nombre_usuario,
                u.nombre_completo,
                u.correo,
                r.nombre AS rol,
                AES_DECRYPT(u.telefono, 'llave_secreta') AS telefono,
                AES_DECRYPT(u.DUI, 'llave_secreta') AS DUI
                FROM usuarios u
                JOIN roles r ON u.id_rol = r.id
                ORDER BY u.id ASC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Transformar 'Administrador' a 'Admin' en los resultados
        return array_map(function ($usuario) {
            if ($usuario['rol'] === 'Administrador') {
                $usuario['rol'] = 'Admin';
            }
            return $usuario;
        }, $usuarios);
    }

    public function getIniciales($nombreCompleto)
    {
        $iniciales = '';
        $nombres = explode(' ', $nombreCompleto);
        foreach ($nombres as $nombre) {
            $iniciales .= strtoupper(substr($nombre, 0, 1));
        }
        return substr($iniciales, 0, 2);
    }

    public function getColorAvatar($rol)
    {
        return match (strtolower($rol)) {
            'admin' => 'bg-blue-500',  // Cambiado de 'administrador'
            'auditor' => 'bg-purple-500',
            default => 'bg-green-500'
        };
    }

    public function getBadgeRol($rol)
    {
        $styles = [
            'admin' => 'bg-blue-900 text-blue-100',  // Cambiado de 'administrador'
            'auditor' => 'bg-purple-900 text-purple-100',
            'usuario' => 'bg-gray-600 text-gray-100'
        ];

        // Normalizar el nombre del rol
        $rolNormalized = strtolower($rol) === 'administrador' ? 'admin' : strtolower($rol);
        $clases = $styles[$rolNormalized] ?? $styles['usuario'];

        return "<span class='{$clases} text-xs px-2 py-1 rounded-full'>" . ucfirst($rolNormalized) . "</span>";
    }

    public function getTotalUsuarios()
    {
        $query = "SELECT COUNT(*) as total FROM usuarios";
        $stmt = $this->pdo->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
