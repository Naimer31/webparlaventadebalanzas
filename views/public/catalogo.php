<section class="container" style="padding: 3rem 0;">
    <div class="text-center" style="margin-bottom: 2rem;">
        <h1>Catálogo de Balanzas</h1>
        <p style="color: var(--gray-dark);">Filtra y encuentra la balanza ideal para tu negocio o industria.</p>
    </div>

    <!-- Filtros de Búsqueda Activos -->
    <form method="GET" action="<?= BASE_URL ?>" style="background: var(--white); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); margin-bottom: 2rem;">
        <input type="hidden" name="c" value="Home">
        <input type="hidden" name="a" value="catalogo">
        <h4 style="margin-bottom: 1rem;"><i class="fa-solid fa-filter"></i> Filtros de Búsqueda</h4>
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <input type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Buscar por Nombre, Marca, Modelo..." style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; flex: 2; min-width: 250px;">
            <select name="cat" style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; flex: 1; min-width: 200px;">
                <option value="0">Todas las Categorías</option>
                <option value="1" <?= (isset($_GET['cat']) && $_GET['cat'] == '1') ? 'selected' : '' ?>>Balanzas Comerciales</option>
                <option value="2" <?= (isset($_GET['cat']) && $_GET['cat'] == '2') ? 'selected' : '' ?>>Balanzas Digitales</option>
                <option value="3" <?= (isset($_GET['cat']) && $_GET['cat'] == '3') ? 'selected' : '' ?>>Balanzas Industriales</option>
                <option value="4" <?= (isset($_GET['cat']) && $_GET['cat'] == '4') ? 'selected' : '' ?>>Balanzas de Precisión</option>
            </select>
            <button type="submit" class="btn-primary" style="flex: 0 1 auto; white-space: nowrap;"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
            <?php if(isset($_GET['search']) || isset($_GET['cat'])): ?>
                <a href="<?= BASE_URL ?>?c=Home&a=catalogo" class="btn-primary" style="background:#e53e3e; display: flex; align-items: center; text-decoration: none;"><i class="fa-solid fa-xmark"></i></a>
            <?php endif; ?>
        </div>
    </form>

    <div class="catalog-grid">
        <?php if (!empty($productos)): ?>
            <?php foreach($productos as $prod): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($prod['imagen']) ?>" alt="<?= htmlspecialchars($prod['nombre']) ?>" class="product-img">
                    <div class="product-info">
                        <span class="product-category"><?= htmlspecialchars($prod['categoria']) ?></span>
                        <h3 class="product-title"><?= htmlspecialchars($prod['nombre']) ?></h3>
                        <p class="product-specs"><?= htmlspecialchars($prod['descripcion']) ?></p>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                            <span class="product-price"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : '$' ?><?= number_format($prod['precio'], 2) ?></span>
                            <!-- Botón agregar con atributos data para JS -->
                            <button class="btn-primary add-to-cart-btn" 
                                data-id="<?= $prod['id'] ?>"
                                data-name="<?= htmlspecialchars($prod['nombre']) ?>"
                                data-price="<?= $prod['precio'] ?>"
                                data-img="<?= htmlspecialchars($prod['imagen']) ?>">
                                Comprar
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center w-100">No se encontraron productos.</p>
        <?php endif; ?>
    </div>
</section>
