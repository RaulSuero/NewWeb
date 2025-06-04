document.addEventListener('DOMContentLoaded', () => {
  const modalOverlay = document.getElementById('qrModal');
  const modalClose   = modalOverlay.querySelector('.qr-modal-close');
  const qrImage      = document.getElementById('qrImage');

  // Función para abrir el modal y asignar la URL del QR
  function openQRModal(ev) {
    const orderId = ev.currentTarget.getAttribute('data-order-id');
    // Usamos la API de QR Server en lugar de Google Charts
    const qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='
                  + encodeURIComponent(orderId);
    qrImage.src = qrUrl;
    modalOverlay.style.display = 'flex';
  }

  // Función para cerrar el modal
  function closeModal() {
    modalOverlay.style.display = 'none';
    qrImage.src = '';
  }

  // Asociar evento a todos los botones “Ver QR”
  document.querySelectorAll('.qr-button')
          .forEach(btn => btn.addEventListener('click', openQRModal));

  modalClose.addEventListener('click', closeModal);

  // Cerrar modal si se hace clic fuera de la caja
  modalOverlay.addEventListener('click', e => {
    if (e.target === modalOverlay) closeModal();
  });
});
