console.log("OrderPopUp.js geladen");

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("openFormBtn");
    const formContainer = document.getElementById("orderFormContainer");

    console.log("Button:", btn);
    console.log("Form container:", formContainer);

    if (btn) {
        btn.addEventListener("click", () => {
            console.log("Button geklikt");
            if (formContainer.style.display === "none" || formContainer.style.display === "") {
                formContainer.style.display = "block";
            } else {
                formContainer.style.display = "none";
            }
        });
    }
});