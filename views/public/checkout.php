<section class="container">
    <div class="checkout-wrap">
        <!-- Productos del Pedido -->
        <div class="checkout-items-box">
            <h2 style="margin-bottom:1.5rem;display:flex;align-items:center;gap:.6rem">
                <i class="fa-solid fa-list-check" style="color:#3b82f6"></i> Resumen del Pedido
            </h2>
            <div id="checkout-items">
                <!-- Renderizado por JS -->
            </div>
            <div class="checkout-total-row">
                <span>Total a Pagar:</span>
                <span id="checkout-total-price"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : 'S/. ' ?>0.00</span>
            </div>
        </div>

        <!-- Pago y Confirmación -->
        <div class="checkout-payment-box">
            <h3 style="margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:.5rem">
                <i class="fa-solid fa-wallet" style="color:#10b981"></i> Pago y Confirmación
            </h3>

            <!-- Info del cliente -->
            <div style="background:var(--surface-2);border:1px solid var(--border);border-radius:var(--radius);padding:1.25rem;margin-bottom:1.5rem">
                <p style="font-size:.85rem;color:var(--text-muted);margin-bottom:.3rem">Comprando como:</p>
                <p style="font-weight:700;color:var(--text-main)">
                    <i class="fa-solid fa-circle-user" style="color:#6366f1"></i>
                    <?= htmlspecialchars($_SESSION['nombre'] ?? 'Cliente') ?>
                </p>
            </div>

            <!-- Método de pago -->
            <div style="text-align:center;margin-bottom:1.5rem">
                <p style="color:var(--text-muted);font-size:.9rem;margin-bottom:.75rem">Método de pago:</p>
                <div style="border:2px solid #3b82f6;border-radius:var(--radius);padding:1rem;background:var(--accent-blue)">
                    <i class="fa-solid fa-money-bill-transfer" style="font-size:1.8rem;color:#3b82f6;display:block;margin-bottom:.5rem"></i>
                    <strong style="color:#1e40af">Transferencia / Billetera Digital</strong>
                </div>
                <p style="font-size:.8rem;color:var(--text-muted);margin-top:.75rem">
                    <i class="fa-solid fa-circle-info"></i>
                    Confirma tu pedido. Un asesor se contactará vía WhatsApp para coordinar el pago.
                </p>
            </div>

            <div style="background:linear-gradient(135deg,#d1fae5,#a7f3d0);border-radius:var(--radius);padding:1rem;margin-bottom:1.5rem;border:1px solid #6ee7b7">
                <p style="color:#065f46;font-size:.88rem;display:flex;align-items:flex-start;gap:.5rem">
                    <i class="fa-brands fa-whatsapp" style="color:#25d366;font-size:1.2rem;flex-shrink:0"></i>
                    Escríbenos también directo al <strong>+51 987 654 321</strong> si tienes dudas.
                </p>
            </div>

            <button id="btn-confirmar-compra" class="btn-primary w-100" style="padding:1rem;font-size:1.05rem;justify-content:center;margin-top:auto">
                <i class="fa-solid fa-check-circle"></i> Confirmar Pedido
            </button>
        </div>
    </div>
</section>

<!-- Modal de Éxito -->
<div id="success-modal" class="modal-overlay">
    <div class="modal-box">
        <i class="fa-solid fa-circle-check" style="font-size:4rem;color:#10b981;display:block;margin-bottom:1rem"></i>
        <h3 style="font-size:1.8rem;margin-bottom:.5rem">¡Pedido Confirmado!</h3>
        <p style="color:var(--text-muted);margin-bottom:2rem">Tu pedido ha sido registrado correctamente. Un asesor te contactará pronto.</p>
        <a id="enlace-boleta" href="#" target="_blank" class="btn-primary" style="display:flex;justify-content:center;margin-bottom:.75rem">
            <i class="fa-solid fa-file-pdf"></i> Ver Boleta
        </a>
        <a href="<?= BASE_URL ?>?c=Venta&a=mis_pedidos" class="btn-outline" style="display:flex;justify-content:center;margin-bottom:.75rem">
            <i class="fa-solid fa-box-open"></i> Mis Pedidos
        </a>
        <a href="<?= BASE_URL ?>" style="display:block;text-align:center;color:var(--text-muted);font-size:.9rem;margin-top:.5rem">
            Volver al Inicio
        </a>
    </div>
</div>
