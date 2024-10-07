$(document).ready(function () {
    $("#toggle-search").click(function () {
        // Alternar la visibilidad del logo, el menú y el buscador
        $("#logo").toggle();
        $("#menu-icon").toggle();
        $("#search-container").toggleClass("flex-display");

        // Cambiar la alineación del contenedor nav
        const currentJustifyContent = $('.wrapper nav').css('justify-content');
        if (currentJustifyContent === 'center') {
            $('.wrapper nav').css('justify-content', 'space-between');
        } else {
            $('.wrapper nav').css('justify-content', 'center');
        }

        // Alternar entre los iconos de abrir y cerrar
        $('#icon-open, #icon-close').toggleClass('visible');
    });
});