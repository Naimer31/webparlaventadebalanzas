<section class="container" style="padding: 5rem 0; display: flex; justify-content: center;">
    <div style="background: var(--white); padding: 2.5rem; border-radius: var(--radius); box-shadow: var(--shadow-md); width: 100%; max-width: 400px;">
        <div class="text-center" style="margin-bottom: 2rem;">
            <i class="fa-solid fa-user-plus" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
            <h2>Crear Cuenta</h2>
            <p style="color: var(--gray-dark);">Regístrate para realizar tus compras</p>
        </div>

        <?php if(isset($_SESSION['error'])): ?>
            <div style="background: #fed7d7; color: #9b2c2c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; text-align: center;">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['success'])): ?>
            <div style="background: #c6f6d5; color: #22543d; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; text-align: center;">
                <?= $_SESSION['success'] ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>?c=Auth&a=process_registro" method="POST">
            <div style="margin-bottom: 1.5rem;">
                <label for="nombre" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required 
                       style="width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; font-family: 'Inter', sans-serif;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="correo" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required 
                       style="width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; font-family: 'Inter', sans-serif;">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Contraseña *</label>
                <input type="password" id="password" name="password" required 
                       style="width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; font-family: 'Inter', sans-serif;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="telefono" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Teléfono / WhatsApp (Opcional)</label>
                <input type="text" id="telefono" name="telefono" 
                       style="width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; font-family: 'Inter', sans-serif;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="direccion" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Dirección (Opcional)</label>
                <input type="text" id="direccion" name="direccion" 
                       style="width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; font-family: 'Inter', sans-serif;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="empresa_ruc" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Empresa / RUC (Opcional)</label>
                <input type="text" id="empresa_ruc" name="empresa_ruc" 
                       style="width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; font-family: 'Inter', sans-serif;">
            </div>

            <button type="submit" class="btn-primary w-100" style="padding: 1rem; font-size: 1.1rem;">Registrarse</button>
        </form>

        <p class="text-center" style="margin-top: 1.5rem; font-size: 0.9rem;">
            ¿Ya tienes cuenta? <a href="<?= BASE_URL ?>?c=Auth&a=login" style="color: var(--secondary-blue); font-weight: 600;">Inicia Sesión</a>
        </p>
    </div>
</section>
