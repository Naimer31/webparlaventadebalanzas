<?php // views/admin/certif_form.php ?>
<style>
:root{--blue:#1a56db;--blue-dark:#1741b0;--gold:#f59e0b;}
.cf-wrap{max-width:900px;margin:0 auto;padding:2rem 1rem 4rem;}
.cf-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;}
.cf-header h1{font-size:1.5rem;color:var(--blue);}
.cf-back{color:var(--blue);text-decoration:none;font-size:.9rem;display:inline-flex;align-items:center;gap:.4rem;}
.cf-back:hover{text-decoration:underline;}
.cf-card{background:#fff;border-radius:14px;box-shadow:0 2px 14px rgba(0,0,0,.08);margin-bottom:1.5rem;overflow:hidden;}
.cf-card-head{background:var(--blue);color:#fff;padding:.7rem 1.2rem;display:flex;align-items:center;gap:.6rem;font-weight:700;font-size:.95rem;}
.cf-card-head i{font-size:1rem;}
.cf-card-body{padding:1.2rem 1.4rem;}
.cf-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1rem;}
.cf-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.cf-field{display:flex;flex-direction:column;gap:.3rem;}
.cf-field label{font-size:.83rem;font-weight:600;color:#374151;}
.cf-field input,.cf-field textarea,.cf-field select{border:1.5px solid #d1d5eb;border-radius:8px;padding:.5rem .75rem;font-size:.92rem;font-family:inherit;transition:border .2s;}
.cf-field input:focus,.cf-field textarea:focus,.cf-field select:focus{outline:none;border-color:var(--blue);}
.cf-field textarea{resize:vertical;min-height:68px;}
.section-note{font-size:.8rem;color:#6b7280;margin-bottom:.8rem;}
/* Condiciones ambientales */
.cond-table{width:100%;border-collapse:collapse;}
.cond-table th,.cond-table td{padding:.5rem .75rem;text-align:center;border:1px solid #e5e7eb;font-size:.9rem;}
.cond-table th{background:#f3f4f6;font-weight:600;color:#374151;}
.cond-table input{width:80px;border:1.5px solid #d1d5eb;border-radius:6px;padding:.35rem .5rem;text-align:center;font-size:.9rem;}
/* Inspection */
.insp-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:.8rem;}
.insp-card{border:1.5px solid #e5e7eb;border-radius:10px;padding:.75rem;text-align:center;}
.insp-card label{font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:.4rem;}
.insp-card select{width:100%;border:1.5px solid #d1d5eb;border-radius:6px;padding:.35rem;font-size:.85rem;}
/* Measurement tables */
.meas-table{width:100%;border-collapse:collapse;font-size:.9rem;}
.meas-table th,.meas-table td{padding:.5rem .75rem;border:1px solid #e5e7eb;text-align:center;}
.meas-table th{background:#1a56db;color:#fff;font-weight:600;}
.meas-table input{width:90px;border:1.5px solid #d1d5eb;border-radius:6px;padding:.3rem .5rem;text-align:center;}
.btn-add-row{background:#e0f2fe;color:#0369a1;border:none;border-radius:6px;padding:.4rem .9rem;cursor:pointer;font-size:.83rem;font-weight:600;margin-top:.6rem;display:inline-flex;align-items:center;gap:.3rem;}
.btn-add-row:hover{background:#bae6fd;}
.btn-del-row{background:none;border:none;color:#dc2626;cursor:pointer;font-size:.9rem;padding:.2rem .4rem;}
/* Submit */
.cf-submit{display:flex;gap:1rem;justify-content:flex-end;margin-top:2rem;}
.btn-submit{background:var(--blue);color:#fff;padding:.75rem 2rem;border:none;border-radius:10px;font-size:1rem;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:.5rem;transition:background .2s;}
.btn-submit:hover{background:var(--blue-dark);}
.btn-cancel{background:#f3f4f6;color:#374151;padding:.75rem 1.5rem;border:1.5px solid #d1d5eb;border-radius:10px;font-size:1rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:.5rem;}
.btn-cancel:hover{background:#e5e7eb;}
.codigo-badge{background:#fef3c7;color:#92400e;border:1.5px solid #fcd34d;border-radius:8px;padding:.4rem .9rem;font-weight:700;font-size:.95rem;display:inline-block;margin-bottom:1rem;}
@media(max-width:600px){.insp-grid{grid-template-columns:1fr 1fr;}.cf-grid-2{grid-template-columns:1fr;}}
</style>

<div class="cf-wrap">
    <div class="cf-header">
        <h1><i class="fa-solid fa-file-certificate" style="color:var(--gold)"></i> Nuevo Certificado de Calibración</h1>
        <a href="<?= BASE_URL ?>?c=Certificado&a=index" class="cf-back">
            <i class="fa-solid fa-arrow-left"></i> Volver a la lista
        </a>
    </div>

    <?php if (isset($_GET['error'])): ?>
    <div style="background:#fee2e2;color:#991b1b;padding:.8rem 1.2rem;border-radius:8px;margin-bottom:1rem;">
        <i class="fa-solid fa-circle-exclamation"></i> Error al guardar. Verifica que el código no esté duplicado.
    </div>
    <?php endif; ?>

    <div class="codigo-badge">
        <i class="fa-solid fa-hashtag"></i> Código sugerido: <?= htmlspecialchars($codigoSugerido) ?>
    </div>

    <form action="<?= BASE_URL ?>?c=Certificado&a=guardar" method="POST">

        <!-- ── SECCIÓN 1 & 2: Solicitante ─────────────────────── -->
        <div class="cf-card">
            <div class="cf-card-head"><i class="fa-solid fa-user"></i> 1 & 2. Solicitante</div>
            <div class="cf-card-body">
                <div class="cf-grid">
                    <div class="cf-field" style="grid-column:1/-1">
                        <label>Código del Certificado *</label>
                        <input type="text" name="codigo" value="<?= htmlspecialchars($codigoSugerido) ?>" required>
                    </div>
                    <div class="cf-field">
                        <label>Nombre del Solicitante</label>
                        <input type="text" name="solicitante_nombre" placeholder="Ej: Juan Pérez García">
                    </div>
                    <div class="cf-field">
                        <label>Dirección</label>
                        <input type="text" name="solicitante_direccion" placeholder="Ej: Jr. Lima 123, Huánuco">
                    </div>
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN 3: Datos del Instrumento ───────────────── -->
        <div class="cf-card">
            <div class="cf-card-head"><i class="fa-solid fa-weight-scale"></i> 3. Datos del Instrumento</div>
            <div class="cf-card-body">
                <div class="cf-grid">
                    <div class="cf-field">
                        <label>Tipo de instrumento</label>
                        <input type="text" name="tipo_instrumento" value="Balanza electrónica de piso">
                    </div>
                    <div class="cf-field">
                        <label>Funcionamiento</label>
                        <input type="text" name="funcionamiento" value="No automático">
                    </div>
                    <div class="cf-field">
                        <label>Capacidad máxima (Kg)</label>
                        <input type="text" name="capacidad_max" placeholder="Ej: 150">
                    </div>
                    <div class="cf-field">
                        <label>División de escala (d) Kg</label>
                        <input type="text" name="division_escala" placeholder="Ej: 0.05">
                    </div>
                    <div class="cf-field">
                        <label>División de verificación (e) Kg</label>
                        <input type="text" name="division_verificacion" placeholder="Ej: 0.05">
                    </div>
                    <div class="cf-field">
                        <label>Clase de exactitud</label>
                        <select name="clase_exactitud">
                            <option value="III" selected>III</option>
                            <option value="II">II</option>
                            <option value="I">I</option>
                            <option value="IIII">IIII</option>
                        </select>
                    </div>
                    <div class="cf-field">
                        <label>Marca</label>
                        <input type="text" name="marca" placeholder="Ej: e-Accura">
                    </div>
                    <div class="cf-field">
                        <label>Modelo</label>
                        <input type="text" name="modelo" placeholder="Ej: PA3">
                    </div>
                    <div class="cf-field">
                        <label>Tipo</label>
                        <input type="text" name="tipo_electronico" value="Electrónico">
                    </div>
                    <div class="cf-field">
                        <label>Procedencia</label>
                        <input type="text" name="procedencia" placeholder="Ej: China">
                    </div>
                    <div class="cf-field">
                        <label>N° de Serie</label>
                        <input type="text" name="nro_serie" placeholder="Ej: SN-20240123">
                    </div>
                    <div class="cf-field">
                        <label>Código de identificación</label>
                        <input type="text" name="codigo_identificacion" placeholder="Ej: EQ-001">
                    </div>
                    <div class="cf-field">
                        <label>Ubicación del instrumento</label>
                        <input type="text" name="ubicacion" placeholder="Ej: Mercado Central, Puesto 12">
                    </div>
                    <div class="cf-field">
                        <label>Lugar de calibración</label>
                        <input type="text" name="lugar_calibracion" placeholder="Ej: Taller Casa de la Balanza">
                    </div>
                    <div class="cf-field">
                        <label>Fecha de calibración</label>
                        <input type="date" name="fecha_calibracion" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="cf-field">
                        <label>Fecha de emisión</label>
                        <input type="date" name="fecha_emision" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN 4: Condiciones Ambientales ─────────────── -->
        <div class="cf-card">
            <div class="cf-card-head"><i class="fa-solid fa-temperature-half"></i> 4. Condiciones Ambientales</div>
            <div class="cf-card-body">
                <table class="cond-table">
                    <thead><tr><th>Parámetro</th><th>Inicio</th><th>Final</th></tr></thead>
                    <tbody>
                        <tr>
                            <td><strong>Temperatura (°C)</strong></td>
                            <td><input type="number" name="temp_inicio" step="0.1" placeholder="22.0"></td>
                            <td><input type="number" name="temp_final"  step="0.1" placeholder="23.0"></td>
                        </tr>
                        <tr>
                            <td><strong>Humedad (%)</strong></td>
                            <td><input type="number" name="humedad_inicio" step="0.1" placeholder="55.0"></td>
                            <td><input type="number" name="humedad_final"  step="0.1" placeholder="57.0"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ── SECCIÓN 5: Trazabilidad ────────────────────────── -->
        <div class="cf-card">
            <div class="cf-card-head"><i class="fa-solid fa-link"></i> 5. Trazabilidad</div>
            <div class="cf-card-body">
                <div class="cf-field">
                    <label>Pesas patrón / Certificados</label>
                    <textarea name="trazabilidad" placeholder="Ej: Pesas patrón clase M1 certificadas por INACAL. Certificado N° 12345-2024"></textarea>
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN 7 & 8: Observaciones y Próxima ─────────── -->
        <div class="cf-card">
            <div class="cf-card-head"><i class="fa-solid fa-notes-medical"></i> 7 & 8. Observaciones y Próxima Calibración</div>
            <div class="cf-card-body">
                <div class="cf-grid-2">
                    <div class="cf-field">
                        <label>Observaciones</label>
                        <textarea name="observaciones" placeholder="Ej: El equipo se encontró en buenas condiciones operativas..."></textarea>
                    </div>
                    <div class="cf-field">
                        <label>Fecha próxima calibración</label>
                        <input type="date" name="proxima_calibracion" value="<?= date('Y-m-d', strtotime('+1 year')) ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN 9a: Inspección Visual ──────────────────── -->
        <div class="cf-card">
            <div class="cf-card-head"><i class="fa-solid fa-eye"></i> 9a. Inspección Visual</div>
            <div class="cf-card-body">
                <div class="insp-grid">
                    <?php foreach(['display'=>'Display','teclado'=>'Teclado','cables'=>'Cables','estructura'=>'Estructura'] as $key=>$label): ?>
                    <div class="insp-card">
                        <label><?= $label ?></label>
                        <select name="insp_<?= $key ?>">
                            <option value="Bueno" selected>✅ Bueno</option>
                            <option value="Regular">⚠️ Regular</option>
                            <option value="Malo">❌ Malo</option>
                        </select>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- ── SECCIÓN 9b: Repetibilidad ──────────────────────── -->
        <div class="cf-card">
            <div class="cf-card-head"><i class="fa-solid fa-rotate"></i> 9b. Ensayo de Repetibilidad</div>
            <div class="cf-card-body">
                <p class="section-note">Ingresa las lecturas repetidas a un mismo peso para evaluar la consistencia del equipo.</p>
                <table class="meas-table" id="rep-table">
                    <thead><tr>
                        <th>Peso Aplicado (kg)</th>
                        <th>Peso Leído (kg)</th>
                        <th>Error</th>
                        <th>E.M.P. (± kg)</th>
                        <th></th>
                    </tr></thead>
                    <tbody id="rep-body">
                        <?php for($i=0;$i<3;$i++): ?>
                        <tr>
                            <td><input type="text" name="rep_peso_aplicado[]" placeholder="0.00"></td>
                            <td><input type="text" name="rep_peso_leido[]"    placeholder="0.00"></td>
                            <td><input type="text" name="rep_error[]"          placeholder="0.00"></td>
                            <td><input type="text" name="rep_emp[]"            placeholder="0.05"></td>
                            <td><button type="button" class="btn-del-row" onclick="delRow(this)"><i class="fa-solid fa-trash-can"></i></button></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                <button type="button" class="btn-add-row" onclick="addRow('rep-body','rep')">
                    <i class="fa-solid fa-plus"></i> Agregar fila
                </button>
            </div>
        </div>

        <!-- ── SECCIÓN 9c: Linealidad ──────────────────────────── -->
        <div class="cf-card">
            <div class="cf-card-head"><i class="fa-solid fa-chart-line"></i> 9c. Ensayo de Linealidad</div>
            <div class="cf-card-body">
                <p class="section-note">Aplica cargas desde mínima hasta capacidad máxima (recomendado: 20%, 40%, 60%, 80%, 100%).</p>
                <table class="meas-table" id="lin-table">
                    <thead><tr>
                        <th>Carga (kg)</th>
                        <th>Lectura (kg)</th>
                        <th>Error</th>
                        <th>E.M.P. (± kg)</th>
                        <th></th>
                    </tr></thead>
                    <tbody id="lin-body">
                        <?php for($i=0;$i<5;$i++): ?>
                        <tr>
                            <td><input type="text" name="lin_carga[]"   placeholder="0.00"></td>
                            <td><input type="text" name="lin_lectura[]" placeholder="0.00"></td>
                            <td><input type="text" name="lin_error[]"   placeholder="0.00"></td>
                            <td><input type="text" name="lin_emp[]"     placeholder="0.05"></td>
                            <td><button type="button" class="btn-del-row" onclick="delRow(this)"><i class="fa-solid fa-trash-can"></i></button></td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                <button type="button" class="btn-add-row" onclick="addRow('lin-body','lin')">
                    <i class="fa-solid fa-plus"></i> Agregar fila
                </button>
            </div>
        </div>

        <!-- ── FIRMA ───────────────────────────────────────────── -->
        <div class="cf-card">
            <div class="cf-card-head"><i class="fa-solid fa-signature"></i> Responsable Técnico</div>
            <div class="cf-card-body">
                <div class="cf-field" style="max-width:400px">
                    <label>Nombre del responsable técnico</label>
                    <input type="text" name="responsable_tecnico" placeholder="Ej: Ing. Carlos Mendoza">
                </div>
            </div>
        </div>

        <div class="cf-submit">
            <a href="<?= BASE_URL ?>?c=Certificado&a=index" class="btn-cancel">
                <i class="fa-solid fa-xmark"></i> Cancelar
            </a>
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-file-circle-check"></i> Generar Certificado
            </button>
        </div>

    </form>
</div>

<script>
function addRow(tbodyId, prefix) {
    const tbody = document.getElementById(tbodyId);
    const tr = document.createElement('tr');
    if (prefix === 'rep') {
        tr.innerHTML = `
            <td><input type="text" name="rep_peso_aplicado[]" placeholder="0.00"></td>
            <td><input type="text" name="rep_peso_leido[]"    placeholder="0.00"></td>
            <td><input type="text" name="rep_error[]"          placeholder="0.00"></td>
            <td><input type="text" name="rep_emp[]"            placeholder="0.05"></td>
            <td><button type="button" class="btn-del-row" onclick="delRow(this)"><i class="fa-solid fa-trash-can"></i></button></td>`;
    } else {
        tr.innerHTML = `
            <td><input type="text" name="lin_carga[]"   placeholder="0.00"></td>
            <td><input type="text" name="lin_lectura[]" placeholder="0.00"></td>
            <td><input type="text" name="lin_error[]"   placeholder="0.00"></td>
            <td><input type="text" name="lin_emp[]"     placeholder="0.05"></td>
            <td><button type="button" class="btn-del-row" onclick="delRow(this)"><i class="fa-solid fa-trash-can"></i></button></td>`;
    }
    tbody.appendChild(tr);
}
function delRow(btn) {
    const row = btn.closest('tr');
    const tbody = row.parentElement;
    if (tbody.rows.length > 1) row.remove();
}
</script>
