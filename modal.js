document.addEventListener('DOMContentLoaded', () => {
    // GSAP info-modal
    const infoOverlay  = document.getElementById('event-modal');
    const infoModal    = infoOverlay.querySelector('.modal');
    const infoClose    = infoOverlay.querySelector('.modal-close');
    const imgEl        = infoOverlay.querySelector('.modal-image');
    const titleEl      = infoOverlay.querySelector('.modal-title');
    const subEl        = infoOverlay.querySelector('.modal-subtitle');
    const priceEl      = infoOverlay.querySelector('.modal-price');
    const locEl        = infoOverlay.querySelector('.modal-location');
    const dateEl       = infoOverlay.querySelector('.modal-datetime');
    const descEl       = infoOverlay.querySelector('.modal-description');
    const buyInfoBtn   = infoOverlay.querySelector('.modal-buy');
  
    // PayPal-modal
    const ppOverlay    = document.getElementById('paypalCheckoutModal');
    const ppClose      = ppOverlay.querySelector('.paypal-modal-close');
    const ppContainer  = document.getElementById('paypal-button-container-checkout');
    const qtyInput     = ppOverlay.querySelector('#paypal-quantity');
  
    // Abre el PayPal Modal con cantidad + precio
    function openPayPalModal(unitPrice) {
        ppOverlay.hidden = false;
        ppContainer.innerHTML = '';
        qtyInput.value = 1; // reset
    
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
            alert('Error al cargar la pasarela de pago.');
            closePPModal();
        });
    }
  
    // Cerrar modales
    function closeInfoModal() {
        gsap.to(infoModal, { autoAlpha:0, scale:0.8, duration:0.3, ease:'power1.in' });
        gsap.to(infoOverlay, { autoAlpha:0, duration:0.3, ease:'power1.in',
            onComplete:() => infoOverlay.hidden = true
        });
    }
    function closePPModal() {
        ppOverlay.hidden = true;
    }
  
    // Abre modal de info y prepara botón “Comprar”
    function openInfoModal(ev) {
        const card      = ev.currentTarget.closest('.card');
        const unitPrice = parseFloat(card.dataset.price) || 0;
    
        // Rellenar campos
        imgEl.src      = card.dataset.image;
        imgEl.alt      = card.dataset.title;
        titleEl.textContent = card.dataset.title;
        subEl.textContent   = card.dataset.subtitle;
        priceEl.textContent = `Precio unitario: ${unitPrice.toFixed(2)} €`;
        locEl.textContent   = card.dataset.location;
        dateEl.textContent  = card.dataset.datetime;
        descEl.textContent  = card.dataset.description;
    
        // Pulsar “Comprar” cierra info-modal y abre PayPal-modal
        buyInfoBtn.onclick = () => {
            closeInfoModal();
            openPayPalModal(unitPrice);
        };
    
        // Animación de apertura
        infoOverlay.hidden = false;
        gsap.set(infoOverlay,  { autoAlpha:0 });
        gsap.set(infoModal,    { autoAlpha:0, scale:0.8 });
        gsap.to(infoOverlay,  { autoAlpha:1, duration:0.3, ease:'power1.out' });
        gsap.to(infoModal,    { autoAlpha:1, scale:1, duration:0.5, ease:'back.out(1.2)' });
    }
  
    // Eventos
    document.querySelectorAll('.card .info_button')
            .forEach(btn => btn.addEventListener('click', openInfoModal));
    infoClose.addEventListener('click', closeInfoModal);
    infoOverlay.addEventListener('click', e => {
        if (e.target === infoOverlay) closeInfoModal();
    });
  
    ppClose.addEventListener('click', closePPModal);
    ppOverlay.addEventListener('click', e => {
        if (e.target === ppOverlay) closePPModal();
    });
});
  