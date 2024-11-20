
<?php require_once __DIR__ . '/../includes/restrict.php'; ?>
<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/admin_page/product_form.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/admin_header.php'; ?>

<div class="main-content">
<div class="admin-layout">
    <!-- Overlay de carga -->
    <div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>

    <div class="form-container">
        <a href="/product" class="back-arrow">
            <i class="fas fa-long-arrow-alt-left"></i> Volver
        </a>
        
        <h1><?= $title ?></h1>
        <form action="<?= $action ?>" method="POST" enctype="multipart/form-data" id="productForm">
            <!-- Campo de Nombre -->
            <div class="form-group">
                <label for="name">Nombre del Producto</label>
                <input type="text" name="name" id="name" value="<?= isset($product['name']) ? $product['name'] : '' ?>" required>
            </div>

            <!-- Lista desplegable para Categorías -->
            <div class="form-group">
                <label for="category">Categoría</label>
                <select name="category" id="category" required>
                    <option value="">Seleccione una categoría</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= isset($product['category']) && $product['category'] == $category['id'] ? 'selected' : '' ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Otros campos del formulario -->
            <div class="form-group">
                <label for="brand">Marca</label>
                <select name="brand" id="brand" required>
                    <option value="">Seleccione una marca</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>" <?= isset($product['brand']) && $product['brand'] == $brand['id'] ? 'selected' : '' ?>>
                            <?= $brand['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="model">Modelo</label>
                <input type="text" name="model" id="model" value="<?= isset($product['model']) ? $product['model'] : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" name="price" id="price" value="<?= isset($product['price']) ? $product['price'] : '' ?>" step="0.01" min="1" required>
            </div>

            <div class="form-group">
                <label for="quantity">Cantidad</label>
                <input type="number" name="quantity" id="quantity" value="<?= isset($product['quantity']) ? $product['quantity'] : '' ?>" min="1" required>
            </div>

            <div class="form-group">
                <label for="image">Imagen</label>
                <input type="file" name="image" id="image" accept="image/*" onchange="previewImage();">
                <div id="preview-container">
                    <?php if (isset($product['image']) && !empty($product['image'])): ?>
                        <img id="preview" src="/<?= $product['image'] ?>" alt="Vista previa de la imagen actual">
                    <?php else: ?>
                        <img id="preview" style="display:none;" alt="Vista previa de la imagen">
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" required><?= isset($product['description']) ? $product['description'] : '' ?></textarea>
            </div>

            <button type="submit" class="submit-btn"><i class="fas fa-save"></i> Guardar Producto</button>
        </form>
    </div>
    </div>
    </div>
    <script src="/static/js/admin_page/product_form.js"></script>

</body>

</html>
