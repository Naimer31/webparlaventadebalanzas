<?php

class AuthController {
    public function login() {
        $title = "Iniciar Sesión | " . APP_NAME;
        $view = "login";
        require_once 'views/shared/layout.php';
    }

    public function process() {
        require_once 'models/Usuario.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';

            $usuarioModel = new Usuario();
            $user = $usuarioModel->autenticar($correo, $password);

            if ($user) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['rol'] = $user['rol'];
                if ($user['rol'] === 'admin') {
                    header("Location: " . BASE_URL . "?c=Admin&a=dashboard");
                } else {
                    header("Location: " . BASE_URL);
                }
                exit;
            } elseif ($correo === 'admin@balanzas.com' && $password === 'admin123') {
                // Fallback demo admin
                $_SESSION['usuario_id'] = 1;
                $_SESSION['rol'] = 'admin';
                header("Location: " . BASE_URL . "?c=Admin&a=dashboard");
                exit;
            } else {
                $_SESSION['error'] = "Credenciales incorrectas.";
                header("Location: " . BASE_URL . "?c=Auth&a=login");
                exit;
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL);
        exit;
    }

    public function registro() {
        $title = "Crear Cuenta | " . APP_NAME;
        $view = "registro";
        require_once 'views/shared/layout.php';
    }

    public function process_registro() {
        require_once 'models/Usuario.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';
            $telefono = $_POST['telefono'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $empresa_ruc = $_POST['empresa_ruc'] ?? '';

            if(empty($nombre) || empty($correo) || empty($password)){
                $_SESSION['error'] = "Los campos Nombre, Correo y Contraseña son obligatorios.";
                header("Location: " . BASE_URL . "?c=Auth&a=registro");
                exit;
            }

            $usuarioModel = new Usuario();
            if($usuarioModel->registrar($nombre, $correo, $password, $telefono, $direccion, $empresa_ruc)){
                $_SESSION['success'] = "Registro exitoso. Ya puedes iniciar sesión.";
                header("Location: " . BASE_URL . "?c=Auth&a=login");
            } else {
                $_SESSION['error'] = "Error al registrar o el correo ya existe.";
                header("Location: " . BASE_URL . "?c=Auth&a=registro");
            }
            exit;
        }
    }
}
