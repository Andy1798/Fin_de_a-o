<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/user_page/cart.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

    <div class="cart-container">
        <h1>Tu Carrito de Compras</h1>

        <?php if (empty($cart)): ?>
            <p>Tu carrito está vacío</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $productId => $product): ?>
                        <tr data-product-id="<?= $productId ?>">
                            <td class="product-info">
                                <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                                <?= $product['name'] ?>
                            </td>
                            <td class="price"><?= number_format($product['price'], 2) ?> UYU</td>
                            <td>
                                <div class="quantity-input-product">
                                    <button type="button" class="btn-decrement-product">-</button>
                                    <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="1"
                                        max="<?= $product['available_stock'] ?>">
                                    <button type="button" class="btn-increment-product">+</button>
                                </div>
                            </td>
                            <td class="subtotal"><?= number_format($product['subtotal'], 2) ?> UYU</td>
                            <td>
                                <form action="/cart/remove/<?= $productId ?>" method="POST">
                                    <button type="submit" class="btn-remove" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-total">
                <p>Total: <span id="total"><?= number_format(array_sum(array_column($cart, 'subtotal')), 2) ?> UYU</span>
                </p>
            </div>
            <form action="/cart/finalize" method="POST">
                <button type="submit" class="btn-finalize">Finalizar Pedido</button>
            </form>

            <form action="/cart/clear" method="POST">
                <button type="submit" class="btn-empty">Vaciar Carrito</button>
            </form>


        <?php endif; ?>
    </div>


<script>document.addEventListener('DOMContentLoaded', function () {
    const cartTable = document.querySelector('table');
    const totalElement = document.querySelector('#total');

    if (cartTable) {
        // Actualizar el subtotal y total cuando el usuario cambia la cantidad
        cartTable.addEventListener('input', function (e) {
            if (e.target && e.target.name === 'quantity') {
                updateQuantity(e.target);
            }
        });

        // Evento para los botones de incremento y decremento
        cartTable.addEventListener('click', function (e) {
            if (e.target && (e.target.classList.contains('btn-increment-product') || e.target.classList.contains('btn-decrement-product'))) {
                const row = e.target.closest('tr');
                const quantityInput = row.querySelector('input[name="quantity"]');
                const maxQuantity = parseInt(quantityInput.getAttribute('max'));
                let quantity = parseInt(quantityInput.value);

                // Incrementar o decrementar la cantidad según el botón presionado
                if (e.target.classList.contains('btn-increment-product')) {
                    if (quantity < maxQuantity) {
                        quantity++;
                    } else {
                        alert('La cantidad seleccionada excede el stock disponible.');
                    }
                } else if (e.target.classList.contains('btn-decrement-product')) {
                    if (quantity > 1) {
                        quantity--;
                    }
                }

                // Actualizar el valor en el input y recalcular
                quantityInput.value = quantity;
                updateQuantity(quantityInput);
            }
        });
    }

    // Función para actualizar la cantidad y recalcular subtotales y total
    function updateQuantity(input) {
        const row = input.closest('tr');
        const productId = row.getAttribute('data-product-id');
        let priceText = row.querySelector('.price').innerText.replace(' UYU', '');
        let price = parseFloat(priceText.replace(/,/g, ''));
        const quantity = parseInt(input.value);
        const maxQuantity = parseInt(input.getAttribute('max'));

        // Validar si la cantidad es mayor al stock disponible
        if (quantity > 0 && quantity <= maxQuantity) {
            const subtotalElement = row.querySelector('.subtotal');
            const newSubtotal = (price * quantity).toFixed(2);

            // Actualiza el subtotal en la fila correspondiente
            subtotalElement.innerText = newSubtotal + ' UYU';

            // Recalcula el total
            updateTotal();

            // Enviar la cantidad actualizada al servidor con AJAX
            updateQuantityInServer(productId, quantity);
        } else {
            alert('La cantidad seleccionada excede el stock disponible.');
            input.value = maxQuantity;
        }
    }

    // Recalcula el total sumando los subtotales
    function updateTotal() {
        const subtotals = document.querySelectorAll('.subtotal');
        let total = 0;
        subtotals.forEach(subtotal => {
            total += parseFloat(subtotal.innerText.replace(/,/g, '').replace(' UYU', ''));
        });
        totalElement.innerText = total.toFixed(2) + ' UYU';
    }

    // Función para actualizar la cantidad en el servidor vía AJAX
    function updateQuantityInServer(productId, quantity) {
        fetch(`/cart/update/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ quantity: quantity })
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Error:', data.message || 'Error desconocido');
                    alert('Error al actualizar la cantidad.');
                    location.reload(); // Recargar la página para obtener la cantidad correcta desde el servidor
                } else {
                    console.log('Cantidad actualizada correctamente.');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
    }
});
</script>

<?php require_once __DIR__ . '/../includes/foot.php'; ?>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
