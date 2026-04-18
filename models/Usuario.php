<?php
require_once 'config/config.php';
require_once 'config/Database.php';

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function registrar($nombre, $correo, $contrasena, $telefono = '', $direccion = '', $empresa_ruc = '') {
        try {
            $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, correo, contrasena, rol, telefono, direccion, empresa_ruc) VALUES (:nombre, :correo, :contrasena, 'cliente', :telefono, :direccion, :empresa_ruc)");
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $hashed_password);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':empresa_ruc', $empresa_ruc);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }
    public function autenticar($correo, $contrasena) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = :correo LIMIT 1");
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
                return $usuario;
            }
            return false;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
