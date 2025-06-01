<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #111827;
            color: #D1D5DB;
        }
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: #4B5563 #1F2937;
        }
        .sidebar::-webkit-scrollbar {
            width: 8px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: #1F2937;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: #4B5563;
            border-radius: 4px;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        .log-entry:hover {
            background-color: #1F2937;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- Header y Sidebar integrados -->
    <div class="flex flex-col h-screen">
        <!-- Header -->
        <header class="bg-gray-800 shadow-md px-6 py-4 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <div class="h-10 w-10 rounded-full bg-orange-500 flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
                <h1 class="text-orange-500 text-2xl font-semibold tracking-wide">Usuario Dashboard</h1>
            </div>
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <i class="fas fa-bell text-gray-400 hover:text-orange-500 cursor-pointer"></i>
                    <span class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                </div>
                <button aria-label="Cerrar sesión" class="text-gray-400 hover:text-orange-500 transition text-lg">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </header>

        <!-- Contenedor principal -->
<div class="flex flex-1 overflow-hidden">
    <!-- Sidebar - Ahora llega hasta arriba -->
    <aside class="bg-gray-800 w-64 flex flex-col border-r border-gray-700 h-screen sticky top-0">
        <div class="flex-1 overflow-y-auto">
        <!-- Perfil del usuario en el sidebar -->
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center space-x-3 mb-4">
                <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">
                    <i class="fas fa-user text-orange-500"></i>
                </div>
                <div>
                    <p class="font-medium">Carlos Ruiz</p>
                    <p class="text-xs text-orange-500">Usuario Estándar</p>
                </div>
            </div>
            <div class="bg-gray-700 rounded-lg p-3 text-center">
                <p class="text-xs text-gray-400">Última actividad</p>
                <p class="text-sm">Hoy 10:30 AM</p>
            </div>
        </div>

        <!-- Navegación -->
        <div class=" flex-1 overflow-y-auto">
            <div class="p-4">
                <h2 class="text-gray-400 uppercase tracking-widest text-xs mb-4 px-2">Navegación</h2>
                <ul class="space-y-1">
                    <li>
                        <a href="#dashboard" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-3 rounded-lg transition">
                            <i class="fas fa-home text-orange-500 w-5"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#perfil" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-3 rounded-lg transition">
                            <i class="fas fa-user-circle text-orange-500 w-5"></i>
                            <span>Mi Perfil</span>
                        </a>
                    </li>
                    <li>
                        <a href="#solicitudes" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-3 rounded-lg transition">
                            <i class="fas fa-paper-plane text-orange-500 w-5"></i>
                            <span>Mis Solicitudes</span>
                        </a>
                    </li>
                    <li>
                        <a href="#actividad" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-3 rounded-lg transition">
                            <i class="fas fa-history text-orange-500 w-5"></i>
                            <span>Mi Actividad</span>
                        </a>
                    </li>
                    <li>
                        <a href="#documentos" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-3 rounded-lg transition">
                            <i class="fas fa-file-alt text-orange-500 w-5"></i>
                            <span>Mis Documentos</span>
                        </a>
                    </li>
                </ul>
            </div>
          </div>

            <!-- Configuración en la parte inferior -->
    <div class="mt-auto p-4 border-t border-gray-700">
        <h2 class="text-gray-400 uppercase tracking-widest text-xs mb-4 px-2">Configuración</h2>
        <ul class="space-y-1">
            <li>
                <a href="#configuracion" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-3 rounded-lg transition">
                    <i class="fas fa-cog text-orange-500 w-5"></i>
                    <span>Configuración</span>
                </a>
            </li>
            <li>
                <a href="#ayuda" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-3 rounded-lg transition">
                    <i class="fas fa-question-circle text-orange-500 w-5"></i>
                    <span>Ayuda</span>
                </a>
            </li>
        </ul>
    </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-8 overflow-y-auto max-h-screen relative">
            <!-- Sección Resumen -->
            <section id="dashboard" class="mb-12 scroll-mt-20">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-orange-500 text-xl font-semibold">Resumen General</h2>
                        <p class="text-gray-400">Vista rápida de tu actividad y estadísticas</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-800 rounded-xl p-6 shadow-inner card-hover">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Mis Registros</p>
                                <h3 class="text-3xl font-bold text-orange-500 mt-1">1,248</h3>
                            </div>
                            <div class="bg-orange-900 bg-opacity-30 p-3 rounded-lg">
                                <i class="fas fa-file-alt text-orange-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-green-500 text-sm">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>12% desde ayer</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-800 rounded-xl p-6 shadow-inner card-hover">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Solicitudes Pendientes</p>
                                <h3 class="text-3xl font-bold text-orange-500 mt-1">5</h3>
                            </div>
                            <div class="bg-blue-900 bg-opacity-30 p-3 rounded-lg">
                                <i class="fas fa-tasks text-blue-500"></i>
                            </div>
                        </div>
                        <a href="#solicitudes" class="text-orange-500 text-sm mt-3 inline-block hover:underline">
                            Ver detalles <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    <div class="bg-gray-800 rounded-xl p-6 shadow-inner card-hover">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Actividad Reciente</p>
                                <h3 class="text-3xl font-bold text-orange-500 mt-1">24</h3>
                            </div>
                            <div class="bg-green-900 bg-opacity-30 p-3 rounded-lg">
                                <i class="fas fa-history text-green-500"></i>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm mt-3">Última: Hoy 10:30 AM</p>
                    </div>
                </div>
            </section>

            <!-- Sección de Datos Personales -->
            <section id="perfil" class="mb-12 scroll-mt-20">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-orange-500 text-xl font-semibold">Mis Datos Personales</h2>
                        <p class="text-gray-400">Información básica de tu cuenta</p>
                    </div>
                    <button class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-pencil-alt mr-2"></i> Editar
                    </button>
                </div>
                
                <div class="bg-gray-800 rounded-xl shadow-inner overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-1">Nombre Completo</label>
                            <p class="bg-gray-700 p-3 rounded text-gray-300">Carlos Antonio Ruiz Méndez</p>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-1">Correo Electrónico</label>
                            <p class="bg-gray-700 p-3 rounded text-gray-300">carlos.ruiz@empresa.com</p>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-1">Departamento</label>
                            <p class="bg-gray-700 p-3 rounded text-gray-300">Ventas</p>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-1">Rol en el Sistema</label>
                            <p class="bg-gray-700 p-3 rounded text-gray-300">Usuario Estándar</p>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-1">Teléfono</label>
                            <p class="bg-gray-700 p-3 rounded text-gray-300">+502 1234 5678</p>
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm font-medium mb-1">Fecha de Ingreso</label>
                            <p class="bg-gray-700 p-3 rounded text-gray-300">15/03/2021</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección de Mis Solicitudes -->
            <section id="solicitudes" class="mb-12 scroll-mt-20">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-orange-500 text-xl font-semibold">Mis Solicitudes</h2>
                        <p class="text-gray-400">Historial de solicitudes realizadas</p>
                    </div>
                    <button class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center">
                        <i class="fas fa-plus mr-2"></i> Nueva Solicitud
                    </button>
                </div>
                
                <div class="bg-gray-800 rounded-xl shadow-inner overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-700">
                                <tr>
                                    <th class="py-4 px-6 font-medium">ID</th>
                                    <th class="py-4 px-6 font-medium">Tipo</th>
                                    <th class="py-4 px-6 font-medium">Descripción</th>
                                    <th class="py-4 px-6 font-medium text-center">Estado</th>
                                    <th class="py-4 px-6 font-medium">Fecha</th>
                                    <th class="py-4 px-6 font-medium text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                    <td class="py-4 px-6">#45621</td>
                                    <td class="py-4 px-6">Acceso a datos</td>
                                    <td class="py-4 px-6">Solicitud de acceso a reportes de ventas Q2</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-green-900 text-green-100 text-xs px-2 py-1 rounded-full">Aprobada</span>
                                    </td>
                                    <td class="py-4 px-6">15/06/2024</td>
                                    <td class="py-4 px-6 text-center space-x-2">
                                        <button class="text-gray-400 hover:text-orange-500 transition" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-blue-500 transition" title="Descargar">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                    <td class="py-4 px-6">#45218</td>
                                    <td class="py-4 px-6">Actualización</td>
                                    <td class="py-4 px-6">Corrección de datos personales</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-yellow-900 text-yellow-100 text-xs px-2 py-1 rounded-full">Pendiente</span>
                                    </td>
                                    <td class="py-4 px-6">10/06/2024</td>
                                    <td class="py-4 px-6 text-center space-x-2">
                                        <button class="text-gray-400 hover:text-orange-500 transition" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-red-500 transition" title="Cancelar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-700 transition">
                                    <td class="py-4 px-6">#44987</td>
                                    <td class="py-4 px-6">Soporte técnico</td>
                                    <td class="py-4 px-6">Problema con acceso a plataforma</td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-blue-900 text-blue-100 text-xs px-2 py-1 rounded-full">En proceso</span>
                                    </td>
                                    <td class="py-4 px-6">05/06/2024</td>
                                    <td class="py-4 px-6 text-center space-x-2">
                                        <button class="text-gray-400 hover:text-orange-500 transition" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-700 px-6 py-3 flex justify-between items-center">
                        <span class="text-sm text-gray-400">Mostrando 1-3 de 5 solicitudes</span>
                        <div class="flex space-x-2">
                            <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md disabled">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="bg-orange-600 text-white p-1 px-2 rounded-md">1</button>
                            <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">2</button>
                            <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección de Actividad Reciente -->
            <section id="actividad" class="mb-12 scroll-mt-20">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-orange-500 text-xl font-semibold">Mi Actividad Reciente</h2>
                        <p class="text-gray-400">Historial de tus acciones en el sistema</p>
                    </div>
                    <div class="relative">
                        <select class="bg-gray-700 text-gray-300 rounded-md pl-3 pr-8 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500 text-sm">
                            <option>Últimos 7 días</option>
                            <option>Últimos 30 días</option>
                            <option>Últimos 90 días</option>
                            <option>Todas las actividades</option>
                        </select>
                    </div>
                </div>
                
                <div class="bg-gray-800 rounded-xl shadow-inner overflow-hidden">
                    <div class="overflow-y-auto max-h-96">
                        <table class="w-full text-left">
                            <thead class="bg-gray-700 sticky top-0">
                                <tr>
                                    <th class="py-4 px-6 font-medium">Fecha/Hora</th>
                                    <th class="py-4 px-6 font-medium">Acción</th>
                                    <th class="py-4 px-6 font-medium">Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-700 log-entry">
                                    <td class="py-4 px-6">2024-06-15 10:15:23</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-orange-900 text-orange-100 text-xs px-2 py-1 rounded-full">Exportación</span>
                                    </td>
                                    <td class="py-4 px-6">Exportaste datos de clientes (125 registros)</td>
                                </tr>
                                <tr class="border-b border-gray-700 log-entry">
                                    <td class="py-4-15 09:30:45</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-blue-900 text-blue-100 text-xs px-2 py-1 rounded-full">Consulta</span>
                                    </td>
                                    <td class="py-4 px-6">Consulta ejecutada: SELECT * FROM ventas WHERE fecha > '2024-05-01'</td>
                                </tr>
                                <tr class="border-b border-gray-700 log-entry">
                                    <td class="py-4 px-6">2024-06-14 09:30:45</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-green-900 text-green-100 text-xs px-2 py-1 rounded-full">Actualización</span>
                                    </td>
                                    <td class="py-4 px-6">Cambio de número telefónico en tu perfil</td>
                                </tr>
                                <tr class="border-b border-gray-700 log-entry">
                                    <td class="py-4 px-6">2024-06-13 11:20:12</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-purple-900 text-purple-100 text-xs px-2 py-1 rounded-full">Reporte</span>
                                    </td>
                                    <td class="py-4 px-6">Generaste reporte de ventas mensuales</td>
                                </tr>
                                <tr class="log-entry">
                                    <td class="py-4 px-6">2024-06-12 14:45:30</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-gray-600 text-gray-100 text-xs px-2 py-1 rounded-full">Sesión</span>
                                    </td>
                                    <td class="py-4 px-6">Inicio de sesión desde IP 192.168.1.100</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bg-gray-700 px-6 py-3 flex justify-between items-center">
                        <span class="text-sm text-gray-400">Mostrando 5 de 24 actividades</span>
                        <div class="flex space-x-2">
                            <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="bg-orange-600 text-white p-1 px-2 rounded-md">1</button>
                            <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">2</button>
                            <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">3</button>
                            <span class="px-2">...</span>
                            <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">5</button>
                            <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Modal para Nueva Solicitud -->
    <div id="requestModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-gray-800 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-orange-500">Nueva Solicitud</h3>
                    <button id="closeRequestModal" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <form class="space-y-4">
                    <div>
                        <label class="block text-gray-300 text-sm mb-2">Tipo de Solicitud</label>
                        <select class="w-full bg-gray-700 text-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option>Seleccione un tipo...</option>
                            <option>Acceso a datos</option>
                            <option>Actualización de información</option>
                            <option>Soporte técnico</option>
                            <option>Reporte personalizado</option>
                            <option>Otro</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 text-sm mb-2">Título</label>
                        <input type="text" placeholder="Descripción breve de la solicitud" class="w-full bg-gray-700 text-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 text-sm mb-2">Descripción Detallada</label>
                        <textarea rows="4" class="w-full bg-gray-700 text-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Describa su solicitud con el mayor detalle posible..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 text-sm mb-2">Adjuntar Archivos (Opcional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-700 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <div class="flex text-sm text-gray-400">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-orange-500 hover:text-orange-400">
                                        <span>Subir un archivo</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">o arrastrar y soltar</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, PDF hasta 10MB</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" id="cancelRequest" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md">
                            Enviar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Funcionalidad para el modal de nueva solicitud
        document.addEventListener('DOMContentLoaded', function() {
            const newRequestBtn = document.querySelector('button:has(i.fa-plus)');
            const requestModal = document.getElementById('requestModal');
            const closeRequestModal = document.getElementById('closeRequestModal');
            const cancelRequest = document.getElementById('cancelRequest');
            
            if (newRequestBtn && requestModal) {
                newRequestBtn.addEventListener('click', () => {
                    requestModal.classList.remove('hidden');
                });
                
                closeRequestModal.addEventListener('click', () => {
                    requestModal.classList.add('hidden');
                });
                
                cancelRequest.addEventListener('click', () => {
                    requestModal.classList.add('hidden');
                });
            }
            
            // Cerrar modal haciendo clic fuera del contenido
            window.addEventListener('click', (event) => {
                if (event.target === requestModal) {
                    requestModal.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>