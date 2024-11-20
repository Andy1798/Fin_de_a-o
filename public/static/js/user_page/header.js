$(document).ready(function () {

    $("#toggle-search").click(function () {
    
        $("#logo, #menu-button").toggle();

        if ($("#search-container").hasClass("header-flex-display")) {
            $(".header-search-wrapper").css({ display: "none", width: "" });
            $('.header-wrapper .header-navigation').css('justify-content', 'space-between');
        } else {
            $(".header-search-wrapper").css({ display: "flex", width: "70%" });
            $('.header-wrapper .header-navigation').css('justify-content', 'center');
        }

        $("#search-container").toggleClass("header-flex-display");

        $('#icon-open').toggle();
        $('#icon-close').toggle();
    });

    $(window).resize(function () {
        const windowWidth = $(window).width();
        const isSearchOpen = $("#search-container").hasClass("header-flex-display");


        if (windowWidth >= 936) {
            $(".header-search-wrapper").css({ display: "flex", width: "" });
            $('.header-wrapper .header-navigation').css('justify-content', 'space-between');
            $("#logo, #menu-button").show();
            $("#icon-open").show();
            $("#icon-close").hide();
            $("#search-container").removeClass("header-flex-display");
        } else {

            if (!isSearchOpen) {
                $(".header-search-wrapper").css({ display: "none", width: "" });
            }

            if (isSearchOpen) {
                $("#menu-button").hide();
            }
        }


        if (windowWidth > 1475) {
            $("#menu-button").hide();
        } else if (!isSearchOpen) {
            $("#menu-button").show();
        }
    }).resize();


    function highlightMatch(text, query) {
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<span class="header-highlight">$1</span>');
    }

    // Variables para el buscador
    const searchInput = document.querySelector('.header-search-input');
    const resultadosContainer = document.getElementById('custom-resultados');
    let debounceTimeout;

    // Evento de búsqueda en tiempo real
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimeout);
        let query = normalizeString(this.value.trim());

        if (query) {
            resultadosContainer.innerHTML = '<div class="header-custom-loading">Cargando... <span class="header-custom-loader"></span></div>';
            resultadosContainer.style.display = 'block';

            debounceTimeout = setTimeout(() => {
                fetch(`/product/buscar?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            let resultados = '';
                            data.forEach(product => {
                                const highlightedName = highlightMatch(product.name, query);
                                resultados += `<a href="catalog/product/${product.id}" class="header-custom-producto">
                                                <img src="${product.image}" alt="${product.name}" class="header-custom-product-img">
                                                <div class="header-custom-producto-info">
                                                    <h3 class="header-custom-product-title">${highlightedName}</h3>
                                                    <p class="header-custom-product-price">US$${product.price}</p>
                                                </div>
                                            </a>`;
                            });
                            resultadosContainer.innerHTML = resultados;
                        } else {
                            resultadosContainer.innerHTML = '<p class="header-custom-no-results">No se encontraron productos</p>';
                        }
                    })
                    .catch(() => {
                        resultadosContainer.innerHTML = '<p class="header-custom-no-results">Error al buscar productos</p>';
                    });
            }, 300);
        } else {
            resultadosContainer.style.display = 'none';
        }
    });


    function normalizeString(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }



    document.addEventListener('click', function (event) {
        const isClickInside = searchInput.contains(event.target) || resultadosContainer.contains(event.target);
        if (!isClickInside && resultadosContainer.style.display === 'block') {
            resultadosContainer.classList.add('closing');
            setTimeout(() => {
                resultadosContainer.style.display = 'none';
                resultadosContainer.classList.remove('closing');
            }, 300);
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const userMenu = document.getElementById('userMenu');
    const submenu = document.getElementById('submenu');

    userMenu.addEventListener('click', function (event) {
        event.preventDefault();
        submenu.classList.toggle('visible');
    });


    document.addEventListener('click', function (event) {
        if (!userMenu.contains(event.target) && !submenu.contains(event.target)) {
            submenu.classList.remove('visible');
        }
    });
});
const searchInput = document.querySelector('.header-search-input');
const resultadosContainer = document.getElementById('custom-resultados');
let debounceTimeout;

function normalizeString(str) {
    return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

searchInput.addEventListener('input', function () {
    clearTimeout(debounceTimeout);
    let query = normalizeString(this.value.trim());

    if (query) {
        resultadosContainer.innerHTML = '<div class="header-custom-loading">Cargando... <span class="header-custom-loader"></span></div>';
        resultadosContainer.style.display = 'block';

        debounceTimeout = setTimeout(() => {
            fetch(`/product/buscar?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let resultados = '';
                        data.forEach(product => {
                            resultados += `<a href="/catalog/product/${product.id}" class="header-custom-producto">
                                            <img src="${product.image}" alt="${product.name}" class="header-custom-product-img">
                                            <div class="header-custom-producto-info">
                                                <h3 class="header-custom-product-title">${product.name}</h3>
                                                <p class="header-custom-product-price">US$${product.price}</p>
                                            </div>
                                        </a>`;
                        });
                        resultadosContainer.innerHTML = resultados;
                    } else {
                        resultadosContainer.innerHTML = '<p class="header-custom-no-results">No se encontraron productos</p>';
                    }
                })
                .catch(() => {
                    resultadosContainer.innerHTML = '<p class="header-custom-no-results">Error al buscar productos</p>';
                });
        }, 300);
    } else {
        resultadosContainer.style.display = 'none';
    }
});
document.addEventListener("click", function (event) {
    const menu = document.getElementById("menu-links");
    const menuButton = document.getElementById("menu-button");

    if (!menu.contains(event.target) && !menuButton.contains(event.target)) {
        if (menu.classList.contains("visible")) {
            menu.classList.remove("visible");
        }
    }
});


document.getElementById("menu-button").addEventListener("click", function () {
    const links = document.querySelector(".header-links");
    links.classList.toggle("visible");
});

document.addEventListener('click', function (event) {
    const isClickInside = searchInput.contains(event.target) || resultadosContainer.contains(event.target);
    if (!isClickInside && resultadosContainer.style.display === 'block') {
        resultadosContainer.classList.add('closing');
        setTimeout(() => {
            resultadosContainer.style.display = 'none';
            resultadosContainer.classList.remove('closing');
        }, 300);
    }
});

function updateCartCount() {
    fetch('/cart/getCount')
        .then(response => response.json())
        .then(data => {
            const cartCount = document.getElementById("cart-count");
            cartCount.innerText = data.count;
            cartCount.style.display = data.count > 0 ? 'flex' : 'none';
        })
        .catch(error => {
            console.error("Error al obtener la cantidad de productos en el carrito:", error);
        });
}

document.addEventListener("DOMContentLoaded", updateCartCount);