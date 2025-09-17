document.addEventListener("DOMContentLoaded", () => {
    const openBtn = document.getElementById("openFormBtn");
    const formContainer = document.getElementById("factuurFormContainer");
    const editModal = document.getElementById("editModal");
    const editForm = document.getElementById("editForm");
    const deleteBtn = document.getElementById("deleteBtn");
    const editOrderSelect = document.getElementById("edit_orderSelect");
    const editTotaalInput = document.getElementById("edit_totaalbedrag");

    // Open / close toevoegen popup
    openBtn.addEventListener("click", () => formContainer.style.display = "flex");
    formContainer.querySelectorAll(".closeBtn").forEach(btn => btn.addEventListener("click", () => formContainer.style.display = "none"));

    // Totaalbedrag automatisch bij toevoegen
    document.querySelectorAll("#factuurFormContainer .orderSelect").forEach(select => {
        const input = select.closest("form").querySelector(".totaalInput");
        select.addEventListener("change", () => {
            const opt = select.options[select.selectedIndex];
            input.value = opt ? opt.getAttribute("data-totaal") : 0;
        });
    });

    // Open bewerk-popup bij klikken op tabelrij
    document.querySelectorAll("table tbody tr").forEach(row => {
        row.addEventListener("click", () => {
            const cells = row.querySelectorAll("td");
            document.getElementById("edit_id").value = cells[0].textContent.trim();
            document.getElementById("edit_factuurdatum").value = cells[2].textContent.trim();

            // Selecteer juiste order in dropdown
            editOrderSelect.value = cells[1].textContent.trim();

            // Totaalbedrag invullen
            const opt = editOrderSelect.options[editOrderSelect.selectedIndex];
            editTotaalInput.value = opt ? opt.getAttribute("data-totaal") : 0;

            editModal.style.display = "flex";
        });
    });

    // Update totaalbedrag bij wijzigen order in edit-popup
    editOrderSelect.addEventListener("change", () => {
        const opt = editOrderSelect.options[editOrderSelect.selectedIndex];
        editTotaalInput.value = opt ? opt.getAttribute("data-totaal") : 0;
    });

    // Close edit popup
    editModal.querySelectorAll(".closeBtn").forEach(btn => btn.addEventListener("click", () => editModal.style.display = "none"));
    window.addEventListener("click", e => { if(e.target === editModal) editModal.style.display = "none"; });

    // Delete factuur
    deleteBtn.addEventListener("click", () => {
        if(confirm("Weet je zeker dat je deze factuur wilt verwijderen?")) {
            editForm.action = "/Controller/FacturenController.php?action=delete";
            editForm.submit();
        }
    });

    // Update factuur
    editForm.addEventListener("submit", () => editForm.action = "/Controller/FacturenController.php?action=update");
});
