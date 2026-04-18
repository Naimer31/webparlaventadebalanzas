<?php

class AdminController {
    
    public function __construct() {
        // Redirigir si no es admin
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header("Location: " . BASE_URL . "?c=Auth&a=login");
            exit;
        }
    }

    public function dashboard() {
        $title = "Dashboard Administrador | " . APP_NAME;
        $view = "../admin/dashboard"; // Ajuste para que layout lo encuentre en views/admin/
        
        require_once 'models/Venta.php';
        require_once 'models/Producto.php';
        
        $ventaModel = new Venta();
        $productoModel = new Producto();
        
        $totalIngresos = $ventaModel->getTotalIngresos();
        $nuevosPedidos = $ventaModel->getCountNuevosPedidos();
        $ultimosPedidos = $ventaModel->getUltimosPedidos();
        $chartData = $ventaModel->getVentasPorDias();
        
        // Obtener productos totales y con stock bajo
        $productos = $productoModel->getAll();
        $totalProductos = count($productos);
        $stockBajo = 0;
        foreach($productos as $p) {
            if($p['stock'] <= 5) $stockBajo++;
        }

        require_once 'views/shared/layout.php';
    }

    public function productos() {
        $title = "Gestión de Productos | " . APP_NAME;
        $view = "../admin/productos";
        require_once 'models/Producto.php';
        $productoModel = new Producto();
        $productos = $productoModel->getAll();
        require_once 'views/shared/layout.php';
    }

    public function guardar_producto() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'models/Producto.php';
            $nombre = $_POST['nombre'] ?? '';
            $marca = $_POST['marca'] ?? '';
            $modelo = $_POST['modelo'] ?? '';
            $capacidad = $_POST['capacidad'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $descripcion = $_POST['descripcion'] ?? '';
            $categoria_id = $_POST['categoria_id'] ?? 1;
            $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;

            $imagenRuta = 'assets/img/balanza_destacada.jpg'; // fallback

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                if (!is_dir('assets/img/uploads')) {
                    mkdir('assets/img/uploads', 0777, true);
                }
                
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $filename = $_FILES['imagen']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $nombreArchivo = time() . '_' . uniqid() . '.' . $ext;
                    $rutaDestino = 'assets/img/uploads/' . $nombreArchivo;
                    
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                        $imagenRuta = $rutaDestino;
                    }
                }
            }

            $productoModel = new Producto();
            if ($productoModel->insert($nombre, $marca, $modelo, $capacidad, $precio, $descripcion, $categoria_id, $stock, $imagenRuta)) {
                $_SESSION['success'] = "Producto agregado correctamente.";
            } else {
                $_SESSION['error'] = "Error al guardar el producto.";
            }

            header("Location: " . BASE_URL . "?c=Admin&a=productos");
            exit;
        }
    }

    public function editar_producto() {
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL . "?c=Admin&a=productos");
            exit;
        }
        $id = $_GET['id'];
        require_once 'models/Producto.php';
        $productoModel = new Producto();
        $producto = $productoModel->getById($id);
        
        if (!$producto) {
            $_SESSION['error'] = "Producto no encontrado.";
            header("Location: " . BASE_URL . "?c=Admin&a=productos");
            exit;
        }
        
        $title = "Editar Producto | " . APP_NAME;
        $view = "../admin/editar_producto";
        require_once 'views/shared/layout.php';
    }

    public function actualizar_producto() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            require_once 'models/Producto.php';
            $id = $_POST['id'];
            $nombre = $_POST['nombre'] ?? '';
            $marca = $_POST['marca'] ?? '';
            $modelo = $_POST['modelo'] ?? '';
            $capacidad = $_POST['capacidad'] ?? '';
            $precio = $_POST['precio'] ?? 0;
            $descripcion = $_POST['descripcion'] ?? '';
            $categoria_id = $_POST['categoria_id'] ?? 1;
            $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;

            $imagenRuta = null;

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                if (!is_dir('assets/img/uploads')) {
                    mkdir('assets/img/uploads', 0777, true);
                }
                
                $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $filename = $_FILES['imagen']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $nombreArchivo = time() . '_' . uniqid() . '.' . $ext;
                    $rutaDestino = 'assets/img/uploads/' . $nombreArchivo;
                    
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                        $imagenRuta = $rutaDestino;
                    }
                }
            }

            $productoModel = new Producto();
            if ($productoModel->update($id, $nombre, $marca, $modelo, $capacidad, $precio, $descripcion, $categoria_id, $stock, $imagenRuta)) {
                $_SESSION['success'] = "Producto actualizado correctamente.";
            } else {
                $_SESSION['error'] = "Error al actualizar el producto.";
            }

            header("Location: " . BASE_URL . "?c=Admin&a=productos");
            exit;
        }
    }

    public function eliminar_producto() {
        if (isset($_GET['id'])) {
            require_once 'models/Producto.php';
            $productoModel = new Producto();
            if ($productoModel->delete($_GET['id'])) {
                $_SESSION['success'] = "Producto eliminado correctamente.";
            } else {
                $_SESSION['error'] = "No se pudo eliminar el producto porque puede tener ventas asociadas.";
            }
        }
        header("Location: " . BASE_URL . "?c=Admin&a=productos");
        exit;
    }
}
