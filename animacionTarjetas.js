document.addEventListener('DOMContentLoaded', () => {
    gsap.registerPlugin(ScrollTrigger);

    const searchInput = document.getElementById('event-search');
    const dateInput = document.getElementById('date-filter');
    const cards = gsap.utils.toArray('.grid-container .card');

    // 0) Estado inicial: todas ocultas
    gsap.set(cards, { opacity: 0, y: 20 });

    // 1) Animación On Scroll
    cards.forEach(card => {
            gsap.to(card, {
            scrollTrigger: {
                trigger: card,
                start: 'top 95%',
                toggleActions: 'play none none none',
                // markers: true
            },
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: 'power2.out'
        });
    });

    // 2) Filtrado + animación de entradas en tiempo real
    function filterCards() {
        const term = searchInput.value.trim().toLowerCase();
        const dateVal = dateInput.value;
        const formattedDate = dateVal ? dateVal.split('-').reverse().join('/') : '';

        // Mostrar/ocultar
        cards.forEach(card => {
            const nameText = card.querySelector('.card-name').textContent.toLowerCase();
            const roleText = card.querySelector('.card-role').textContent;
            const matchesName = term ? nameText.includes(term) : true;
            const matchesDate = formattedDate ? roleText.includes(formattedDate) : true;
            card.style.display = (matchesName && matchesDate) ? '' : 'none';
        });

        // Reinicializar estado sólo en los visibles, y animar
        const visible = cards.filter(c => c.style.display !== 'none');
        gsap.set(visible, { opacity: 0, y: 20 });  // re-oculta antes de animar
        gsap.to(visible, {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: 'power2.out',
            stagger: 0.1,
            overwrite: true
        });
    }

    searchInput.addEventListener('input', filterCards);
    dateInput.addEventListener('change', filterCards);
});
