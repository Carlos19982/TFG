// public/js/pilotosSearch.js
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchPilotoInput');
    const pilotosContainer = document.getElementById('listaPilotosContainer');
    const noPilotosMensaje = document.getElementById('noPilotosMensaje'); // Mensaje original si no hay pilotos
    const noResultadosBusqueda = document.getElementById('noResultadosBusqueda'); // Mensaje para búsqueda sin resultados

    if (searchInput && pilotosContainer) {
        searchInput.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase().trim();
            const pilotos = pilotosContainer.querySelectorAll('.team-member'); // Selecciona todos los elementos de piloto
            let visiblesCount = 0;

            pilotos.forEach(pilotoElement => {
                const nombreElement = pilotoElement.querySelector('.member-name');
                if (nombreElement) {
                    const nombreCompleto = nombreElement.textContent.toLowerCase();
                    if (nombreCompleto.includes(searchTerm)) {
                        pilotoElement.style.display = ''; // Muestra el elemento (revierte a su display original)
                        visiblesCount++;
                    } else {
                        pilotoElement.style.display = 'none'; // Oculta el elemento
                    }
                }
            });

            // Mostrar/ocultar mensaje de "no resultados"
            if (pilotos.length > 0) { // Solo gestionamos el mensaje de búsqueda si hay pilotos para buscar
                if (visiblesCount === 0 && searchTerm !== '') {
                    noResultadosBusqueda.style.display = 'block';
                } else {
                    noResultadosBusqueda.style.display = 'none';
                }
            }

            // Ocultar el mensaje original de "no hay pilotos" si estamos buscando
            // y hay pilotos cargados inicialmente.
            if (noPilotosMensaje && pilotos.length > 0) {
                if (searchTerm !== '') {
                    noPilotosMensaje.style.display = 'none';
                } else if (visiblesCount > 0) { // Si borramos la búsqueda y hay pilotos, que no aparezca
                     noPilotosMensaje.style.display = 'none';
                } else if(visiblesCount === 0 && searchTerm === '') { // Si borramos y no hay, que se muestre
                    // Esto es un caso raro, si la lista original estaba vacía y se busca algo.
                    // El mensaje original 'noPilotosMensaje' debería manejar esto por defecto.
                }
            }
        });
    }
});