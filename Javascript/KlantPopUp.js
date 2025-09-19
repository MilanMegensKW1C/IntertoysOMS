console.log("KlantPopUp.js geladen");

document.addEventListener("DOMContentLoaded", () => {
    const addBtn = document.getElementById("openFormBtn");
    const formContainer = document.getElementById("klantFormContainer");
    const form = document.getElementById("klantForm");
    const deleteInput = document.getElementById("delete_user_id");

    // Open/close formulier voor nieuwe klant
    if (addBtn && formContainer) {
        addBtn.addEventListener("click", () => {
            formContainer.style.display =
                formContainer.style.display === "none" || formContainer.style.display === ""
                    ? "block"
                    : "none";

            // Reset formulier voor toevoegen
            document.getElementById("form_action").value = "add";
            form.reset();
            deleteInput.value = "";
        });
    }

    // Klik op klant-row om te bewerken/verwijderen
    document.querySelectorAll(".klant-row").forEach(row => {
        row.addEventListener("click", () => {
            const cols = row.children;

            formContainer.style.display = "block";

            // Vul formulier met bestaande gegevens
            document.getElementById("form_user_id").value = row.dataset.userId;
            document.getElementById("form_action").value = "update";
            document.getElementById("form_voornaam").value = cols[1].textContent;
            document.getElementById("form_achternaam").value = cols[2].textContent;
            document.getElementById("form_email").value = cols[3].textContent;
            document.getElementById("form_rol").value = cols[4].textContent.toLowerCase(); // Zorg dat rol overeenkomt met value

            // Vul hidden input voor verwijderen
            deleteInput.value = row.dataset.userId;

            // Scroll naar formulier
            window.scrollTo(0, formContainer.offsetTop);
        });
    });
});
