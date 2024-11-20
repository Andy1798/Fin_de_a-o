function previewImage() {
    const input = document.getElementById('image');
    const preview = document.getElementById('preview');
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const loadingOverlay = document.getElementById('loading-overlay');


    const productForm = document.getElementById('productForm');
    productForm.addEventListener('submit', function () {
        loadingOverlay.style.display = 'flex';
    });


    const backArrow = document.querySelector('.back-arrow');
    backArrow.addEventListener('click', function () {
        loadingOverlay.style.display = 'flex';
    });
});

