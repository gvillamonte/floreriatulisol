<!-- ========================================================
     Página de Checkout y Pasarela Culqi - Florería Tulisol
     ======================================================== -->

<div class="checkout-section">
    <div class="container">
        <div class="section-title-wrap" style="text-align: left; margin-bottom: 2rem;">
            <span class="section-badge">Paso Final</span>
            <h1 class="section-heading">Datos de Entrega y Pago Seguro</h1>
            <p class="section-desc">Por favor ingresa los datos de entrega de tu arreglo floral para garantizar una sorpresa perfecta.</p>
        </div>

        <form id="checkout-form" class="checkout-grid" onsubmit="return false;">
            <!-- Columna Izquierda: Datos del Comprador y Destinatario -->
            <div>
                <!-- 1. Datos de quien envía (Comprador) -->
                <div class="checkout-card">
                    <h3><span style="display:inline-flex; align-items:center;"><?= View::icon('user', 18) ?></span> 1. Tus Datos de Contacto (Remitente)</h3>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="customer_name">Tu Nombre Completo *</label>
                            <input type="text" id="customer_name" class="form-control" placeholder="Ej: Carlos Mendoza" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="customer_phone">Teléfono / WhatsApp *</label>
                            <input type="tel" id="customer_phone" class="form-control" placeholder="Ej: 984 123 456" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="customer_email">Correo Electrónico (Para recibir el comprobante Culqi) *</label>
                        <input type="email" id="customer_email" class="form-control" placeholder="carlos@gmail.com" required>
                    </div>
                </div>

                <!-- 2. Datos de quien recibe (Destinatario) -->
                <div class="checkout-card">
                    <h3><span style="display:inline-flex; align-items:center;"><?= View::icon('truck', 18) ?></span> 2. Datos de Entrega (Destinatario)</h3>
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="recipient_name">Nombre de quien recibe la sorpresa *</label>
                            <input type="text" id="recipient_name" class="form-control" placeholder="Ej: Andrea Torres" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="recipient_phone">Teléfono de quien recibe (Opcional)</label>
                            <input type="tel" id="recipient_phone" class="form-control" placeholder="Para llamar al llegar">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="delivery_address">Dirección Exacta de Entrega *</label>
                        <input type="text" id="delivery_address" class="form-control" placeholder="Calle, Av, Número, Dpto, Urbanización" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="delivery_reference">Referencia de Entrega (Opcional)</label>
                        <input type="text" id="delivery_reference" class="form-control" placeholder="Ej: Frente al parque, edificio blanco de 3 pisos">
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label" for="delivery_date">Fecha de Entrega *</label>
                            <input type="date" id="delivery_date" class="form-control" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="delivery_time_slot">Turno de Horario *</label>
                            <select id="delivery_time_slot" class="form-control">
                                <option value="Mañana (9:00 AM - 1:00 PM)">Mañana (9:00 AM - 1:00 PM)</option>
                                <option value="Tarde (2:00 PM - 6:30 PM)">Tarde (2:00 PM - 6:30 PM)</option>
                                <option value="Noche (6:30 PM - 8:30 PM)">Noche (6:30 PM - 8:30 PM)</option>
                                <option value="Inmediato / Express">Express (Coordinación inmediata)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 3. Tarjeta de Dedicatoria Impresa -->
                <div class="checkout-card">
                    <h3><span style="display:inline-flex; align-items:center;"><?= View::icon('mail', 18) ?></span> 3. Dedicatoria para la Tarjeta de Cortesía</h3>
                    <div class="form-group">
                        <label class="form-label" for="dedication_message">Mensaje Especial (Impreso en sobre lacrado)</label>
                        <textarea id="dedication_message" class="form-control" rows="3" placeholder="Escribe tus palabras aquí..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="sender_signature">Firma o Remitente de la Tarjeta</label>
                        <input type="text" id="sender_signature" class="form-control" placeholder="Ej: Con amor, Carlos (o déjalo en blanco para anónimo)">
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Resumen de Compra y Botón Culqi -->
            <div>
                <div class="checkout-card" style="position: sticky; top: 100px;">
                    <h3><span style="display:inline-flex; align-items:center;"><?= View::icon('package', 18) ?></span> Resumen de Compra</h3>

                    <!-- Lista de Ítems en el Carrito -->
                    <div style="max-height: 240px; overflow-y: auto; margin-bottom: 1.5rem;">
                        <?php foreach ($cart as $item): ?>
                            <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 0.85rem; padding-bottom: 0.85rem; border-bottom: 1px solid #f1f5f9;">
                                <img src="<?= View::upload($item['image']) ?>" alt="<?= View::e($item['name']) ?>" style="width: 50px; height: 50px; border-radius: 8px; object-fit: cover;">
                                <div style="flex-grow: 1;">
                                    <h5 style="font-size: 0.875rem; color: #1e293b; margin-bottom: 0.2rem;"><?= View::e($item['name']) ?></h5>
                                    <small style="color: #64748b;">Cant: <?= $item['quantity'] ?> • <?= View::money($item['price']) ?></small>
                                </div>
                                <span style="font-weight: 700; font-size: 0.9rem; color: var(--primary-dark);">
                                    <?= View::money($item['price'] * $item['quantity']) ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Desglose de Precios -->
                    <div style="border-top: 1px solid #e2e8f0; padding-top: 1rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem; color: #475569;">
                            <span>Subtotal:</span>
                            <span style="font-weight: 600; color: #0f172a;"><?= View::money($subtotal) ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.9rem; color: #475569;">
                            <span>Costo de Delivery:</span>
                            <span style="font-weight: 600; color: #0f172a;"><?= View::money($deliveryCost) ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 0.75rem; border-top: 2px solid #e2e8f0; font-size: 1.35rem; font-weight: 800; color: #0f172a;">
                            <span>Total a Pagar:</span>
                            <span style="color: var(--primary-dark);"><?= View::money($total) ?></span>
                        </div>
                    </div>

                    <!-- Métodos de Pago Culqi -->
                    <div class="payment-methods-box">
                        <span style="font-size: 0.825rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.4rem;">
                            Pasarela Culqi: Billeteras Digitales y Tarjetas
                        </span>
                        <p style="font-size: 0.78rem; color: #64748b; margin-bottom: 0.65rem;">
                            Al dar clic, se abrirá la pasarela segura de Culqi donde podrás pagar con <strong>Yape</strong>, <strong>Plin</strong> o tarjetas Visa/Mastercard/Amex.
                        </p>
                        <div class="culqi-badge-strip">
                            <span class="wallet-badge badge-yape">YAPE</span>
                            <span class="wallet-badge badge-plin">PLIN</span>
                            <span class="wallet-badge badge-visa">VISA</span>
                            <span class="wallet-badge badge-master">Mastercard</span>
                        </div>
                    </div>

                    <!-- Botón Principal de Pago con Culqi -->
                    <button type="button" id="btn-pay-culqi" 
                            data-public-key="<?= View::e($culqiPublicKey) ?>" 
                            data-amount="<?= $total ?>" 
                            class="btn btn-primary" 
                            style="width: 100%; padding: 1rem; font-size: 1.05rem; margin-bottom: 0.75rem;">
                        <?= View::icon('card', 18) ?> <span>Pagar <?= View::money($total) ?> con Culqi</span>
                    </button>

                    <!-- Botón Alternativo por WhatsApp -->
                    <button type="button" id="btn-pay-whatsapp" class="btn btn-whatsapp" style="width: 100%; padding: 0.75rem; font-size: 0.9rem;">
                        <?= View::icon('whatsapp', 18) ?> <span>Coordinar y Pagar por WhatsApp</span>
                    </button>

                    <div style="text-align: center; margin-top: 1rem; font-size: 0.75rem; color: #94a3b8;">
                        Transacción encriptada con cifrado SSL de 256 bits mediante Culqi.
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
