<?php require_once __DIR__ . '/../includes/restrict.php'; ?>
<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/admin_page/list_product.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/admin_header.php'; ?>

<!-- Main Content Area -->
<div class="main-content">
    <h1><?= $title ?></h1>

    <!-- Contenedor de Acciones (Buscador y Opciones) -->
    <div class="actions-container">
        <!-- Search box -->
        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" id="searchBox" class="search-box" placeholder="Buscar productos...">
        </div>

        <!-- Botones de Opciones -->
        <div class="options">
            <a href="/product/create" class="option-btn">
                <i class="fas fa-box-open"></i> Agregar Producto
            </a>
            <a href="/category/create" class="option-btn">
                <i class="fas fa-tags"></i> Agregar Categoría
            </a>
            <a href="/brand/create" class="option-btn">
                <i class="fas fa-industry"></i> Agregar Marca
            </a>
        </div>
    </div>
    <table class="product-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Imagen</th>
                <th>Descripción</th>
                <th>Despublicar/Publicar</th>
                <th>Destacar</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="productTableBody">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($product['id']) ?></td>
                        <td data-label="Nombre"><?= htmlspecialchars($product['name']) ?></td>
                        <td data-label="Categoría"><?= htmlspecialchars($product['category_name']) ?></td>
                        <td data-label="Marca"><?= htmlspecialchars($product['brand_name']) ?></td>
                        <td data-label="Modelo"><?= htmlspecialchars($product['model']) ?></td>
                        <td data-label="Precio"><?= htmlspecialchars($product['price']) ?></td>
                        <td data-label="Cantidad"><?= htmlspecialchars($product['quantity']) ?></td>
                        <td data-label="Imagen">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Imagen de <?= htmlspecialchars($product['name']) ?>" width="50">
                        </td>
                        <td data-label="Descripción"><?= htmlspecialchars($product['description']) ?></td>

                        <td data-label="Publicar">
                            <label class="switch">
                                <input type="checkbox" class="toggle-published" data-id="<?= $product['id'] ?>" <?= $product['published'] == 1 ? 'checked' : '' ?>>
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td data-label="Destacar">
                            <label class="switch">
                                <input type="checkbox" class="toggle-featured" data-id="<?= $product['id'] ?>" data-published="<?= $product['published'] ?>" <?= $product['featured'] == 1 ? 'checked' : '' ?>>
                                <span class="slider round"></span>
                            </label>
                        </td>

                        <td data-label="Acciones">
                            <div class="actions">
                                <a href="/product/edit/<?= $product['id'] ?>" class="btn btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="/product/delete/<?= $product['id'] ?>" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                    <button type="submit" class="btn btn-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12">No hay productos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- Paginación -->
    <div class="pagination">
    <?php
    // Determinar el rango de páginas a mostrar
    $visiblePages = 3; // Número máximo de páginas visibles
    $startPage = max(1, $currentPage - floor($visiblePages / 2));
    $endPage = min($totalPages, $startPage + $visiblePages - 1);

    // Ajustar el rango si estamos cerca del final
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

<!-- Overlay de carga -->
<div id="loading-overlay">
    <div id="loading-spinner"></div>
</div>

<script src="/static/js/admin_page/list_product.js"></script>
<?php require_once __DIR__ . '/../includes/foot.php'; ?>

</body>

</html>
