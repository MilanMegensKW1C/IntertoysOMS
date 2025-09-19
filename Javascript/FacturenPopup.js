/**
 * FacturenPopup.js
 *
 * Auteur: Milan
 * Beschrijving: Beheert de popups voor toevoegen, bewerken en verwijderen van facturen.
 */
document.addEventListener("DOMContentLoaded", () => {
    // Variabelen ophalen
    const openBtn = document.getElementById("openFormBtn");         
    const formContainer = document.getElementById("factuurFormContainer");
    const editModal = document.getElementById("editModal");  
    const editForm = document.getElementById("editForm");      
    const deleteBtn = document.getElementById("deleteBtn");      
    const editOrderSelect = document.getElementById("edit_orderSelect"); 
    const editTotaalInput = document.getElementById("edit_totaalbedrag");

    // Popup openen/sluiten voor toevoegen
    openBtn.addEventListener("click", () => formContainer.style.display = "flex");

    // Alle "close" knoppen in de popup opzoeken en functie toevoegen
    formContainer.querySelectorAll(".closeBtn").forEach(btn => 
        btn.addEventListener("click", () => formContainer.style.display = "none")
    );

    // ------------------------------
    // Totaalbedrag automatisch invullen bij toevoegen
    // ------------------------------
    document.querySelectorAll("#factuurFormContainer .orderSelect").forEach(select => {
        const input = select.closest("form").querySelector(".totaalInput"); // Zoek het input veld in hetzelfde formulier
        select.addEventListener("change", () => {
            const opt = select.options[select.selectedIndex]; // Krijg de geselecteerde optie
            // Vul het totaalbedrag van de geselecteerde order in de input
            input.value = opt ? opt.getAttribute("data-totaal") : 0;
        });
    });

    // Open de bewerk-popup als je op een tabelrij klikt
    document.querySelectorAll("table tbody tr").forEach(row => {
        row.addEventListener("click", () => {
            const cells = row.querySelectorAll("td");

            // Vul hidden input en andere velden met bestaande data
            document.getElementById("edit_id").value = cells[0].textContent.trim();
            document.getElementById("edit_factuurdatum").value = cells[2].textContent.trim();

            // Kies de juiste order in de dropdown op basis van order_id
            editOrderSelect.value = cells[1].textContent.trim(); 

            // Totaalbedrag invullen in de edit-popup
            const opt = editOrderSelect.options[editOrderSelect.selectedIndex];
            editTotaalInput.value = opt ? opt.getAttribute("data-totaal") : 0;

            // Toon de edit-popup
            editModal.style.display = "flex";
        });
    });

    // Update totaalbedrag als de gebruiker een andere order selecteert in edit-popup
    editOrderSelect.addEventListener("change", () => {
        // Geselecteerde optie ophalen
        const opt = editOrderSelect.options[editOrderSelect.selectedIndex]; 
        // Update input veld
        editTotaalInput.value = opt ? opt.getAttribute("data-totaal") : 0;  
    });

    // Sluit bewerk-popup
    editModal.querySelectorAll(".closeBtn").forEach(btn => 
        btn.addEventListener("click", () => editModal.style.display = "none")
    );

    // Sluit als ergens buiten de popup wordt geklikt
    window.addEventListener("click", e => { 
        if(e.target === editModal) editModal.style.display = "none"; 
    });

    // Verwijder een factuur
    deleteBtn.addEventListener("click", () => {
        if(confirm("Weet je zeker dat je deze factuur wilt verwijderen?")) {
            // Stelt het formulier in op 'delete' actie en submit
            editForm.action = "/Controller/FacturenController.php?action=delete";
            editForm.submit();
        }
    });

    // Update factuur bij submit van edit-popup
    editForm.addEventListener("submit", () => {
        editForm.action = "/Controller/FacturenController.php?action=update";
    });
});
