<?php require_once __DIR__ . '/../includes/head.php'; ?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>


<!-- Botón de volver al listado -->
<a href="/catalog" class="btn-Back-product">
    <span class="icon-product">⟵</span> <!-- Puedes usar un ícono de FontAwesome o similar si prefieres -->
    <span class="text-product">Volver al Catálogo</span>
</a>

<!-- Sección principal del producto -->
<section class="product-container-product">
    <div class="product-container-product-inner">
        <!-- Imágenes miniatura a la izquierda -->


        <!-- Imagen principal del producto a la derecha -->
        <div class="product-main-image-product">
            <img src="/<?= $product['image'] ?>" alt="Image of <?= $product['name'] ?>" id="product-image"
                class="thumbnail-active-product">
        </div>
    </div>

    <!-- Detalles del producto -->
    <div class="product-details-product">
        <h1>
            <?= $product['name'] ?>
            <?= $product['model'] ?>
            <?= $product['brand'] ?>
        </h1>
        <p class="product-price-product">
            <span class="current-price-product">$
                <?= $product['price'] ?>
            </span>
            <span class="original-price-product"></span>
        </p>
        <p class="description">
            <?= $product['description'] ?>
        </p>
        <p class="product-availability-product">Disponibilidad: <span>
                <?= $product['quantity'] ?>
            </span></p>

        <!-- Cantidad con flechas personalizadas -->
        <form action="/cart/add/<?= $product['id'] ?>" method="POST" class="form-product">
    <div class="purchase-quantity-product">
        <label for="quantity">Cantidad:</label>
        <div class="quantity-input-product">
            <button class="btn-decrement-product" type="button" onmousedown="startChangingQuantity(-1)" onmouseup="stopChangingQuantity()" onmouseleave="stopChangingQuantity()">-</button>
            <input type="number" id="quantity" name="quantity" min="1" max="<?= $product['quantity'] ?>" value="1" required>
            <button class="btn-increment-product" type="button" onmousedown="startChangingQuantity(1)" onmouseup="stopChangingQuantity()" onmouseleave="stopChangingQuantity()">+</button>
        </div>
    </div>
    <button type="submit" class="btn btn-product">AGREGAR AL CARRITO</button>
</form>





    </div>
</section>


<?php require_once __DIR__ . '/../includes/footer.php'; ?>
<?php require_once __DIR__ . '/../includes/foot.php'; ?>