export function addDiaEconomico() {
    var modal = $(".addDiaEconomico");
    modal.find(".modal_body").html(`
    <form action="admin_home.php?page=dashboard&action=addDiaEconomico" method="POST">
        <div class="input_group checkbox">
            <label>Selecciona el tipo de permiso</label>
            <div class="chip_container">
                <div class="chip" name="permiso-programado" data-value="permiso-programado">
                    <i class="fa-solid fa-circle-dot"></i>
                    Permiso programado
                </div>
                <div class="chip" name="permiso-fortuito" data-value="permiso-fortuito">
                    <i class="fa-solid fa-circle-dot"></i>
                    Permiso fortuito
                </div>
            </div>
        </div>
    
        <div class="input_group date">
            <label>Dias de ausencia</label>
                <div class="date_container">
                    <div class="date_input">
                        <span>Fecha de inicio</span>
                        <input type="date" name="start-date" disabled>
                    </div>
                    <div class="date_input">
                        <span>Fecha de regreso</span>
                        <input type="date" name="end-date" disabled>
                    </div>
                </div>
        </div>

        <input type="hidden" name="permiso" id="permiso" value="">
        <button type="submit">Generar dia económico</button>
    </form>
    `);

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('chip')) {
            const chips = document.querySelectorAll('.chip');
            chips.forEach(c => {
                c.classList.remove('selected');
            });

            event.target.classList.add('selected');

            const selectedChipValue = event.target.getAttribute('data-value');
            document.querySelector('#permiso').value = selectedChipValue;

            const startDateInput = document.querySelector('input[name="start-date"]');
            const endDateInput = document.querySelector('input[name="end-date"]');

            function limpiarInputsDeFecha() {
                startDateInput.value = '';
                endDateInput.value = '';
            }

            const today = new Date().toISOString().split('T')[0];

            if (selectedChipValue === 'permiso-programado') {
                startDateInput.removeAttribute('disabled');
                endDateInput.removeAttribute('disabled');
                limpiarInputsDeFecha();
                startDateInput.setAttribute('min', today);
                startDateInput.removeAttribute('max');
                endDateInput.setAttribute('min', today);
                endDateInput.removeAttribute('max');
            } else if (selectedChipValue === 'permiso-fortuito') {
                startDateInput.removeAttribute('disabled');
                endDateInput.removeAttribute('disabled');
                limpiarInputsDeFecha();
                startDateInput.setAttribute('max', today);
                startDateInput.removeAttribute('min');
                endDateInput.setAttribute('max', today);
                endDateInput.removeAttribute('min');
            }
        }
    });

    modal.show();
}
