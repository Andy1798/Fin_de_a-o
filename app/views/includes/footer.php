<footer>
    <div class="container">
        <div class="brand">
            <a href="/" class="brand">
                Ruta MT
            </a>
            <div class="social-media">
                <ul>
                    <li>
                        <a href="#" target="_blank" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-label="Facebook" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" aria-label="Instagram" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="hours">
                <h4>Horario</h4>
                <hr />
                <h5>
                    Lunes a Viernes: <span>8:00 am - 7:00 pm</span>
                </h5>
                <h5>
                    Sábados: <span>8:00 am - 12:00 pm</span>
                </h5>
            </div>
        </div>
        <div class="our-services">
            <h4>Nuestros Servicios</h4>
            <ul>
                <li>Gomería</li>
                <li>Repuestos de autos</li>
                <li>Lubricantes</li>
                <li>Mecánica diésel</li>
                <li>Neumáticos</li>
            </ul>
        </div>
        <div class="our-contact">
            <h4>Contáctanos</h4>
            <ul>
                <li>
                    <a href="tel:+59891040732"><i class="fa-solid fa-phone"></i>+598 91 040 732</a>
                </li>
                <li>
                    <a href="mailto:rutamt@gmail.com">
                        <i class="fa-solid fa-envelope"></i>
                        rutamt@gmail.com
                    </a>
                </li>
                <li>
                    <i class="fa-solid fa-location-dot"></i>
                    <span>
                        <a href="https://maps.app.goo.gl/ikZFUoeo5VXWcrEx5"> AV. Aparicio Saravia 1260 </a>
                    </span>
                </li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <p>
                <a href="">Mapa del sitio</a>
            </p>
            <p class="copy">
                &copy; CCMG <span>2024~Presente</span>
            </p>
            <p>Todos los derechos reservados</p>
        </div>
    </div>
</footer>

<!-- Overlay de carga -->
<div id="loading-overlay">
    <div id="loading-spinner"></div>
</div>

<!-- Script para activar el overlay de carga -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadingOverlay = document.getElementById('loading-overlay');

        // Seleccionar todos los enlaces en la página
        const links = document.querySelectorAll('a[href]');

        links.forEach(link => {
            link.addEventListener('click', function(event) {
                // Prevenir la ejecución múltiple si ya está cargando
                if (!loadingOverlay.style.display || loadingOverlay.style.display === 'none') {
                    loadingOverlay.style.display = 'flex'; // Mostrar el overlay
                }
            });
        });
    });
</script>
