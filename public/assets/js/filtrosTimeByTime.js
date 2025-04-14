document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const clearInput = document.getElementById("clear_input");
    const tableContainer = document.getElementById("tableContainer");
    const tableItems = () => tableContainer.querySelectorAll(".table_body_item");

    // Función para normalizar texto
    function normalizeText(text) {
        return text
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .trim();
    }

    // Filtro por texto
    searchInput.addEventListener("input", function () {
        const value = normalizeText(this.value);

        tableItems().forEach(item => {
            let match = false;

            if (typeof role !== "undefined" && role === 3) {
                const folio = normalizeText(item.querySelector(".row_folio")?.textContent || "");
                const fecha = normalizeText(item.querySelector(".row_fecha")?.textContent || "");
                match = folio.includes(value) || fecha.includes(value);
            } else {
                const nombre = normalizeText(item.querySelector(".user_name")?.textContent || "");
                match = nombre.includes(value);
            }

            item.style.display = match ? "" : "none";
        });

        toggleNoResultsMessage();
    });

    // Botón para limpiar búsqueda
    clearInput.addEventListener("click", function () {
        searchInput.value = "";
        tableItems().forEach(item => item.style.display = "");
        toggleNoResultsMessage();
    });

    // Filtros por botones
    const filterButtons = document.querySelectorAll(".btn_filter");
    filterButtons.forEach(button => {
        button.addEventListener("click", function () {
            const filter = this.getAttribute("data-filter");

            tableItems().forEach(item => {
                const estatus = item.querySelector(".row_estatus")?.textContent.toLowerCase();
                const pago = item.classList.contains("row_pendiente");

                if (filter === "pendiente") {
                    item.style.display = estatus === "pendiente" ? "" : "none";
                } else if (filter === "entregado") {
                    item.style.display = estatus === "entregado" ? "" : "none";
                } else if (filter === "incidencias") {
                    item.style.display = pago ? "" : "none";
                } else {
                    item.style.display = "";
                }
            });

            toggleNoResultsMessage();
        });
    });

    function toggleNoResultsMessage() {
        const visibleItems = [...tableItems()].filter(item => item.style.display !== "none");
        const noResults = document.getElementById("noResultsMessage");
        if (noResults) {
            noResults.style.display = visibleItems.length ? "none" : "block";
        }
    }
});
