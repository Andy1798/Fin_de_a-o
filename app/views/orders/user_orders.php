<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/user_page/user_orders.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div id="loading-overlay">
    <div id="loading-spinner"></div>
</div>

<div class="admin-orders-container">
    <h1>Mis Pedidos</h1>

    <!-- Filter Container with Dropdown -->
    <div class="filter-container">
        <label for="status-filter">Filtrar por Estado:</label>
        <select id="status-filter" onchange="filterByStatus()">
            <option value="Todos">Todos</option>
            <option value="Pendiente">Pendiente</option>
            <option value="Pronto">Pronto</option>
            <option value="Finalizado">Finalizado</option>
            <option value="Cancelado">Cancelado</option>
        </select>
    </div>

    <table id="orders-table" class="orders-table">
        <thead>
            <tr>
                <th class="th-order">ID</th>
                <th>Estado</th>
                <th>Fecha de Creación</th>
                <th class="th-order2">Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr class="order-row" data-status="<?= htmlspecialchars($order['status']) ?>">
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td><?= date('d/m/Y', strtotime($order['created_at'])) ?></td>
                        <td>
                            <a href="/orders/showDetails/<?= $order['id'] ?>" class="eye-icon">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No tienes pedidos aún.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- Controles de Paginación -->
    <div class="pagination">
        <?php
        $visiblePages = 3; // Máximo de páginas visibles
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

<?php require_once __DIR__ . '/../includes/foot.php'; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

<script>
    function filterByStatus() {
        const filter = document.getElementById("status-filter").value;
        const rows = document.querySelectorAll(".order-row");

        rows.forEach(row => {
            const status = row.getAttribute("data-status");
            row.style.display = (filter === "Todos" || status === filter) ? "" : "none";
        });
    }

    $(document).ready(function () {
        const table = $('#orders-table').DataTable({
            paging: false,
            lengthChange: false,
            ordering: true,  // Habilita el ordenamiento
            info: true,
            searching: false,
            order: [[0, 'desc']],  // Orden descendente inicial en la columna 0 (ID)
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
        });

        $('#orders-table th.sorting').removeClass('sorting_desc').addClass('sorting_disabled');
    });


    // Loading overlay display
    const loadingOverlay = document.getElementById('loading-overlay');

    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', () => {
            loadingOverlay.style.display = 'flex';
        });
    });

    const sidebarLinks = document.querySelectorAll('.sidebar a[href]');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function () {
            loadingOverlay.style.display = 'flex';
        });
    });
</script>


</body>

</html>