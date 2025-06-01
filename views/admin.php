<?php
require_once '../core/db.php';
require_once '../controllers/admin_controller.php';
require_once __DIR__ . '/../core/CSRF.php';

$adminController = new AdminController();
$usuarios = $adminController->getUsuariosConRoles();
$csrfToken = CSRF::generarToken();

?>

<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/estilos.css">

</head>

<body class="bg-gray-900 text-gray-300 min-h-screen flex flex-col">
    <!-- Header -->

    <body class="bg-gray-900 text-gray-300 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-gray-800 shadow-md px-6 py-4 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <div class="h-10 w-10 rounded-full bg-orange-500 flex items-center justify-center">
                    <i class="fas fa-shield-alt text-white"></i>
                </div>
                <h1 class="text-orange-500 text-2xl font-semibold tracking-wide">Admin Dashboard</h1>
            </div>
            <div class="flex items-center space-x-6">
                <nav class="space-x-6 hidden md:flex text-gray-400 text-sm font-medium">
                    <a href="#usuarios" class="hover:text-orange-500 transition flex items-center">
                        <i class="fas fa-home mr-2"></i> Inicio
                    </a>
                    <a href="#usuarios" class="hover:text-orange-500 transition flex items-center">
                        <i class="fas fa-users mr-2"></i> Usuarios
                    </a>
                    <a href="#crear-backup" class="hover:text-orange-500 transition flex items-center">
                        <i class="fas fa-box mr-2"></i> Backups
                    </a>
                    <a href="#registros" class="hover:text-orange-500 transition flex items-center">
                        <i class="fas fa-clipboard-list mr-2"></i> Auditoría
                    </a>
                    <a href="#configuraciones" class="hover:text-orange-500 transition flex items-center">
                        <i class="fas fa-cogs mr-2"></i> Configuración
                    </a>
                </nav>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="fas fa-bell text-gray-400 hover:text-orange-500 cursor-pointer"></i>
                        <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">2</span>
                    </div>
                    <button aria-label="Cerrar sesión" class="text-gray-400 hover:text-orange-500 transition text-lg">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </header>

        <div class="flex flex-1 overflow-hidden">
            <!-- Sidebar -->
            <aside class="bg-gray-800 w-64 p-6 flex flex-col justify-between sticky top-16 h-[calc(100vh-64px)] overflow-y-auto sidebar">
                <div>
                    <div class="mb-8">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-user text-orange-500"></i>
                            </div>
                            <div>
                                <p class="font-medium">María Gómez</p>
                                <p class="text-xs text-orange-500">Administrador</p>
                            </div>
                        </div>
                        <div class="bg-gray-700 rounded-lg p-3 text-center">
                            <p class="text-xs text-gray-400">Última actividad</p>
                            <p class="text-sm">Hoy 14:30</p>
                        </div>
                    </div>

                    <h2 class="text-gray-400 uppercase tracking-widest text-xs mb-4">Navegación</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="#usuarios" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-users text-orange-500 w-5"></i>
                                <span>Gestionar usuarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="#roles" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-user-shield text-orange-500 w-5"></i>
                                <span>Asignar roles</span>
                            </a>
                        </li>
                        <li>
                            <a href="#crear-backup" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-box text-orange-500 w-5"></i>
                                <span>Crear backups</span>
                            </a>
                        </li>
                        <li>
                            <a href="#restaurar-backup" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-save text-orange-500 w-5"></i>
                                <span>Restaurar backups</span>
                            </a>
                        </li>
                        <li>
                            <a href="#registros" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-file-alt text-orange-500 w-5"></i>
                                <span>Consultar registros</span>
                            </a>
                        </li>
                        <li>
                            <a href="#estadisticas" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-chart-bar text-orange-500 w-5"></i>
                                <span>Estadísticas</span>
                            </a>
                        </li>
                        <li>
                            <a href="#datos-sensibles" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-dna text-orange-500 w-5"></i>
                                <span>Datos sensibles</span>
                            </a>
                        </li>
                        <li>
                            <a href="#configuraciones" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-cogs text-orange-500 w-5"></i>
                                <span>Configuraciones</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="mt-8">
                    <h2 class="text-gray-400 uppercase tracking-widest text-xs mb-4">Cuenta</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="#perfil" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                                <i class="fas fa-user-circle text-orange-500 w-5"></i>
                                <span>Mi perfil</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Main content -->
            <main class="flex-1 p-8 overflow-y-auto max-h-screen relative">
                <!-- Sección de Usuarios -->
                <section id="usuarios" class="mb-12 scroll-mt-20">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-orange-500 text-xl font-semibold">Gestionar usuarios</h2>
                            <p class="text-gray-400">Crear, editar y eliminar usuarios del sistema</p>
                        </div>
                        <div class="flex space-x-3">
                            <button class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm font-medium flex items-center">
                                <i class="fas fa-filter mr-2"></i> Filtrar
                            </button>
                            <button class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm font-medium flex items-center">
                                <i class="fas fa-download mr-2"></i> Exportar
                            </button>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-xl shadow-inner overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th class="py-4 px-6 font-medium">Nombre</th>
                                        <th class="py-4 px-6 font-medium">Usuario</th>
                                        <th class="py-4 px-6 font-medium">Correo</th>
                                        <th class="py-4 px-6 font-medium">Rol</th>
                                        <th class="py-4 px-6 font-medium text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($usuarios as $usuario): ?>
                                        <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                            <td class="py-4 px-6">
                                                <div class="flex items-center space-x-3">
                                                    <div class="h-8 w-8 rounded-full <?= $adminController->getColorAvatar($usuario['rol']) ?> flex items-center justify-center text-white text-xs">
                                                        <?= $adminController->getIniciales($usuario['nombre_completo']) ?>
                                                    </div>
                                                    <span><?= htmlspecialchars($usuario['nombre_completo']) ?></span>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6"><?= htmlspecialchars($usuario['nombre_usuario']) ?></td>
                                            <td class="py-4 px-6"><?= htmlspecialchars($usuario['correo']) ?></td>
                                            <td class="py-4 px-6">
                                                <?= $adminController->getBadgeRol($usuario['rol']) ?>
                                            </td>
                                            <td class="py-4 px-6 text-center space-x-2">
                                                <button
                                                    data-user='<?= json_encode($usuario) ?>'
                                                    class="modifyBtn bg-orange-600 hover:bg-orange-700 text-white px-3 py-1 rounded-md text-xs font-semibold transition">
                                                    <i class="fas fa-edit mr-1"></i> Modificar
                                                </button>
                                                <button
                                                    data-id="<?= $usuario['id'] ?>"
                                                    class="deleteBtn bg-red-700 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs font-semibold transition">
                                                    <i class="fas fa-trash mr-1"></i> Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-700 px-6 py-3 flex justify-between items-center">
                            <span class="text-sm text-gray-400">Mostrando 3 de 128 usuarios</span>
                            <div class="flex space-x-2">
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md disabled">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="bg-orange-600 text-white p-1 px-2 rounded-md">1</button>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">2</button>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">3</button>
                                <span class="px-2">...</span>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">12</button>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button id="openModalBtn" class="mt-6 bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-md font-semibold transition flex items-center" type="button">
                        <i class="fas fa-plus mr-2"></i> Crear nuevo usuario
                    </button>
                </section>

                <!-- Sección de Roles -->
                <section id="roles" class="mb-12 scroll-mt-20">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-orange-500 text-xl font-semibold">Asignar roles</h2>
                            <p class="text-gray-400">Administra los roles de los usuarios: admin, auditor, usuario</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-xl shadow-inner p-6 max-w-md">
                        <form class="space-y-4">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                            <div>
                                <label for="user-select" class="block mb-2 text-gray-300 text-sm font-medium">Selecciona usuario</label>
                                <select id="user-select" class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option>Juan Pérez</option>
                                    <option>María Gómez</option>
                                    <option>Carlos Ruiz</option>
                                </select>
                            </div>
                            <div>
                                <label for="role-select" class="block mb-2 text-gray-300 text-sm font-medium">Selecciona rol</label>
                                <select id="role-select" class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option>Admin</option>
                                    <option>Auditor</option>
                                    <option>Usuario</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-5 py-2 rounded-md transition flex items-center justify-center w-full">
                                <i class="fas fa-user-shield mr-2"></i> Asignar rol
                            </button>
                        </form>
                    </div>
                </section>

                <!-- Sección de Crear Backup -->
                <section id="crear-backup" class="mb-12 scroll-mt-20">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-orange-500 text-xl font-semibold">Crear backups</h2>
                            <p class="text-gray-400">Genera backups con encriptación para proteger tus datos</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-xl shadow-inner p-6">
                        <button class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-md font-semibold transition flex items-center" type="button">
                            <i class="fas fa-box mr-2"></i> Crear Backup Encriptado
                        </button>
                        <div class="mt-4 text-sm text-gray-400">
                            <i class="fas fa-info-circle mr-2 text-orange-500"></i> Los backups se almacenan con encriptación AES-256 para máxima seguridad.
                        </div>
                    </div>
                </section>

                <!-- Sección de Restaurar Backup -->
                <section id="restaurar-backup" class="mb-12 scroll-mt-20">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-orange-500 text-xl font-semibold">Restaurar backups</h2>
                            <p class="text-gray-400">Restaura backups previamente creados para recuperar datos</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-xl shadow-inner p-6">
                        <button class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-md font-semibold transition flex items-center" type="button">
                            <i class="fas fa-save mr-2"></i> Restaurar Backup
                        </button>
                        <div class="mt-4 text-sm text-gray-400">
                            <i class="fas fa-exclamation-triangle mr-2 text-yellow-500"></i> Esta acción sobrescribirá los datos actuales. Realice una copia de seguridad primero.
                        </div>
                    </div>
                </section>

                <!-- Sección de Registros de Auditoría -->
                <section id="registros" class="mb-12 scroll-mt-20">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-orange-500 text-xl font-semibold">Consultar registros de auditoría</h2>
                            <p class="text-gray-400">Revisa los registros de auditoría para monitorear actividades</p>
                        </div>
                        <div class="flex space-x-3">
                            <div class="relative">
                                <input type="text" placeholder="Buscar registro..." class="bg-gray-700 text-gray-300 rounded-md pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 w-64">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                            <button class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center">
                                <i class="fas fa-file-export mr-2"></i> Exportar JSON
                            </button>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-xl shadow-inner overflow-hidden">
                        <div class="overflow-y-auto max-h-96">
                            <table class="w-full text-left">
                                <thead class="bg-gray-700 sticky top-0">
                                    <tr>
                                        <th class="py-4 px-6 font-medium">Fecha/Hora</th>
                                        <th class="py-4 px-6 font-medium">Usuario</th>
                                        <th class="py-4 px-6 font-medium">Acción</th>
                                        <th class="py-4 px-6 font-medium">Detalles</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-700 log-entry">
                                        <td class="py-4 px-6">2024-06-01 10:15:23</td>
                                        <td class="py-4 px-6">Juan Pérez</td>
                                        <td class="py-4 px-6">
                                            <span class="bg-gray-600 text-gray-100 text-xs px-2 py-1 rounded-full">Autenticación</span>
                                        </td>
                                        <td class="py-4 px-6">Inició sesión en el sistema</td>
                                    </tr>
                                    <tr class="border-b border-gray-700 log-entry">
                                        <td class="py-4 px-6">2024-06-01 10:17:45</td>
                                        <td class="py-4 px-6">María Gómez</td>
                                        <td class="py-4 px-6">
                                            <span class="bg-green-900 text-green-100 text-xs px-2 py-1 rounded-full">Backup</span>
                                        </td>
                                        <td class="py-4 px-6">Creó backup completo de la base</td>
                                    </tr>
                                    <tr class="border-b border-gray-700 log-entry">
                                        <td class="py-4 px-6">2024-06-01 10:20:10</td>
                                        <td class="py-4 px-6">Carlos Ruiz</td>
                                        <td class="py-4 px-6">
                                            <span class="bg-yellow-900 text-yellow-100 text-xs px-2 py-1 rounded-full">Modificación</span>
                                        </td>
                                        <td class="py-4 px-6">Actualizó configuración de perfil</td>
                                    </tr>
                                    <tr class="border-b border-gray-700 log-entry">
                                        <td class="py-4 px-6">2024-06-01 10:25:00</td>
                                        <td class="py-4 px-6">María Gómez</td>
                                        <td class="py-4 px-6">
                                            <span class="bg-blue-900 text-blue-100 text-xs px-2 py-1 rounded-full">Auditoría</span>
                                        </td>
                                        <td class="py-4 px-6">Revisión de registros completada</td>
                                    </tr>
                                    <tr class="log-entry">
                                        <td class="py-4 px-6">2024-06-01 10:30:12</td>
                                        <td class="py-4 px-6">Juan Pérez</td>
                                        <td class="py-4 px-6">
                                            <span class="bg-red-900 text-red-100 text-xs px-2 py-1 rounded-full">Eliminación</span>
                                        </td>
                                        <td class="py-4 px-6">Eliminó usuario Carlos Ruiz</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-700 px-6 py-3 flex justify-between items-center">
                            <span class="text-sm text-gray-400">Mostrando 5 de 1,248 registros</span>
                            <div class="flex space-x-2">
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="bg-orange-600 text-white p-1 px-2 rounded-md">1</button>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">2</button>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">3</button>
                                <span class="px-2">...</span>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">42</button>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección de Estadísticas -->
                <section id="estadisticas" class="mb-12 scroll-mt-20">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-orange-500 text-xl font-semibold">Estadísticas generales</h2>
                            <p class="text-gray-400">Métricas clave del sistema</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-gray-800 rounded-xl p-6 shadow-inner card-hover">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-gray-400 text-sm font-medium">Usuarios activos</p>
                                    <h3 class="text-3xl font-bold text-orange-500 mt-1">128</h3>
                                </div>
                                <div class="bg-orange-900 bg-opacity-30 p-3 rounded-lg">
                                    <i class="fas fa-users text-orange-500"></i>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-green-500 text-sm">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>12% este mes</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-800 rounded-xl p-6 shadow-inner card-hover">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-gray-400 text-sm font-medium">Backups realizados</p>
                                    <h3 class="text-3xl font-bold text-orange-500 mt-1">54</h3>
                                </div>
                                <div class="bg-blue-900 bg-opacity-30 p-3 rounded-lg">
                                    <i class="fas fa-database text-blue-500"></i>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-green-500 text-sm">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>8% este mes</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-800 rounded-xl p-6 shadow-inner card-hover">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-gray-400 text-sm font-medium">Roles asignados</p>
                                    <h3 class="text-3xl font-bold text-orange-500 mt-1">3</h3>
                                </div>
                                <div class="bg-purple-900 bg-opacity-30 p-3 rounded-lg">
                                    <i class="fas fa-user-shield text-purple-500"></i>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-green-500 text-sm">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>5% este mes</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-800 rounded-xl p-6 shadow-inner card-hover">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-gray-400 text-sm font-medium">Alertas de seguridad</p>
                                    <h3 class="text-3xl font-bold text-orange-500 mt-1">2</h3>
                                </div>
                                <div class="bg-red-900 bg-opacity-30 p-3 rounded-lg">
                                    <i class="fas fa-shield-alt text-red-500"></i>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex items-center text-green-500 text-sm">
                                    <i class="fas fa-arrow-down mr-1 text-red-500"></i>
                                    <span class="text-red-500">50% menos que ayer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección de Datos Sensibles -->
                <section id="datos-sensibles" class="mb-12 scroll-mt-20">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-orange-500 text-xl font-semibold">Acceder a datos sensibles</h2>
                            <p class="text-gray-400">Visualiza y administra datos sensibles encriptados</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-xl shadow-inner overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th class="py-4 px-6 font-medium">ID</th>
                                        <th class="py-4 px-6 font-medium">Descripción</th>
                                        <th class="py-4 px-6 font-medium">Estado</th>
                                        <th class="py-4 px-6 font-medium text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                        <td class="py-4 px-6">001</td>
                                        <td class="py-4 px-6">Clave API principal</td>
                                        <td class="py-4 px-6">
                                            <span class="bg-orange-900 text-orange-100 text-xs px-2 py-1 rounded-full">Encriptado</span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button data-id="001" data-desc="Clave API principal" class="viewSensitiveBtn bg-orange-600 hover:bg-orange-700 text-white px-3 py-1 rounded-md text-xs font-semibold transition">
                                                <i class="fas fa-eye mr-1"></i> Ver
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                        <td class="py-4 px-6">002</td>
                                        <td class="py-4 px-6">Certificado SSL</td>
                                        <td class="py-4 px-6">
                                            <span class="bg-orange-900 text-orange-100 text-xs px-2 py-1 rounded-full">Encriptado</span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button data-id="002" data-desc="Certificado SSL" class="viewSensitiveBtn bg-orange-600 hover:bg-orange-700 text-white px-3 py-1 rounded-md text-xs font-semibold transition">
                                                <i class="fas fa-eye mr-1"></i> Ver
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-700 transition">
                                        <td class="py-4 px-6">003</td>
                                        <td class="py-4 px-6">Token de acceso</td>
                                        <td class="py-4 px-6">
                                            <span class="bg-orange-900 text-orange-100 text-xs px-2 py-1 rounded-full">Encriptado</span>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button data-id="003" data-desc="Token de acceso" class="viewSensitiveBtn bg-orange-600 hover:bg-orange-700 text-white px-3 py-1 rounded-md text-xs font-semibold transition">
                                                <i class="fas fa-eye mr-1"></i> Ver
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-700 px-6 py-3 flex justify-between items-center">
                            <span class="text-sm text-gray-400">Mostrando 3 de 12 elementos</span>
                            <div class="flex space-x-2">
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md disabled">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="bg-orange-600 text-white p-1 px-2 rounded-md">1</button>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">2</button>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">3</button>
                                <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección de Configuraciones -->
                <section id="configuraciones" class="mb-12 scroll-mt-20">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-orange-500 text-xl font-semibold">Configuraciones generales</h2>
                            <p class="text-gray-400">Ajusta las configuraciones generales del sistema</p>
                        </div>
                    </div>

                    <div class="bg-gray-800 rounded-xl shadow-inner p-6 max-w-2xl">
                        <form class="space-y-6">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                            <div>
                                <label for="site-name" class="block mb-2 text-gray-300 text-sm font-medium">Nombre del sitio</label>
                                <input
                                    type="text"
                                    id="site-name"
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                    value="Mi Sistema Seguro" />
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <label for="maintenance-mode" class="text-gray-300 text-sm font-medium">Modo mantenimiento</label>
                                    <p class="text-gray-500 text-xs">Desactiva el acceso público al sistema</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="maintenance-mode" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-orange-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <label for="notifications" class="text-gray-300 text-sm font-medium">Habilitar notificaciones</label>
                                    <p class="text-gray-500 text-xs">Recibe alertas por correo electrónico</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="notifications" checked class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-orange-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                                </label>
                            </div>
                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-md transition flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i> Guardar cambios
                            </button>
                        </form>
                    </div>
                </section>

                <!-- Modal backdrop -->
                <div id="modalBackdrop" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm hidden z-40"></div>

                <!-- Crear Modal -->
                <div id="modalCrear" class="fixed inset-0 flex items-center justify-center p-6 hidden z-50">
                    <div class="bg-gray-800 rounded-lg shadow-lg max-w-md w-full p-6 relative">
                        <button id="closeModalCrearBtn" aria-label="Cerrar modal" class="absolute top-3 right-3 text-gray-400 hover:text-orange-500 text-xl font-semibold transition">
                            &times;
                        </button>
                        <h3 class="text-orange-500 text-xl font-semibold mb-6 text-center">Crear nuevo usuario</h3>
                        <form id="createUserForm" class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                            <div>
                                <label for="nombre_usuario" class="block mb-1 text-gray-300 font-light text-sm">Nombre de usuario</label>
                                <input type="text" id="nombre_usuario" name="nombre_usuario" required
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="contrasena" class="block mb-1 text-gray-300 font-light text-sm">Contraseña</label>
                                <input type="password" id="contrasena" name="contrasena" required
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="nombre_completo" class="block mb-1 text-gray-300 font-light text-sm">Nombre completo</label>
                                <input type="text" id="nombre_completo" name="nombre_completo" required
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="telefono" class="block mb-1 text-gray-300 font-light text-sm">Teléfono</label>
                                <input type="tel" id="telefono" name="telefono" pattern="[0-9+\-\s]*"
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="dui" class="block mb-1 text-gray-300 font-light text-sm">DUI</label>
                                <input type="text" id="dui" name="dui" pattern="\d{8}-\d"
                                    placeholder="12345678-9"
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="rol" class="block mb-1 text-gray-300 font-light text-sm">Rol</label>
                                <select id="rol" name="rol" required
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="" disabled selected>Selecciona un rol</option>
                                    <option value="admin">Admin</option>
                                    <option value="auditor">Auditor</option>
                                    <option value="usuario">Usuario</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2 flex justify-end space-x-3 pt-4 border-t border-gray-700">
                                <button type="button" id="cancelCrearBtn" class="px-5 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-300 font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit" class="px-5 py-2 rounded-md bg-orange-600 hover:bg-orange-700 text-black font-semibold transition">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modificar Modal -->
                <div id="modalModificar" class="fixed inset-0 flex items-center justify-center p-6 hidden z-50">
                    <div class="bg-gray-800 rounded-lg shadow-lg max-w-md w-full p-6 relative">
                        <button id="closeModalModificarBtn" aria-label="Cerrar modal" class="absolute top-3 right-3 text-gray-400 hover:text-orange-500 text-xl font-semibold transition">
                            &times;
                        </button>
                        <h3 class="text-orange-500 text-xl font-semibold mb-6 text-center">Modificar usuario</h3>
                        <form id="modifyUserForm" class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                            <div>
                                <label for="mod_nombre_usuario" class="block mb-1 text-gray-300 font-light text-sm">Nombre de usuario</label>
                                <input type="text" id="mod_nombre_usuario" name="nombre_usuario" required
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="mod_contrasena" class="block mb-1 text-gray-300 font-light text-sm">Contraseña</label>
                                <input type="password" id="mod_contrasena" name="contrasena"
                                    placeholder="Dejar vacío para no cambiar"
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="mod_nombre_completo" class="block mb-1 text-gray-300 font-light text-sm">Nombre completo</label>
                                <input type="text" id="mod_nombre_completo" name="nombre_completo" required
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="mod_telefono" class="block mb-1 text-gray-300 font-light text-sm">Teléfono</label>
                                <input type="tel" id="mod_telefono" name="telefono" pattern="[0-9+\-\s]*"
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="mod_dui" class="block mb-1 text-gray-300 font-light text-sm">DUI</label>
                                <input type="text" id="mod_dui" name="dui" pattern="\d{8}-\d"
                                    placeholder="12345678-9"
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            </div>
                            <div>
                                <label for="mod_rol" class="block mb-1 text-gray-300 font-light text-sm">Rol</label>
                                <select id="mod_rol" name="rol" required
                                    class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                    <option value="" disabled>Selecciona un rol</option>
                                    <option value="admin">Admin</option>
                                    <option value="auditor">Auditor</option>
                                    <option value="usuario">Usuario</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2 flex justify-end space-x-3 pt-4 border-t border-gray-700">
                                <button type="button" id="cancelModificarBtn" class="px-5 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-300 font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit" class="px-5 py-2 rounded-md bg-orange-600 hover:bg-orange-700 text-black font-semibold transition">
                                    Guardar cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal contraseña admin -->
                <div id="modalAdminPass" class="fixed inset-0 flex items-center justify-center p-6 hidden z-50">
                    <div class="bg-gray-800 rounded-lg shadow-lg max-w-sm w-full p-6 relative">
                        <button id="closeModalAdminPassBtn" aria-label="Cerrar modal" class="absolute top-3 right-3 text-gray-400 hover:text-orange-500 text-xl font-semibold transition">
                            &times;
                        </button>
                        <h3 class="text-orange-500 text-xl font-semibold mb-6 text-center">Autenticación requerida</h3>
                        <p class="text-gray-400 mb-4 text-center">Ingrese la contraseña de administrador para visualizar el dato sensible:</p>
                        <p id="sensitiveDesc" class="text-gray-300 mb-6 text-center font-semibold"></p>
                        <form id="adminPassForm" class="space-y-4">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                            <input type="password" id="adminPassword" name="adminPassword" placeholder="Contraseña de administrador" required
                                class="w-full bg-gray-700 text-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" />
                            <div class="flex justify-end space-x-3">
                                <button type="button" id="cancelAdminPassBtn" class="px-5 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-300 font-semibold transition">
                                    Cancelar
                                </button>
                                <button type="submit" class="px-5 py-2 rounded-md bg-orange-600 hover:bg-orange-700 text-black font-semibold transition">
                                    Verificar
                                </button>
                            </div>
                        </form>
                        <p id="errorMsg" class="text-red-500 text-sm mt-3 text-center hidden">Contraseña incorrecta. Intente de nuevo.</p>
                    </div>
                </div>
            </main>
        </div>

        <script>
            // Crear modal elements
            const openModalCrearBtn = document.getElementById('openModalBtn');
            const closeModalCrearBtn = document.getElementById('closeModalCrearBtn');
            const cancelCrearBtn = document.getElementById('cancelCrearBtn');
            const modalCrear = document.getElementById('modalCrear');

            // Modificar modal elements
            const modalModificar = document.getElementById('modalModificar');
            const closeModalModificarBtn = document.getElementById('closeModalModificarBtn');
            const cancelModificarBtn = document.getElementById('cancelModificarBtn');

            // Admin password modal elements
            const modalAdminPass = document.getElementById('modalAdminPass');
            const closeModalAdminPassBtn = document.getElementById('closeModalAdminPassBtn');
            const cancelAdminPassBtn = document.getElementById('cancelAdminPassBtn');
            const adminPassForm = document.getElementById('adminPassForm');
            const adminPasswordInput = document.getElementById('adminPassword');
            const sensitiveDesc = document.getElementById('sensitiveDesc');
            const errorMsg = document.getElementById('errorMsg');

            // Backdrop shared
            const modalBackdrop = document.getElementById('modalBackdrop');

            // Forms
            const createUserForm = document.getElementById('createUserForm');
            const modifyUserForm = document.getElementById('modifyUserForm');

            // Open Crear modal
            function openCrearModal() {
                modalCrear.classList.remove('hidden');
                modalBackdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            // Close Crear modal
            function closeCrearModal() {
                modalCrear.classList.add('hidden');
                modalBackdrop.classList.add('hidden');
                document.body.style.overflow = '';
                createUserForm.reset();
            }

            // Open Modificar modal and fill data
            function openModificarModal(userData) {
                modalModificar.classList.remove('hidden');
                modalBackdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                // Fill form fields
                document.getElementById('mod_nombre_usuario').value = userData.nombre_usuario || '';
                document.getElementById('mod_contrasena').value = '';
                document.getElementById('mod_nombre_completo').value = userData.nombre_completo || '';
                document.getElementById('mod_telefono').value = userData.telefono || '';
                document.getElementById('mod_dui').value = userData.dui || '';
                document.getElementById('mod_rol').value = userData.rol || '';
            }

            // Close Modificar modal
            function closeModificarModal() {
                modalModificar.classList.add('hidden');
                modalBackdrop.classList.add('hidden');
                document.body.style.overflow = '';
                modifyUserForm.reset();
            }

            // Open Admin Password modal
            let currentSensitiveData = null;

            function openAdminPassModal(id, desc) {
                currentSensitiveData = {
                    id,
                    desc
                };
                sensitiveDesc.textContent = desc;
                errorMsg.classList.add('hidden');
                adminPasswordInput.value = '';
                modalAdminPass.classList.remove('hidden');
                modalBackdrop.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                adminPasswordInput.focus();
            }

            // Close Admin Password modal
            function closeAdminPassModal() {
                modalAdminPass.classList.add('hidden');
                modalBackdrop.classList.add('hidden');
                document.body.style.overflow = '';
                currentSensitiveData = null;
                errorMsg.classList.add('hidden');
                adminPasswordInput.value = '';
            }

            // Event listeners Crear modal
            openModalCrearBtn.addEventListener('click', openCrearModal);
            closeModalCrearBtn.addEventListener('click', closeCrearModal);
            cancelCrearBtn.addEventListener('click', closeCrearModal);

            // Event listeners Modificar modal
            closeModalModificarBtn.addEventListener('click', closeModificarModal);
            cancelModificarBtn.addEventListener('click', closeModificarModal);

            // Event listeners Admin Password modal
            closeModalAdminPassBtn.addEventListener('click', closeAdminPassModal);
            cancelAdminPassBtn.addEventListener('click', closeAdminPassModal);

            // Close modals on backdrop click
            modalBackdrop.addEventListener('click', () => {
                if (!modalCrear.classList.contains('hidden')) closeCrearModal();
                if (!modalModificar.classList.contains('hidden')) closeModificarModal();
                if (!modalAdminPass.classList.contains('hidden')) closeAdminPassModal();
            });

            // Handle form submissions (simulated)
            createUserForm.addEventListener('submit', (e) => {
                e.preventDefault();
                alert('Usuario creado correctamente (simulado)');
                closeCrearModal();
            });

            modifyUserForm.addEventListener('submit', (e) => {
                e.preventDefault();
                alert('Usuario modificado correctamente (simulado)');
                closeModificarModal();
            });

            adminPassForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const enteredPass = adminPasswordInput.value.trim();
                // Simulated admin password check (password: admin123)
                if (enteredPass === 'admin123') {
                    alert(`Dato sensible "${currentSensitiveData.desc}" mostrado (simulado).`);
                    closeAdminPassModal();
                } else {
                    errorMsg.classList.remove('hidden');
                }
            });

            // Attach event listeners to all modify buttons
            document.querySelectorAll('.modifyBtn').forEach(button => {
                button.addEventListener('click', () => {
                    const userData = JSON.parse(button.getAttribute('data-user'));
                    openModificarModal(userData);
                });
            });

            // Attach event listeners to all view sensitive buttons
            document.querySelectorAll('.viewSensitiveBtn').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const desc = button.getAttribute('data-desc');
                    openAdminPassModal(id, desc);
                });
            });
        </script>
    </body>

</html>