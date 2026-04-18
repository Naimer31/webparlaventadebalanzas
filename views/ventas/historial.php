<h2>Historial de Mis Compras</h2>

<table class="table">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Certificado</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($misVentas as $venta): ?>
        <tr>
            <td><?php echo $venta['fecha']; ?></td>
            <td><?php echo $venta['producto_nombre']; ?></td>
            <td>S/ <?php echo number_format($venta['total'], 2); ?></td>
            <td>
                <span class="badge"><?php echo $venta['estado']; ?></span>
            </td>
            <td>
                <?php if ($venta['estado'] == 'Pagado' || $venta['estado'] == 'Entregado'): ?>
                    <a href="index.php?c=Certificado&a=descargar&id=<?php echo $venta['detalle_id']; ?>" 
                    class="btn-print" 
                    target="_blank">
                        <i class="fas fa-file-pdf"></i> Imprimir Certificado
                    </a>
                <?php else: ?>
                    <small>Disponible al pagar</small>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<style>
    .btn-print {
        background-color: #27ae60;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 0.9em;
    }
    .btn-print:hover {
        background-color: #219150;
    }
</style>