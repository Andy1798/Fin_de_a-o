
document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll(".input");

    function addcl() {
        let parent = this.parentNode.parentNode;
        parent.classList.add("focus");
    }

    function remcl() {
        let parent = this.parentNode.parentNode;
        if (this.value === "") {
            parent.classList.remove("focus");
        }
    }

    // Agregar clase focus si ya hay algo escrito en el campo al cargar la página
    inputs.forEach(input => {
        if (input.value.trim() !== "") {
            let parent = input.parentNode.parentNode;
            parent.classList.add("focus");
        }
        input.addEventListener("focus", addcl);
        input.addEventListener("blur", remcl);
    });

    console.log("Script cargado y ejecutado"); // Para verificar la ejecución del script
});
