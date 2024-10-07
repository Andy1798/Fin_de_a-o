document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(event) {
        const input = document.querySelector('#name');
        
        if (input.value.trim() === '') {
            event.preventDefault(); // Evitar el envío del formulario
            alert('El nombre de la categoría es obligatorio.');
        }
    });
});
