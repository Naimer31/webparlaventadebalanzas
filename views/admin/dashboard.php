<div class="container" style="padding: 2rem 0; display: flex; gap: 2rem; min-height: 70vh;">
    <!-- Admin Sidebar -->
    <aside style="width: 250px; background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-sm); padding: 1.5rem;">
        <h3 style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #e2e8f0;">
            <i class="fa-solid fa-gauge-high"></i> Panel Admin
        </h3>
        <ul style="list-style: none;">
            <li style="margin-bottom: 1rem;">
                <a href="<?= BASE_URL ?>?c=Admin&a=dashboard" style="color: var(--primary-blue); font-weight: 600; display: block;"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            </li>
            <li style="margin-bottom: 1rem;">
                <a href="<?= BASE_URL ?>?c=Admin&a=productos" style="color: var(--gray-dark); display: block;"><i class="fa-solid fa-box"></i> Productos</a>
            </li>
            <li style="margin-bottom: 1rem;">
                <a href="#" style="color: var(--gray-dark); display: block;"><i class="fa-solid fa-users"></i> Clientes</a>
            </li>
            <li style="margin-bottom: 1rem;">
                <a href="#" style="color: var(--gray-dark); display: block;"><i class="fa-solid fa-file-invoice-dollar"></i> Ventas</a>
            </li>
            <li style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
                <a href="<?= BASE_URL ?>?c=Auth&a=logout" style="color: #e53e3e; display: block;"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
            </li>
        </ul>
    </aside>

    <!-- Dashboard Content -->
    <div style="flex: 1;">
        <h2>Resumen de la Tienda</h2>
        <p style="color: var(--gray-dark); margin-bottom: 2rem;">Bienvenido al panel de administración de balanzas.</p>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-left: 4px solid #3182ce;">
                <h4 style="color: var(--gray-dark); font-size: 0.9rem; margin-bottom: 0.5rem;">Ventas Totales</h4>
                <p style="font-size: 1.8rem; font-weight: 700; color: var(--primary-blue);"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : '$' ?><?= number_format(isset($totalIngresos) ? $totalIngresos : 0, 2) ?></p>
            </div>
            
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-left: 4px solid #38a169;">
                <h4 style="color: var(--gray-dark); font-size: 0.9rem; margin-bottom: 0.5rem;">Pedidos Nuevos</h4>
                <p style="font-size: 1.8rem; font-weight: 700; color: var(--primary-blue);"><?= isset($nuevosPedidos) ? $nuevosPedidos : 0 ?></p>
            </div>
            
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-left: 4px solid #d69e2e;">
                <h4 style="color: var(--gray-dark); font-size: 0.9rem; margin-bottom: 0.5rem;">Productos (Stock)</h4>
                <p style="font-size: 1.8rem; font-weight: 700; color: var(--primary-blue);"><?= isset($totalProductos) ? $totalProductos : 0 ?></p>
            </div>
            
            <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-left: 4px solid #e53e3e;">
                <h4 style="color: var(--gray-dark); font-size: 0.9rem; margin-bottom: 0.5rem;">Stock Bajo</h4>
                <p style="font-size: 1.8rem; font-weight: 700; color: var(--primary-blue);"><?= isset($stockBajo) ? $stockBajo : 0 ?></p>
            </div>
        </div>

        <!-- Gráfico con Chart.js -->
        <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem;">Ventas de los Últimos 7 Días</h3>
            <canvas id="ventasChart" width="400" height="150"></canvas>
        </div>

        <!-- Recent Orders Table -->
        <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
            <h3 style="margin-bottom: 1rem;">Últimos Pedidos</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #e2e8f0; text-align: left;">
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">ID</th>
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">Cliente</th>
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">Fecha</th>
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">Total</th>
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($ultimosPedidos) && count($ultimosPedidos) > 0): ?>
                        <?php foreach($ultimosPedidos as $pedido): ?>
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                <td style="padding: 1rem 0.5rem; font-weight: bold;">#<?= $pedido['id'] ?></td>
                                <td style="padding: 1rem 0.5rem;"><?= htmlspecialchars($pedido['cliente']) ?></td>
                                <td style="padding: 1rem 0.5rem;"><?= date('d M Y', strtotime($pedido['fecha'])) ?></td>
                                <td style="padding: 1rem 0.5rem;"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : '$' ?><?= number_format($pedido['total'], 2) ?></td>
                                <td style="padding: 1rem 0.5rem;">
                                    <?php
                                        $bg = '#e2e8f0'; $color = '#4a5568';
                                        if($pedido['estado'] == 'Pendiente') { $bg = '#fefcbf'; $color = '#b7791f'; }
                                        if($pedido['estado'] == 'Pagado' || $pedido['estado'] == 'Entregado') { $bg = '#c6f6d5'; $color = '#22543d'; }
                                    ?>
                                    <span style="background: <?= $bg ?>; color: <?= $color ?>; padding: 0.2rem 0.6rem; border-radius: 999px; font-size: 0.8rem; font-weight: bold;">
                                        <?= $pedido['estado'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="padding: 1rem; text-align: center;">No hay pedidos recientes.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php
            $labels = [];
            $dataVentas = [];
            if(isset($chartData)) {
                foreach($chartData as $cd) {
                    $labels[] = date('d M', strtotime($cd['fecha_dia']));
                    $dataVentas[] = $cd['total_dia'];
                }
            }
        ?>
        const ctx = document.getElementById('ventasChart').getContext('2d');
        const ventasChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Ventas Diarias (<?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : '$' ?>)',
                    data: <?= json_encode($dataVentas) ?>,
                    backgroundColor: 'rgba(49, 130, 206, 0.2)',
                    borderColor: 'rgba(49, 130, 206, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
