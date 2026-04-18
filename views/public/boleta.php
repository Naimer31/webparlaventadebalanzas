<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            background: #fdfdfd;
            margin: 0;
            padding: 20px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            background: #fff;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 28px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .btn-print {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background: #3182ce;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        @media print {
            .btn-print {
                display: none;
            }
            .invoice-box {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="btn-print">Imprimir / Guardar PDF</button>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                <!-- Logo text instead of image for safety -->
                                <h2 style="margin:0; color:#2b6cb0;">Casa de La Balanza</h2>
                            </td>
                            
                            <td style="text-align: right;">
                                <strong>Boleta Electrónica</strong><br>
                                Nro: #<?= str_pad($venta['id'], 6, '0', STR_PAD_LEFT) ?><br>
                                Fecha: <?= date('d/m/Y', strtotime($venta['fecha'])) ?><br>
                                Hora: <?= date('H:i', strtotime($venta['fecha'])) ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                <strong>Empresa:</strong><br>
                                Tienda de Balanzas EIRL<br>
                                Av. Los Pinos 123, Ciudad<br>
                                RUC: 20123456789
                            </td>
                            
                            <td style="text-align: right;">
                                <strong>Cliente:</strong><br>
                                <?= htmlspecialchars($venta['cliente_nombre']) ?><br>
                                <?= htmlspecialchars($venta['cliente_correo']) ?><br>
                                Estado: <?= $venta['estado'] ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>Producto</td>
                <td style="text-align: center;">Cant.</td>
                <td style="text-align: right;">P. Unit.</td>
                <td style="text-align: right;">Subtotal</td>
            </tr>
            
            <?php foreach($venta['detalles'] as $index => $item): ?>
            <tr class="item <?= ($index === count($venta['detalles']) - 1) ? 'last' : '' ?>">
                <td><?= htmlspecialchars($item['nombre']) ?> <?= htmlspecialchars($item['marca']) ?></td>
                <td style="text-align: center;"><?= $item['cantidad'] ?></td>
                <td style="text-align: right;"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : '$' ?><?= number_format($item['precio'], 2) ?></td>
                <td style="text-align: right;"><?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : '$' ?><?= number_format($item['precio'] * $item['cantidad'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
            
            <tr class="total">
                <td colspan="3" style="text-align: right;">Total Pagar:</td>
                <td style="text-align: right;">
                   <?= defined('CURRENCY_SYMBOL') ? CURRENCY_SYMBOL : '$' ?><?= number_format($venta['total'], 2) ?>
                </td>
            </tr>
        </table>
        
        <div style="text-align: center; margin-top: 40px; color: #718096; font-size: 0.9em;">
            <p>Gracias por su compra. Esta es una representación impresa de la Boleta de Venta Electrónica.</p>
        </div>
    </div>
</body>
</html>
