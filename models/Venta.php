<?php
require_once 'config/Database.php';

class Venta {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    // Registrar una venta y descontar stock automáticamente
    public function crearVenta($usuario_id, $carritoItems, $total) {
        try {
            $this->conn->beginTransaction();

            // 1. Insertar la Venta principal
            $queryVenta = "INSERT INTO ventas (usuario_id, total, estado) VALUES (:usuario_id, :total, 'Pendiente')";
            $stmtVenta = $this->conn->prepare($queryVenta);
            $stmtVenta->bindParam(':usuario_id', $usuario_id);
            $stmtVenta->bindParam(':total', $total);
            $stmtVenta->execute();
            
            $venta_id = $this->conn->lastInsertId();

            // 2. Insertar los detalles y actualizar stock
            $queryDetalle = "INSERT INTO detalle_venta (venta_id, producto_id, cantidad, precio) VALUES (:venta_id, :producto_id, :cantidad, :precio)";
            $stmtDetalle = $this->conn->prepare($queryDetalle);

            $queryStock = "UPDATE productos SET stock = stock - :cant1 WHERE id = :producto_id AND stock >= :cant2";
            $stmtStock = $this->conn->prepare($queryStock);

            foreach ($carritoItems as $item) {
                // Insertar detalle
                $stmtDetalle->bindValue(':venta_id', $venta_id);
                $stmtDetalle->bindValue(':producto_id', $item['id']);
                $stmtDetalle->bindValue(':cantidad', $item['cantidad']);
                $stmtDetalle->bindValue(':precio', $item['precio']);
                $stmtDetalle->execute();

                // Actualizar stock
                $stmtStock->bindValue(':cant1', (int)$item['cantidad'], PDO::PARAM_INT);
                $stmtStock->bindValue(':cant2', (int)$item['cantidad'], PDO::PARAM_INT);
                $stmtStock->bindValue(':producto_id', $item['id']);
                $stmtStock->execute();

                // Si no se actualizó ninguna fila, significa que no había stock suficiente
                if ($stmtStock->rowCount() == 0) {
                    throw new Exception("Sin stock suficiente para el producto ID: " . $item['id']);
                }
            }

            $this->conn->commit();
            return $venta_id;

        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error al crear venta: " . $e->getMessage());
            return false;
        }
    }

    // Obtener Venta por ID incluyendo detalles
    public function getVentaById($id) {
        $query = "SELECT v.*, u.nombre as cliente_nombre, u.correo as cliente_correo 
                  FROM ventas v 
                  JOIN usuarios u ON v.usuario_id = u.id 
                  WHERE v.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $venta = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($venta) {
            $queryDetalles = "SELECT dv.*, p.nombre, p.marca 
                              FROM detalle_venta dv 
                              JOIN productos p ON dv.producto_id = p.id 
                              WHERE dv.venta_id = :venta_id";
            $stmtDetalles = $this->conn->prepare($queryDetalles);
            $stmtDetalles->bindParam(':venta_id', $id);
            $stmtDetalles->execute();
            $venta['detalles'] = $stmtDetalles->fetchAll(PDO::FETCH_ASSOC);
        }

        return $venta;
    }

    public function getVentasByUserId($userId) {
        $query = "SELECT * FROM ventas WHERE usuario_id = :usuario_id ORDER BY fecha DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':usuario_id', $userId);
        $stmt->execute();
        
        $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($ventas as &$venta) {
            $queryDetalles = "SELECT dv.*, p.nombre, p.marca FROM detalle_venta dv JOIN productos p ON dv.producto_id = p.id WHERE dv.venta_id = :venta_id";
            $stmtDetalles = $this->conn->prepare($queryDetalles);
            $stmtDetalles->bindParam(':venta_id', $venta['id']);
            $stmtDetalles->execute();
            $venta['detalles'] = $stmtDetalles->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $ventas;
    }

    // --- MÉTODOS PARA EL DASHBOARD ---

    // Obtener Total de Ventas en dinero
    public function getTotalIngresos() {
        $query = "SELECT SUM(total) as ingresos FROM ventas WHERE estado != 'Cancelado'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['ingresos'] ? $row['ingresos'] : 0;
    }

    // Obtener cantidad de Pedidos Nuevos (Pendientes)
    public function getCountNuevosPedidos() {
        $query = "SELECT COUNT(*) as cantidad FROM ventas WHERE estado = 'Pendiente'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['cantidad'] ? $row['cantidad'] : 0;
    }

    // Obtener Últimos 5 pedidos
    public function getUltimosPedidos() {
        $query = "SELECT v.id, v.total, v.fecha, v.estado, u.nombre as cliente 
                  FROM ventas v 
                  JOIN usuarios u ON v.usuario_id = u.id 
                  ORDER BY v.fecha DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Datos para la gráfica (Ventas de los últimos 7 días)
    public function getVentasPorDias() {
        $query = "SELECT DATE(fecha) as fecha_dia, SUM(total) as total_dia 
                  FROM ventas 
                  WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND estado != 'Cancelado'
                  GROUP BY DATE(fecha) 
                  ORDER BY DATE(fecha) ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
