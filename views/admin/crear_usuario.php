<?php
// views/admin/crear_usuario.php
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
.admin-content  { flex:1; background:#fff; border-radius:12px; padding:2rem; box-shadow:0 2px 12px rgba(0,0,0,.08); }
.breadcrumb     { display:flex; align-items:center; gap:.5rem; font-size:.88rem; color:#6b7280; margin-bottom:1.5rem; }
.breadcrumb a   { color:#1a56db; text-decoration:none; }
.form-grid      { display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; }
.form-group     { margin-bottom:1.5rem; }
.form-label     { display:block; margin-bottom:.5rem; font-weight:600; color:#374151; font-size:.9rem; }
.form-control   { width:100%; padding:.75rem; border:1px solid #d1d5db; border-radius:8px; font-size:.95rem; }
.alert          { padding:1rem; border-radius:8px; margin-bottom:1.5rem; display:flex; align-items:center; gap:.5rem; }
.alert-error    { background:#fef2f2; color:#b91c1c; border-left:4px solid #ef4444; }
.alert-success  { background:#f0fdf4; color:#15803d; border-left:4px solid #22c55e; }
.btn-submit     { background:#1a56db; color:#fff; border:none; padding:1rem 2rem; border-radius:8px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-block; }
.btn-submit:hover { background:#1e40af; }
.btn-cancel     { background:#f1f5f9; color:#475569; border:none; padding:1rem 2rem; border-radius:8px; font-weight:600; cursor:pointer; text-decoration:none; display:inline-block; margin-right:1rem; }
.btn-cancel:hover { background:#e2e8f0; }
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

    <div class="admin-content">
        <div class="breadcrumb">
            <a href="<?= BASE_URL ?>?c=Admin&a=dashboard"><i class="fa-solid fa-house"></i> Dashboard</a>
            <i class="fa-solid fa-chevron-right" style="font-size:.7rem"></i>
            <a href="<?= BASE_URL ?>?c=Admin&a=clientes">Clientes</a>
            <i class="fa-solid fa-chevron-right" style="font-size:.7rem"></i>
            <span>Nuevo Usuario</span>
        </div>

        <h1 style="color:#1a56db; margin-bottom:1.5rem;"><i class="fa-solid fa-user-plus"></i> Crear Nuevo Usuario</h1>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>?c=Admin&a=guardar_usuario" method="POST">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label" for="nombre">Nombre Completo *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label class="form-label" for="correo">Correo Electrónico *</label>
                    <input type="email" id="correo" name="correo" class="form-control" required placeholder="correo@ejemplo.com">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña *</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Min. 6 caracteres">
                </div>
                <div class="form-group">
                    <label class="form-label" for="rol">Rol del Usuario *</label>
                    <select id="rol" name="rol" class="form-control" required>
                        <option value="cliente">Cliente (Usuario base)</option>
                        <option value="admin">Administrador (Acceso al panel)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="telefono">Teléfono (Opcional)</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Ej. 987654321">
                </div>
                <div class="form-group">
                    <label class="form-label" for="empresa_ruc">Empresa/RUC (Opcional)</label>
                    <input type="text" id="empresa_ruc" name="empresa_ruc" class="form-control" placeholder="RUC o Nombre de empresa">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="direccion">Dirección (Opcional)</label>
                <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección de envío">
            </div>

            <div style="margin-top:2rem">
                <a href="<?= BASE_URL ?>?c=Admin&a=clientes" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-save"></i> Guardar Usuario</button>
            </div>
        </form>
    </div>
</div>
