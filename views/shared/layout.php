<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : APP_NAME ?></title>
    <meta name="description" content="Casa de La Balanza Huánuco — Especialistas en pesaje industrial y comercial. Encuentra balanzas digitales, industriales y de precisión con garantía.">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <script>
        // Aplicar tema ANTES de renderizar para evitar flash
        (function(){
            const t = localStorage.getItem('balanzas_theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
        const CURRENCY_SYMBOL = "<?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : 'S/. ' ?>";
    </script>
</head>
<body>
    <!-- ── SOCIAL TOP BAR ──────────────────────────── -->
    <?php if (!isset($view) || strpos($view, '../admin') === false): ?>
    <div class="social-topbar">
        <div class="container social-topbar-inner">
            <a href="https://wa.me/51987654321?text=Hola,%20quisiera%20información%20sobre%20sus%20balanzas" target="_blank" rel="noopener" class="topbar-social topbar-whatsapp" title="WhatsApp">
                <i class="fa-brands fa-whatsapp"></i> +51 987 654 321
            </a>
            <span class="topbar-sep">|</span>
            <a href="https://facebook.com/casadelabalanzahuanuco" target="_blank" rel="noopener" class="topbar-social" title="Facebook">
                <i class="fa-brands fa-facebook-f"></i> Facebook
            </a>
            <span class="topbar-sep">|</span>
            <a href="https://instagram.com/casadelabalanza" target="_blank" rel="noopener" class="topbar-social" title="Instagram">
                <i class="fa-brands fa-instagram"></i> Instagram
            </a>
            <span class="topbar-sep">|</span>
            <a href="https://tiktok.com/@casadelabalanza" target="_blank" rel="noopener" class="topbar-social" title="TikTok">
                <i class="fa-brands fa-tiktok"></i> TikTok
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- ── NAVBAR ─────────────────────────────────── -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="<?= BASE_URL ?>" class="logo">
                <i class="fa-solid fa-weight-scale"></i> Casa de La Balanza Huánuco
            </a>

            <?php if (!isset($view) || strpos($view, '../admin') === false): ?>
            <ul class="nav-links" id="nav-links">
                <li><a href="<?= BASE_URL ?>">Inicio</a></li>
                <li><a href="<?= BASE_URL ?>?c=Home&a=catalogo">Catálogo</a></li>
                <?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['rol']) && $_SESSION['rol'] !== 'admin'): ?>
                    <li><a href="<?= BASE_URL ?>?c=Home&a=mis_pedidos"><i class="fa-solid fa-box-open"></i> Mis Pedidos</a></li>
                    <li>
                        <a href="<?= BASE_URL ?>?c=Auth&a=logout" class="nav-user-badge">
                            <i class="fa-solid fa-circle-user"></i>
                            <?= htmlspecialchars($_SESSION['nombre'] ?? 'Mi cuenta') ?>
                        </a>
                    </li>
                <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <li>
                        <a href="<?= BASE_URL ?>?c=Admin&a=dashboard" class="nav-user-badge">
                            <i class="fa-solid fa-gauge"></i> Admin
                        </a>
                    </li>
                <?php else: ?>
                    <li><a href="<?= BASE_URL ?>?c=Auth&a=login" class="btn-login"><i class="fa-solid fa-user"></i> Login</a></li>
                <?php endif; ?>
                <li>
                    <a href="#" class="cart-icon" id="cart-toggle" title="Mi carrito">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-count">0</span>
                    </a>
                </li>
                <!-- Dark Mode Toggle -->
                <li>
                    <button class="dark-toggle" id="dark-toggle" title="Cambiar tema" aria-label="Cambiar modo oscuro">
                        <span class="dark-toggle-thumb">
                            <span class="dark-toggle-icon-sun">☀️</span>
                            <span class="dark-toggle-icon-moon">🌙</span>
                        </span>
                    </button>
                </li>
            </ul>
            <div class="hamburger" id="hamburger">
                <i class="fa-solid fa-bars"></i>
            </div>
            <?php else: ?>
            <!-- Admin navbar: solo toggle de tema -->
            <div style="display:flex;align-items:center;gap:1rem;">
                <button class="dark-toggle" id="dark-toggle" title="Cambiar tema" aria-label="Cambiar modo oscuro">
                    <span class="dark-toggle-thumb">
                        <span class="dark-toggle-icon-sun">☀️</span>
                        <span class="dark-toggle-icon-moon">🌙</span>
                    </span>
                </button>
            </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- ── MAIN CONTENT ───────────────────────────── -->
    <main class="main-content">
        <?php
        if (isset($view)) {
            if (strpos($view, '../admin/') === 0) {
                $adminViewFile = 'views/admin/' . substr($view, strlen('../admin/')) . '.php';
                if (file_exists($adminViewFile)) {
                    require_once $adminViewFile;
                } else {
                    echo "<div class='container' style='padding:100px 0;text-align:center'><h2>Vista admin no encontrada: " . htmlspecialchars($adminViewFile) . "</h2></div>";
                }
            } elseif (file_exists('views/public/' . $view . '.php')) {
                require_once 'views/public/' . $view . '.php';
            } else {
                echo "<div class='container' style='padding:100px 0;text-align:center'><h2>Vista no encontrada.</h2></div>";
            }
        } else {
            echo "<div class='container' style='padding:100px 0;text-align:center'><h2>Vista no encontrada.</h2></div>";
        }
        ?>
    </main>

    <!-- ── CONTACT / REDES SECCIÓN ─────────────────── -->
    <?php if (!isset($view) || strpos($view, '../admin') === false): ?>
    <section class="contact-section">
        <div class="container">
            <div class="section-title" style="margin-bottom:2rem">
                <span class="badge-tag">📲 CONTÁCTANOS</span>
                <h2>¿Tienes alguna consulta?</h2>
                <p>Estamos disponibles por WhatsApp, redes sociales o visítanos en tienda.</p>
            </div>
            <div class="contact-cards" style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;">
                <!-- WhatsApp -->
                <a href="https://wa.me/51987654321?text=Hola,%20quisiera%20información%20sobre%20sus%20balanzas" target="_blank" rel="noopener" class="contact-card contact-card-wa" style="display:flex;flex-direction:row;align-items:center;gap:1rem;">
                    <div class="contact-card-icon"><i class="fa-brands fa-whatsapp"></i></div>
                    <div class="contact-card-body">
                        <h4>WhatsApp</h4>
                        <p>+51 987 654 321</p>
                        <span class="contact-card-cta">Escríbenos ahora →</span>
                    </div>
                </a>
                <!-- Facebook -->
                <a href="https://facebook.com/casadelabalanzahuanuco" target="_blank" rel="noopener" class="contact-card contact-card-fb" style="display:flex;flex-direction:row;align-items:center;gap:1rem;">
                    <div class="contact-card-icon"><i class="fa-brands fa-facebook-f"></i></div>
                    <div class="contact-card-body">
                        <h4>Facebook</h4>
                        <p>Casa de La Balanza</p>
                        <span class="contact-card-cta">Síguenos →</span>
                    </div>
                </a>
                <!-- Instagram -->
                <a href="https://instagram.com/casadelabalanza" target="_blank" rel="noopener" class="contact-card contact-card-ig" style="display:flex;flex-direction:row;align-items:center;gap:1rem;">
                    <div class="contact-card-icon"><i class="fa-brands fa-instagram"></i></div>
                    <div class="contact-card-body">
                        <h4>Instagram</h4>
                        <p>@casadelabalanza</p>
                        <span class="contact-card-cta">Síguenos →</span>
                    </div>
                </a>
                <!-- TikTok -->
                <a href="https://tiktok.com/@casadelabalanza" target="_blank" rel="noopener" class="contact-card contact-card-tt" style="display:flex;flex-direction:row;align-items:center;gap:1rem;">
                    <div class="contact-card-icon"><i class="fa-brands fa-tiktok"></i></div>
                    <div class="contact-card-body">
                        <h4>TikTok</h4>
                        <p>@casadelabalanza</p>
                        <span class="contact-card-cta">Síguenos →</span>
                    </div>
                </a>
                <!-- Email -->
                <a href="mailto:ventas@probalanzas.com" class="contact-card contact-card-email" style="display:flex;flex-direction:row;align-items:center;gap:1rem;">
                    <div class="contact-card-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="contact-card-body">
                        <h4>Correo</h4>
                        <p>ventas@probalanzas.com</p>
                        <span class="contact-card-cta">Enviar correo →</span>
                    </div>
                </a>
                <!-- Ubicación -->
                <a href="https://maps.google.com/?q=Av+Empresarios+123+Huanuco+Peru" target="_blank" rel="noopener" class="contact-card contact-card-map" style="display:flex;flex-direction:row;align-items:center;gap:1rem;">
                    <div class="contact-card-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="contact-card-body">
                        <h4>Visítanos</h4>
                        <p>Av. Empresarios 123, Huánuco</p>
                        <span class="contact-card-cta">Ver en mapa →</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ── FOOTER ─────────────────────────────────── -->
    <footer class="footer">
        <div class="container footer-content">
            <div class="footer-col">
                <h3><i class="fa-solid fa-weight-scale"></i> Casa de La Balanza Huánuco</h3>
                <p>Especialistas en pesaje industrial y comercial.</p>
                <p>Precisión, garantía y servicio técnico certificado.</p>
                <!-- Social icons -->
                <div class="footer-socials">
                    <a href="https://wa.me/51987654321" target="_blank" rel="noopener" class="footer-social-btn footer-social-wa" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://facebook.com/casadelabalanzahuanuco" target="_blank" rel="noopener" class="footer-social-btn footer-social-fb" title="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://instagram.com/casadelabalanza" target="_blank" rel="noopener" class="footer-social-btn footer-social-ig" title="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://tiktok.com/@casadelabalanza" target="_blank" rel="noopener" class="footer-social-btn footer-social-tt" title="TikTok">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Navegación</h3>
                <p><a href="<?= BASE_URL ?>" style="color:#94a3b8">Inicio</a></p>
                <p><a href="<?= BASE_URL ?>?c=Home&a=catalogo" style="color:#94a3b8">Catálogo</a></p>
                <p><a href="<?= BASE_URL ?>?c=Auth&a=registro" style="color:#94a3b8">Crear Cuenta</a></p>
            </div>
            <div class="footer-col">
                <h3>Contacto</h3>
                <p>
                    <a href="https://wa.me/51987654321?text=Hola,%20quisiera%20información%20sobre%20sus%20balanzas" target="_blank" rel="noopener" style="color:#25d366;display:flex;align-items:center;gap:.5rem;font-weight:600">
                        <i class="fa-brands fa-whatsapp"></i> +51 987 654 321
                    </a>
                </p>
                <p><i class="fa-solid fa-envelope" style="color:#6366f1"></i> ventas@probalanzas.com</p>
                <p><i class="fa-solid fa-location-dot" style="color:#ef4444"></i> Av. Empresarios 123, Huánuco</p>
                <p style="margin-top:.75rem;font-size:.82rem;color:#64748b"><i class="fa-solid fa-clock" style="color:#f59e0b"></i> Lun–Sáb: 9:00–18:00</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Casa de La Balanza Huánuco. Todos los derechos reservados.</p>
        </div>
    </footer>
    <?php endif; ?>

    <!-- ── CART SIDEBAR ───────────────────────────── -->
    <?php if (!isset($view) || strpos($view, '../admin') === false): ?>
    <div class="cart-sidebar" id="cart-sidebar">
        <div class="cart-header">
            <h2><i class="fa-solid fa-cart-shopping"></i> Tu Carrito</h2>
            <button class="close-cart" id="close-cart"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="cart-items" id="cart-items"></div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cart-total-price"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : 'S/. ' ?>0.00</span>
            </div>
            <button class="btn-primary w-100 mt-3" id="btn-checkout" style="justify-content:center;">
                <i class="fa-solid fa-credit-card"></i> Proceder al Pago
            </button>
            <?php if (!isset($_SESSION['usuario_id'])): ?>
            <p style="text-align:center;font-size:.8rem;margin-top:.75rem;color:var(--text-muted)">
                <i class="fa-solid fa-circle-info"></i> Debes <a href="<?= BASE_URL ?>?c=Auth&a=login" style="color:#3b82f6">iniciar sesión</a> para comprar
            </p>
            <?php endif; ?>
        </div>
    </div>
    <div class="cart-overlay" id="cart-overlay"></div>
    <?php endif; ?>

    <!-- Toast container -->
    <div id="toast-container"></div>

    <!-- ── FLOATING WHATSAPP BUTTON ───────────────── -->
    <?php if (!isset($view) || strpos($view, '../admin') === false): ?>
    <a href="https://wa.me/51987654321?text=Hola,%20quisiera%20información%20sobre%20sus%20balanzas"
       target="_blank" rel="noopener"
       class="whatsapp-float"
       title="Chatea con nosotros por WhatsApp"
       id="whatsapp-float">
        <i class="fa-brands fa-whatsapp"></i>
        <span class="whatsapp-float-tooltip">¡Escríbenos!</span>
    </a>
    <?php endif; ?>

    <script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html>
