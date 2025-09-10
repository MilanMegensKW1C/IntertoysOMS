
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("orderModal");
    const openBtn = document.getElementById("openModalBtn");
    const closeBtn = document.getElementById("closeModalBtn");

    if (openBtn) {
        openBtn.addEventListener("click", () => {
            modal.style.display = "block";
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });
    }

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});

const orderForm = document.getElementById('orderForm');

orderForm.addEventListener('submit', function(e) {
    e.preventDefault(); // voorkomt normale submit

    const formData = new FormData(orderForm);

    fetch('/IntertoysOMS/Controller/add_order_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // nieuwe rij toevoegen aan de tabel
            const tableBody = document.querySelector('#ordersTable tbody');
            const row = tableBody.insertRow(0);
            row.innerHTML = `
                <td>${data.order_id}</td>
                <td>${data.orderdatum}</td>
                <td>${data.klantnaam}</td>
                <td>${data.status}</td>
            `;
            // modal sluiten
            document.getElementById('orderModal').style.display = 'none';
            orderForm.reset();
        } else {
            alert('Er ging iets mis bij het opslaan.');
        }
    });
});
