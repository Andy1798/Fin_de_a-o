let sliderPosition = 0;

function moveSlider(direction) {
    const slider = document.querySelector('.products-grid');  // Cambiado de .productos-grid a .products-grid
    const maxPosition = slider.scrollWidth - slider.clientWidth;

    const scrollAmount = 220; // Ajusta este valor según el tamaño de tus productos

    sliderPosition += direction * scrollAmount;
    
    if (sliderPosition < 0) sliderPosition = 0;
    if (sliderPosition > maxPosition) sliderPosition = maxPosition;

    slider.scrollTo({
        left: sliderPosition,
        behavior: 'smooth'
    });
}
