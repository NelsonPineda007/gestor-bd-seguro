<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard Auditor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/estilos.css">

</head>

<body class="bg-gray-900 text-gray-300 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gray-800 shadow-md px-6 py-4 flex items-center justify-between sticky top-0 z-30">
        <div class="flex items-center space-x-4">
            <div class="h-10 w-10 rounded-full bg-orange-500 flex items-center justify-center">
                <i class="fas fa-shield-alt text-white"></i>
            </div>
            <h1 class="text-orange-500 text-2xl font-semibold tracking-wide">Auditor Dashboard</h1>
        </div>
        <div class="flex items-center space-x-6">
            <nav class="space-x-6 hidden md:flex text-gray-400 text-sm font-medium">
                <a href="#usuarios" class="hover:text-orange-500 transition flex items-center">
                    <i class="fas fa-users mr-2"></i> Usuarios
                </a>
                <a href="#registros" class="hover:text-orange-500 transition flex items-center">
                    <i class="fas fa-clipboard-list mr-2"></i> Auditoría
                </a>
                <a href="#estadisticas" class="hover:text-orange-500 transition flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i> Estadísticas
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
                            <p class="text-xs text-orange-500">Auditor</p>
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
                            <span>Gestión de Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="#registros" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-file-alt text-orange-500 w-5"></i>
                            <span>Registros de Auditoría</span>
                        </a>
                    </li>
                    <li>
                        <a href="#estadisticas" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-chart-bar text-orange-500 w-5"></i>
                            <span>Estadísticas</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="mt-8">
                <h2 class="text-gray-400 uppercase tracking-widest text-xs mb-4">Cuenta</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="#perfil" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-user-cog text-orange-500 w-5"></i>
                            <span>Configuración</span>
                        </a>
                    </li>
                    <li>
                        <a href="#ayuda" class="flex items-center space-x-3 text-gray-300 hover:bg-gray-700 px-3 py-2 rounded-lg transition">
                            <i class="fas fa-question-circle text-orange-500 w-5"></i>
                            <span>Ayuda</span>
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
                        <h2 class="text-orange-500 text-xl font-semibold">Gestión de Usuarios</h2>
                        <p class="text-gray-400">Visualiza y monitorea los usuarios del sistema</p>
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
                                    <th class="py-4 px-6 font-medium">Correo</th>
                                    <th class="py-4 px-6 font-medium">Rol</th>
                                    <th class="py-4 px-6 font-medium text-center">Estado</th>
                                    <th class="py-4 px-6 font-medium text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs">JP</div>
                                            <span>Juan Pérez</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">juan.perez@mail.com</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-blue-900 text-blue-100 text-xs px-2 py-1 rounded-full">Admin</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-green-900 text-green-100 text-xs px-2 py-1 rounded-full">Activo</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 px-3 py-1 rounded-md text-xs font-medium" disabled>
                                            <i class="fas fa-eye mr-1"></i> Ver Detalles
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center text-white text-xs">MG</div>
                                            <span>María Gómez</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">maria.gomez@mail.com</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-purple-900 text-purple-100 text-xs px-2 py-1 rounded-full">Auditor</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-green-900 text-green-100 text-xs px-2 py-1 rounded-full">Activo</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 px-3 py-1 rounded-md text-xs font-medium" disabled>
                                            <i class="fas fa-eye mr-1"></i> Ver Detalles
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-700 transition">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center text-white text-xs">CR</div>
                                            <span>Carlos Ruiz</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">carlos.ruiz@mail.com</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-gray-600 text-gray-100 text-xs px-2 py-1 rounded-full">Usuario</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-yellow-900 text-yellow-100 text-xs px-2 py-1 rounded-full">Inactivo</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <button class="bg-gray-600 hover:bg-gray-500 text-gray-300 px-3 py-1 rounded-md text-xs font-medium" disabled>
                                            <i class="fas fa-eye mr-1"></i> Ver Detalles
                                        </button>
                                    </td>
                                </tr>
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
            </section>

            <!-- Sección de Registros de Auditoría -->
            <section id="registros" class="mb-12 scroll-mt-20">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-orange-500 text-xl font-semibold">Registros de Auditoría</h2>
                        <p class="text-gray-400">Historial completo de actividades del sistema</p>
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
                                    <td class="py-4 px-6">2024-06-01 10:30:12</td>
                                    <td class="py-4 px-6">Juan Pérez</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-red-900 text-red-100 text-xs px-2 py-1 rounded-full">Eliminación</span>
                                    </td>
                                    <td class="py-4 px-6">Eliminó usuario Carlos Ruiz</td>
                            
                                </tr>
                                <tr class="border-b border-gray-700 log-entry">
                                    <td class="py-4 px-6">2024-06-01 10:25:00</td>
                                    <td class="py-4 px-6">María Gómez</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-blue-900 text-blue-100 text-xs px-2 py-1 rounded-full">Auditoría</span>
                                    </td>
                                    <td class="py-4 px-6">Revisión de registros completada</td>
                                    
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
                                    <td class="py-4 px-6">2024-06-01 10:17:45</td>
                                    <td class="py-4 px-6">María Gómez</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-green-900 text-green-100 text-xs px-2 py-1 rounded-full">Backup</span>
                                    </td>
                                    <td class="py-4 px-6">Creó backup completo de la base</td>
                                    
                                </tr>
                                <tr class="log-entry">
                                    <td class="py-4 px-6">2024-06-01 10:15:23</td>
                                    <td class="py-4 px-6">Juan Pérez</td>
                                    <td class="py-4 px-6">
                                        <span class="bg-gray-600 text-gray-100 text-xs px-2 py-1 rounded-full">Autenticación</span>
                                    </td>
                                    <td class="py-4 px-6">Inició sesión en el sistema</td>
                                    
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
                <h2 class="text-orange-500 text-xl font-semibold mb-6">Estadísticas del Sistema</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-gray-800 rounded-xl p-6 shadow-inner card-hover">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Usuarios Activos</p>
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
                                <p class="text-gray-400 text-sm font-medium">Backups Realizados</p>
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
                                <p class="text-gray-400 text-sm font-medium">Eventos Auditados</p>
                                <h3 class="text-3xl font-bold text-orange-500 mt-1">1,248</h3>
                            </div>
                            <div class="bg-purple-900 bg-opacity-30 p-3 rounded-lg">
                                <i class="fas fa-clipboard-list text-purple-500"></i>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-green-500 text-sm">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>23% este mes</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-800 rounded-xl p-6 shadow-inner card-hover">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-gray-400 text-sm font-medium">Alertas de Seguridad</p>
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