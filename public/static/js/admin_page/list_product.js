


document.getElementById('searchBox').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#productTableBody tr');

    rows.forEach(row => {
        const productName = row.querySelector('td[data-label="Nombre"]').textContent.toLowerCase();
        if (productName.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// PUBLICAR / DESPUBLICAR

function uncheckFeaturedWithAnimation(checkbox) {

    checkbox.closest('.switch').style.transition = 'opacity 0.4s ease';
    checkbox.closest('.switch').style.opacity = 0.5;

    setTimeout(() => {
        checkbox.checked = false;
        checkbox.closest('.switch').style.opacity = 1;
    }, 400);
}


document.querySelectorAll('.toggle-published').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const productId = this.getAttribute('data-id');
        const publishedStatus = this.checked ? 1 : 0;

        fetch(`/product/togglePublished/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ published: publishedStatus })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (!data.success) {
                    alert(data.message || 'Error al actualizar el estado de publicación');
                    this.checked = !this.checked;
                } else {

                    const featuredCheckbox = document.querySelector(`.toggle-featured[data-id="${productId}"]`);
                    if (featuredCheckbox && publishedStatus === 0) {
                        featuredCheckbox.checked = false;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud.');
                this.checked = !this.checked;
            });
    });
});


document.querySelectorAll('.toggle-featured').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const productId = this.getAttribute('data-id');
        const publishedStatus = this.getAttribute('data-published');
        const featuredStatus = this.checked ? 1 : 0;


        if (publishedStatus == 0) {
            alert("Tienes que publicar el Producto antes");
            this.checked = false;
            return;
        }


        fetch(`/product/toggleFeatured/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ featured: featuredStatus })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (!data.success) {
                    alert(data.message || 'Error al actualizar el estado de destacado');
                    this.checked = !this.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud.');
                this.checked = !this.checked;
            });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const loadingOverlay = document.getElementById('loading-overlay');


    const sidebarLinks = document.querySelectorAll('.sidebar a[href]');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function () {
            loadingOverlay.style.display = 'flex';
        });
    });

    const deleteForms = document.querySelectorAll('.actions form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function () {
            loadingOverlay.style.display = 'flex';
        });
    });

    const actionButtons = document.querySelectorAll('.option-btn, .btn-edit');
    actionButtons.forEach(button => {
        button.addEventListener('click', function () {
            loadingOverlay.style.display = 'flex';
        });
    });
});
