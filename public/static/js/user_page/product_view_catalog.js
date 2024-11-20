function changeQuantity(change, elementId) {
    const quantityInput = document.getElementById(elementId);
    let newQuantity = parseInt(quantityInput.value) + change;
    const maxQuantity = parseInt(quantityInput.max);


    quantityInput.value = Math.min(Math.max(newQuantity, 1), maxQuantity);

    synchronizeQuantities(quantityInput.value);
}

function synchronizeQuantities(value) {

    document.getElementById("quantity").value = value;
    document.getElementById("quantity-mobile").value = value;
}


document.getElementById('quantity').addEventListener('input', function () {
    this.value = Math.min(Math.max(this.value, 1), this.max);
    synchronizeQuantities(this.value);
});

document.getElementById('quantity-mobile').addEventListener('input', function () {
    this.value = Math.min(Math.max(this.value, 1), this.max);
    synchronizeQuantities(this.value);
});



document.addEventListener('DOMContentLoaded', () => {
    const track = document.querySelector('.productos-slider');
    const products = document.querySelectorAll('.producto');
    const prevButton = document.querySelector('.btn-anterior');
    const nextButton = document.querySelector('.btn-siguiente');

    let currentIndex = 0;
    let productWidth;
    let visibleProducts;
    let maxIndex;

    function updateSliderDimensions() {
        productWidth = products[0].offsetWidth + 20;
        visibleProducts = Math.floor(document.querySelector('.productos-wrapper').offsetWidth / productWidth);
        maxIndex = products.length - visibleProducts;


        if (currentIndex > maxIndex) {
            currentIndex = maxIndex;
        }

        updateSliderPosition();
    }

    function updateSliderPosition() {
        track.style.transition = 'transform 0.5s ease';
        track.style.transform = `translateX(-${productWidth * currentIndex}px)`;
    }

    function bounceEffect(direction) {
        const bounceDistance = 30;
        track.style.transition = 'transform 0.2s ease';

        if (direction === 'left') {
            track.style.transform = `translateX(-${productWidth * currentIndex + bounceDistance}px)`;
        } else {
            track.style.transform = `translateX(-${productWidth * currentIndex - bounceDistance}px)`;
        }

        setTimeout(() => {
            track.style.transition = 'transform 0.5s ease';
            track.style.transform = `translateX(-${productWidth * currentIndex}px)`;
        }, 200);
    }

    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateSliderPosition();
        } else {
            bounceEffect('left');
        }
    });

    nextButton.addEventListener('click', () => {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateSliderPosition();
        } else if (currentIndex === maxIndex) {
            bounceEffect('right');
        }
    });


    updateSliderDimensions();


    window.addEventListener('resize', updateSliderDimensions);
});
