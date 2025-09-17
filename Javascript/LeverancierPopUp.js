console.log("LeveranciersPopup.js geladen");

document.addEventListener("DOMContentLoaded", () => {
    const openBtn = document.getElementById("openFormBtn");
    const formContainer = document.getElementById("leverancierFormContainer");

    function showModal(modal){ modal.style.display="flex"; }
    function closeModal(modal){ modal.style.display="none"; }

    // Toevoegen popup
    openBtn.addEventListener("click", ()=> showModal(formContainer));
    formContainer.querySelectorAll(".closeBtn").forEach(btn => {
        btn.addEventListener("click", ()=> closeModal(formContainer));
    });

    // Bewerken popup
    const modal = document.getElementById("editModal");
    const editForm = document.getElementById("editForm");
    const deleteBtn = document.getElementById("deleteBtn");

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

    modal.querySelectorAll(".closeBtn").forEach(btn => {
        btn.addEventListener("click", ()=> closeModal(modal));
    });

    window.addEventListener("click", (e)=>{ if(e.target===modal) closeModal(modal); });

    // Verwijderen knop
    deleteBtn.addEventListener("click", ()=>{
        if(confirm("Weet je zeker dat je deze leverancier wilt verwijderen?")){
            editForm.action = "/Controller/LeveranciersController.php?action=delete";
            editForm.submit();
        }
    });

    // Opslaan knop
    editForm.addEventListener("submit", ()=>{
        editForm.action = "/Controller/LeveranciersController.php?action=update";
    });

    // ----------- Toevoegen sorteerfunctie voor kolommen -----------

    const table = document.querySelector("table");
    const headers = table.querySelectorAll("th");

    function sortTable(table, colIndex, ascending = true) {
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.querySelectorAll("tr"));

        rows.sort((a, b) => {
            const aText = a.cells[colIndex].textContent.trim().toLowerCase();
            const bText = b.cells[colIndex].textContent.trim().toLowerCase();

            if (aText < bText) return ascending ? -1 : 1;
            if (aText > bText) return ascending ? 1 : -1;
            return 0;
        });

        rows.forEach(row => tbody.appendChild(row));
    }

    headers.forEach((th, index) => {
        let ascending = true;
        th.addEventListener("click", () => {
            // Verwijder sortering van andere kolommen
            headers.forEach(h => h.classList.remove("asc", "desc"));

            sortTable(table, index, ascending);
            th.classList.add(ascending ? "asc" : "desc");
            ascending = !ascending;
        });
    });
});
