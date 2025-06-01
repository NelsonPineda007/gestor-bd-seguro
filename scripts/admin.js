class AdminInterface {
    constructor() {
        this.apiUrl = '../controllers/admin_controller.php';
        this.init();
    }

    async init() {
        await this.cargarUsuarios();
        // this.setupEventListeners(); // Para futuros eventos
    }

    async cargarUsuarios() {
        try {
            const response = await fetch(`${this.apiUrl}?action=listar_usuarios`);
            const data = await response.json();
            
            if (response.ok) {
                this.renderizarUsuarios(data);
            } else {
                throw new Error(data.error || "Error al cargar usuarios");
            }
        } catch (error) {
            this.mostrarError(error);
        }
    }

    renderizarUsuarios(usuarios) {
        const tabla = document.getElementById('tabla-usuarios');
        // ... (mismo código de renderizado que antes)
    }

    // Métodos para futuras acciones:
    async eliminarUsuario(id) {
        // Implementación futura
    }
}

// Inicialización
document.addEventListener('DOMContentLoaded', () => new AdminInterface());