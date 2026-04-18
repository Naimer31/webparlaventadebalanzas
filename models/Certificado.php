<?php
require_once 'config/config.php';
require_once 'config/Database.php';

class Certificado {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        try {
            $stmt = $this->db->query("SELECT * FROM certificados ORDER BY created_at DESC");
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM certificados WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function insert($data) {
        try {
            $sql = "INSERT INTO certificados (
                codigo, solicitante_nombre, solicitante_direccion,
                tipo_instrumento, funcionamiento, capacidad_max, division_escala,
                division_verificacion, clase_exactitud, marca, modelo, tipo_electronico,
                procedencia, nro_serie, codigo_identificacion, ubicacion,
                lugar_calibracion, fecha_calibracion, fecha_emision,
                temp_inicio, temp_final, humedad_inicio, humedad_final,
                trazabilidad, observaciones, proxima_calibracion,
                insp_display, insp_teclado, insp_cables, insp_estructura,
                repetibilidad, linealidad, responsable_tecnico
            ) VALUES (
                :codigo, :solicitante_nombre, :solicitante_direccion,
                :tipo_instrumento, :funcionamiento, :capacidad_max, :division_escala,
                :division_verificacion, :clase_exactitud, :marca, :modelo, :tipo_electronico,
                :procedencia, :nro_serie, :codigo_identificacion, :ubicacion,
                :lugar_calibracion, :fecha_calibracion, :fecha_emision,
                :temp_inicio, :temp_final, :humedad_inicio, :humedad_final,
                :trazabilidad, :observaciones, :proxima_calibracion,
                :insp_display, :insp_teclado, :insp_cables, :insp_estructura,
                :repetibilidad, :linealidad, :responsable_tecnico
            )";
            $stmt = $this->db->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM certificados WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function generateCodigo() {
        $year = date('Y');
        try {
            $stmt = $this->db->query("SELECT COUNT(*) as total FROM certificados WHERE YEAR(created_at) = $year");
            $row = $stmt->fetch();
            $num = str_pad($row['total'] + 1, 4, '0', STR_PAD_LEFT);
            return "CGM-{$year}-{$num}";
        } catch (\PDOException $e) {
            return "CGM-" . $year . "-" . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }
    }
}
