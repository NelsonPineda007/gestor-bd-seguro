// Clase principal para administración
class AdminInterface {
    constructor() {
        this.apiUrl = '../controllers/admin_controller.php';
        this.initElements();
        this.initEvents();
        this.currentPage = 1;
        this.perPage = 3;
        this.cargarUsuarios(this.currentPage);
        this.currentUserId = null;
    }

    // Métodos de ayuda para el renderizado
    getColorClass(rol) {
        const rolLower = rol.toLowerCase();
        return rolLower.includes('admin') ? 'bg-blue-500' :
            rolLower.includes('auditor') ? 'bg-purple-500' :
                'bg-green-500';
    }

    getIniciales(nombreCompleto) {
        return nombreCompleto.split(' ')
            .filter(n => n.length > 0)
            .map(n => n[0].toUpperCase())
            .join('')
            .substring(0, 2);
    }

    getBadgeRol(rol) {
        const rolLower = rol.toLowerCase();
        let clases = 'text-xs px-2 py-1 rounded-full';

        if (rolLower.includes('admin')) {
            clases += ' bg-blue-900 text-blue-100';
        } else if (rolLower.includes('auditor')) {
            clases += ' bg-purple-900 text-purple-100';
        } else {
            clases += ' bg-gray-600 text-gray-100';
        }

        const texto = rolLower.includes('administrador') ? 'admin' : rolLower;
        return `<span class="${clases}">${texto.charAt(0).toUpperCase() + texto.slice(1)}</span>`;
    }

    initElements() {
        // Elementos modales
        this.modal = document.getElementById('modalCrear');
        this.modalModificar = document.getElementById('modalModificar');

        // Botones
        this.openModalBtn = document.getElementById('openModalBtn');
        this.closeModalBtn = document.getElementById('closeModalCrearBtn');
        this.cancelBtn = document.getElementById('cancelCrearBtn');
        this.closeModalModificarBtn = document.getElementById('closeModalModificarBtn');
        this.cancelModificarBtn = document.getElementById('cancelModificarBtn');

        // Formularios
        this.createForm = document.getElementById('createUserForm');
        this.modifyForm = document.getElementById('modifyUserForm');

        // Inputs
        this.duiInput = document.getElementById('dui');
        this.modDuiInput = document.getElementById('mod_dui');

        // Tabla
        this.tablaUsuarios = document.getElementById('tabla-usuarios');
    }

    initEvents() {
        // Eventos del modal de creación
        if (this.openModalBtn) {
            this.openModalBtn.addEventListener('click', () => this.abrirModal());
        }

        if (this.closeModalBtn) {
            this.closeModalBtn.addEventListener('click', () => this.cerrarModal());
        }

        if (this.cancelBtn) {
            this.cancelBtn.addEventListener('click', () => this.cerrarModal());
        }

        // Eventos del modal de modificación
        if (this.closeModalModificarBtn) {
            this.closeModalModificarBtn.addEventListener('click', () => this.cerrarModalModificar());
        }

        if (this.cancelModificarBtn) {
            this.cancelModificarBtn.addEventListener('click', () => this.cerrarModalModificar());
        }

        // Formateo de DUI
        if (this.duiInput) {
            this.duiInput.addEventListener('input', (e) => this.formatearDUI(e));
        }

        if (this.modDuiInput) {
            this.modDuiInput.addEventListener('input', (e) => this.formatearDUI(e));
        }

        // Envío de formularios
        if (this.createForm) {
            this.createForm.addEventListener('submit', (e) => this.enviarFormularioCreacion(e));
        }

        if (this.modifyForm) {
            this.modifyForm.addEventListener('submit', (e) => this.enviarFormularioModificacion(e));
        }

        // Delegación de eventos para los botones de modificar y eliminar
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modifyBtn') || e.target.closest('.modifyBtn')) {
                const btn = e.target.classList.contains('modifyBtn') ? e.target : e.target.closest('.modifyBtn');
                const userData = JSON.parse(btn.dataset.user);
                this.abrirModalModificar(userData);
            }

            if (e.target.classList.contains('deleteBtn') || e.target.closest('.deleteBtn')) {
                const btn = e.target.classList.contains('deleteBtn') ? e.target : e.target.closest('.deleteBtn');
                const userId = btn.dataset.id;
                this.eliminarUsuario(userId);
            }
        });
    }

    // Métodos para los modales
    abrirModal() {
        if (this.modal) {
            this.modal.classList.remove('hidden');
        }
    }

    cerrarModal() {
        if (this.modal) {
            this.modal.classList.add('hidden');
            this.createForm.reset();
        }
    }

    abrirModalModificar(userData) {
        if (!this.modalModificar) return;

        this.currentUserId = userData.id;

        // Llenar el formulario con los datos del usuario
        document.getElementById('mod_id').value = userData.id;
        document.getElementById('mod_nombre_usuario').value = userData.nombre_usuario || '';
        document.getElementById('mod_nombre_completo').value = userData.nombre_completo || '';
        document.getElementById('mod_correo').value = userData.correo || '';
        document.getElementById('mod_telefono').value = userData.telefono || '';
        document.getElementById('mod_dui').value = userData.DUI || '';

        // Seleccionar el rol correcto
        const rolSelect = document.getElementById('mod_rol');
        if (rolSelect) {
            for (let i = 0; i < rolSelect.options.length; i++) {
                if (rolSelect.options[i].value == userData.id_rol ||
                    rolSelect.options[i].text.toLowerCase() === userData.rol.toLowerCase()) {
                    rolSelect.selectedIndex = i;
                    break;
                }
            }
        }

        this.modalModificar.classList.remove('hidden');
    }

    cerrarModalModificar() {
        if (this.modalModificar) {
            this.modalModificar.classList.add('hidden');
            this.modifyForm.reset();
            this.currentUserId = null;
        }
    }

    formatearDUI(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 9) value = value.substring(0, 9);
        if (value.length > 8) value = `${value.substring(0, 8)}-${value.substring(8)}`;
        e.target.value = value;
    }

    async cargarUsuarios(pagina = 1) {
        try {
            this.currentPage = pagina;
            const timestamp = new Date().getTime();
            const response = await fetch(`${this.apiUrl}?action=getUsuarios&pagina=${pagina}&porPagina=${this.perPage}&_=${timestamp}`, {
                headers: {
                    'Accept': 'application/json'
                },
                cache: 'no-store'
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const data = await response.json();

            if (!data.usuarios) {
                throw new Error('Formato de datos incorrecto');
            }

            this.renderizarUsuarios(data.usuarios);
            this.renderizarPaginacion(data.total, this.perPage, pagina);
        } catch (error) {
            console.error('Error al cargar usuarios:', error);
            alert.error(`Error al cargar usuarios: ${error.message}`);
        }
    }

    async eliminarUsuario(userId) {
        const confirm = await alert.confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.');

        if (!confirm.isConfirmed) return;

        try {
            const response = await fetch(`${this.apiUrl}?action=deleteUsuario`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    id: userId,
                    csrf_token: document.querySelector('[name="csrf_token"]').value
                })
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                await alert.success(result.message);
                await this.cargarUsuarios(this.currentPage);
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            await alert.error(error.message || 'Ocurrió un error inesperado al eliminar el usuario');
        }
    }

    renderizarPaginacion(totalUsuarios, porPagina, paginaActual) {
        const container = document.getElementById('pagination-container');
        if (!container) return;

        const totalPaginas = Math.ceil(totalUsuarios / porPagina);
        const paginasAMostrar = 3;

        let html = '<div class="flex space-x-2">';

        // Botón Anterior
        if (paginaActual > 1) {
            html += `<button onclick="adminInterface.cargarUsuarios(${paginaActual - 1})" class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md">
                <i class="fas fa-chevron-left"></i>
            </button>`;
        } else {
            html += `<button class="bg-gray-600 text-gray-300 p-1 rounded-md disabled" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>`;
        }

        // Números de página
        const inicio = Math.max(1, paginaActual - paginasAMostrar);
        const fin = Math.min(totalPaginas, paginaActual + paginasAMostrar);

        if (inicio > 1) {
            html += `<button onclick="adminInterface.cargarUsuarios(1)" class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">1</button>`;
            if (inicio > 2) html += '<span class="px-2">...</span>';
        }

        for (let i = inicio; i <= fin; i++) {
            html += `<button onclick="adminInterface.cargarUsuarios(${i})" class="${i == paginaActual ? 'bg-orange-600 text-white' : 'bg-gray-600 hover:bg-gray-500 text-gray-300'} p-1 px-2 rounded-md">
                ${i}
            </button>`;
        }

        if (fin < totalPaginas) {
            if (fin < totalPaginas - 1) html += '<span class="px-2">...</span>';
            html += `<button onclick="adminInterface.cargarUsuarios(${totalPaginas})" class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 px-2 rounded-md">${totalPaginas}</button>`;
        }

        // Botón Siguiente
        if (paginaActual < totalPaginas) {
            html += `<button onclick="adminInterface.cargarUsuarios(${paginaActual + 1})" class="bg-gray-600 hover:bg-gray-500 text-gray-300 p-1 rounded-md">
                <i class="fas fa-chevron-right"></i>
            </button>`;
        } else {
            html += `<button class="bg-gray-600 text-gray-300 p-1 rounded-md disabled" disabled>
                <i class="fas fa-chevron-right"></i>
            </button>`;
        }

        html += '</div>';
        container.innerHTML = html;
    }

    renderizarUsuarios(usuarios) {
        const tbody = this.tablaUsuarios ? this.tablaUsuarios.querySelector('tbody') : null;
        if (!tbody) {
            console.error('No se encontró el tbody de la tabla');
            return;
        }

        tbody.innerHTML = usuarios.map(usuario => `
            <tr class="border-b border-gray-700 hover:bg-gray-700 transition">
                <td class="py-4 px-6">
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-full ${this.getColorClass(usuario.rol)} flex items-center justify-center text-white text-xs">
                            ${this.getIniciales(usuario.nombre_completo)}
                        </div>
                        <span>${usuario.nombre_completo}</span>
                    </div>
                </td>
                <td class="py-4 px-6">${usuario.nombre_usuario}</td>
                <td class="py-4 px-6">${usuario.correo}</td>
                <td class="py-4 px-6">${this.getBadgeRol(usuario.rol)}</td>
                <td class="py-4 px-6 text-center space-x-2">
                    <button 
                        data-user='${JSON.stringify(usuario)}'
                        class="modifyBtn bg-orange-600 hover:bg-orange-700 text-white px-3 py-1 rounded-md text-xs font-semibold transition">
                        <i class="fas fa-edit mr-1"></i> Modificar
                    </button>
                    <button 
                        data-id="${usuario.id}"
                        class="deleteBtn bg-red-700 hover:bg-red-600 text-white px-3 py-1 rounded-md text-xs font-semibold transition">
                        <i class="fas fa-trash mr-1"></i> Eliminar
                    </button>
                </td>
            </tr>
        `).join('');
    }

    async enviarFormularioCreacion(e) {
        e.preventDefault();

        if (!/^\d{8}-\d$/.test(this.duiInput.value)) {
            alert.error('Por favor ingrese un DUI válido (12345678-9)');
            this.duiInput.focus();
            return;
        }

        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        submitBtn.disabled = true;

        try {
            const formData = new FormData(this.createForm);
            const data = Object.fromEntries(formData.entries());
            data.csrf_token = document.querySelector('[name="csrf_token"]').value;

            const response = await fetch(`${this.apiUrl}?action=createUsuario`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                await alert.success(result.message);
                await this.cargarUsuarios(this.currentPage);
                this.cerrarModal();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            await alert.error(error.message || 'Ocurrió un error inesperado al crear el usuario');
        } finally {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    }

    async enviarFormularioModificacion(e) {
        e.preventDefault();

        if (!this.currentUserId) {
            alert.error('No se ha seleccionado ningún usuario para modificar');
            return;
        }

        if (!/^\d{8}-\d$/.test(this.modDuiInput.value)) {
            alert.error('Por favor ingrese un DUI válido (12345678-9)');
            this.modDuiInput.focus();
            return;
        }

        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
        submitBtn.disabled = true;

        try {
            const formData = new FormData(this.modifyForm);
            const data = Object.fromEntries(formData.entries());
            data.id = this.currentUserId;
            data.csrf_token = document.querySelector('[name="csrf_token"]').value;

            if (!data.contrasena) {
                delete data.contrasena;
            }

            const response = await fetch(`${this.apiUrl}?action=updateUsuario`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                await alert.success(result.message);
                await this.cargarUsuarios(this.currentPage);
                this.cerrarModalModificar();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            await alert.error(error.message || 'Ocurrió un error inesperado al modificar el usuario');
        } finally {
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        }
    }
}

// Inicialización cuando el DOM esté listo
window.addEventListener('load', () => {
    window.adminInterface = new AdminInterface();
});