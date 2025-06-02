renderizarPaginacion() {
        const paginationContainer = document.getElementById('pagination-container');
        if (!paginationContainer) return;

        const totalPages = Math.ceil(this.totalUsers / this.perPage);
        
        let paginationHTML = `
            <div class="flex items-center justify-between mt-6">
                <button 
                    id="prev-page" 
                    class="px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-300 font-semibold transition ${this.currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${this.currentPage <= 1 ? 'disabled' : ''}
                >
                    Anterior
                </button>
                
                <span class="text-gray-300">
                    Página ${this.currentPage} de ${totalPages}
                </span>
                
                <button 
                    id="next-page" 
                    class="px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-gray-300 font-semibold transition ${this.currentPage >= totalPages ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${this.currentPage >= totalPages ? 'disabled' : ''}
                >
                    Siguiente
                </button>
            </div>
        `;

        paginationContainer.innerHTML = paginationHTML;

        // Event listeners para los botones
        document.getElementById('prev-page')?.addEventListener('click', () => {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.cargarUsuarios();
            }
        });

        document.getElementById('next-page')?.addEventListener('click', () => {
            if (this.currentPage < totalPages) {
                this.currentPage++;
                this.cargarUsuarios();
            }
        });
    }