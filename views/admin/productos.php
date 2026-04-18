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
        <h2>Gestión de Productos</h2>
        <p style="color: var(--gray-dark); margin-bottom: 2rem;">Añade nuevos productos y gestiona sus imágenes.</p>

        <?php if(isset($_SESSION['success'])): ?>
            <div style="background: #c6f6d5; color: #22543d; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])): ?>
            <div style="background: #fed7d7; color: #9b2c2c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); margin-bottom: 2rem;">
            <h3>Subir Nuevo Producto</h3>
            <form action="<?= BASE_URL ?>?c=Admin&a=guardar_producto" method="POST" enctype="multipart/form-data" style="margin-top: 1rem;">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600;">Nombre del Producto *</label>
                        <input type="text" name="nombre" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Categoría (ID) *</label>
                        <select name="categoria_id" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                            <option value="1">Balanzas Comerciales</option>
                            <option value="2">Balanzas Digitales</option>
                            <option value="3">Balanzas Industriales</option>
                            <option value="4">Balanzas de Precisión</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600;">Marca</label>
                        <input type="text" name="marca" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Modelo</label>
                        <input type="text" name="modelo" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Capacidad</label>
                        <input type="text" name="capacidad" placeholder="Ej. 30 kg" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 2fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600;">Precio *</label>
                        <input type="number" step="0.01" name="precio" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Stock *</label>
                        <input type="number" name="stock" required value="0" min="0" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600;">Imagen * (Subir archivo)</label>
                        <input type="file" name="imagen" accept="image/*" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; background: #f8fafc;">
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-weight: 600;">Descripción</label>
                    <textarea name="descripcion" rows="3" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;"></textarea>
                </div>

                <button type="submit" class="btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar Producto</button>
            </form>
        </div>

        <!-- Tabla de Productos -->
        <div style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
            <h3 style="margin-bottom: 1rem;">Productos Registrados</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #e2e8f0; text-align: left;">
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">Imagen</th>
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">Nombre</th>
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">Precio</th>
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">Stock</th>
                        <th style="padding: 1rem 0.5rem; color: var(--gray-dark);">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productos)): ?>
                        <?php foreach($productos as $prod): ?>
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <td style="padding: 1rem 0.5rem;">
                                <img src="<?= BASE_URL . $prod['imagen'] ?>" alt="Img" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                            </td>
                            <td style="padding: 1rem 0.5rem; font-weight: bold;"><?= htmlspecialchars($prod['nombre']) ?></td>
                            <td style="padding: 1rem 0.5rem;"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : '$' ?><?= number_format($prod['precio'], 2) ?></td>
                            <td style="padding: 1rem 0.5rem;">
                                <span style="background: <?= $prod['stock'] > 5 ? '#c6f6d5' : '#fed7d7' ?>; color: <?= $prod['stock'] > 5 ? '#22543d' : '#9b2c2c' ?>; padding: 0.2rem 0.6rem; border-radius: 999px; font-weight: bold; font-size: 0.85rem;">
                                    <?= (int)$prod['stock'] ?>
                                </span>
                            </td>
                            <td style="padding: 1rem 0.5rem;">
                                <a href="<?= BASE_URL ?>?c=Admin&a=editar_producto&id=<?= $prod['id'] ?>" class="btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.9rem; margin-right: 0.5rem; background: #3182ce;"><i class="fa-solid fa-pen"></i></a>
                                <a href="<?= BASE_URL ?>?c=Admin&a=eliminar_producto&id=<?= $prod['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este producto?');" class="btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.9rem; background: #e53e3e;"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center" style="padding: 1rem;">No hay productos registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
