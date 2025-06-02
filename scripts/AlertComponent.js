class AlertComponent {
    constructor() {
        this.defaultConfig = {
            width: '400px',
            padding: '1.5rem',
            background: 'rgb(17, 24, 39)',
            color: '#ffffff',
            confirmButtonColor: 'rgb(234, 88, 12)',
            buttonsStyling: false,
            backdrop: false,
            customClass: {
                container: '!bg-gray-900 !max-w-[400px] !mx-auto !my-8',
                popup: '!bg-gray-900 !text-white !border !border-gray-700 !rounded-lg !shadow-xl',
                title: '!text-white !text-lg',
                htmlContainer: '!text-gray-200 !text-sm',
                confirmButton: '!bg-orange-600 hover:!bg-orange-700 !text-white !font-medium !py-2 !px-4 !rounded-md',
                cancelButton: '!bg-gray-600 hover:!bg-gray-700 !text-white !font-medium !py-2 !px-4 !rounded-md !mr-2'
            }
        };
    }

    success(message, title = 'Éxito') {
        return Swal.fire({
            ...this.defaultConfig,
            title,
            text: message,
            icon: 'success'
        });
    }

    error(message, title = 'Error') {
        return Swal.fire({
            ...this.defaultConfig,
            title,
            text: message,
            icon: 'error'
        });
    }

    confirm(message, title = 'Confirmar') {
        return Swal.fire({
            ...this.defaultConfig,
            title,
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        });
    }
}

// Crea instancia global
window.alert = new AlertComponent();