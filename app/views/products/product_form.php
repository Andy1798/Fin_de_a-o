<?php require_once __DIR__ . '/../includes/restrict.php'; ?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/static/css/admin_page/product_form.css">
</head>

<body>
    <h1><?= $title ?></h1>
    <form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" value="<?= isset($product['name']) ? $product['name'] : '' ?>" required><br><br>

        <!-- Lista desplegable para Categorías -->
        <label for="category">Categoría:</label>
        <select name="category" id="category" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= isset($product['category']) && $product['category'] == $category['id'] ? 'selected' : '' ?>>
                    <?= $category['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <!-- Lista desplegable para Marcas -->
        <label for="brand">Marca:</label>
        <select name="brand" id="brand" required>
            <option value="">Seleccione una marca</option>
            <?php foreach ($brands as $brand): ?>
                <option value="<?= $brand['id'] ?>" <?= isset($product['brand']) && $product['brand'] == $brand['id'] ? 'selected' : '' ?>>
                    <?= $brand['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <!-- Campo para Modelo -->
        <label for="model">Modelo:</label>
        <input type="text" name="model" id="model" value="<?= isset($product['model']) ? $product['model'] : '' ?>" required><br><br>

        <label for="price">Precio:</label>
        <input type="number" name="price" id="price" value="<?= isset($product['price']) ? $product['price'] : '' ?>" step="0.01" required><br><br>

        <label for="quantity">Cantidad:</label>
        <input type="number" name="quantity" id="quantity" value="<?= isset($product['quantity']) ? $product['quantity'] : '' ?>" required><br><br>

        <label for="image">Imagen:</label>
        <input type="file" name="image" id="image" accept="image/*" onchange="previewImage();"><br><br>
        <div id="preview-container" style="margin-bottom: 20px;">
            <img id="preview" style="width: 100%; max-width: 500px; display: none;">
        </div>

        <label for="description">Descripción:</label>
        <textarea name="description" id="description" required><?= isset($product['description']) ? $product['description'] : '' ?></textarea><br><br>

        <button type="submit">Guardar</button>
    </form>
    <script src="/static/js/crear-p.js"></script>
</body>

</html>
