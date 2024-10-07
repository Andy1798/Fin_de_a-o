<?php require_once __DIR__ . '/../includes/restrict.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/admin_page/list_product.css">
    <title><?= $title ?></title>
</head>

<body>
    <h1><?= $title ?></h1>
    <a href="/product/create" class="btn btn-add">Agregar nuevo producto</a><br><br>
    <a href="/category/create" class="btn btn-add">Agregar Nueva Categoria</a><br><br>
    <a href="/brand/create" class="btn btn-add">Agregar Nueva Marca</a><br><br>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Marca</th>
                <th>Modelo</th> <!-- Columna "Modelo" agregada -->
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Imagen</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['category'] ?></td>
                        <td><?= $product['brand'] ?></td>
                        <td><?= $product['model'] ?></td> <!-- Mostrar modelo -->
                        <td><?= $product['price'] ?></td>
                        <td><?= $product['quantity'] ?></td>
                        <td><img src="<?= $product['image'] ?>" alt="Imagen de <?= $product['name'] ?>" width="50"></td>
                        <td><?= $product['description'] ?></td>
                        <td>
                            <a href="/product/edit/<?= $product['id'] ?>" class="btn btn-edit">Editar</a> |
                            <form action="/product/delete/<?= $product['id'] ?>" method="POST">
                                <button type="submit" class="btn btn-delete">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No hay productos registrados.</td> <!-- Ajustar el colspan -->
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>