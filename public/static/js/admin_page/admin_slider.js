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
        disableOnInteraction: false,
    },
    effect: 'slide',
    speed: 1000,
});
document.addEventListener('DOMContentLoaded', function () {
    const loadingOverlay = document.getElementById('loading-overlay');
    const sidebarLinks = document.querySelectorAll('.sidebar a[href]');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            if (!loadingOverlay.style.display || loadingOverlay.style.display === 'none') {
                loadingOverlay.style.display = 'flex';
            }
        });
    });
});
