/**
 * Culqi Checkout v4 Integration - Florería Tulisol
 * Tarjetas de Crédito/Débito y Billeteras Digitales (Yape, Plin)
 */

document.addEventListener('DOMContentLoaded', () => {
    initCulqiCheckout();
    initWhatsAppCheckout();
});

function initCulqiCheckout() {
    const payBtn = document.getElementById('btn-pay-culqi');
    if (!payBtn) return;

    // Obtener llaves y montos desde atributos del DOM
    const culqiPublicKey = payBtn.dataset.publicKey || 'pk_test_a0d8b3684a0d9239';
    const totalAmount = parseFloat(payBtn.dataset.amount || '0');
    const orderTitle = 'Florería Tulisol - Pedido Online';

    // Monto en céntimos para Culqi (ej: S/ 144.00 -> 14400)
    const amountInCents = Math.round(totalAmount * 100);

    // Inicializar Culqi v4
    if (typeof Culqi !== 'undefined') {
        Culqi.publicKey = culqiPublicKey;
        Culqi.settings({
            title: orderTitle,
            currency: 'PEN',
            amount: amountInCents,
            options: {
                lang: 'es',
                installments: true,
                paymentMethods: {
                    tarjeta: true,
                    yape: true,
                    billetera: true,
                    bancaMovil: true,
                    agente: true,
                    cuotealo: true
                }
            }
        });
    }

    // Botón de pago
    payBtn.addEventListener('click', (e) => {
        e.preventDefault();

        // 1. Validar formulario de checkout
        if (!validateCheckoutForm()) {
            return;
        }

        // 2. Abrir Culqi modal
        if (typeof Culqi !== 'undefined') {
            Culqi.open();
        } else {
            // Modo de fallback si no cargó el script externo de Culqi
            alert('Cargando pasarela Culqi... Si estás sin conexión, se procesará en modo de prueba.');
            simulateCulqiPayment();
        }
    });

    // Función callback global requerida por Culqi
    window.culqi = async function() {
        if (Culqi.token) {
            // Token generado exitosamente (Tarjeta o Yape)
            const tokenId = Culqi.token.id;
            Culqi.close();
            await processServerCharge(tokenId);
        } else if (Culqi.order) {
            // Orden generada para PagoEfectivo / Billeteras
            const orderId = Culqi.order.id;
            Culqi.close();
            await processServerCharge(orderId);
        } else {
            // Error en Culqi
            if (Culqi.error) {
                alert('Culqi: ' + Culqi.error.user_message);
            }
        }
    };
}

// Envía el cobro al backend PHP
async function processServerCharge(tokenId) {
    const payBtn = document.getElementById('btn-pay-culqi');
    const originalText = payBtn.innerHTML;
    payBtn.disabled = true;
    payBtn.innerHTML = 'Procesando pago seguro...';

    const formData = getCheckoutFormData();
    formData.token_id = tokenId;

    try {
        const res = await fetch(`${window.BASE_URL}api/culqi/charge`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });

        const data = await res.json();

        if (data.success) {
            window.location.href = data.redirect_url;
        } else {
            alert('Error al procesar el pago: ' + (data.message || 'Intente nuevamente'));
            payBtn.disabled = false;
            payBtn.innerHTML = originalText;
        }
    } catch (err) {
        alert('Error de conexión con el servidor al confirmar el cobro.');
        payBtn.disabled = false;
        payBtn.innerHTML = originalText;
    }
}

// Simulación de prueba para sandbox local
function simulateCulqiPayment() {
    if (confirm('¿Deseas simular un pago exitoso con Culqi (Tarjetas / Yape) en este entorno de prueba?')) {
        const simulatedToken = 'tkn_simulated_' + Math.random().toString(36).substring(7);
        processServerCharge(simulatedToken);
    }
}

// Botón de pago alternativo por WhatsApp
function initWhatsAppCheckout() {
    const btnWsp = document.getElementById('btn-pay-whatsapp');
    if (!btnWsp) return;

    btnWsp.addEventListener('click', async (e) => {
        e.preventDefault();
        if (!validateCheckoutForm()) return;

        const formData = getCheckoutFormData();
        btnWsp.disabled = true;
        btnWsp.innerHTML = 'Generando pedido...';

        try {
            const res = await fetch(`${window.BASE_URL}api/order/offline`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(formData)
            });
            const data = await res.json();
            if (data.success) {
                // Redirigir a confirmación
                window.location.href = data.redirect_url;
            } else {
                alert(data.message || 'Error al registrar pedido.');
                btnWsp.disabled = false;
                btnWsp.innerHTML = 'Confirmar y Enviar por WhatsApp';
            }
        } catch (err) {
            alert('Error de conexión.');
            btnWsp.disabled = false;
        }
    });
}

function getCheckoutFormData() {
    return {
        customer_name: document.getElementById('customer_name')?.value || '',
        customer_email: document.getElementById('customer_email')?.value || '',
        customer_phone: document.getElementById('customer_phone')?.value || '',
        recipient_name: document.getElementById('recipient_name')?.value || '',
        recipient_phone: document.getElementById('recipient_phone')?.value || '',
        delivery_address: document.getElementById('delivery_address')?.value || '',
        delivery_reference: document.getElementById('delivery_reference')?.value || '',
        delivery_date: document.getElementById('delivery_date')?.value || '',
        delivery_time_slot: document.getElementById('delivery_time_slot')?.value || '',
        dedication_message: document.getElementById('dedication_message')?.value || '',
        sender_signature: document.getElementById('sender_signature')?.value || ''
    };
}

function validateCheckoutForm() {
    const required = [
        { id: 'customer_name', name: 'Tu Nombre' },
        { id: 'customer_email', name: 'Tu Correo Electrónico' },
        { id: 'customer_phone', name: 'Tu Teléfono / WhatsApp' },
        { id: 'recipient_name', name: 'Nombre de quien recibe' },
        { id: 'delivery_address', name: 'Dirección de Entrega' },
        { id: 'delivery_date', name: 'Fecha de Entrega' }
    ];

    for (const item of required) {
        const el = document.getElementById(item.id);
        if (!el || !el.value.trim()) {
            alert(`Por favor completa el campo: ${item.name}`);
            if (el) el.focus();
            return false;
        }
    }
    return true;
}
