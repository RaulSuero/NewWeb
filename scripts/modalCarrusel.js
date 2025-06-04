document.addEventListener('DOMContentLoaded', () => {
  // --- Referencias al Modal de Info ---
  const infoOverlay = document.getElementById('event-modal');
  const infoModal   = infoOverlay.querySelector('.modal');
  const infoClose   = infoOverlay.querySelector('.modal-close');
  const imgEl       = infoOverlay.querySelector('.modal-image');
  const titleEl     = infoOverlay.querySelector('.modal-title');
  const subEl       = infoOverlay.querySelector('.modal-subtitle');
  const locEl       = infoOverlay.querySelector('.modal-location');
  const dateEl      = infoOverlay.querySelector('.modal-datetime');
  const descEl      = infoOverlay.querySelector('.modal-description');
  const priceEl     = infoOverlay.querySelector('.modal-price');
  const buyBtn      = infoOverlay.querySelector('.modal-buy');

  // --- Referencias al Modal de PayPal ---
  const ppOverlay    = document.getElementById('paypalCheckoutModal');
  const ppModal      = ppOverlay.querySelector('.paypal-modal');
  const ppClose      = ppOverlay.querySelector('.paypal-modal-close');
  const qtyInput     = ppOverlay.querySelector('#paypal-quantity');
  const ppContainer  = document.getElementById('paypal-button-container-checkout');

  // Mueve ambos modales al raíz del documento para evitar issues de transform/overflow
  [infoOverlay, ppOverlay].forEach(ov => {
    if (ov.parentNode !== document.documentElement) {
      document.documentElement.appendChild(ov);
    }
    // y forzamos fixed + inset
    Object.assign(ov.style, {
      position: 'fixed',
      inset:    '0',
      zIndex:   ov === infoOverlay ? '2000' : '2001'
    });
  });

  // Función para abrir el modal de PayPal
  function openPayPalModal(unitPrice) {
    // Oculta info-modal
    closeInfoModal();

    // Muestra PayPal-modal
    ppOverlay.hidden = false;
    qtyInput.value   = 1;
    ppContainer.innerHTML = '';  // limpia

    // Renderiza botones PayPal
    paypal.Buttons({
      createOrder: (data, actions) => {
        const qty   = Math.max(1, parseInt(qtyInput.value, 10) || 1);
        const total = (unitPrice * qty).toFixed(2);
        return actions.order.create({
          purchase_units: [{ amount: { value: total } }]
        });
      },
      onApprove: (data, actions) =>
        actions.order.capture().then(details => {
          alert(`Gracias, ${details.payer.name.given_name}! Compraste ${qtyInput.value} entrada(s).`);
          closePPModal();
        })
    })
    .render('#paypal-button-container-checkout')
    .catch(err => {
      console.error(err);
      alert('Error al cargar PayPal.');
      closePPModal();
    });
  }

  // Cierra el PayPal-modal
  function closePPModal() {
    ppOverlay.hidden = true;
  }

  // Abre info-modal rellenándolo desde data-attributes de la tarjeta
  function openInfoModal(ev) {
    const card  = ev.currentTarget;
    const price = parseFloat(card.dataset.price) || 0;

    imgEl.src           = card.dataset.image;
    imgEl.alt           = card.dataset.title;
    titleEl.textContent = card.dataset.title;
    subEl.textContent   = card.dataset.subtitle;
    locEl.textContent   = card.dataset.location;
    dateEl.textContent  = card.dataset.datetime;
    descEl.textContent  = card.dataset.description;
    priceEl.textContent = `Precio unitario: ${price.toFixed(2)} €`;

    infoOverlay.hidden = false;

    // Animación de entrada (opcional)
    if (window.gsap) {
      gsap.set(infoOverlay, { autoAlpha: 0 });
      gsap.set(infoModal,   { autoAlpha: 0, scale: 0.8 });
      gsap.to(infoOverlay,  { autoAlpha: 1, duration: 0.3, ease: 'power1.out' });
      gsap.to(infoModal,    { autoAlpha: 1, scale: 1,   duration: 0.5, ease: 'back.out(1.2)' });
    }
  }

  // Cierra el info-modal
  function closeInfoModal() {
    if (window.gsap) {
      gsap.to(infoModal,   { autoAlpha: 0, scale: 0.8, duration: 0.3, ease: 'power1.in' });
      gsap.to(infoOverlay,{ autoAlpha: 0, duration: 0.3, ease: 'power1.in',
        onComplete: () => infoOverlay.hidden = true
      });
    } else {
      infoOverlay.hidden = true;
    }
  }

  // Asocia eventos
  document.querySelectorAll('.event-card').forEach(card => {
    card.style.cursor = 'pointer';
    card.addEventListener('click', openInfoModal);
  });
  infoClose.addEventListener('click', closeInfoModal);
  infoOverlay.addEventListener('click', e => {
    if (e.target === infoOverlay) closeInfoModal();
  });

  // Cuando se pulsa "Comprar" en el info-modal, abre el PayPal-modal
  buyBtn.addEventListener('click', ev => {
    ev.stopPropagation();  // no reabre info-modal
    const unitPrice = parseFloat(ev.currentTarget.closest('.modal').querySelector('.modal-price').textContent.replace(/[^\d.]/g, '')) || 0;
    openPayPalModal(unitPrice);
  });

  // Asocia cierre del PayPal-modal
  ppClose.addEventListener('click', closePPModal);
  ppOverlay.addEventListener('click', e => {
    if (e.target === ppOverlay) closePPModal();
  });
});
