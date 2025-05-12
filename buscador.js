document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('event-search');
    const dateInput   = document.getElementById('date-filter');
    const clearButton = document.getElementById('clear-filters');  // botón “Limpiar”
    const cards       = document.querySelectorAll('.grid-container .card');
  
    function filterCards() {
        const term    = searchInput.value.trim().toLowerCase();
        const dateVal = dateInput.value; // "YYYY-MM-DD" o ""
        const formattedDate = dateVal
        ? dateVal.split('-').reverse().join('/')  // pasa a "DD/MM/YYYY"
        : '';
  
      cards.forEach(card => {
        const nameText = card.querySelector('.card-name').textContent.toLowerCase();
        const roleText = card.querySelector('.card-role').textContent;
  
        // Si hay término de búsqueda, comprobar nombre; si no, pasar
        const matchesName = term
          ? nameText.includes(term)
          : true;
  
        // Si hay fecha seleccionada, comprobar la fecha; si no, pasar
        const matchesDate = formattedDate
          ? roleText.includes(formattedDate)
          : true;
  
        // Mostrar sólo si cumple ambas condiciones
        card.style.display = (matchesName && matchesDate) ? '' : 'none';
      });
    }
  
    // Filtrar en tiempo real
    searchInput.addEventListener('input', filterCards);
    dateInput.addEventListener('change', filterCards);
  
    // Limpiar filtros al pulsar el botón
    clearButton.addEventListener('click', () => {
      searchInput.value = '';
      dateInput.value   = '';
      filterCards();      // volver a mostrar todas las tarjetas
      searchInput.focus(); // opcional: devolver el foco al input de texto
    });
});
  