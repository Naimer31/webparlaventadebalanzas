<?php
// views/admin/certificados.php  — Lista de certificados (dentro del layout con navbar admin)
$adminBase = BASE_URL . '?c=Admin&a=';
$certBase  = BASE_URL . '?c=Certificado&a=';
?>

<style>
.admin-wrap        { max-width: 1100px; margin: 0 auto; padding: 2rem 1rem; }
.admin-topbar      { display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; flex-wrap:wrap; gap:1rem; }
.admin-topbar h1   { font-size:1.6rem; color:var(--primary-blue); }
.btn-nuevo         { background:#1a56db; color:#fff; padding:.65rem 1.4rem; border-radius:8px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:.5rem; transition:background .2s; }
.btn-nuevo:hover   { background:#1741b0; }
.cert-table        { width:100%; border-collapse:collapse; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
.cert-table thead  { background:#1a56db; color:#fff; }
.cert-table th, .cert-table td { padding:.75rem 1rem; text-align:left; border-bottom:1px solid #e5e7eb; font-size:.92rem; }
.cert-table tbody tr:hover { background:#f0f4ff; }
.badge-code        { background:#e0e7ff; color:#1a56db; padding:.2rem .6rem; border-radius:20px; font-weight:700; font-size:.82rem; }
.btn-ver, .btn-del { padding:.35rem .9rem; border-radius:6px; font-size:.85rem; font-weight:600; border:none; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:.3rem; }
.btn-ver           { background:#e0f2fe; color:#0369a1; }
.btn-ver:hover     { background:#bae6fd; }
.btn-del           { background:#fee2e2; color:#dc2626; }
.btn-del:hover     { background:#fecaca; }
.empty-state       { text-align:center; padding:3rem; color:#6b7280; }
.empty-state i     { font-size:3rem; color:#d1d5db; margin-bottom:1rem; }
.breadcrumb        { display:flex; align-items:center; gap:.5rem; font-size:.9rem; color:#6b7280; margin-bottom:1.5rem; }
.breadcrumb a      { color:#1a56db; text-decoration:none; }
.breadcrumb a:hover{ text-decoration:underline; }
</style>

<div class="admin-wrap">
    <div class="breadcrumb">
        <a href="<?= BASE_URL ?>?c=Admin&a=dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
        <i class="fa-solid fa-chevron-right" style="font-size:.7rem"></i>
        <span>Certificados de Calibración</span>
    </div>

    <div class="admin-topbar">
        <h1><i class="fa-solid fa-certificate" style="color:#f59e0b"></i> Certificados de Calibración</h1>
        <a href="<?= $certBase ?>crear" class="btn-nuevo">
            <i class="fa-solid fa-plus"></i> Nuevo Certificado
        </a>
    </div>

    <?php if (!empty($certificados)): ?>
    <table class="cert-table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Solicitante</th>
                <th>Marca / Modelo</th>
                <th>Capacidad</th>
                <th>Fecha Calibración</th>
                <th>Próxima</th>
                <th style="text-align:center">Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($certificados as $c): ?>
            <tr>
                <td><span class="badge-code"><?= htmlspecialchars($c['codigo']) ?></span></td>
                <td><?= htmlspecialchars($c['solicitante_nombre']) ?></td>
                <td><?= htmlspecialchars($c['marca'] . ' ' . $c['modelo']) ?></td>
                <td><?= htmlspecialchars($c['capacidad_max']) ?></td>
                <td><?= $c['fecha_calibracion'] ? date('d/m/Y', strtotime($c['fecha_calibracion'])) : '—' ?></td>
                <td><?= $c['proxima_calibracion'] ? date('d/m/Y', strtotime($c['proxima_calibracion'])) : '—' ?></td>
                <td style="text-align:center; white-space:nowrap">
                    <a href="<?= $certBase ?>imprimir&id=<?= $c['id'] ?>" target="_blank" class="btn-ver" title="Previsualizar">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="<?= $certBase ?>pdf&id=<?= $c['id'] ?>" target="_blank" class="btn-ver" style="background:#e0e7ff; color:#3730a3;" title="Descargar PDF">
                        <i class="fa-solid fa-file-pdf"></i>
                    </a>
                    <a href="<?= $certBase ?>eliminar&id=<?= $c['id'] ?>"
                       class="btn-del"
                       onclick="return confirm('¿Eliminar el certificado <?= htmlspecialchars($c['codigo']) ?>?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty-state">
        <i class="fa-solid fa-file-circle-question"></i>
        <p><strong>Aún no hay certificados registrados.</strong></p>
        <p style="margin-top:.5rem">Crea el primero usando el botón <em>"Nuevo Certificado"</em>.</p>
    </div>
    <?php endif; ?>
</div>
