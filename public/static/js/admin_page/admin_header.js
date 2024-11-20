function toggleSidebar() {
    var sidebar = document.getElementById('sidebar');
    var mainContent = document.querySelector('.main-content');
    sidebar.classList.toggle('active');
    mainContent.classList.toggle('active');
}






window.onload = function () {
    var toggleBtn = document.querySelector('.toggle-btn');
    if (window.innerWidth <= 1024) {
        toggleBtn.style.display = 'block';
    } else {
        toggleBtn.style.display = 'none';
    }

    window.onresize = function () {
        if (window.innerWidth <= 1024) {
            toggleBtn.style.display = 'block';
        } else {
            toggleBtn.style.display = 'none';
        }
    };
};
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