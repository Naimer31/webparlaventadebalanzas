<?php
require_once 'models/Producto.php';

class HomeController {
    
    public function index() {
        $title = "Inicio | " . APP_NAME;
        $view = "home";
        require_once 'models/Producto.php';
        $model = new Producto();
        $productos = $model->getAll();
        require_once 'views/shared/layout.php';
    }

    public function catalogo() {
        $title = "Catálogo de Balanzas | " . APP_NAME;
        $view = "catalogo";
        
        $cat = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        $model = new Producto();
        if ($cat > 0 || $search !== '') {
            $productos = $model->filter($cat, $search);
        } else {
            $productos = $model->getAll();
        }
        
        require_once 'views/shared/layout.php';
    }
    public function mis_pedidos() {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "?c=Auth&a=login");
            exit;
        }
        
        $title = "Mis Pedidos | " . APP_NAME;
        $view = "mis_pedidos";
        
        require_once 'models/Venta.php';
        $ventaModel = new Venta();
        $pedidos = $ventaModel->getVentasByUserId($_SESSION['usuario_id']);
        
        require_once 'views/shared/layout.php';
    }
}
