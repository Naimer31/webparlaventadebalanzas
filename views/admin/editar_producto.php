<div class="container" style="padding: 2rem 0; display: flex; gap: 2rem; min-height: 70vh;">
    <!-- Admin Sidebar -->
    <aside style="width: 250px; background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-sm); padding: 1.5rem; height: max-content;">
        <h3 style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #e2e8f0;">
            <i class="fa-solid fa-gauge-high"></i> Panel Admin
        </h3>
        <ul style="list-style: none;">
            <li style="margin-bottom: 1rem;">
                <a href="<?= BASE_URL ?>?c=Admin&a=dashboard" style="color: var(--gray-dark); display: block;"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            </li>
            <li style="margin-bottom: 1rem;">
                <a href="<?= BASE_URL ?>?c=Admin&a=productos" style="color: var(--primary-blue); font-weight: 600; display: block;"><i class="fa-solid fa-box"></i> Productos</a>
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

    <!-- Content -->
    <div style="flex: 1;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2>Editar Producto</h2>
                <p style="color: var(--gray-dark);">Modifica la información o la imagen actual de la balanza.</p>
            </div>
            <a href="<?= BASE_URL ?>?c=Admin&a=productos" class="btn-primary" style="background: var(--gray-dark);"><i class="fa-solid fa-arrow-left"></i> Volver</a>
        </div>

        <!-- Formulario de Edición -->
        <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); margin-bottom: 2rem;">
            <form action="<?= BASE_URL ?>?c=Admin&a=actualizar_producto" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600;">Nombre del Producto *</label>
                        <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Categoría (ID) *</label>
                        <select name="categoria_id" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="1" <?= $producto['categoria_id'] == 1 ? 'selected' : '' ?>>Balanzas Comerciales</option>
                            <option value="2" <?= $producto['categoria_id'] == 2 ? 'selected' : '' ?>>Balanzas Digitales</option>
                            <option value="3" <?= $producto['categoria_id'] == 3 ? 'selected' : '' ?>>Balanzas Industriales</option>
                            <option value="4" <?= $producto['categoria_id'] == 4 ? 'selected' : '' ?>>Balanzas de Precisión</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600;">Marca</label>
                        <input type="text" name="marca" value="<?= htmlspecialchars($producto['marca']) ?>" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Modelo</label>
                        <input type="text" name="modelo" value="<?= htmlspecialchars($producto['modelo']) ?>" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Capacidad</label>
                        <input type="text" name="capacidad" value="<?= htmlspecialchars($producto['capacidad']) ?>" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 2fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600;">Precio *</label>
                        <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($producto['precio']) ?>" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Stock *</label>
                        <input type="number" name="stock" value="<?= (int)($producto['stock'] ?? 0) ?>" min="0" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Cambiar Imagen (Ignorar si se mantiene la misma)</label>
                        <input type="file" name="imagen" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; background: #f8fafc;">
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600;">Descripción</label>
                    <textarea name="descripcion" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                </div>

                <div style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 4px; background: #fafafa; display: inline-block;">
                    <p style="margin-bottom: 0.5rem; font-size: 0.9rem; font-weight: bold; color: var(--gray-dark);">Imagen Actual:</p>
                    <img src="<?= BASE_URL . $producto['imagen'] ?>" alt="Imagen Actual" style="height: 100px; border-radius: 4px; object-fit: cover;">
                </div>

                <div>
                    <button type="submit" class="btn-primary" style="background: #38a169;"><i class="fa-solid fa-floppy-disk"></i> Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
