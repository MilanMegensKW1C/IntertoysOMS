/**
 * LeveranciersPopup.js
 *
 * Auteur: Milan
 * Beschrijving: Beheert de popups voor toevoegen, bewerken en verwijderen van leveranciers.
 */

document.addEventListener("DOMContentLoaded", () => {
    // Variabelen ophalen
    const openBtn = document.getElementById("openFormBtn");
    const formContainer = document.getElementById("leverancierFormContainer");
    const modal = document.getElementById("editModal");
    const editForm = document.getElementById("editForm");
    const deleteBtn = document.getElementById("deleteBtn");

    // Functies voor popup tonen/sluiten
    const showModal = (m) => m.style.display = "flex";
    const closeModal = (m) => m.style.display = "none";

    // Toevoegen popup
    openBtn.addEventListener("click", () => showModal(formContainer));
    formContainer.querySelectorAll(".closeBtn").forEach(btn => btn.addEventListener("click", () => closeModal(formContainer)));

    // Bewerken popup openen bij klikken op tabelrij
    document.querySelectorAll("table tbody tr").forEach(row => {
        row.addEventListener("click", () => {
            const cells = row.querySelectorAll("td");
            document.getElementById("edit_id").value = cells[0].textContent.trim();
            document.getElementById("edit_bedrijfsnaam").value = cells[1].textContent.trim();
            document.getElementById("edit_adres").value = cells[2].textContent.trim();
            document.getElementById("edit_contactpersoon").value = cells[3].textContent.trim();
            document.getElementById("edit_email").value = cells[4].textContent.trim();
            showModal(modal);
        });
    });

    // Sluit bewerk-popup
    modal.querySelectorAll(".closeBtn").forEach(btn => btn.addEventListener("click", () => closeModal(modal)));
    window.addEventListener("click", e => { if(e.target === modal) closeModal(modal); });

    // Verwijderen knop
    deleteBtn.addEventListener("click", () => {
        if(confirm("Weet je zeker dat je deze leverancier wilt verwijderen?")) {
            editForm.action = "/Controller/LeveranciersController.php?action=delete";
            editForm.submit();
        }
    });

    // Opslaan/bewerken knop
    editForm.addEventListener("submit", () => {
        editForm.action = "/Controller/LeveranciersController.php?action=update";
    });
});
