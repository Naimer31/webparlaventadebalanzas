<?php
// views/certificado_print.php
require_once 'config/config.php';

// Helper para mostrar valor o raya
function v($val, $fallback = '—') {
    return trim((string)$val) !== '' ? htmlspecialchars($val) : $fallback;
}
function fmtDate($d) {
    if (!$d) return '__ / __ / ____';
    $dt = DateTime::createFromFormat('Y-m-d', $d);
    return $dt ? $dt->format('d / m / Y') : $d;
}

$c = $cert; // alias
$isPdf = isset($isPdf) ? $isPdf : false;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Certificado <?= v($c['codigo']) ?> | <?= APP_NAME ?></title>
<style>
/* ═══════════════════════════════════════════════
   BASE PARA DOMPDF Y HTML
═══════════════════════════════════════════════ */
* { box-sizing:border-box; margin:0; padding:0; }
body {
  font-family: 'Helvetica', 'Arial', sans-serif;
  font-size: 10pt;
  background: <?= $isPdf ? '#fff' : '#cdd0d8' ?>;
  color: #111;
}

<?php if (!$isPdf): ?>
/* TOOLBAR EN PANTALLA */
.toolbar {
  background:#1a3a6b; padding:.8rem 1.5rem; display:flex; align-items:center; gap:1rem;
}
.toolbar h2 { color:#fff; font-size:1rem; flex:1; }
.btn-print { background:#f59e0b; color:#111; padding:.5rem 1rem; border:none; border-radius:5px; cursor:pointer; font-weight:bold; }
.btn-back { color:#93c5fd; text-decoration:none; }
.page { width:210mm; min-height:297mm; background:#fff; margin:20px auto; padding:10mm; box-shadow:0 4px 10px rgba(0,0,0,.2); }
<?php else: ?>
.page { padding: 0mm; } /* Dompdf maneja márgenes por sí solo */
<?php endif; ?>

/* ESTRUCTURAS */
table { width:100%; border-collapse:collapse; }
.cert-header { border:2.5px solid #1a3a6b; margin-bottom:10px; }
.cert-section { margin-bottom:8px; border:1px solid #1a3a6b; }
.cert-section-title { background:#1a3a6b; color:#fff; font-size:9pt; font-weight:bold; padding:4px 8px; text-transform:uppercase; }
.cert-section-body { padding:4px 8px; }

.fields-table td { padding:2px 4px; font-size:9pt; vertical-align:top; }
.fields-table td.lbl { font-weight:bold; color:#1a3a6b; width:40%; }
.fields-table td.val { border-bottom:1px dotted #aaa; width:60%; }

.data-table th { background:#1a3a6b; color:#fff; padding:4px; border:1px solid #1a3a6b; font-size:9pt; text-align:center; }
.data-table td { padding:4px; border:1px solid #aaa; font-size:9pt; text-align:center; }

.env-table th { background:#dce6f5; color:#1a3a6b; border:1px solid #aaa; padding:4px; font-size:9pt; }
.env-table td { border:1px solid #aaa; padding:4px; text-align:center; font-size:9pt; }

/* FIRMAS */
.firma-box { border:1px solid #1a3a6b; padding:8px; text-align:center; }
.firma-title { font-size:8pt; font-weight:bold; color:#1a3a6b; border-bottom:1px solid #ddd; margin-bottom:30px; text-align:left; }

.footer-notas { border:1.5px solid #f59e0b; background:#fffbeb; padding:6px; font-size:8pt; color:#92400e; margin-top:10px; }
.footer-notas h4 { margin-bottom:4px; }
.footer-notas ul { padding-left:15px; margin:0; }

.page-break { page-break-after: always; }
</style>
</head>
<body>

<?php if (!$isPdf): ?>
<div class="toolbar no-print">
  <h2>Certificado de Calibración — <?= v($c['codigo']) ?></h2>
  <a href="<?= BASE_URL ?>?c=Certificado&a=index" class="btn-back">Volver</a>
  <a href="<?= BASE_URL ?>?c=Certificado&a=pdf&id=<?= $c['id'] ?>" class="btn-print" target="_blank">Descargar PDF Original (Dompdf)</a>
</div>
<?php endif; ?>

<div class="page">

  <!-- ENCABEZADO -->
  <table class="cert-header">
    <tr>
      <td style="width:25%; border-right:2px solid #1a3a6b; text-align:center; padding:8px;">
        <div style="font-size:24pt;color:#f59e0b;line-height:1;margin-bottom:4px;font-family:serif;">⚖</div>
        <div style="font-size:10pt;font-weight:bold;color:#1a3a6b;">CASA DE LA<br>BALANZA HUÁNUCO</div>
        <div style="font-size:7pt;color:#555;margin-top:2px;">Servicio de Calibración Metrológica</div>
      </td>
      <td style="text-align:center; padding:8px;">
        <h1 style="font-size:14pt;font-weight:bold;color:#1a3a6b;margin:0;">CERTIFICADO DE CALIBRACIÓN</h1>
        <div style="font-size:11pt;color:#333;margin-top:4px;">N° <strong><?= v($c['codigo']) ?></strong></div>
      </td>
      <td style="width:20%; border-left:2px solid #1a3a6b; text-align:center; padding:8px; font-size:9pt; font-weight:bold; color:#1a3a6b;">
        PÁGINA<br>1 DE 2
      </td>
    </tr>
  </table>

  <!-- 1. SOLICITANTE -->
  <div class="cert-section">
    <div class="cert-section-title">1. Solicitante</div>
    <div class="cert-section-body">
      <table style="width:100%;">
        <tr>
          <td style="width:15%; font-weight:bold; color:#1a3a6b; font-size:9pt; padding:2px;">Nombre:</td>
          <td style="width:35%; border-bottom:1px dotted #aaa; font-size:9pt; padding:2px;"><?= v($c['solicitante_nombre']) ?></td>
          <td style="width:15%; font-weight:bold; color:#1a3a6b; font-size:9pt; padding:2px; padding-left:10px;">Dirección:</td>
          <td style="width:35%; border-bottom:1px dotted #aaa; font-size:9pt; padding:2px;"><?= v($c['solicitante_direccion']) ?></td>
        </tr>
      </table>
    </div>
  </div>

  <!-- 3. INSTRUMENTO -->
  <div class="cert-section">
    <div class="cert-section-title">3. Datos del Instrumento</div>
    <div class="cert-section-body">
      <table style="width:100%;">
        <tr>
          <!-- Columna Izquierda -->
          <td style="width:48%; vertical-align:top;">
            <table class="fields-table">
              <tr><td class="lbl">Tipo:</td><td class="val"><?= v($c['tipo_instrumento']) ?></td></tr>
              <tr><td class="lbl">Funcionamiento:</td><td class="val"><?= v($c['funcionamiento']) ?></td></tr>
              <tr><td class="lbl">Capacidad max:</td><td class="val"><?= v($c['capacidad_max']) ?> Kg</td></tr>
              <tr><td class="lbl">Div. escala (d):</td><td class="val"><?= v($c['division_escala']) ?> Kg</td></tr>
              <tr><td class="lbl">Div. verific. (e):</td><td class="val"><?= v($c['division_verificacion']) ?> Kg</td></tr>
              <tr><td class="lbl">Clase exactitud:</td><td class="val"><?= v($c['clase_exactitud']) ?></td></tr>
              <tr><td class="lbl">Marca:</td><td class="val"><?= v($c['marca']) ?></td></tr>
              <tr><td class="lbl">Modelo:</td><td class="val"><?= v($c['modelo']) ?></td></tr>
            </table>
          </td>
          <!-- Espaciador -->
          <td style="width:4%;"></td>
          <!-- Columna Derecha -->
          <td style="width:48%; vertical-align:top;">
            <table class="fields-table">
              <tr><td class="lbl">Tipo de equipo:</td><td class="val"><?= v($c['tipo_electronico']) ?></td></tr>
              <tr><td class="lbl">Procedencia:</td><td class="val"><?= v($c['procedencia']) ?></td></tr>
              <tr><td class="lbl">N° de Serie:</td><td class="val"><?= v($c['nro_serie']) ?></td></tr>
              <tr><td class="lbl">Cód. Identific.:</td><td class="val"><?= v($c['codigo_identificacion']) ?></td></tr>
              <tr><td class="lbl">Ubicación:</td><td class="val"><?= v($c['ubicacion']) ?></td></tr>
              <tr><td class="lbl">Lugar calibr.:</td><td class="val"><?= v($c['lugar_calibracion']) ?></td></tr>
              <tr><td class="lbl">Fecha calibr.:</td><td class="val"><?= fmtDate($c['fecha_calibracion']) ?></td></tr>
              <tr><td class="lbl">Fecha emisión:</td><td class="val"><?= fmtDate($c['fecha_emision']) ?></td></tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <!-- 4. CONDICIONES AMBIENTALES -->
  <div class="cert-section">
    <div class="cert-section-title">4. Condiciones Ambientales</div>
    <div class="cert-section-body">
      <table class="env-table">
        <tr>
          <th>Parámetro</th><th>Inicio</th><th>Final</th>
        </tr>
        <tr>
          <td><strong>Temperatura (°C)</strong></td>
          <td><?= v($c['temp_inicio']) ?></td>
          <td><?= v($c['temp_final']) ?></td>
        </tr>
        <tr>
          <td><strong>Humedad relativa (%)</strong></td>
          <td><?= v($c['humedad_inicio']) ?></td>
          <td><?= v($c['humedad_final']) ?></td>
        </tr>
      </table>
    </div>
  </div>

  <!-- 5. TRAZABILIDAD -->
  <div class="cert-section">
    <div class="cert-section-title">5. Trazabilidad</div>
    <div class="cert-section-body" style="font-size:9pt;">
      <?= v($c['trazabilidad'], 'Pesas patrón certificadas (clase M1 – INACAL). Certificados de calibración vigentes.') ?>
    </div>
  </div>

  <!-- 6. PROCEDIMIENTO -->
  <div class="cert-section">
    <div class="cert-section-title">6. Procedimiento de Calibración</div>
    <div class="cert-section-body" style="font-size:9pt;">
      La calibración se realizó por comparación directa con pesas patrón certificadas, siguiendo los
      procedimientos técnicos establecidos conforme a las normas metrológicas legales vigentes y
      al <em>Vocabulario Internacional de Metrología (VIM)</em>.
    </div>
  </div>

  <!-- 7. OBSERVACIONES -->
  <div class="cert-section">
    <div class="cert-section-title">7. Observaciones</div>
    <div class="cert-section-body" style="font-size:9pt; min-height:20px;">
      <?= v($c['observaciones'], 'Sin observaciones adicionales.') ?>
    </div>
  </div>

  <!-- 8. PRÓXIMA CALIBRACIÓN -->
  <div class="cert-section">
    <div class="cert-section-title">8. Próxima Calibración</div>
    <div class="cert-section-body">
      <table style="width:100%;">
        <tr>
          <td style="width:30%; font-weight:bold; color:#1a3a6b; font-size:9pt;">Fecha recomendada:</td>
          <td style="font-weight:bold; font-size:10pt; color:#1a3a6b; border-bottom:1px dotted #ccc;"><?= fmtDate($c['proxima_calibracion']) ?></td>
        </tr>
      </table>
    </div>
  </div>

  <!-- NOTAS AL PIE -->
  <div class="footer-notas">
    <h4>NOTAS IMPORTANTES</h4>
    <ul>
      <li>Este certificado es válido únicamente para el equipo calibrado indicado.</li>
      <li>No constituye certificado de conformidad ni aprobación de uso.</li>
      <li>Prohibida su reproducción parcial o total sin autorización del responsable técnico.</li>
      <li>Debe contar con firma y sello original del responsable técnico para ser válido.</li>
    </ul>
  </div>

  <div style="text-align:right; font-size:8pt; margin-top:8px; border-top:1px solid #ccc; padding-top:4px;">
    Certificado N° <?= v($c['codigo']) ?> — Página 1 de 2
  </div>
</div>

<div class="page-break"></div> <!-- Salto de pagina para PDF/Impresión -->

<div class="page">
  <!-- ENCABEZADO PÁGINA 2 -->
  <table class="cert-header">
    <tr>
      <td style="width:25%; border-right:2px solid #1a3a6b; text-align:center; padding:8px;">
        <div style="font-size:24pt;color:#f59e0b;line-height:1;margin-bottom:4px;font-family:serif;">⚖</div>
        <div style="font-size:10pt;font-weight:bold;color:#1a3a6b;">CASA DE LA<br>BALANZA HUÁNUCO</div>
        <div style="font-size:7pt;color:#555;margin-top:2px;">Servicio de Calibración Metrológica</div>
      </td>
      <td style="text-align:center; padding:8px;">
        <h1 style="font-size:14pt;font-weight:bold;color:#1a3a6b;margin:0;">CERTIFICADO DE CALIBRACIÓN</h1>
        <div style="font-size:11pt;color:#333;margin-top:4px;">N° <strong><?= v($c['codigo']) ?></strong></div>
      </td>
      <td style="width:20%; border-left:2px solid #1a3a6b; text-align:center; padding:8px; font-size:9pt; font-weight:bold; color:#1a3a6b;">
        PÁGINA<br>2 DE 2
      </td>
    </tr>
  </table>

  <div class="cert-section">
    <div class="cert-section-title">9. Resultados de Medición</div>
    
    <!-- 9a. INSPECCIÓN VISUAL -->
    <div style="background:#f0f4fb; border-bottom:1px solid #1a3a6b; padding:4px 8px; font-weight:bold; font-size:9pt; color:#1a3a6b;">🔹 Inspección Visual</div>
    <div class="cert-section-body">
      <table style="width:100%;">
        <tr>
          <?php foreach(['display'=>'Display', 'teclado'=>'Teclado', 'cables'=>'Cables', 'estructura'=>'Estructura'] as $key => $label): 
            $val = $c['insp_' . $key] ?? 'Bueno';
            $color = strtolower($val) === 'bueno' ? '#16a34a' : (strtolower($val) === 'regular' ? '#d97706' : '#dc2626');
          ?>
          <td style="width:25%; border:1px solid #aaa; text-align:center; padding:4px; border-radius:4px;">
            <div style="font-weight:bold; font-size:8pt; color:#1a3a6b; margin-bottom:2px;"><?= $label ?></div>
            <div style="font-size:9pt; font-weight:bold; color:<?= $color ?>;"><?= htmlspecialchars($val) ?></div>
          </td>
          <?php endforeach; ?>
        </tr>
      </table>
    </div>

    <!-- 9b. REPETIBILIDAD -->
    <div style="background:#f0f4fb; border-bottom:1px solid #1a3a6b; border-top:1px solid #1a3a6b; padding:4px 8px; font-weight:bold; font-size:9pt; color:#1a3a6b;">🔹 Ensayo de Repetibilidad</div>
    <div class="cert-section-body">
      <table class="data-table">
        <tr>
          <th>Peso Aplicado (kg)</th><th>Peso Leído (kg)</th><th>Error (kg)</th><th>E.M.P. (± kg)</th><th>Resultado</th>
        </tr>
        <?php foreach($c['repetibilidad'] as $row):
          $err = (float)($row['error'] ?? 0);
          $emp = (float)($row['emp'] ?? 0);
          $ok  = ($emp > 0) ? (abs($err) <= $emp) : null;
        ?>
        <tr>
          <td><?= v($row['peso_aplicado']) ?></td><td><?= v($row['peso_leido']) ?></td><td><?= v($row['error']) ?></td><td>± <?= v($row['emp']) ?></td>
          <td>
            <?php if($ok === true): ?><span style="color:#16a34a;font-weight:bold;">Conforme</span>
            <?php elseif($ok === false): ?><span style="color:#dc2626;font-weight:bold;">No Conforme</span>
            <?php else: ?>—<?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>

    <!-- 9c. LINEALIDAD -->
    <div style="background:#f0f4fb; border-bottom:1px solid #1a3a6b; border-top:1px solid #1a3a6b; padding:4px 8px; font-weight:bold; font-size:9pt; color:#1a3a6b;">🔹 Ensayo de Linealidad</div>
    <div class="cert-section-body">
      <table class="data-table">
        <tr>
          <th>Carga (kg)</th><th>Lectura (kg)</th><th>Error (kg)</th><th>E.M.P. (± kg)</th><th>Resultado</th>
        </tr>
        <?php foreach($c['linealidad'] as $row):
          $err = (float)($row['error'] ?? 0);
          $emp = (float)($row['emp'] ?? 0);
          $ok  = ($emp > 0) ? (abs($err) <= $emp) : null;
        ?>
        <tr>
          <td><?= v($row['carga']) ?></td><td><?= v($row['lectura']) ?></td><td><?= v($row['error']) ?></td><td>± <?= v($row['emp']) ?></td>
          <td>
            <?php if($ok === true): ?><span style="color:#16a34a;font-weight:bold;">Conforme</span>
            <?php elseif($ok === false): ?><span style="color:#dc2626;font-weight:bold;">No Conforme</span>
            <?php else: ?>—<?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>

    <!-- DEFINICIONES -->
    <div style="background:#f0f4fb; border-top:1px solid #1a3a6b; padding:4px 8px; font-weight:bold; font-size:9pt; color:#1a3a6b;">🔹 Definiciones</div>
    <div class="cert-section-body">
      <table style="width:100%; font-size:8pt;">
        <tr>
          <td style="width:33%;"><strong>E:</strong> Error (E = I - Val)</td>
          <td style="width:33%;"><strong>I:</strong> Indicación</td>
          <td style="width:33%;"><strong>E.M.P:</strong> Error Max.</td>
        </tr>
        <tr>
          <td><strong>Ec:</strong> Error corregido</td>
          <td><strong>d:</strong> División escala</td>
          <td><strong>e:</strong> Div. verificación</td>
        </tr>
      </table>
    </div>
  </div>

  <!-- FIRMAS -->
  <table style="width:100%; margin-top:20px; border-collapse: separate; border-spacing: 15px 0;">
    <tr>
      <td style="width:50%;" class="firma-box">
        <div class="firma-title">Responsable Técnico</div>
        <div style="margin-top:20px; font-weight:bold; font-size:10pt;">
          <?= v($c['responsable_tecnico'], '___________________________') ?>
        </div>
        <div style="font-size:8pt; border-top:1px solid #555; padding-top:2px; margin-top:5px;">Nombre y Apellidos</div>
      </td>
      <td style="width:50%;" class="firma-box">
        <div class="firma-title">Firma y Sello</div>
        <div style="margin-top:40px;"></div>
        <div style="font-size:8pt; border-top:1px solid #555; padding-top:2px; margin-top:5px;">Firma / Sello Oficial</div>
      </td>
    </tr>
  </table>

  <div style="text-align:right; font-size:8pt; margin-top:10px; border-top:1px solid #ccc; padding-top:4px;">
    Certificado N° <?= v($c['codigo']) ?> — Página 2 de 2 — <?= fmtDate($c['fecha_emision']) ?>
  </div>
</div>

</body>
</html>
