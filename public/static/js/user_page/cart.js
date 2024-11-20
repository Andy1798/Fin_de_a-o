document.addEventListener('DOMContentLoaded', function () {
    const cartTable = document.querySelector('table');
    const totalElement = document.querySelector('#total');

    if (cartTable) {

        cartTable.addEventListener('input', function (e) {
            if (e.target && e.target.name === 'quantity') {
                updateQuantity(e.target);
            }
        });

        cartTable.addEventListener('click', function (e) {
            if (e.target && (e.target.classList.contains('btn-increment-product') || e.target.classList.contains('btn-decrement-product'))) {
                const row = e.target.closest('tr');
                const quantityInput = row.querySelector('input[name="quantity"]');
                const maxQuantity = parseInt(quantityInput.getAttribute('max'));
                let quantity = parseInt(quantityInput.value);

            
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

                quantityInput.value = quantity;
                updateQuantity(quantityInput);
            }
        });
    }


    function updateQuantity(input) {
        const row = input.closest('tr');
        const productId = row.getAttribute('data-product-id');
        let priceText = row.querySelector('.price').innerText.replace(' UYU', '');
        let price = parseFloat(priceText.replace(/,/g, ''));
        const quantity = parseInt(input.value);
        const maxQuantity = parseInt(input.getAttribute('max'));


        if (quantity > 0 && quantity <= maxQuantity) {
            const subtotalElement = row.querySelector('.subtotal');
            const newSubtotal = (price * quantity).toFixed(2);


            subtotalElement.innerText = newSubtotal + ' UYU';


            updateTotal();


            updateQuantityInServer(productId, quantity);
        } else {
            alert('La cantidad seleccionada excede el stock disponible.');
            input.value = maxQuantity;
        }
    }


    function updateTotal() {
        const subtotals = document.querySelectorAll('.subtotal');
        let total = 0;
        subtotals.forEach(subtotal => {
            total += parseFloat(subtotal.innerText.replace(/,/g, '').replace(' UYU', ''));
        });
        totalElement.innerText = total.toFixed(2) + ' UYU';
    }

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
                    location.reload();
                } else {
                    console.log('Cantidad actualizada correctamente.');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
            });
    }
});