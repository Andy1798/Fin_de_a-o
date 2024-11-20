<?php require_once __DIR__ . '/../includes/restrict.php'; ?>
<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/admin_page/earnings.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/admin_header.php'; ?>

<div class="main-content">
    <div class="earnings-container">
        <h1>Reporte de Ganancias</h1>

        <div class="filter-container">
            <form method="POST" action="/earnings/filter" id="dateFilterForm">
                <label for="date_range">Rango de Fechas:</label>
                <input type="text" id="date_range" name="date_range" placeholder="Selecciona el rango de fechas" readonly>
                <button type="submit" class="btn-filter">Buscar</button>
            </form>

            <form method="GET" action="/earnings">
                <button type="submit" class="btn-filter todas">Todas</button>
            </form>
        </div>

        <?php if (empty($completedOrders)): ?>
            <div class="no-orders">
                <p>No se encontraron pedidos realizados en la fecha seleccionada.</p>
            </div>
        <?php else: ?>
            <table class="earnings-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Total (UYU)</th>
                        <th>Fecha de Creación</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($completedOrders as $order): ?>
                        <tr>
                            <td data-label="Usuario"><?= htmlspecialchars($order['name'] . ' ' . $order['lastname']) ?></td>
                            <td data-label="Total (UYU)"><?= htmlspecialchars($order['total'] ?? '0') ?> UYU</td>
                            <td data-label="Fecha de Creación"><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                            <td data-label="Detalles">
                                <a href="/orders/showDetails/<?= $order['id'] ?>" class="eye-icon">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="grand-total">
                <h2>Total de Ganancias: <?= number_format($grandTotal, 2) ?> UYU</h2>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Overlay de carga -->
<div id="loading-overlay">
    <div id="loading-spinner"></div>
</div>

<?php require_once __DIR__ . '/../includes/foot.php'; ?>

<script src="/static/js/admin_page/earnings.js"></script>

</body>

</html>
