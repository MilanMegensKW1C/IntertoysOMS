console.log("ProductPopUp.js geladen");

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("openFormBtn");
    const formContainer = document.getElementById("productFormContainer"); // uniek ID

    if (btn && formContainer) {
        btn.addEventListener("click", () => {
            formContainer.style.display =
                formContainer.style.display === "none" || formContainer.style.display === ""
                    ? "block"
                    : "none";
        });
    }
});
