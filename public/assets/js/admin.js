/**
 * Florería Tulisol - JavaScript del Panel de Control CMS
 * Previsualización de Imágenes WebP, Pestañas de Configuración y Alertas
 */

document.addEventListener('DOMContentLoaded', () => {
    initSidebarAccordion();
    initWebPImagePreviews();
    initSettingsTabs();
    initConfirmDeletions();
});

// 0. Acordeón del sidebar (abrir/cerrar grupos con click)
function initSidebarAccordion() {
    document.querySelectorAll('.sidebar-group-toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const group = toggle.closest('.sidebar-group');
            if (!group) return;
            const isOpen = group.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            try {
                const key = group.dataset.group;
                if (key) {
                    const open = JSON.parse(localStorage.getItem('tulisol_sidebar_open') || '{}');
                    open[key] = isOpen;
                    localStorage.setItem('tulisol_sidebar_open', JSON.stringify(open));
                }
            } catch (e) { /* sin storage */ }
        });
    });

    // Restaurar estado previo del usuario
    try {
        const open = JSON.parse(localStorage.getItem('tulisol_sidebar_open') || '{}');
        document.querySelectorAll('.sidebar-group').forEach(group => {
            const key = group.dataset.group;
            if (key && typeof open[key] === 'boolean') {
                group.classList.toggle('is-open', open[key]);
                const toggle = group.querySelector('.sidebar-group-toggle');
                if (toggle) toggle.setAttribute('aria-expanded', open[key] ? 'true' : 'false');
            }
        });
    } catch (e) { /* sin storage */ }
}

// 1. Previsualizador de imágenes con aviso de optimización WebP
function initWebPImagePreviews() {
    document.querySelectorAll('.webp-file-input').forEach(input => {
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            const previewContainer = document.getElementById(input.dataset.previewTarget);
            const previewImg = previewContainer?.querySelector('img');
            const noticeEl = document.getElementById(input.dataset.noticeTarget);

            if (file && previewContainer && previewImg) {
                // Verificar extensión y peso
                const validTypes = ['image/webp', 'image/jpeg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    alert('Formato no válido. Seleccione una imagen WebP, JPG o PNG para optimizar.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = (event) => {
                    previewImg.src = event.target.result;
                    previewContainer.style.display = 'block';
                    if (noticeEl) {
                        const originalSizeKb = (file.size / 1024).toFixed(1);
                        noticeEl.innerHTML = `Imagen lista: <strong>${file.name}</strong> (${originalSizeKb} KB). Se convertirá y optimizará en WebP al guardar.`;
                        noticeEl.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });
}

// 2. Navegación por pestañas en Configuración del CMS
function initSettingsTabs() {
    const tabs = document.querySelectorAll('.settings-tabs .tab-btn');
    const panes = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetId = tab.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.classList.remove('active'));

            tab.classList.add('active');
            const targetPane = document.getElementById(targetId);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        });
    });
}

// 3. Confirmación de eliminación segura
function initConfirmDeletions() {
    document.querySelectorAll('.btn-confirm-delete').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const itemName = btn.dataset.name || 'este elemento';
            if (!confirm(`¿Estás seguro de que deseas eliminar permanentemente ${itemName}? Esta acción no se puede deshacer.`)) {
                e.preventDefault();
            }
        });
    });
}
