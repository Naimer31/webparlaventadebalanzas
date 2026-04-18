<?php

class VentaController {

    public function __construct() {
        // Inicializar sesión si no está iniciada (se maneja en index.php, pero por seguridad)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function checkout() {
        // Redirigir al login si no está autenticado
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . BASE_URL . "?c=Auth&a=login&redirect=checkout");
            exit;
        }

        $title = "Finalizar Compra | " . APP_NAME;
        $view = "checkout";
        require_once 'views/shared/layout.php';
    }

    public function procesar() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'Usuario no autenticado', 'redirect' => '?c=Auth&a=login']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || empty($input['carrito'])) {
            echo json_encode(['success' => false, 'message' => 'El carrito está vacío']);
            return;
        }

        require_once 'models/Venta.php';
        $ventaModel = new Venta();

        $usuario_id = $_SESSION['usuario_id'];
        $carrito = $input['carrito'];
        $total = 0;

        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $venta_id = $ventaModel->crearVenta($usuario_id, $carrito, $total);

        if ($venta_id) {
            echo json_encode([
                'success' => true, 
                'message' => 'Venta registrada con éxito', 
                'venta_id' => $venta_id
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Hubo un error al procesar la venta. Verifique el stock disponible.']);
        }
    }

    public function boleta() {
        if (!isset($_GET['id'])) {
            header("Location: " . BASE_URL);
            exit;
        }

        require_once 'models/Venta.php';
        $ventaModel = new Venta();
        $venta = $ventaModel->getVentaById($_GET['id']);

        if (!$venta) {
            echo "Boleta no encontrada.";
            exit;
        }

        // Permiso: Sólo admin o el dueño de la boleta pueden verla
        if ($_SESSION['rol'] !== 'admin' && $_SESSION['usuario_id'] != $venta['usuario_id']) {
            echo "Acceso denegado.";
            exit;
        }

        $title = "Boleta Electrónica #" . $venta['id'];
        // Usamos una vista sin el layout completo, directa para imprimir
        require_once 'views/public/boleta.php';
    }
}
?>
