<?php // views/public/mis_pedidos.php — Pedidos del cliente logueado ?>
<section class="container orders-page">
    <div class="profile-header">
        <div class="profile-avatar">
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <h2><?= htmlspecialchars($_SESSION['nombre'] ?? 'Cliente') ?></h2>
            <p style="opacity:.8">Historial de compras y pedidos</p>
        </div>
    </div>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
        <h2 style="margin:0"><i class="fa-solid fa-box-open" style="color:#3b82f6"></i> Mis Pedidos</h2>
        <a href="<?= BASE_URL ?>?c=Home&a=catalogo" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Seguir Comprando
        </a>
    </div>

    <?php if (empty($pedidos)): ?>
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);text-align:center;padding:4rem 2rem;">
        <i class="fa-solid fa-box-open" style="font-size:4rem;color:var(--text-muted);opacity:.4;display:block;margin-bottom:1.5rem"></i>
        <h3>Aún no tienes pedidos</h3>
        <p style="color:var(--text-muted);margin:.5rem 0 1.5rem">Explora nuestro catálogo y realiza tu primera compra.</p>
        <a href="<?= BASE_URL ?>?c=Home&a=catalogo" class="btn-primary">
            <i class="fa-solid fa-magnifying-glass"></i> Ver Catálogo
        </a>
    </div>

    <?php else: ?>
    <?php foreach ($pedidos as $pedido): ?>
    <div class="order-card">
        <div class="order-card-header">
            <div>
                <strong>Pedido #<?= $pedido['id'] ?></strong>
                <span style="color:var(--text-muted);font-size:.85rem;margin-left:.75rem">
                    <?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?>
                </span>
            </div>
            <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap">
                <strong style="color:var(--text-main)">
                    <?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : 'S/. ' ?><?= number_format($pedido['total'], 2) ?>
                </strong>
                <?php
                    $clase = [
                        'Pendiente' => 'badge-pendiente',
                        'Pagado'    => 'badge-pagado',
                        'Entregado' => 'badge-entregado',
                        'Cancelado' => 'badge-cancelado',
                    ][$pedido['estado']] ?? 'badge-pendiente';
                ?>
                <span class="order-badge <?= $clase ?>">
                    <?php
                        $icons = ['Pendiente'=>'🕐','Pagado'=>'✅','Entregado'=>'📦','Cancelado'=>'❌'];
                        echo ($icons[$pedido['estado']] ?? '') . ' ' . $pedido['estado'];
                    ?>
                </span>
                <a href="<?= BASE_URL ?>?c=Venta&a=boleta&id=<?= $pedido['id'] ?>"
                   target="_blank"
                   style="font-size:.85rem;color:#3b82f6;font-weight:600">
                    <i class="fa-solid fa-file-invoice"></i> Ver boleta
                </a>
            </div>
        </div>
        <div class="order-card-body">
            <?php if (!empty($pedido['detalles'])): ?>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1rem">
                <?php foreach ($pedido['detalles'] as $det): ?>
                <div style="display:flex;gap:.75rem;align-items:center;background:var(--surface-2);border-radius:var(--radius);padding:.75rem;border:1px solid var(--border)">
                    <i class="fa-solid fa-weight-scale" style="font-size:1.5rem;color:#3b82f6;flex-shrink:0"></i>
                    <div>
                        <strong style="font-size:.9rem;color:var(--text-main)"><?= htmlspecialchars($det['nombre']) ?></strong><br>
                        <span style="font-size:.82rem;color:var(--text-muted)">
                            <?= htmlspecialchars($det['marca'] ?? '') ?> — Cant: <?= $det['cantidad'] ?>
                        </span><br>
                        <span style="font-weight:700;color:var(--secondary-blue)">
                            <?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : 'S/. ' ?><?= number_format($det['precio'] * $det['cantidad'], 2) ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p style="color:var(--text-muted);font-size:.9rem">Sin detalles disponibles.</p>
            <?php endif; ?>

            <?php if ($pedido['estado'] === 'Pendiente'): ?>
            <div style="margin-top:1rem;padding:.9rem;background:var(--accent-blue);border-radius:var(--radius);font-size:.88rem;color:#1e40af;display:flex;gap:.6rem;align-items:flex-start;border:1px solid #bfdbfe">
                <i class="fa-solid fa-circle-info" style="margin-top:.1rem;flex-shrink:0"></i>
                <span>Tu pedido está <strong>pendiente de pago</strong>. Un asesor se comunicará contigo. También puedes escribirnos al <strong>+51 987 654 321</strong> por WhatsApp.</span>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</section>
