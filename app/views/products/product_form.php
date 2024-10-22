<?php require_once __DIR__ . '/../includes/restrict.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/static/css/admin_page/product_form.css">
</head>

<body>
    <div class="form-container">
        <a href="/product" class="back-arrow">
            <i class="fas fa-long-arrow-alt-left"></i> Volver
        </a>
        <h1><?= $title ?></h1>
        <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
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

            <!-- Lista desplegable para Marcas -->
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

            <!-- Campo para Modelo -->
            <div class="form-group">
                <label for="model">Modelo</label>
                <input type="text" name="model" id="model" value="<?= isset($product['model']) ? $product['model'] : '' ?>" required>
            </div>

            <!-- Campo para Precio -->
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" name="price" id="price" value="<?= isset($product['price']) ? $product['price'] : '' ?>" step="0.01" required>
            </div>

            <!-- Campo para Cantidad -->
            <div class="form-group">
                <label for="quantity">Cantidad</label>
                <input type="number" name="quantity" id="quantity" value="<?= isset($product['quantity']) ? $product['quantity'] : '' ?>" required>
            </div>

            <!-- Campo de Imagen con previsualización -->
            <div class="form-group">
                <label for="image">Imagen</label>
                <input type="file" name="image" id="image" accept="image/*" onchange="previewImage();" required>
                <div id="preview-container">
                    <img id="preview" style="display:none;" alt="Vista previa de la imagen">
                </div>
            </div>

            <!-- Campo para Descripción -->
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" required><?= isset($product['description']) ? $product['description'] : '' ?></textarea>
            </div>

            <!-- Botón de Guardar -->
            <button type="submit" class="submit-btn"><i class="fas fa-save"></i> Guardar Producto</button>
        </form>
    </div>

    <script src="/static/js/admin_page/product_create.js"></script>
</body>

</html>
