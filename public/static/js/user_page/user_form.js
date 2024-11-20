
document.addEventListener("DOMContentLoaded", () => {
    const inputs = document.querySelectorAll(".input");

    function addFocusToParent(input) {
        let parent = input.parentNode.parentNode;
        parent.classList.add("focus");
    }

    function addcl() {
        addFocusToParent(this);
    }

    function remcl() {
        let parent = this.parentNode.parentNode;
        if (this.value.trim() === "") {
            parent.classList.remove("focus");
        }
    }

    inputs.forEach(input => {
        if (input.value.trim() !== "") {
            addFocusToParent(input); 
        }
        input.addEventListener("focus", addcl); 
        input.addEventListener("blur", remcl); 
    });

    console.log("Animación configurada correctamente"); 
});
function focusInput(element) {
    const input = element.nextElementSibling;
    if (input) {
        input.focus();
    }
}
