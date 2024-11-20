document.addEventListener('DOMContentLoaded', function () {
    const loadingOverlay = document.getElementById('loading-overlay');

    const brandForm = document.getElementById('brandForm');
    brandForm.addEventListener('submit', function () {
        loadingOverlay.style.display = 'flex';
    });


    const backArrow = document.querySelector('.back-arrow');
    backArrow.addEventListener('click', function () {
        loadingOverlay.style.display = 'flex';
    });
});