<?php
// controllers/CertificadoController.php

require_once 'vendor/autoload.php'; // Esto carga todas las librerías de Composer automáticamente

use Dompdf\Dompdf;

// Aquí ya puedes usar la clase Dompdf para generar el certificado

require_once 'models/Certificado.php';

class CertificadoController {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
            header("Location: " . BASE_URL . "?c=Auth&a=login");
            exit;
        }
    }

    public function index() {
        $title = "Certificados de Calibración | " . APP_NAME;
        $view  = "../admin/certificados";
        $model = new Certificado();
        $certificados = $model->getAll();
        require_once 'views/shared/layout.php';
    }

    public function crear() {
        $title = "Nuevo Certificado | " . APP_NAME;
        $view  = "../admin/certif_form";
        $model = new Certificado();
        $codigoSugerido = $model->generateCodigo();
        $certificado = null;
        require_once 'views/shared/layout.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?c=Certificado&a=index');
            exit;
        }

        // Armar filas de repetibilidad (JSON)
        $repRows = [];
        if (!empty($_POST['rep_peso_aplicado'])) {
            foreach ($_POST['rep_peso_aplicado'] as $i => $val) {
                $repRows[] = [
                    'peso_aplicado' => $val,
                    'peso_leido'    => $_POST['rep_peso_leido'][$i]  ?? '',
                    'error'         => $_POST['rep_error'][$i]       ?? '',
                    'emp'           => $_POST['rep_emp'][$i]          ?? '',
                ];
            }
        }

        // Armar filas de linealidad (JSON)
        $linRows = [];
        if (!empty($_POST['lin_carga'])) {
            foreach ($_POST['lin_carga'] as $i => $val) {
                $linRows[] = [
                    'carga'   => $val,
                    'lectura' => $_POST['lin_lectura'][$i] ?? '',
                    'error'   => $_POST['lin_error'][$i]   ?? '',
                    'emp'     => $_POST['lin_emp'][$i]      ?? '',
                ];
            }
        }

        $data = [
            'codigo'                => trim($_POST['codigo']                ?? ''),
            'solicitante_nombre'    => trim($_POST['solicitante_nombre']    ?? ''),
            'solicitante_direccion' => trim($_POST['solicitante_direccion'] ?? ''),
            'tipo_instrumento'      => trim($_POST['tipo_instrumento']      ?? 'Balanza electrónica de piso'),
            'funcionamiento'        => trim($_POST['funcionamiento']        ?? 'No automático'),
            'capacidad_max'         => trim($_POST['capacidad_max']         ?? ''),
            'division_escala'       => trim($_POST['division_escala']       ?? ''),
            'division_verificacion' => trim($_POST['division_verificacion'] ?? ''),
            'clase_exactitud'       => trim($_POST['clase_exactitud']       ?? 'III'),
            'marca'                 => trim($_POST['marca']                 ?? ''),
            'modelo'                => trim($_POST['modelo']                ?? ''),
            'tipo_electronico'      => trim($_POST['tipo_electronico']      ?? 'Electrónico'),
            'procedencia'           => trim($_POST['procedencia']           ?? ''),
            'nro_serie'             => trim($_POST['nro_serie']             ?? ''),
            'codigo_identificacion' => trim($_POST['codigo_identificacion'] ?? ''),
            'ubicacion'             => trim($_POST['ubicacion']             ?? ''),
            'lugar_calibracion'     => trim($_POST['lugar_calibracion']     ?? ''),
            'fecha_calibracion'     => $_POST['fecha_calibracion'] ?: null,
            'fecha_emision'         => $_POST['fecha_emision']     ?: null,
            'temp_inicio'           => $_POST['temp_inicio']       ?: null,
            'temp_final'            => $_POST['temp_final']         ?: null,
            'humedad_inicio'        => $_POST['humedad_inicio']     ?: null,
            'humedad_final'         => $_POST['humedad_final']       ?: null,
            'trazabilidad'          => trim($_POST['trazabilidad']          ?? ''),
            'observaciones'         => trim($_POST['observaciones']         ?? ''),
            'proxima_calibracion'   => $_POST['proxima_calibracion'] ?: null,
            'insp_display'          => $_POST['insp_display']    ?? 'Bueno',
            'insp_teclado'          => $_POST['insp_teclado']    ?? 'Bueno',
            'insp_cables'           => $_POST['insp_cables']     ?? 'Bueno',
            'insp_estructura'       => $_POST['insp_estructura'] ?? 'Bueno',
            'repetibilidad'         => json_encode($repRows),
            'linealidad'            => json_encode($linRows),
            'responsable_tecnico'   => trim($_POST['responsable_tecnico'] ?? ''),
        ];

        $model = new Certificado();
        $id = $model->insert($data);

        if ($id) {
            header('Location: ' . BASE_URL . '?c=Certificado&a=imprimir&id=' . $id);
        } else {
            header('Location: ' . BASE_URL . '?c=Certificado&a=crear&error=1');
        }
        exit;
    }

    public function imprimir() {
        $id    = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $model = new Certificado();
        $cert  = $model->getById($id);

        if (!$cert) {
            echo "<p style='font-family:sans-serif;padding:2rem;'>Certificado no encontrado.</p>";
            exit;
        }

        // Decodificar JSON con defaults
        $cert['repetibilidad'] = json_decode($cert['repetibilidad'] ?? '[]', true) ?: [
            ['peso_aplicado' => '', 'peso_leido' => '', 'error' => '', 'emp' => ''],
            ['peso_aplicado' => '', 'peso_leido' => '', 'error' => '', 'emp' => ''],
            ['peso_aplicado' => '', 'peso_leido' => '', 'error' => '', 'emp' => ''],
        ];
        $cert['linealidad'] = json_decode($cert['linealidad'] ?? '[]', true) ?: [
            ['carga' => '', 'lectura' => '', 'error' => '', 'emp' => ''],
            ['carga' => '', 'lectura' => '', 'error' => '', 'emp' => ''],
            ['carga' => '', 'lectura' => '', 'error' => '', 'emp' => ''],
        ];

        // Vista standalone html
        $isPdf = false;
        require_once 'views/admin/certificado_print.php';
        exit;
    }

    public function pdf() {
        $id    = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $model = new Certificado();
        $cert  = $model->getById($id);

        if (!$cert) {
            echo "Certificado no encontrado.";
            exit;
        }

        $cert['repetibilidad'] = json_decode($cert['repetibilidad'] ?? '[]', true) ?: [];
        $cert['linealidad']    = json_decode($cert['linealidad']    ?? '[]', true) ?: [];

        ob_start();
        $isPdf = true;
        require 'views/admin/certificado_print.php';
        $html = ob_get_clean();

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html);
        $dompdf->render();
        // Attachment => false muestra el PDF en el navegador para guardarlo
        $dompdf->stream("CERTIFICADO-" . htmlspecialchars($cert['codigo']) . ".pdf", ["Attachment" => false]);
        exit;
    }

    public function eliminar() {
        $id    = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $model = new Certificado();
        $model->delete($id);
        header('Location: ' . BASE_URL . '?c=Certificado&a=index');
        exit;
    }

    public function json() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'ID de certificado inválido']);
            exit;
        }

        $model = new Certificado();
        $data = $model->getById($id);

        header('Content-Type: application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Certificado no encontrado']);
        }
        exit;
    }
}
