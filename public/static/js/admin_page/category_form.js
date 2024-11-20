document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');

    form.addEventListener('submit', function (event) {
        const input = document.querySelector('#name');

        if (input.value.trim() === '') {
            event.preventDefault();
            alert('El nombre de la categoría es obligatorio.');
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const loadingOverlay = document.getElementById('loading-overlay');


    const categoryForm = document.getElementById('categoryForm');
    categoryForm.addEventListener('submit', function () {
        loadingOverlay.style.display = 'flex';
    });

    const backArrow = document.querySelector('.back-arrow');
    backArrow.addEventListener('click', function () {
        loadingOverlay.style.display = 'flex';
    });
});