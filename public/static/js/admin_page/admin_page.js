function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    var mainContent = document.querySelector('.main-content');
    sidebar.classList.toggle('compact');

    // Ajustamos el margen del contenido principal dependiendo del estado del sidebar
    if (sidebar.classList.contains('compact')) {
        mainContent.style.marginLeft = '80px'; // Ancho del sidebar compacto
    } else {
        mainContent.style.marginLeft = '250px'; // Ancho del sidebar expandido
    }
}



