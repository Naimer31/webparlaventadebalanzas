<?php
// views/admin/clientes.php — Lista de clientes registrados
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
.admin-wrap     { }
.admin-topbar   { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem; }
.admin-topbar h1{ font-size:1.5rem; color:#1a56db; }
.breadcrumb     { display:flex; align-items:center; gap:.5rem; font-size:.88rem; color:#6b7280; margin-bottom:1.5rem; }
.breadcrumb a   { color:#1a56db; text-decoration:none; }
.data-table     { width:100%; border-collapse:collapse; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
.data-table thead { background:#1a56db; color:#fff; }
.data-table th, .data-table td { padding:.8rem 1rem; text-align:left; border-bottom:1px solid #e5e7eb; font-size:.9rem; }
.data-table tbody tr:hover { background:#f0f4ff; }
.badge-role     { padding:.2rem .7rem; border-radius:20px; font-size:.8rem; font-weight:700; }
.role-admin     { background:#fef3c7; color:#92400e; }
.role-cliente   { background:#d1fae5; color:#065f46; }
.empty-state    { text-align:center; padding:3rem; color:#6b7280; }
.empty-state i  { font-size:3rem; color:#d1d5db; margin-bottom:1rem; display:block; }
.search-box     { display:flex; gap:.75rem; align-items:center; }
.search-box input { padding:.5rem 1rem; border:1px solid #d1d5db; border-radius:8px; font-size:.9rem; }
.stats-mini     { display:flex; gap:1rem; margin-bottom:1.5rem; flex-wrap:wrap; }
.stat-card-mini { background:#fff; border-radius:10px; box-shadow:0 1px 6px rgba(0,0,0,.08); padding:1rem 1.5rem; flex:1; min-width:140px; border-left:4px solid #1a56db; }
.stat-card-mini h4 { font-size:.8rem; color:#6b7280; margin-bottom:.3rem; }
.stat-card-mini p  { font-size:1.6rem; font-weight:700; color:#1a56db; }
</style>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <h3><i class="fa-solid fa-gauge-high"></i> Panel Admin</h3>
        <ul>
            <li><a href="<?= BASE_URL ?>?c=Admin&a=dashboard"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="<?= BASE_URL ?>?c=Admin&a=productos"><i class="fa-solid fa-box"></i> Productos</a></li>
            <li><a href="<?= BASE_URL ?>?c=Admin&a=clientes" class="active"><i class="fa-solid fa-users"></i> Clientes</a></li>
            <li><a href="<?= BASE_URL ?>?c=Admin&a=ventas"><i class="fa-solid fa-file-invoice-dollar"></i> Ventas</a></li>
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
            <span>Clientes</span>
        </div>

        <!-- Stats -->
        <div class="stats-mini">
            <div class="stat-card-mini" style="border-left-color:#1a56db">
                <h4>Total Clientes</h4>
                <p><?= count(array_filter($clientes ?? [], fn($c) => $c['rol'] === 'cliente')) ?></p>
            </div>
            <div class="stat-card-mini" style="border-left-color:#9333ea">
                <h4>Administradores</h4>
                <p><?= count(array_filter($clientes ?? [], fn($c) => $c['rol'] === 'admin')) ?></p>
            </div>
            <div class="stat-card-mini" style="border-left-color:#059669">
                <h4>Total Usuarios</h4>
                <p><?= count($clientes ?? []) ?></p>
            </div>
        </div>

        <div class="admin-topbar">
            <h1><i class="fa-solid fa-users" style="color:#1a56db"></i> Gestión de Usuarios</h1>
            <div style="display:flex; gap:1rem; align-items:center;">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Buscar usuario..." onkeyup="filtrarTabla()">
                    <i class="fa-solid fa-magnifying-glass" style="color:#9ca3af"></i>
                </div>
                <a href="<?= BASE_URL ?>?c=Admin&a=crear_usuario" class="btn-submit" style="padding:0.6rem 1rem; font-size:0.9rem; text-decoration:none;"><i class="fa-solid fa-plus"></i> Nuevo Usuario</a>
            </div>
        </div>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error" style="background:#fef2f2; color:#b91c1c; border-left:4px solid #ef4444; padding:1rem; margin-bottom:1.5rem;">
                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="background:#f0fdf4; color:#15803d; border-left:4px solid #22c55e; padding:1rem; margin-bottom:1.5rem;">
                <i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($_SESSION['success']) ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($clientes)): ?>
        <table class="data-table" id="tablaClientes">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Empresa / RUC</th>
                    <th>Rol</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($clientes as $c): ?>
                <tr>
                    <td><strong>#<?= $c['id'] ?></strong></td>
                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                    <td><?= htmlspecialchars($c['correo']) ?></td>
                    <td><?= htmlspecialchars($c['telefono'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($c['empresa_ruc'] ?? '—') ?></td>
                    <td>
                        <span class="badge-role <?= $c['rol'] === 'admin' ? 'role-admin' : 'role-cliente' ?>">
                            <?= ucfirst($c['rol']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($c['fecha_registro'])) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            <i class="fa-solid fa-user-slash"></i>
            <p><strong>No hay clientes registrados aún.</strong></p>
            <p style="margin-top:.5rem">Los clientes aparecerán aquí cuando se registren en la tienda.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function filtrarTabla() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#tablaClientes tbody tr');
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(input) ? '' : 'none';
    });
}
</script>
