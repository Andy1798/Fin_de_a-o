<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/user_page/order_details.css">
</head>
<body>
<?php if ($userInfo['role'] === 'admin'): ?>
    <?php require_once __DIR__ . '/../includes/admin_header.php'; ?>
<?php else: ?>
    <?php require_once __DIR__ . '/../includes/header.php'; ?>



    
<?php endif; ?>
<div class="main-content">
<h2>Detalles de la Orden #<?= htmlspecialchars($orderId) ?></h2>

<?php if (!empty($orderDetails)): ?>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total = 0;
            foreach ($orderDetails as $item): 
                $total += (float)$item['subtotal'];
            ?>
                <tr>
                <td data-label="Producto"><?= htmlspecialchars($item['product_name']) ?></td>
                    <td data-label="Cantidad"><?= $item['quantity'] ?></td>
                    <td data-label="Precio Unitario">$<?= number_format((float)$item['price'], 2) ?></td>
                    <td data-label="Subtotal">$<?= number_format((float)$item['subtotal'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
    <tr>
        <td colspan="3"><strong>Total</strong></td>
        <td><strong>$<?= number_format($total, 2) ?></strong></td>
    </tr>
</tfoot>

    </table>
<?php else: ?>
    <p>No se encontraron detalles para esta orden.</p>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/foot.php'; ?>

<?php if ($userInfo['role'] === 'admin'): ?>
    <div class="back-button-container">
        <a href="/admin" class="back-button">Volver a Órdenes</a>
    </div>
    <div class="back-button-container">
        <a href="/earnings" class="back-button">Volver a Ganancias</a>
    </div>
<?php else: ?>
    <div class="back-button-container">
        <a href="/user/orders" class="back-button">Volver a Órdenes</a>
    </div>
    </div>
    <?php require_once __DIR__ . '/../includes/foot.php'; ?>

    <?php require_once __DIR__ . '/../includes/footer.php'; ?>

<?php endif; ?>

</body>
</html>
