document.addEventListener('DOMContentLoaded', () => {
    const modalOverlay = document.getElementById('paypalCheckoutModal');
    const modalClose   = modalOverlay.querySelector('.paypal-modal-close');
    const buttonDiv    = document.getElementById('paypal-button-container-checkout');
    const qtyInput     = document.getElementById('paypal-quantity');

    function openPayPalModal(ev) {
    const btn       = ev.currentTarget;
    const unitPrice = parseFloat(btn.dataset.price)  || 0;
    const showId    = parseInt(btn.dataset.showId, 10) || 0;

    // Mostrar modal y limpiar contenedor
    modalOverlay.hidden = false;
    buttonDiv.innerHTML = '';
    qtyInput.value      = 1;

    paypal.Buttons({
        createOrder: (data, actions) => {
        const qty   = Math.max(1, parseInt(qtyInput.value, 10) || 1);
        const total = (unitPrice * qty).toFixed(2);

        return actions.order.create({
            purchase_units: [{
            amount: {
                value: total,
                currency_code: 'EUR'
            }
            }]
        });
        },
        onApprove: (data, actions) => {
        return actions.order.capture().then(details => {
            // Preparamos los datos a guardar
            const payload = {
            order_id: data.orderID,
            payer_id: details.payer.payer_id,
            show_id: showId,
            quantity: parseInt(qtyInput.value, 10),
            amount: details.purchase_units[0].amount.value,
            currency: details.purchase_units[0].amount.currency_code,
            status: details.status
            };

            // Llamada AJAX a nuestro endpoint PHP
            return fetch('save-order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(res => {
            if (res.ok) {
                alert(`¡Gracias, ${details.payer.name.given_name}! Pedido registrado.`);
            } else {
                console.error('Error al guardar pedido:', res.error);
                alert('Pago OK, pero no se pudo registrar la compra.');
            }
            closeModal();
            })
            .catch(err => {
            console.error('Error de red:', err);
            alert('Pago OK, pero fallo de red al guardar la compra.');
            closeModal();
            });
        });
        },
        onError: err => {
        console.error('Error PayPal:', err);
        alert('Hubo un error procesando el pago.');
        closeModal();
        }
    })
    .render('#paypal-button-container-checkout')
    .catch(err => {
        console.error('No se pudo cargar PayPal:', err);
        alert('No se pudo inicializar PayPal.');
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
