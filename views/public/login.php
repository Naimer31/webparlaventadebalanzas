<section class="container" style="padding: 5rem 0; display: flex; justify-content: center;">
    <div style="background: var(--white); padding: 2.5rem; border-radius: var(--radius); box-shadow: var(--shadow-md); width: 100%; max-width: 400px;">
        <div class="text-center" style="margin-bottom: 2rem;">
            <i class="fa-solid fa-weight-scale" style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;"></i>
            <h2>Iniciar Sesión</h2>
            <p style="color: var(--gray-dark);">Accede a tu cuenta o panel administrativo</p>
        </div>

        <?php if(isset($_SESSION['error'])): ?>
            <div style="background: #fed7d7; color: #9b2c2c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; text-align: center;">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>?c=Auth&a=process" method="POST">
            <div style="margin-bottom: 1.5rem;">
                <label for="correo" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required 
                       style="width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; font-family: 'Inter', sans-serif;">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Contraseña</label>
                <input type="password" id="password" name="password" required 
                       style="width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; font-family: 'Inter', sans-serif;">
            </div>

            <button type="submit" class="btn-primary w-100" style="padding: 1rem; font-size: 1.1rem;">Ingresar</button>
        </form>

        <p class="text-center" style="margin-top: 1.5rem; font-size: 0.9rem;">
            ¿Info admin? correo: <b>admin@balanzas.com</b> | pass: <b>admin123</b>
        </p>
        <p class="text-center" style="margin-top: 0.5rem; font-size: 0.9rem;">
            ¿No tienes cuenta? <a href="<?= BASE_URL ?>?c=Auth&a=registro" style="color: var(--secondary-blue); font-weight: 600;">Regístrate</a>
        </p>
    </div>
</section>
