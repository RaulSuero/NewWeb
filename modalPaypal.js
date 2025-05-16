document.addEventListener('DOMContentLoaded', () => {
    const modalOverlay = document.getElementById('paypalCheckoutModal');
    const modalClose = modalOverlay.querySelector('.paypal-modal-close');
    const buttonDiv = document.getElementById('paypal-button-container-checkout');
    const qtyInput = document.getElementById('paypal-quantity');
  
    function openPayPalModal(ev) {
        // 1) Obtener precio unitario del botón
        const btn = ev.currentTarget;
        const unitPrice = parseFloat(btn.dataset.price) || 0;
    
        // 2) Mostrar modal y limpiar contenedor
        modalOverlay.hidden = false;
        buttonDiv.innerHTML = '';
    
        // 3) Cuando cambiemos la cantidad, podemos opcionalmente
        //    actualizar algo previo al pago (no imprescindible).
        qtyInput.value = 1;
    
        // 4) Cargar y renderizar PayPal
        paypal.Buttons({
            createOrder: (data, actions) => {
                // lee cantidad y calcula total
                const qty = parseInt(qtyInput.value, 10) || 1;
                const total = (unitPrice * qty).toFixed(2);
        
                return actions.order.create({
                    purchase_units: [{
                        amount: { value: total }
                    }]
                });
            },
            onApprove: (data, actions) => {
                return actions.order.capture().then(details => {
                    alert(`Gracias, ${details.payer.name.given_name}! Compraste ${qtyInput.value} entrada(s).`);
                    closeModal();
                });
            }
        })
        .render('#paypal-button-container-checkout')
        .catch(err => {
            console.error(err);
            alert('No se pudo cargar PayPal.');
            closeModal();
        });
    }
  
    function closeModal() {
      modalOverlay.hidden = true;
    }
  
    // Asociamos los botones “Comprar”
    document.querySelectorAll('.card .buy_button')
            .forEach(btn => btn.addEventListener('click', openPayPalModal));
  
    modalClose.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', e => {
        if (e.target === modalOverlay) closeModal();
    });
});
  