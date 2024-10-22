<?php require_once __DIR__ . '/../includes/restrict.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/admin_page/list_product.css">
    <link rel="stylesheet" href="/static/css/admin_page/admin_header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?= $title ?></title>
</head>

<body>
    <!-- Top Navigation Bar -->
    <div class="top-nav">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="user-info">
            <span><?php echo $_SESSION["userLogged"]["name"] . " " . $_SESSION["userLogged"]["lastname"]; ?></span>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <ul class="menu">
            <li><a href="/product"><i class="fas fa-box"></i> <span>PRODUCTO</span></a></li>
            <li><a href="/admin/homecontrol"><i class="fas fa-user-shield"></i> <span>HOME CONTROL</span></a></li>
            <li><a href="/catalog"><i class="fas fa-users-cog"></i> <span>CATALOGO</span></a></li>
            <li><a href="/order"><i class="fas fa-calendar-check"></i> <span>VER PEDIDOS</span></a></li>
            <li><a href=""><i class="fas fa-calendar-check"></i> <span>VER RESERVAS</span></a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1><?= $title ?></h1>

        <!-- Search box -->
        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" id="searchBox" class="search-box" placeholder="Buscar productos...">
        </div>

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

        <table>
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
                            <td data-label="ID"><?= $product['id'] ?></td>
                            <td data-label="Nombre"><?= $product['name'] ?></td>
                            <td data-label="Categoría"><?= $product['category'] ?></td>
                            <td data-label="Marca"><?= $product['brand'] ?></td>
                            <td data-label="Modelo"><?= $product['model'] ?></td>
                            <td data-label="Precio"><?= $product['price'] ?></td>
                            <td data-label="Cantidad"><?= $product['quantity'] ?></td>
                            <td data-label="Imagen"><img src="<?= $product['image'] ?>" alt="Imagen de <?= $product['name'] ?>"
                                    width="50"></td>
                            <td data-label="Descripción"><?= $product['description'] ?></td>

                            <td data-label="Publicar">
                                <label class="switch">
                                    <input type="checkbox" class="toggle-published" data-id="<?= $product['id'] ?>"
                                        <?= $product['published'] == 1 ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td data-label="Destacar">
                                <label class="switch">
                                    <input type="checkbox" class="toggle-featured" data-id="<?= $product['id'] ?>"
                                        data-published="<?= $product['published'] ?>" <?= $product['featured'] == 1 ? 'checked' : '' ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>

                            <td data-label="Acciones">
                                <div class="actions">
                                    <a href="/product/edit/<?= $product['id'] ?>" class="btn btn-edit"><i
                                            class="fas fa-edit"></i></a>
                                    <form action="/product/delete/<?= $product['id'] ?>" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                        <button type="submit" class="btn btn-delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10">No hay productos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>

    <script src="/static/js/admin_page/product_list.js"></script>
    <script src="/static/js/admin_page/admin_page.js"></script>

</body>

</html>