let sliderPosition = 0;

function moveSlider(direction) {
    const slider = document.querySelector('.products-grid');  
    const maxPosition = slider.scrollWidth - slider.clientWidth;

    const scrollAmount = 220;

    sliderPosition += direction * scrollAmount;
    
    if (sliderPosition < 0) sliderPosition = 0;
    if (sliderPosition > maxPosition) sliderPosition = maxPosition;

    slider.scrollTo({
        left: sliderPosition,
        behavior: 'smooth'
    });
}
function toggleMenu() {
    const menu = document.getElementById("sortMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

function sortBy(order) {
    console.log("Ordenar por:", order);
    document.getElementById("sortMenu").style.display = "none";
}

function toggleOffcanvas() {
    const offcanvasMenu = document.getElementById("offcanvasMenu");
    offcanvasMenu.classList.toggle("active");
}


window.onclick = function (event) {
    const sortMenu = document.getElementById("sortMenu");
    const offcanvasMenu = document.getElementById("offcanvasMenu");

    if (!event.target.closest('.sort-button') && sortMenu.style.display === "block") {
        sortMenu.style.display = "none";
    }

    if (offcanvasMenu.classList.contains("active") && !event.target.closest(".filter-button") && !event.target.closest(".offcanvas-menu")) {
        offcanvasMenu.classList.remove("active");
    }
};


function toggleOffcanvas() {
    const offcanvasMenu = document.getElementById("offcanvasMenu");
    offcanvasMenu.classList.toggle("active");
}

window.onclick = function (event) {
    const offcanvasMenu = document.getElementById("offcanvasMenu");
    if (offcanvasMenu.classList.contains("active") && !event.target.closest(".offcanvas-menu") && !event.target.closest(".filter-button")) {
        offcanvasMenu.classList.remove("active");
    }
};


window.onresize = function () {
    const offcanvasMenu = document.getElementById("offcanvasMenu");
    if (window.innerWidth > 1024 && offcanvasMenu.classList.contains("active")) {
        offcanvasMenu.classList.remove("active");
    }
};
function toggleOffcanvas() {
    const offcanvasMenu = document.getElementById("offcanvasMenu");
    offcanvasMenu.classList.toggle("active");
}


document.addEventListener('DOMContentLoaded', function () {
const searchInput = document.getElementById('header-search-input'); 
const productDivs = document.querySelectorAll('.products-grid .product');

searchInput.addEventListener('input', function () {
    const searchTerm = searchInput.value.trim().toLowerCase();

    productDivs.forEach(product => {
        const productName = product.getAttribute('data-name').toLowerCase();
        if (productName.includes(searchTerm)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
});
});