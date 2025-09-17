console.log("OrderPopUp.js geladen");

document.addEventListener("DOMContentLoaded", () => {
    let productIndex = 1;
    const addProductBtn = document.getElementById("addProductRow");
    const productenContainer = document.getElementById("productenContainer");

    if (addProductBtn) {
        addProductBtn.addEventListener("click", () => {
            const newRow = document.createElement("div");
            newRow.classList.add("product-row");
            newRow.innerHTML = `
                <select name="producten[${productIndex}][id]" required>
                    <option value="">-- Kies een product --</option>
                    ${productenContainer.querySelector("select").innerHTML}
                </select>
                <input type="number" name="producten[${productIndex}][aantal]" min="1" value="1" required>
            `;
            productenContainer.appendChild(newRow);
            productIndex++;
        });
    }
});
