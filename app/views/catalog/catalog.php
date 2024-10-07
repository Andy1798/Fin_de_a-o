<?php require_once __DIR__ . '/../includes/head.php'; ?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<div class="content">
    <!-- Sidebar with categories -->
    <aside class="sidebar">
        <h2>CATEGORIAS</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li><a href="/catalog/category/<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Main container encapsulating filter and catalog -->
    <div class="main-content">

        <!-- Dynamic product catalog -->
        <section class="catalog">
            <div class="products-grid">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product">
                            <img src="/<?= $product['image'] ?>" alt="Image of <?= $product['name'] ?>" class="product-img" />
                            <div class="product-info">
                                <h5 class="product-name">
                                    <?= $product['name'] ?>         <?= $product['model'] ?>         <?= $product['brand'] ?>
                                </h5>
                                <p class="product-price">$<?= $product['price'] ?></p>
                                <a class="btn btn-cart" href="/catalog/product/<?= $product['id'] ?>">VER OPCIONES</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>NO HAY PRODUCTOS DISPONIBLES EN ESTE MOMENTO</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">ANTERIOR</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">SIGUIENTE</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
<?php require_once __DIR__ . '/../includes/foot.php'; ?>

</body>

</html>