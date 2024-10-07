<?php require_once __DIR__ . '/../includes/head.php'; ?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="content">
    <!-- Main container for product details -->
    <div class="main-content">
        <section class="product-detail">
            <div class="product-detail-container">
                <img src="/<?= $product['image'] ?>" alt="Image of <?= $product['name'] ?>" class="product-img" />
                
                <div class="product-info">
                    <h1><?= $product['name'] ?> <?= $product['model'] ?> <?= $product['brand'] ?></h1>
                    <p class="product-price">$<?= $product['price'] ?></p>
                    <p class="product-description"><?= $product['description'] ?></p>
                    
                    <form action="/cart/add/<?= $product['id'] ?>" method="POST">
                        <label for="quantity">Cantidad:</label>
                        <input type="number" id="quantity" name="quantity" min="1" max="<?= $product['quantity'] ?>" value="1" required>
                        <button type="submit" class="btn btn-cart">AGREGAR AL CARRITO</button>
                    </form>

                    <!-- Link or button to return to catalog -->
                    <a href="/catalog" class="btn btn-back">REGRESAR AL CATALOGO</a>
                </div>
            </div>
        </section>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
<?php require_once __DIR__ . '/../includes/foot.php'; ?>
