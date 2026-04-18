<section class="hero">
    <div class="container">
        <h1>Precisión y Confianza en Cada Pesaje</h1>
        <p>Expertos en venta de balanzas comerciales, digitales e industriales a nivel profesional.</p>
        <a href="<?= BASE_URL ?>?c=Home&a=catalogo" class="btn-primary">Ver Catálogo</a>
    </div>
</section>

<section class="container" style="margin-top: -40px; position: relative; z-index: 10;">
    <div style="background: white; padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-md); display: flex; justify-content: space-around; flex-wrap: wrap; text-align: center; gap: 1.5rem;">
        <div>
            <i class="fa-solid fa-truck-fast" style="font-size: 2.5rem; color: var(--secondary-blue); margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 1.1rem; color: var(--primary-blue);">Envíos a todo el país</h3>
        </div>
        <div>
            <i class="fa-solid fa-shield-halved" style="font-size: 2.5rem; color: var(--secondary-blue); margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 1.1rem; color: var(--primary-blue);">Garantía de 1 año</h3>
        </div>
        <div>
            <i class="fa-solid fa-headset" style="font-size: 2.5rem; color: var(--secondary-blue); margin-bottom: 0.5rem;"></i>
            <h3 style="font-size: 1.1rem; color: var(--primary-blue);">Soporte 24/7</h3>
        </div>
    </div>
</section>

<section class="container">
    <div class="text-center" style="margin-top: 4rem;">
        <h2>Nuestros Equipos Destacados</h2>
        <p style="color: var(--gray-dark);">Conoce las balanzas más populares entre nuestros clientes</p>
    </div>
    
    <div class="featured-grid">
        <!-- Renderizamos 3 productos destacados si están disponibles -->
        <?php if (!empty($productos)): ?>
            <?php foreach(array_slice($productos, 0, 3) as $prod): ?>
                <div class="product-card">
                    <img src="<?= htmlspecialchars($prod['imagen']) ?>" alt="<?= htmlspecialchars($prod['nombre']) ?>" class="product-img">
                    <div class="product-info">
                        <span class="product-category"><?= htmlspecialchars($prod['categoria']) ?></span>
                        <h3 class="product-title"><?= htmlspecialchars($prod['nombre']) ?></h3>
                        <p class="product-specs">Capacidad: <?= htmlspecialchars($prod['capacidad']) ?> | Marca: <?= htmlspecialchars($prod['marca']) ?></p>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                            <span class="product-price"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : '$' ?><?= number_format($prod['precio'], 2) ?></span>
                            <!-- Botón agregar con atributos data para JS -->
                            <button class="btn-primary add-to-cart-btn" 
                                data-id="<?= $prod['id'] ?>"
                                data-name="<?= htmlspecialchars($prod['nombre']) ?>"
                                data-price="<?= $prod['precio'] ?>"
                                data-img="<?= htmlspecialchars($prod['imagen']) ?>">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center w-100">Cargando productos...</p>
        <?php endif; ?>
    </div>
</section>
