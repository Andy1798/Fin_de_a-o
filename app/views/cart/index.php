<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/user_page/cart.css">

</head>

<body>

    <h1>Tu Carrito de Compras</h1>

    <?php if (empty($cart)): ?>
        <p>Tu carrito está vacío</p>
    <?php else: ?>
        <table>
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
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td class="price"><?= number_format($product['price'], 2) ?> USD</td>
                        <td>
                            <input type="number" name="quantity" value="<?= $product['quantity'] ?>" min="1">
                        </td>
                        <td class="subtotal"><?= number_format($product['subtotal'], 2) ?> USD</td>
                        <td>
                            <form action="/cart/remove/<?= $productId ?>" method="POST">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>Total: <span id="total"><?= number_format(array_sum(array_column($cart, 'subtotal')), 2) ?> USD</span></p>

        <form action="/cart/clear" method="POST">
            <button type="submit">Vaciar Carrito</button>
        </form>

        <form action="/cart/finalize" method="POST">
            <button type="submit">Finalizar Pedido</button>
        </form>
    <?php endif; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartTable = document.querySelector('table');
            const totalElement = document.querySelector('#total');

            if (cartTable) {
                cartTable.addEventListener('input', function (e) {
                    if (e.target && e.target.name === 'quantity') {
                        const row = e.target.closest('tr');
                        const productId = row.getAttribute('data-product-id');
                        let priceText = row.querySelector('.price').innerText.replace(' USD', '');

                        // Elimina las comas de los miles para manejar bien el valor
                        let price = parseFloat(priceText.replace(/,/g, ''));
                        const quantity = parseInt(e.target.value);

                        if (quantity > 0) {
                            const subtotalElement = row.querySelector('.subtotal');
                            const newSubtotal = (price * quantity).toFixed(2); // Calculamos el subtotal correctamente

                            // Actualiza el subtotal en la fila correspondiente
                            subtotalElement.innerText = newSubtotal + ' USD';  // Mostrar el subtotal con el formato correcto

                            // Recalcula el total
                            updateTotal();

                            // Enviar la cantidad actualizada al servidor con AJAX
                            updateQuantityInServer(productId, quantity);
                        }
                    }
                });
            }

            function updateTotal() {
                const subtotals = document.querySelectorAll('.subtotal');
                let total = 0;
                subtotals.forEach(subtotal => {
                    // Elimina las comas y convierte el texto en un número
                    total += parseFloat(subtotal.innerText.replace(/,/g, '').replace(' USD', ''));
                });
                totalElement.innerText = total.toFixed(2) + ' USD'; // Mostrar el total con el formato correcto
            }

            // Función para actualizar la cantidad en el servidor vía AJAX
            function updateQuantityInServer(productId, quantity) {
                // Usa template literals para construir la URL
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




</body>

</html>