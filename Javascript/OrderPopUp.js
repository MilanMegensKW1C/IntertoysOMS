console.log("OrderPopUp.js geladen");

document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("openFormBtn");
    const container = document.getElementById("orderFormContainer");
    const addProductBtn = document.getElementById("addProductRow");
    const productenContainer = document.getElementById("productenContainer");

    console.log("Knop:", btn, "Container:", container, "AddProduct:", addProductBtn);

    if (!btn || !container) {
        console.warn("Toggle niet geactiveerd: knop of container niet gevonden.");
        return;
    }

    // Toggle formulier
    btn.addEventListener("click", () => {
        console.log("Formulier knop geklikt");
        container.style.display = container.style.display === "none" ? "block" : "none";
    });

    // Product toevoegen
    if (addProductBtn && productenContainer) {
        let productIndex = productenContainer.querySelectorAll(".product-row").length;

        addProductBtn.addEventListener("click", () => {
            const selectTemplate = productenContainer.querySelector("select");
            if (!selectTemplate) return;

            const newRow = document.createElement("div");
            newRow.classList.add("product-row");
            newRow.innerHTML = `
                <select name="producten[${productIndex}][id]" required>
                    ${selectTemplate.innerHTML}
                </select>
                <input type="number" name="producten[${productIndex}][aantal]" min="1" value="1" required>
                <button type="button" class="remove-product-btn">Verwijder</button>
            `;
            productenContainer.appendChild(newRow);

            newRow.querySelector(".remove-product-btn").addEventListener("click", () => {
                newRow.remove();
            });

            productIndex++;
        });
    }
});
