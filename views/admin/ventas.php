<?php
// views/admin/ventas.php — Lista de ventas con gestión de estado
$adminBase = BASE_URL . '?c=Admin&a=';
?>

<style>
.admin-layout    { display:flex; gap:2rem; min-height:70vh; padding:2rem 0; max-width:1200px; margin:0 auto; }
.admin-sidebar   { width:240px; flex-shrink:0; background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.08); padding:1.5rem; height:max-content; }
.admin-sidebar h3{ font-size:1rem; margin-bottom:1.5rem; padding-bottom:1rem; border-bottom:1px solid #e2e8f0; color:#1a56db; }
.admin-sidebar ul{ list-style:none; }
.admin-sidebar li{ margin-bottom:.75rem; }
.admin-sidebar a { display:flex; align-items:center; gap:.6rem; padding:.5rem .75rem; border-radius:8px; color:#4a5568; text-decoration:none; font-size:.92rem; transition:all .2s; }
.admin-sidebar a:hover, .admin-sidebar a.active { background:#eff6ff; color:#1a56db; font-weight:600; }
.admin-sidebar .logout a { color:#e53e3e; }
.admin-sidebar .logout a:hover { background:#fff5f5; }
.admin-content  { flex:1; }
.admin-topbar   { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
.admin-topbar h1{ font-size:1.5rem; color:#1a56db; }
.breadcrumb     { display:flex; align-items:center; gap:.5rem; font-size:.88rem; color:#6b7280; margin-bottom:1.5rem; }
.breadcrumb a   { color:#1a56db; text-decoration:none; }
.data-table     { width:100%; border-collapse:collapse; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
.data-table thead { background:#1a56db; color:#fff; }
.data-table th, .data-table td { padding:.8rem 1rem; text-align:left; border-bottom:1px solid #e5e7eb; font-size:.9rem; }
.data-table tbody tr:hover { background:#f0f4ff; }
.empty-state    { text-align:center; padding:3rem; color:#6b7280; background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.08); }
.empty-state i  { font-size:3rem; color:#d1d5db; margin-bottom:1rem; display:block; }
.stats-mini     { display:flex; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap; }
.stat-card-mini { background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.08); padding:1rem 1.5rem; flex:1; min-width:140px; }
.stat-card-mini h4 { font-size:.8rem; color:#6b7280; margin-bottom:.3rem; }
.stat-card-mini p  { font-size:1.4rem; font-weight:700; }
.badge-estado   { padding:.25rem .8rem; border-radius:20px; font-size:.8rem; font-weight:700; white-space:nowrap; }
.estado-pendiente  { background:#fef9c3; color:#854d0e; }
.estado-pagado     { background:#d1fae5; color:#065f46; }
.estado-entregado  { background:#dbeafe; color:#1e40af; }
.estado-cancelado  { background:#fee2e2; color:#991b1b; }
.btn-estado     { padding:.3rem .7rem; border-radius:6px; font-size:.8rem; font-weight:600; border:none; cursor:pointer; background:#e0e7ff; color:#3730a3; transition:background .2s; }
.btn-estado:hover { background:#c7d2fe; }
.alert-success  { background:#d1fae5; color:#065f46; padding:1rem; border-radius:8px; margin-bottom:1rem; }
.alert-error    { background:#fee2e2; color:#991b1b; padding:1rem; border-radius:8px; margin-bottom:1rem; }
.filter-bar     { display:flex; gap:.75rem; align-items:center; flex-wrap:wrap; }
.filter-bar select, .filter-bar input { padding:.45rem .9rem; border:1px solid #d1d5db; border-radius:8px; font-size:.88rem; }
</style>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <h3><i class="fa-solid fa-gauge-high"></i> Panel Admin</h3>
        <ul>
            <li><a href="<?= BASE_URL ?>?c=Admin&a=dashboard"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="<?= BASE_URL ?>?c=Admin&a=productos"><i class="fa-solid fa-box"></i> Productos</a></li>
            <li><a href="<?= BASE_URL ?>?c=Admin&a=clientes"><i class="fa-solid fa-users"></i> Clientes</a></li>
            <li><a href="<?= BASE_URL ?>?c=Admin&a=ventas" class="active"><i class="fa-solid fa-file-invoice-dollar"></i> Ventas</a></li>
            <li><a href="<?= BASE_URL ?>?c=Certificado&a=index"><i class="fa-solid fa-certificate"></i> Certificados</a></li>
            <li class="logout" style="margin-top:2rem; padding-top:1rem; border-top:1px solid #e2e8f0;">
                <a href="<?= BASE_URL ?>?c=Auth&a=logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
            </li>
        </ul>
    </aside>

    <!-- Content -->
    <div class="admin-content">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>?c=Admin&a=dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
            <i class="fa-solid fa-chevron-right" style="font-size:.7rem"></i>
            <span>Ventas</span>
        </div>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert-success"><i class="fa-solid fa-check-circle"></i> <?= $_SESSION['success'] ?><?php unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert-error"><i class="fa-solid fa-triangle-exclamation"></i> <?= $_SESSION['error'] ?><?php unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Stats -->
        <?php
            $totalVentas     = count($ventas ?? []);
            $pendientes      = count(array_filter($ventas ?? [], fn($v) => $v['estado'] === 'Pendiente'));
            $pagados         = count(array_filter($ventas ?? [], fn($v) => $v['estado'] === 'Pagado' || $v['estado'] === 'Entregado'));
            $cancelados      = count(array_filter($ventas ?? [], fn($v) => $v['estado'] === 'Cancelado'));
            $ingresoTotal    = array_sum(array_column(array_filter($ventas ?? [], fn($v) => $v['estado'] !== 'Cancelado'), 'total'));
        ?>
        <div class="stats-mini">
            <div class="stat-card-mini" style="border-left:4px solid #1a56db">
                <h4>Total Pedidos</h4>
                <p style="color:#1a56db"><?= $totalVentas ?></p>
            </div>
            <div class="stat-card-mini" style="border-left:4px solid #d97706">
                <h4>Pendientes</h4>
                <p style="color:#d97706"><?= $pendientes ?></p>
            </div>
            <div class="stat-card-mini" style="border-left:4px solid #059669">
                <h4>Completados</h4>
                <p style="color:#059669"><?= $pagados ?></p>
            </div>
            <div class="stat-card-mini" style="border-left:4px solid #dc2626">
                <h4>Cancelados</h4>
                <p style="color:#dc2626"><?= $cancelados ?></p>
            </div>
            <div class="stat-card-mini" style="border-left:4px solid #7c3aed">
                <h4>Ingresos Totales</h4>
                <p style="color:#7c3aed; font-size:1.1rem"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : 'S/. ' ?><?= number_format($ingresoTotal, 2) ?></p>
            </div>
        </div>

        <div class="admin-topbar">
            <h1><i class="fa-solid fa-file-invoice-dollar" style="color:#1a56db"></i> Gestión de Ventas</h1>
            <div class="filter-bar">
                <input type="text" id="searchInput" placeholder="Buscar cliente..." onkeyup="filtrarTabla()">
                <select id="filterEstado" onchange="filtrarTabla()">
                    <option value="">Todos los estados</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Pagado">Pagado</option>
                    <option value="Entregado">Entregado</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
            </div>
        </div>

        <?php if (!empty($ventas)): ?>
        <table class="data-table" id="tablaVentas">
            <thead>
                <tr>
                    <th>#Pedido</th>
                    <th>Cliente</th>
                    <th>Correo</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th style="text-align:center">Cambiar Estado</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($ventas as $v): ?>
                <tr data-estado="<?= $v['estado'] ?>">
                    <td><strong>#<?= $v['id'] ?></strong></td>
                    <td><?= htmlspecialchars($v['cliente_nombre']) ?></td>
                    <td><?= htmlspecialchars($v['cliente_correo']) ?></td>
                    <td><strong><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : 'S/. ' ?><?= number_format($v['total'], 2) ?></strong></td>
                    <td><?= date('d/m/Y H:i', strtotime($v['fecha'])) ?></td>
                    <td>
                        <?php
                            $claseEstado = [
                                'Pendiente' => 'estado-pendiente',
                                'Pagado'    => 'estado-pagado',
                                'Entregado' => 'estado-entregado',
                                'Cancelado' => 'estado-cancelado',
                            ][$v['estado']] ?? 'estado-pendiente';
                        ?>
                        <span class="badge-estado <?= $claseEstado ?>"><?= $v['estado'] ?></span>
                    </td>
                    <td style="text-align:center; white-space:nowrap">
                        <form method="POST" action="<?= BASE_URL ?>?c=Admin&a=cambiar_estado_venta" style="display:inline">
                            <input type="hidden" name="venta_id" value="<?= $v['id'] ?>">
                            <select name="estado" style="padding:.3rem .6rem; border:1px solid #d1d5db; border-radius:6px; font-size:.82rem;">
                                <option value="Pendiente"  <?= $v['estado']==='Pendiente'  ? 'selected':'' ?>>Pendiente</option>
                                <option value="Pagado"     <?= $v['estado']==='Pagado'     ? 'selected':'' ?>>Pagado</option>
                                <option value="Entregado"  <?= $v['estado']==='Entregado'  ? 'selected':'' ?>>Entregado</option>
                                <option value="Cancelado"  <?= $v['estado']==='Cancelado'  ? 'selected':'' ?>>Cancelado</option>
                            </select>
                            <button type="submit" class="btn-estado"><i class="fa-solid fa-floppy-disk"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <i class="fa-solid fa-receipt"></i>
            <p><strong>No hay ventas registradas aún.</strong></p>
            <p style="margin-top:.5rem">Los pedidos realizados por clientes aparecerán aquí.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function filtrarTabla() {
    const texto  = document.getElementById('searchInput').value.toLowerCase();
    const estado = document.getElementById('filterEstado').value.toLowerCase();
    const rows   = document.querySelectorAll('#tablaVentas tbody tr');
    rows.forEach(row => {
        const textMatch   = row.textContent.toLowerCase().includes(texto);
        const estadoMatch = !estado || row.dataset.estado.toLowerCase() === estado;
        row.style.display = (textMatch && estadoMatch) ? '' : 'none';
    });
}
</script>
