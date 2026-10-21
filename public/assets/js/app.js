/**
 * Florería Tulisol - JavaScript Principal Frontend
 * Carrito Drawer, AJAX, Notificaciones y Menú Móvil
 */

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initCategoryNav();
    initCartDrawer();
    initAddToCartButtons();
    initQuickQuantity();
    initWhatsAppBuyButtons();
});

// 1. Menú Móvil
function initMobileMenu() {
    const toggle = document.querySelector('.mobile-menu-toggle');
    const menu = document.querySelector('.mobile-nav-menu');
    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('open');
        });
    }
}

// 1b. Barra de Categorías (píldoras): centrar activa + degradado
function initCategoryNav() {
    const nav = document.querySelector('.category-nav');
    const scroller = document.querySelector('.category-nav-scroll');
    if (!nav || !scroller) return;

    // Centrar la píldora activa al cargar
    const activePill = scroller.querySelector('.cat-pill.active');
    if (activePill) {
        const offset = activePill.offsetLeft - (scroller.clientWidth / 2) + (activePill.clientWidth / 2);
        scroller.scrollLeft = Math.max(0, offset);
    }

    // Ocultar degradado cuando se llega al final del scroll
    function updateFade() {
        const atEnd = scroller.scrollLeft + scroller.clientWidth >= scroller.scrollWidth - 8;
        nav.classList.toggle('at-end', atEnd);
    }
    scroller.addEventListener('scroll', updateFade, { passive: true });
    updateFade();

    // Arrastre con mouse en desktop
    let isDown = false, startX = 0, startScroll = 0;
    scroller.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX;
        startScroll = scroller.scrollLeft;
        scroller.style.cursor = 'grabbing';
        scroller.style.scrollBehavior = 'auto';
    });
    window.addEventListener('mouseup', () => {
        isDown = false;
        scroller.style.cursor = '';
        scroller.style.scrollBehavior = '';
    });
    window.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        scroller.scrollLeft = startScroll - (e.pageX - startX);
    });
}

// 2. Carrito Drawer
function initCartDrawer() {
    const trigger = document.querySelector('.cart-btn-trigger');
    const overlay = document.querySelector('.cart-drawer-overlay');
    const drawer = document.querySelector('.cart-drawer');
    const closeBtn = document.querySelector('.drawer-close-btn');

    if (!drawer) return;

    function openCart() {
        if (overlay) overlay.classList.add('active');
        drawer.classList.add('active');
        fetchCart();
    }

    function closeCart() {
        if (overlay) overlay.classList.remove('active');
        drawer.classList.remove('active');
    }

    if (trigger) trigger.addEventListener('click', openCart);
    if (closeBtn) closeBtn.addEventListener('click', closeCart);
    if (overlay) overlay.addEventListener('click', closeCart);

    window.openCartDrawer = openCart;
    window.closeCartDrawer = closeCart;
}

// 3. Obtener y Renderizar Carrito vía API
async function fetchCart() {
    try {
        const res = await fetch(`${window.BASE_URL}api/cart`);
        const data = await res.json();
        if (data.success) {
            renderCartDrawer(data);
            updateCartBadges(data.totalItems);
        }
    } catch (e) {
        console.error('Error fetching cart:', e);
    }
}

function updateCartBadges(count) {
    document.querySelectorAll('.cart-badge').forEach(b => {
        b.textContent = count;
        b.style.display = count > 0 ? 'inline-block' : 'none';
    });
}

function renderCartDrawer(data) {
    const container = document.getElementById('drawer-items-list');
    const subtotalEl = document.getElementById('drawer-subtotal');
    const totalEl = document.getElementById('drawer-total');

    if (!container) return;

    if (data.cart.length === 0) {
        container.innerHTML = `
            <div style="text-align: center; padding: 3rem 1rem; color: #6d5b60;">
                <div style="margin-bottom: 1rem; color: var(--primary, #c4788c); display: flex; justify-content: center;">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                </div>
                <h4 style="font-size: 1.1rem; color: #332629; margin-bottom: 0.5rem;">Tu carrito está vacío</h4>
                <p style="font-size: 0.85rem; margin-bottom: 1.5rem;">Enamórate de nuestros ramos frescos y llena tu día de color.</p>
                <a href="${window.BASE_URL}catalogo" class="btn btn-primary btn-sm">Explorar Catálogo</a>
            </div>
        `;
        if (subtotalEl) subtotalEl.textContent = 'S/ 0.00';
        if (totalEl) totalEl.textContent = 'S/ 0.00';
        return;
    }

    let html = '';
    data.cart.forEach(item => {
        const imgUrl = `${window.BASE_URL}${item.image}`;
        html += `
            <div class="cart-item-row" data-id="${item.product_id}">
                <img src="${imgUrl}" alt="${item.name}" class="cart-item-img">
                <div class="cart-item-info">
                    <h5>${item.name}</h5>
                    <div class="cart-item-price">${item.priceText} x ${item.quantity}</div>
                    ${item.dedication ? `<small style="color: #9e5365; display: block; font-size: 0.75rem;">Nota de dedicatoria incluida</small>` : ''}
                </div>
                <button type="button" class="cart-item-remove" onclick="removeCartItem(${item.product_id})" title="Eliminar" style="display: flex; align-items: center; justify-content: center;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
        `;
    });

    container.innerHTML = html;
    if (subtotalEl) subtotalEl.textContent = data.subtotalText;
    if (totalEl) totalEl.textContent = data.totalText;
}

// 4. Agregar al Carrito
function initAddToCartButtons() {
    document.querySelectorAll('.btn-add-cart-action').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            const pid = btn.dataset.productId;
            const dedicationInput = document.getElementById('product-dedication-note');
            const qtyInput = document.getElementById('product-detail-qty');

            const payload = {
                product_id: parseInt(pid),
                quantity: qtyInput ? parseInt(qtyInput.value) || 1 : 1,
                dedication: dedicationInput ? dedicationInput.value : ''
            };

            const originalText = btn.innerHTML;
            btn.innerHTML = 'Agregando...';
            btn.disabled = true;

            try {
                const res = await fetch(`${window.BASE_URL}api/cart/add`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (data.success) {
                    showToast('¡Arreglo añadido al carrito!', 'success');
                    renderCartDrawer(data);
                    updateCartBadges(data.totalItems);
                    if (window.openCartDrawer) window.openCartDrawer();
                } else {
                    showToast(data.message || 'Error al agregar', 'error');
                }
            } catch (err) {
                showToast('Error de conexión', 'error');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    });
}

// 5. Eliminar del Carrito
window.removeCartItem = async function(pid) {
    try {
        const res = await fetch(`${window.BASE_URL}api/cart/remove`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: pid })
        });
        const data = await res.json();
        if (data.success) {
            renderCartDrawer(data);
            updateCartBadges(data.totalItems);
        }
    } catch (e) {
        console.error(e);
    }
};

// 6. Controles de cantidad en la vista de detalle
function initQuickQuantity() {
    const decBtn = document.getElementById('qty-decrease');
    const incBtn = document.getElementById('qty-increase');
    const input = document.getElementById('product-detail-qty');

    if (decBtn && incBtn && input) {
        decBtn.addEventListener('click', () => {
            let v = parseInt(input.value) || 1;
            if (v > 1) input.value = v - 1;
        });
        incBtn.addEventListener('click', () => {
            let v = parseInt(input.value) || 1;
            input.value = v + 1;
        });
    }
}

// 7. Comprar por WhatsApp (mensaje completo del producto)
function initWhatsAppBuyButtons() {
    document.querySelectorAll('.btn-wsp-buy').forEach(el => {
        el.addEventListener('click', () => {
            if (el.dataset.detail !== '1') return;

            const qtyInput = document.getElementById('product-detail-qty');
            const dedInput = document.getElementById('product-dedication-note');
            const qty = qtyInput ? (parseInt(qtyInput.value) || 1) : 1;
            const priceNum = parseFloat(el.dataset.priceNum || '0');

            try {
                const url = new URL(el.getAttribute('href'));
                const phone = url.pathname.replace(/\//g, '');
                const lines = (url.searchParams.get('text') || '').split('\n');

                let idx = -1;
                lines.forEach((line, i) => {
                    if (line.startsWith('Precio:') || line.startsWith('Antes:')) idx = i;
                });

                const subtotal = (priceNum * qty).toLocaleString('es-PE', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                const extra = [`Cantidad: ${qty}`, `Subtotal: S/ ${subtotal}`];

                if (idx >= 0) {
                    lines.splice(idx + 1, 0, ...extra);
                } else {
                    lines.push(...extra);
                }

                if (dedInput && dedInput.value.trim()) {
                    lines.push('', 'Dedicatoria: ' + dedInput.value.trim());
                }

                el.setAttribute('href', `https://wa.me/${phone}?text=${encodeURIComponent(lines.join('\n'))}`);
            } catch (err) {
                console.error('Error enlace WhatsApp:', err);
            }
        });
    });
}

// 8. Notificación Toast Flotante
function showToast(message, type = 'info') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.style.position = 'fixed';
        container.style.bottom = '24px';
        container.style.left = '24px';
        container.style.zIndex = '9999';
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        container.style.gap = '8px';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.style.background = type === 'success' ? '#10b981' : (type === 'error' ? '#ef4444' : '#3b82f6');
    toast.style.color = '#fff';
    toast.style.padding = '0.75rem 1.25rem';
    toast.style.borderRadius = '9999px';
    toast.style.fontSize = '0.9rem';
    toast.style.fontWeight = '600';
    toast.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
    toast.style.transition = 'all 0.3s ease';
    toast.textContent = message;

    container.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        setTimeout(() => toast.remove(), 300);
    }, 3200);
}
window.showToast = showToast;
