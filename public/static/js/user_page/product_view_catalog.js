// Function to change the product quantity
function changeQuantity(value) {
    const inputQuantity = document.getElementById('quantity');
    let quantity = parseInt(inputQuantity.value);

    if (isNaN(quantity)) {
        quantity = 1; // Set to 1 if not a number
    }

    // Increment or decrement the quantity, ensuring it doesn't go below 1
    quantity += value;
    if (quantity < 1) quantity = 1; // Ensure quantity doesn't go below 1

    inputQuantity.value = quantity; // Update the value in the input
}

// Event to ensure the DOM is loaded before executing any code
document.addEventListener('DOMContentLoaded', function() {
    // Add any additional code here if necessary
});
