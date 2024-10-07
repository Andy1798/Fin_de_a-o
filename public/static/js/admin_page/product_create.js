function previewImage() {
    var file = document.getElementById("image").files[0];
    var reader = new FileReader();
    
    reader.onloadend = function() {
        var img = document.getElementById("preview");
        img.src = reader.result;
        img.style.display = 'block'; // Muestra la imagen
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        var img = document.getElementById("preview");
        img.style.display = 'none'; // Oculta la imagen si no se selecciona ninguna
    }
}
