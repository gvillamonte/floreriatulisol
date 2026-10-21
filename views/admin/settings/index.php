<!-- ========================================================
     Configuración de la Empresa, Logo WebP y Pasarela Culqi
     Florería Tulisol CMS
     ======================================================== -->

<div class="card" style="max-width: 1000px; margin: 0 auto 3rem;">
    <div class="card-header">
        <div>
            <h3>Configuración del Negocio y Pasarela Culqi</h3>
            <span style="font-size: 0.85rem; color: #64748b;">Edita datos de la empresa, redes, logotipos WebP y pasarela de pago.</span>
        </div>
    </div>

    <div class="card-body">
        <!-- Navegación por Pestañas -->
        <div class="settings-tabs">
            <button type="button" class="tab-btn active" data-tab="tab-branding" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                <?= View::icon('flower', 16) ?> <span>Marca y Logos (WebP)</span>
            </button>
            <button type="button" class="tab-btn" data-tab="tab-contact" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                <?= View::icon('pin', 16) ?> <span>Contacto y Tienda</span>
            </button>
            <button type="button" class="tab-btn" data-tab="tab-about" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                <?= View::icon('book', 16) ?> <span>Quiénes Somos</span>
            </button>
            <button type="button" class="tab-btn" data-tab="tab-culqi" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                <?= View::icon('card', 16) ?> <span>Pasarela Culqi y Pagos</span>
            </button>
            <button type="button" class="tab-btn" data-tab="tab-shipping" style="display: inline-flex; align-items: center; gap: 0.4rem;">
                <?= View::icon('truck', 16) ?> <span>Delivery y Tarifas</span>
            </button>
        </div>

        <form action="<?= BASE_URL ?>admin/configuracion/guardar" method="POST" enctype="multipart/form-data">
            
            <!-- PESTAÑA 1: Marca y Logos WebP -->
            <div id="tab-branding" class="tab-pane active">
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="site_name">Nombre de la Florería / Empresa *</label>
                        <input type="text" id="site_name" name="site_name" class="form-control" value="<?= View::e($settings['site_name'] ?? 'Florería Tulisol') ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="site_tagline">Eslogan / Slogan Comercial</label>
                        <input type="text" id="site_tagline" name="site_tagline" class="form-control" value="<?= View::e($settings['site_tagline'] ?? '') ?>">
                    </div>
                </div>

                <!-- Subida de Logotipo WebP -->
                <div style="background: #f8fafc; border-radius: 14px; padding: 1.5rem; border: 1px solid #e2e8f0; margin-bottom: 2rem;">
                    <h4 style="font-size: 1rem; color: #0f172a; margin-bottom: 0.5rem;">Logotipo Oficial de la Empresa</h4>
                    <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1rem;">
                        Las imágenes subidas son convertidas y optimizadas automáticamente a formato <strong>.webp</strong> para máxima velocidad en Google PageSpeed.
                    </p>

                    <div style="display: flex; gap: 2rem; align-items: center; flex-wrap: wrap;">
                        <div>
                            <span style="font-size: 0.75rem; color: #64748b; display: block; margin-bottom: 0.35rem;">Logo actual:</span>
                            <div style="background: #fff; padding: 0.75rem; border-radius: 10px; border: 1px solid #cbd5e1; display: inline-block;">
                                <img src="<?= View::upload($settings['site_logo'] ?? 'uploads/branding/logo.webp') ?>" alt="Logo actual" style="height: 60px; object-fit: contain;">
                            </div>
                        </div>

                        <div style="flex-grow: 1;">
                            <label class="form-label">Subir nuevo logo (WebP, PNG, JPG):</label>
                            <input type="file" name="site_logo" class="webp-file-input form-control" data-preview-target="logo-preview-box" data-notice-target="logo-notice" accept="image/webp,image/png,image/jpeg">
                            <span class="webp-badge-notice">Se guardará como WebP comprimido sin perder nitidez</span>
                            
                            <div id="logo-preview-box" class="preview-container" style="margin-top: 0.75rem;">
                                <img src="" alt="Previsualización Logo">
                            </div>
                            <div id="logo-notice" style="display: none; font-size: 0.8rem; color: #059669; margin-top: 0.35rem; font-weight: 600;"></div>
                        </div>
                    </div>
                </div>

                <!-- Subida de Favicon WebP -->
                <div style="background: #f8fafc; border-radius: 14px; padding: 1.5rem; border: 1px solid #e2e8f0; margin-bottom: 1.5rem;">
                    <h4 style="font-size: 1rem; color: #0f172a; margin-bottom: 0.5rem;">Favicon (Ícono del Navegador)</h4>
                    <div style="display: flex; gap: 2rem; align-items: center; flex-wrap: wrap;">
                        <div>
                            <span style="font-size: 0.75rem; color: #64748b; display: block; margin-bottom: 0.35rem;">Favicon actual:</span>
                            <div style="background: #fff; padding: 0.5rem; border-radius: 8px; border: 1px solid #cbd5e1; display: inline-block;">
                                <img src="<?= View::upload($settings['site_favicon'] ?? 'uploads/branding/favicon.webp') ?>" alt="Favicon" style="width: 32px; height: 32px; object-fit: contain;">
                            </div>
                        </div>

                        <div style="flex-grow: 1;">
                            <label class="form-label">Subir nuevo favicon:</label>
                            <input type="file" name="site_favicon" class="form-control" accept="image/webp,image/png,image/jpeg">
                        </div>
                    </div>
                </div>
            </div>

            <!-- PESTAÑA 2: Contacto y Tienda -->
            <div id="tab-contact" class="tab-pane">
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="site_phone">Teléfono de Contacto</label>
                        <input type="text" id="site_phone" name="site_phone" class="form-control" value="<?= View::e($settings['site_phone'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="site_email">Correo Electrónico de la Tienda</label>
                        <input type="email" id="site_email" name="site_email" class="form-control" value="<?= View::e($settings['site_email'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="site_whatsapp">Número de WhatsApp (con código de país sin '+')</label>
                        <input type="text" id="site_whatsapp" name="site_whatsapp" class="form-control" value="<?= View::e($settings['site_whatsapp'] ?? '51932070468') ?>" placeholder="51932070468">
                        <small style="color: #64748b; font-size: 0.75rem;">Ejemplo para Perú: 51 seguido de 9 dígitos.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="site_whatsapp_msg">Mensaje Inicial de WhatsApp</label>
                        <input type="text" id="site_whatsapp_msg" name="site_whatsapp_msg" class="form-control" value="<?= View::e($settings['site_whatsapp_msg'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="site_address">Dirección Física de la Florería</label>
                    <input type="text" id="site_address" name="site_address" class="form-control" value="<?= View::e($settings['site_address'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="site_schedule">Horario de Atención</label>
                    <input type="text" id="site_schedule" name="site_schedule" class="form-control" value="<?= View::e($settings['site_schedule'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="site_maps_embed">Código de Incrustación de Google Maps (&lt;iframe&gt;)</label>
                    <textarea id="site_maps_embed" name="site_maps_embed" class="form-control" rows="3"><?= View::e($settings['site_maps_embed'] ?? '') ?></textarea>
                </div>

                <!-- Redes Sociales -->
                <div style="background: #f8fafc; border-radius: 12px; padding: 1.25rem; border: 1px solid #e2e8f0; margin-top: 1.5rem;">
                    <h4 style="font-size: 0.95rem; color: #0f172a; margin-bottom: 1rem;">Redes Sociales de la Florería</h4>
                    <div class="form-row-3">
                        <div class="form-group">
                            <label class="form-label">Instagram URL</label>
                            <input type="url" name="instagram_url" class="form-control" value="<?= View::e($settings['instagram_url'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Facebook URL</label>
                            <input type="url" name="facebook_url" class="form-control" value="<?= View::e($settings['facebook_url'] ?? '') ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">TikTok URL</label>
                            <input type="url" name="tiktok_url" class="form-control" value="<?= View::e($settings['tiktok_url'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- PESTAÑA 3: Quiénes Somos -->
            <div id="tab-about" class="tab-pane">
                <div class="form-group">
                    <label class="form-label" for="about_title">Título Principal de la Sección</label>
                    <input type="text" id="about_title" name="about_title" class="form-control" value="<?= View::e($settings['about_title'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="about_subtitle">Subtítulo / Lema de Presentación</label>
                    <input type="text" id="about_subtitle" name="about_subtitle" class="form-control" value="<?= View::e($settings['about_subtitle'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label class="form-label" for="about_text">Historia y Pasión Floral</label>
                    <textarea id="about_text" name="about_text" class="form-control" rows="4"><?= View::e($settings['about_text'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="about_mission">Misión de la Florería</label>
                    <textarea id="about_mission" name="about_mission" class="form-control" rows="3"><?= View::e($settings['about_mission'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- PESTAÑA 4: Pasarela Culqi -->
            <div id="tab-culqi" class="tab-pane">
                <div style="background: #fcf6f8; border: 1px solid #f5e4e8; padding: 1.5rem; border-radius: 14px; margin-bottom: 2rem;">
                    <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #fff; display: flex; align-items: center; justify-content: center; color: var(--primary-dark, #9e5365); border: 1px solid #f5e4e8; flex-shrink: 0;">
                            <?= View::icon('card', 26) ?>
                        </div>
                        <div>
                            <h4 style="color: #9e5365; font-size: 1.15rem;">Pasarela de Pago Culqi v4</h4>
                            <p style="font-size: 0.85rem; color: #6d5b60;">
                                Permite a tus clientes pagar directamente con <strong>Tarjetas de Crédito / Débito</strong> y billeteras digitales (<strong>Yape</strong>, <strong>Plin</strong>, etc.).
                            </p>
                        </div>
                    </div>

                    <div class="culqi-badge-strip">
                        <span class="wallet-badge badge-yape">YAPE HABILITADO</span>
                        <span class="wallet-badge badge-plin">PLIN HABILITADO</span>
                        <span class="wallet-badge badge-visa">VISA</span>
                        <span class="wallet-badge badge-master">MASTERCARD</span>
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="culqi_mode">Modo de Operación Culqi</label>
                        <select id="culqi_mode" name="culqi_mode" class="form-control" style="font-weight: 700;">
                            <option value="test" <?= (($settings['culqi_mode'] ?? 'test') === 'test') ? 'selected' : '' ?>>
                                Modo Pruebas (Test Sandbox)
                            </option>
                            <option value="live" <?= (($settings['culqi_mode'] ?? 'test') === 'live') ? 'selected' : '' ?>>
                                Modo Producción (Ventas Reales)
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="culqi_public_key">Llave Pública Culqi (Public Key) *</label>
                    <input type="text" id="culqi_public_key" name="culqi_public_key" class="form-control" value="<?= View::e($settings['culqi_public_key'] ?? '') ?>" placeholder="pk_test_... o pk_live_..." required>
                    <small style="color: #64748b; font-size: 0.75rem;">Comienza con <code>pk_test_</code> o <code>pk_live_</code>. Se usa en el frontend para abrir el modal seguro.</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="culqi_secret_key">Llave Secreta Culqi (Secret Key) *</label>
                    <input type="password" id="culqi_secret_key" name="culqi_secret_key" class="form-control" value="<?= View::e($settings['culqi_secret_key'] ?? '') ?>" placeholder="sk_test_... o sk_live_..." required>
                    <small style="color: #64748b; font-size: 0.75rem;">Comienza con <code>sk_test_</code> o <code>sk_live_</code>. Se mantiene cifrada en el servidor para efectuar el cobro.</small>
                </div>
            </div>

            <!-- PESTAÑA 5: Delivery y Tarifas -->
            <div id="tab-shipping" class="tab-pane">
                <div class="form-row-2">
                    <div class="form-group">
                        <label class="form-label" for="delivery_cost">Costo Estándar de Envío / Delivery (S/.) *</label>
                        <input type="number" step="0.50" id="delivery_cost" name="delivery_cost" class="form-control" value="<?= $settings['delivery_cost'] ?? '15.00' ?>" required>
                        <small style="color: #64748b; font-size: 0.75rem;">Se añade automáticamente en el checkout al total del pedido.</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="free_shipping_threshold">Monto Mínimo para Envío Gratuito (S/.)</label>
                        <input type="number" step="1.00" id="free_shipping_threshold" name="free_shipping_threshold" class="form-control" value="<?= $settings['free_shipping_threshold'] ?? '250.00' ?>">
                    </div>
                </div>
            </div>

            <!-- Botón Guardar Cambios -->
            <div style="margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
                <button type="submit" class="btn-admin btn-admin-primary" style="padding: 0.85rem 2rem; font-size: 1rem;">
                    Guardar Todas las Configuraciones
                </button>
            </div>
        </form>
    </div>
</div>
