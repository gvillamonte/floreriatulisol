<!-- ========================================================
     Página de Contacto y Ubicación - Florería Tulisol
     ======================================================== -->

<div class="catalog-page-header">
    <div class="container">
        <span class="section-badge">Atención al Cliente</span>
        <h1 style="font-size: 2.75rem; color: var(--text-main); margin-bottom: 0.5rem;">Contáctanos y Visítanos</h1>
        <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto;">
            Estamos aquí para ayudarte a elegir el arreglo floral ideal para esa persona especial.
        </p>
    </div>
</div>

<div class="container" style="padding: 4rem 1.25rem 6rem;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3.5rem; align-items: start;">
        <!-- Formulario de Contacto -->
        <div style="background: #fff; border-radius: 16px; padding: 2.5rem; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
            <h3 style="font-size: 1.35rem; color: var(--text-main); margin-bottom: 0.5rem;">Envíanos un Mensaje</h3>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Responderemos tu consulta en menos de 15 minutos.</p>

            <form action="<?= BASE_URL ?>contacto/enviar" method="POST">
                <div class="form-group">
                    <label class="form-label" for="contact_name">Tu Nombre *</label>
                    <input type="text" id="contact_name" name="name" class="form-control" placeholder="Carlos Mendoza" required>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label" for="contact_email">Correo Electrónico *</label>
                        <input type="email" id="contact_email" name="email" class="form-control" placeholder="carlos@correo.com" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="contact_phone">Teléfono / WhatsApp</label>
                        <input type="tel" id="contact_phone" name="phone" class="form-control" placeholder="+51 984 ...">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="contact_subject">Asunto</label>
                    <input type="text" id="contact_subject" name="subject" class="form-control" placeholder="Consulta sobre evento o ramo especial">
                </div>

                <div class="form-group">
                    <label class="form-label" for="contact_message">Mensaje *</label>
                    <textarea id="contact_message" name="message" class="form-control" rows="4" placeholder="¿En qué te podemos ayudar?" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <?= View::icon('mail', 18) ?> Enviar Mensaje
                </button>
            </form>
        </div>

        <!-- Tarjetas de Información y Mapa -->
        <div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                <div style="background: #fff; padding: 1.5rem; border-radius: 14px; border: 1px solid var(--border-color, #f5e4e8);">
                    <div style="color: var(--primary); margin-bottom: 0.75rem;"><?= View::icon('pin', 26) ?></div>
                    <h4 style="font-size: 1rem; color: var(--text-main); margin-bottom: 0.25rem;">Nuestra Tienda</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);"><?= View::e($settings['site_address'] ?? 'Av. El Sol 452, Cusco') ?></p>
                </div>

                <div style="background: #fff; padding: 1.5rem; border-radius: 14px; border: 1px solid var(--border-color, #f5e4e8);">
                    <div style="color: var(--primary); margin-bottom: 0.75rem;"><?= View::icon('phone', 26) ?></div>
                    <h4 style="font-size: 1rem; color: var(--text-main); margin-bottom: 0.25rem;">Teléfonos</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);"><?= View::e($settings['site_phone'] ?? '+51 932 070 468') ?></p>
                </div>

                <div style="background: #fff; padding: 1.5rem; border-radius: 14px; border: 1px solid var(--border-color, #f5e4e8);">
                    <div style="color: var(--primary); margin-bottom: 0.75rem;"><?= View::icon('clock', 26) ?></div>
                    <h4 style="font-size: 1rem; color: var(--text-main); margin-bottom: 0.25rem;">Horario</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);"><?= View::e($settings['site_schedule'] ?? 'Lun - Dom: 8am - 9pm') ?></p>
                </div>

                <div style="background: #fff; padding: 1.5rem; border-radius: 14px; border: 1px solid var(--border-color, #f5e4e8);">
                    <div style="color: var(--primary); margin-bottom: 0.75rem;"><?= View::icon('mail', 26) ?></div>
                    <h4 style="font-size: 1rem; color: var(--text-main); margin-bottom: 0.25rem;">Correo</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);"><?= View::e($settings['site_email'] ?? 'ventas@floreriatulisol.com') ?></p>
                </div>
            </div>

            <!-- Mapa de Google Maps -->
            <div style="background: #fff; border-radius: 14px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: var(--shadow-sm);">
                <?= $settings['site_maps_embed'] ?? '' ?>
            </div>
        </div>
    </div>
</div>
