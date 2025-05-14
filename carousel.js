document.addEventListener('DOMContentLoaded', () => {
    gsap.registerPlugin();
    
    const track = document.querySelector('.carousel-track');
    const slides = gsap.utils.toArray('.carousel-track .event-card');
    const nextBtn = document.querySelector('.next');
    const prevBtn = document.querySelector('.prev');
    const container = document.querySelector('.carousel-container');
    
    // 1) Clonación para bucle infinito
    const clonesBefore = slides.map(el => el.cloneNode(true));
    const clonesAfter = slides.map(el => el.cloneNode(true));
    clonesBefore.reverse().forEach(clone => track.insertBefore(clone, track.firstChild));
    clonesAfter.forEach(clone  => track.appendChild(clone));
    
    // 2) Cálculo de ancho de slide + gap
    const gap = parseFloat(getComputedStyle(track).gap) || 0;
    const slideW = slides[0].getBoundingClientRect().width + gap;
    const totalSlides = slides.length;
    const cycleDistance = slideW * totalSlides;
    
    // 3) Posicionar al primer slide “real”
    const startIndex = totalSlides;
    gsap.set(track, { x: -slideW * startIndex });
    
    // 4) Timeline de bucle continuo
    const loopDuration = 60; // segundos por ciclo completo
    const loop = gsap.timeline({ repeat: -1 })
    .to(track, {
        x: `-=${cycleDistance}`,
        duration: loopDuration,
        ease: 'none'
    })
    .set(track, { x: -slideW * startIndex });
    
    // 5) Helpers para recalcular progreso de loop
    function restartLoopFromCurrent() {
        // posición actual
        const currentX = gsap.getProperty(track, 'x');
        // distancia recorrida desde el startIndex
        const offset   = -currentX - (slideW * startIndex);
        // módulo para 0–cycleDistance y normalizar a [0,1]
        const mod      = ((offset % cycleDistance) + cycleDistance) % cycleDistance;
        const progress = mod / cycleDistance;
        loop.progress(progress).play();
    }
    
    // 6) Botones Next / Prev
    nextBtn.addEventListener('click', () => {
        loop.pause();
        gsap.to(track, {
            x: `-=${slideW}`,
            duration: 0.5,
            ease: 'power1.inOut',
            onComplete: restartLoopFromCurrent
        });
    });
    
    prevBtn.addEventListener('click', () => {
        loop.pause();
        gsap.to(track, {
            x: `+=${slideW}`,
            duration: 0.5,
            ease: 'power1.inOut',
            onComplete: restartLoopFromCurrent
        });
    });
    
    // 7) Hover: ralentiza/reanuda el bucle
    const slowdownFactor = 0.15;  // % de la velocidad original
    container.addEventListener('mouseenter', () => {
        loop.timeScale(slowdownFactor);
    });
    container.addEventListener('mouseleave', () => {
        loop.timeScale(1);
    });
    
});
    