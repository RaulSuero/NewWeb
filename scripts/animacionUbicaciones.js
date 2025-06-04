document.addEventListener('DOMContentLoaded', () => {
    gsap.registerPlugin(ScrollTrigger);

    // Seleccionamos cada bloque de ubicación
    const items = gsap.utils.toArray('.ubications-list .ubication');

    // 0) Estado inicial: ocultos y desplazados
    gsap.set(items, { opacity: 0, y: 20 });

    // 1) Creamos un ScrollTrigger para cada uno
    items.forEach(el => {
        gsap.to(el, {
            opacity: 1,
            y: 0,
            duration: 0.6,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: el,
                start: 'top 95%',
                toggleActions: 'play none none none'
            }
        });
    });
});
