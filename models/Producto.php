<?php
require_once 'config/config.php';
require_once 'config/Database.php';

class Producto {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        // En un entorno real sin la base lista retornaremos datos de prueba si falla
        try {
            $stmt = $this->db->query("SELECT p.*, c.nombre as categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id");
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            // Datos quemados de prueba para avanzar con el frontend
            return [
                [
                    'id' => 1,
                    'nombre' => 'Balanza Electrónica 30KG ACS-30',
                    'marca' => 'Fertow',
                    'modelo' => 'ACS-30',
                    'capacidad' => '30 kg',
                    'precio' => 120.00,
                    'descripcion' => 'Balanza ideal para tiendas y mercados con cálculo de precio automático y batería recargable.',
                    'categoria' => 'Balanzas Comerciales',
                    'imagen' => 'https://images.unsplash.com/photo-1594235311893-6c703e7e008b?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'id' => 2,
                    'nombre' => 'Balanza de Plataforma 500KG',
                    'marca' => 'T-Scale',
                    'modelo' => 'TCS-500',
                    'capacidad' => '500 kg',
                    'precio' => 850.00,
                    'descripcion' => 'Balanza industrial de plataforma de acero inoxidable, ideal para almacenes.',
                    'categoria' => 'Balanzas Industriales',
                    'imagen' => 'https://images.unsplash.com/photo-1621245844445-5c123681498b?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'id' => 3,
                    'nombre' => 'Balanza Gramera Digital 5KG',
                    'marca' => 'Brave',
                    'modelo' => 'SF-400',
                    'capacidad' => '5 kg',
                    'precio' => 45.00,
                    'descripcion' => 'Alta precisión para uso en cocina, repostería o laboratorio. Diseño compacto.',
                    'categoria' => 'Balanzas de Precisión',
                    'imagen' => 'https://images.unsplash.com/photo-1627989392233-a3d122d2f3fe?q=80&w=600&auto=format&fit=crop'
                ]
            ];
        }
    }

    public function filter($cat, $search) {
        try {
            $sql = "SELECT p.*, c.nombre as categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE 1=1";
            $params = [];
            
            if ($cat > 0) {
                $sql .= " AND p.categoria_id = :cat";
                $params[':cat'] = $cat;
            }
            if ($search !== '') {
                $sql .= " AND (p.nombre LIKE :search OR p.descripcion LIKE :search OR p.marca LIKE :search)";
                $params[':search'] = '%' . $search . '%';
            }
            
            $stmt = $this->db->prepare($sql);
            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return $this->getAll(); // fallback
        }
    }

    public function insert($nombre, $marca, $modelo, $capacidad, $precio, $descripcion, $categoria_id, $stock, $imagen) {
        try {
            $sql = "INSERT INTO productos (nombre, marca, modelo, capacidad, precio, descripcion, categoria_id, stock, imagen) VALUES (:nombre, :marca, :modelo, :capacidad, :precio, :descripcion, :categoria_id, :stock, :imagen)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':capacidad', $capacidad);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':categoria_id', $categoria_id);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':imagen', $imagen);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function update($id, $nombre, $marca, $modelo, $capacidad, $precio, $descripcion, $categoria_id, $stock, $imagen = null) {
        try {
            if ($imagen) {
                $sql = "UPDATE productos SET nombre=:nombre, marca=:marca, modelo=:modelo, capacidad=:capacidad, precio=:precio, descripcion=:descripcion, categoria_id=:categoria_id, stock=:stock, imagen=:imagen WHERE id=:id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':imagen', $imagen);
            } else {
                $sql = "UPDATE productos SET nombre=:nombre, marca=:marca, modelo=:modelo, capacidad=:capacidad, precio=:precio, descripcion=:descripcion, categoria_id=:categoria_id, stock=:stock WHERE id=:id";
                $stmt = $this->db->prepare($sql);
            }
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':capacidad', $capacidad);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':categoria_id', $categoria_id);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
}
