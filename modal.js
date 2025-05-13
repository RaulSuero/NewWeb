document.addEventListener('DOMContentLoaded', () => {
    // Asegúrate de haber cargado GSAP antes de este script
    const modalOverlay = document.getElementById('event-modal');
    const modal        = modalOverlay.querySelector('.modal');
    const closeBtn     = modalOverlay.querySelector('.modal-close');
  
    // campos del modal
    const imgEl    = modalOverlay.querySelector('.modal-image');
    const titleEl  = modalOverlay.querySelector('.modal-title');
    const subEl    = modalOverlay.querySelector('.modal-subtitle');
    const locEl    = modalOverlay.querySelector('.modal-location');
    const dateEl   = modalOverlay.querySelector('.modal-datetime');
    const descEl   = modalOverlay.querySelector('.modal-description');
  
    function openModal(ev) {
      const card = ev.currentTarget.closest('.card');
      imgEl.src        = card.dataset.image;
      imgEl.alt        = card.dataset.title;
      titleEl.textContent     = card.dataset.title;
      subEl.textContent       = card.dataset.subtitle;
      locEl.textContent       = card.dataset.location;
      dateEl.textContent      = card.dataset.datetime;
      descEl.textContent      = card.dataset.description;
  
      // Quitamos hidden para mostrar el overlay
      modalOverlay.hidden = false;
  
      // Inicializamos estado oculto para animar
      gsap.set(modalOverlay, { autoAlpha: 0 });
      gsap.set(modal, { autoAlpha: 0, scale: 0.8 });
  
      // Fade-in del overlay
      gsap.to(modalOverlay, {
        autoAlpha: 1,
        duration: 0.3,
        ease: 'power1.out'
      });
  
      // Pop-in de la caja
      gsap.to(modal, {
        autoAlpha: 1,
        scale: 1,
        duration: 0.5,
        ease: 'back.out(1.2)'
      });
    }
  
    function closeModal() {
      // Animación de salida invertida
      gsap.to(modal, {
        autoAlpha: 0,
        scale: 0.8,
        duration: 0.3,
        ease: 'power1.in'
      });
      gsap.to(modalOverlay, {
        autoAlpha: 0,
        duration: 0.3,
        ease: 'power1.in',
        onComplete: () => {
          modalOverlay.hidden = true;
        }
      });
    }
  
    // Asociar eventos
    document.querySelectorAll('.card .info_button')
            .forEach(btn => btn.addEventListener('click', openModal));
    closeBtn.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', e => {
      if (e.target === modalOverlay) {
        closeModal();
      }
    });
  });
  