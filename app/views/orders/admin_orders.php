<?php require_once __DIR__ . '/../includes/restrict.php'; ?>
<?php require_once __DIR__ . '/../includes/head.php'; ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/static/css/admin_page/admin_orders.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/admin_header.php'; ?>

<div class="main-content">
    <div class="admin-orders-container">
        <h1>Listado de Pedidos</h1>

        <div class="dataTables_filter">
    <div class="search-container">
        <i class="fas fa-search"></i>
        <input type="text" class="search-box" placeholder="Buscar..." aria-label="Buscar">
    </div>
    <div class="filter-container">
        <label for="status-filter">Filtrar por estado:</label>
        <select id="status-filter" onchange="filterByStatus()">
            <option value="Todos">Todos</option>
            <option value="Pendiente">Pendiente</option>
            <option value="Pronto">Pronto</option>
            <option value="Finalizado">Finalizado</option>
            <option value="Cancelado">Cancelado</option>
        </select>
    </div>
</div>


        <!-- Tabla de Pedidos -->
        <div class="orders-table-wrapper">
            <table id="orders-table" class="orders-table display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Teléfono</th>
                        <th>Estado</th>
                        <th>Fecha de Creación</th>
                        <th>Cambiar Estado</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="order-row" data-status="<?= htmlspecialchars($order['status']) ?>">
                            <td data-label="ID"><?= htmlspecialchars($order['id']) ?></td>
                            <td data-label="Usuario"><?= htmlspecialchars($order['name'] . ' ' . $order['lastname']) ?></td>
                            <td data-label="Teléfono"><?= htmlspecialchars($order['phone'] ?? 'No disponible') ?></td>
                            <td data-label="Estado"><?= htmlspecialchars($order['status']) ?></td>
                            <td data-label="Fecha de Creación"><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                            <td data-label="Cambiar Estado">
                                <form action="/orders/changeStatus/<?= $order['id'] ?>" method="POST">
                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                        <option value="Pendiente" <?= $order['status'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                        <option value="Pronto" <?= $order['status'] == 'Pronto' ? 'selected' : '' ?>>Pronto</option>
                                        <option value="Finalizado" <?= $order['status'] == 'Finalizado' ? 'selected' : '' ?>>Finalizado</option>
                                        <option value="Cancelado" <?= $order['status'] == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                    </select>
                                </form>
                            </td>
                            <td data-label="Detalles">
                                <a href="/orders/showDetails/<?= $order['id'] ?>" class="eye-icon">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <?php
            $visiblePages = 3;
            $startPage = max(1, $currentPage - floor($visiblePages / 2));
            $endPage = min($totalPages, $startPage + $visiblePages - 1);
            $startPage = max(1, $endPage - $visiblePages + 1);
            ?>
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?= $currentPage - 1 ?>" class="page-link">Anterior</a>
            <?php endif; ?>
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?page=<?= $i ?>" class="page-link <?= $i == $currentPage ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?= $currentPage + 1 ?>" class="page-link">Siguiente</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="loading-overlay">
    <div id="loading-spinner"></div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        const table = $('#orders-table').DataTable({
            responsive: true,
            autoWidth: false,
            paging: false,
            lengthChange: false,
            ordering: true,
            info: true,
            order: [[0, 'desc']],
            columnDefs: [
                { targets: '_all', className: 'dt-center' }
            ],
            language: {
                info: "Mostrando _START_ a _END_ de _TOTAL_ órdenes",
                infoEmpty: "No se encontraron órdenes",
                zeroRecords: "No se encontraron resultados",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            },
            dom: 'lrtip', // Desactiva el buscador integrado de DataTables
            initComplete: function () {
                // Buscador personalizado
                $('.search-box').on('keyup', function () {
                    table.search(this.value).draw();
                });
            }
        });

        $(window).on('resize', function () {
            table.columns.adjust();
        });
    });
</script>

</body>
</html>
