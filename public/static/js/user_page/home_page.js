const swiper = new Swiper('.swiper-container', {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    grabCursor: true,
    autoplay: {
        delay: 4000, // Las imágenes cambian cada 4 segundos
        disableOnInteraction: false, // Continúa el autoplay incluso si el usuario interactúa
    },
    effect: 'slide',  // Efecto de transición deslizante
    speed: 1000,      // Velocidad de la transición en milisegundos
});
