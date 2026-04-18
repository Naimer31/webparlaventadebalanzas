// ============================================================
//  CASA DE LA BALANZA — main.js v2.0
//  Dark Mode + Cart (quantity control) + Checkout + Toasts
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

    // ── DARK MODE ─────────────────────────────────────────────────────
    const html = document.documentElement;
    const savedTheme = localStorage.getItem('balanzas_theme') || 'light';
    html.setAttribute('data-theme', savedTheme);

    const darkToggle = document.getElementById('dark-toggle');
    if (darkToggle) {
        darkToggle.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            localStorage.setItem('balanzas_theme', next);
        });
    }

    // ── TOAST NOTIFICATIONS ───────────────────────────────────────────
    function showToast(msg, type = 'success') {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            document.body.appendChild(container);
        }
        const icons = { success: '✅', error: '❌', info: 'ℹ️' };
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `<span>${icons[type] || '📌'}</span><span>${msg}</span>`;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 3200);
    }
    window.showToast = showToast;

    // ── CART SIDEBAR TOGGLE ───────────────────────────────────────────
    const cartToggleBtn = document.getElementById('cart-toggle');
    const closeCartBtn  = document.getElementById('close-cart');
    const cartSidebar   = document.getElementById('cart-sidebar');
    const cartOverlay   = document.getElementById('cart-overlay');

    function openCart()  { cartSidebar?.classList.add('open');    cartOverlay?.classList.add('show'); }
    function closeCart() { cartSidebar?.classList.remove('open'); cartOverlay?.classList.remove('show'); }

    cartToggleBtn?.addEventListener('click', (e) => { e.preventDefault(); openCart(); });
    closeCartBtn?.addEventListener('click', closeCart);
    cartOverlay?.addEventListener('click', closeCart);

    // ── CART STATE ────────────────────────────────────────────────────
    let cart = JSON.parse(localStorage.getItem('balanzas_cart')) || [];

    function saveCart() {
        localStorage.setItem('balanzas_cart', JSON.stringify(cart));
        renderCart();
    }

    function renderCart() {
        const countEl = document.querySelector('.cart-count');
        const itemsEl = document.getElementById('cart-items');
        const totalEl = document.getElementById('cart-total-price');

        const totalQty = cart.reduce((s, i) => s + i.quantity, 0);
        if (countEl) countEl.textContent = totalQty;

        if (!itemsEl) return;
        if (cart.length === 0) {
            itemsEl.innerHTML = `
                <div class="cart-empty">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <p>Tu carrito está vacío</p>
                    <small>Agrega productos desde el catálogo</small>
                </div>`;
        } else {
            itemsEl.innerHTML = '';
            let total = 0;
            cart.forEach((item, idx) => {
                total += item.price * item.quantity;
                const el = document.createElement('div');
                el.className = 'cart-item';
                el.innerHTML = `
                    <img src="${item.img}" alt="${item.name}" class="cart-item-img" onerror="this.src='assets/img/balanza_destacada.jpg'">
                    <div class="cart-item-info">
                        <h4>${item.name}</h4>
                        <span class="cart-item-price">${CURRENCY_SYMBOL}${Number(item.price).toFixed(2)}</span>
                        <div class="cart-qty-ctrl">
                            <button class="cart-qty-btn" data-action="dec" data-idx="${idx}">−</button>
                            <span class="cart-qty-val">${item.quantity}</span>
                            <button class="cart-qty-btn" data-action="inc" data-idx="${idx}">+</button>
                        </div>
                        <button class="cart-item-remove" data-idx="${idx}">
                            <i class="fa-solid fa-trash-can"></i> Eliminar
                        </button>
                    </div>`;
                itemsEl.appendChild(el);
            });
            if (totalEl) totalEl.textContent = `${CURRENCY_SYMBOL}${total.toFixed(2)}`;
        }
        if (totalEl && cart.length === 0) totalEl.textContent = `${CURRENCY_SYMBOL}0.00`;

        // Quantity controls
        itemsEl.querySelectorAll('.cart-qty-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const idx    = parseInt(btn.dataset.idx);
                const action = btn.dataset.action;
                if (action === 'inc') cart[idx].quantity++;
                if (action === 'dec') {
                    if (cart[idx].quantity > 1) cart[idx].quantity--;
                    else cart.splice(idx, 1);
                }
                saveCart();
            });
        });
        itemsEl.querySelectorAll('.cart-item-remove').forEach(btn => {
            btn.addEventListener('click', () => {
                const name = cart[parseInt(btn.dataset.idx)].name;
                cart.splice(parseInt(btn.dataset.idx), 1);
                saveCart();
                showToast(`"${name}" eliminado del carrito`, 'info');
            });
        });
    }

    // ── ADD-TO-CART BUTTONS ───────────────────────────────────────────
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id    = btn.dataset.id;
            const name  = btn.dataset.name;
            const price = parseFloat(btn.dataset.price);
            const img   = btn.dataset.img;

            const existing = cart.find(i => i.id === id);
            if (existing) {
                existing.quantity++;
                showToast(`+1 "${name}" en el carrito`, 'success');
            } else {
                cart.push({ id, name, price, img, quantity: 1 });
                showToast(`"${name}" agregado al carrito`, 'success');
            }
            saveCart();

            // Button feedback
            const origHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Agregado';
            btn.disabled = true;
            setTimeout(() => { btn.innerHTML = origHTML; btn.disabled = false; }, 1600);

            openCart();
        });
    });

    renderCart();

    // ── PROCEED TO CHECKOUT ───────────────────────────────────────────
    const btnCheckout = document.getElementById('btn-checkout');
    if (btnCheckout) {
        btnCheckout.addEventListener('click', () => {
            if (cart.length === 0) {
                showToast('Tu carrito está vacío', 'error');
                return;
            }
            window.location.href = '?c=Venta&a=checkout';
        });
    }

    // ── CHECKOUT PAGE ─────────────────────────────────────────────────
    const checkoutItemsEl  = document.getElementById('checkout-items');
    const checkoutTotalEl  = document.getElementById('checkout-total-price');
    const btnConfirmar     = document.getElementById('btn-confirmar-compra');

    if (checkoutItemsEl) {
        if (cart.length === 0) {
            checkoutItemsEl.innerHTML = `
                <div style="text-align:center;padding:3rem;color:var(--text-muted)">
                    <i class="fa-solid fa-cart-shopping" style="font-size:3rem;opacity:.3;display:block;margin-bottom:1rem"></i>
                    <p>Tu carrito está vacío. <a href="?c=Home&a=catalogo" style="color:#3b82f6">Ver catálogo</a></p>
                </div>`;
            if (btnConfirmar) btnConfirmar.disabled = true;
        } else {
            let total = 0;
            checkoutItemsEl.innerHTML = '';
            cart.forEach(item => {
                total += item.price * item.quantity;
                checkoutItemsEl.innerHTML += `
                    <div class="checkout-row">
                        <div>
                            <strong>${item.name}</strong>
                            <br><span style="font-size:.85rem;color:var(--text-muted)">Und: ${CURRENCY_SYMBOL}${Number(item.price).toFixed(2)} × ${item.quantity}</span>
                        </div>
                        <span style="font-weight:700">${CURRENCY_SYMBOL}${(item.price * item.quantity).toFixed(2)}</span>
                    </div>`;
            });
            if (checkoutTotalEl) checkoutTotalEl.textContent = `${CURRENCY_SYMBOL}${total.toFixed(2)}`;
        }
    }

    if (btnConfirmar) {
        btnConfirmar.addEventListener('click', async () => {
            if (cart.length === 0) return;

            const payload = { carrito: cart.map(c => ({ id: c.id, cantidad: c.quantity, precio: c.price })) };
            btnConfirmar.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Procesando...';
            btnConfirmar.disabled = true;

            try {
                const res    = await fetch('?c=Venta&a=procesar', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                const result = await res.json();

                if (result.success) {
                    cart = [];
                    saveCart();
                    // Show success modal
                    const modal    = document.getElementById('success-modal');
                    const linkBol  = document.getElementById('enlace-boleta');
                    if (modal)   modal.classList.add('show');
                    if (linkBol) linkBol.href = `?c=Venta&a=boleta&id=${result.venta_id}`;
                } else {
                    if (result.redirect) window.location.href = result.redirect;
                    else {
                        showToast(result.message || 'Error al procesar', 'error');
                        btnConfirmar.innerHTML = '<i class="fa-solid fa-check"></i> Confirmar Pedido';
                        btnConfirmar.disabled = false;
                    }
                }
            } catch (err) {
                console.error(err);
                showToast('Error de conexión. Intenta nuevamente.', 'error');
                btnConfirmar.innerHTML = '<i class="fa-solid fa-check"></i> Confirmar Pedido';
                btnConfirmar.disabled = false;
            }
        });
    }

    // ── MOBILE HAMBURGER ──────────────────────────────────────────────
    const hamburger = document.querySelector('.hamburger');
    const navLinks  = document.querySelector('.nav-links');
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('mobile-open');
        });
    }

});
