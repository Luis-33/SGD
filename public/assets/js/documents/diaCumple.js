export function addDiaCumple() {
    var modal = $(".addDiaCumple");
    modal.find(".modal_body").html(
        `<form action="admin_home.php?page=dashboard&action=addDiaCumple" method="POST">
             <div class="input_group date">
                <label>Selecciona el dia que deseas tomar</label>
                <div class="date_container_birthday">
                    <div class="date_input">
                        <span>Día a tomar</span>
                        <input type="date" name="birthday">
                    </div>
                </div>
            </div>

            <button type="submit">Generar dia de cumpleaños</button>
        </form>`
    );

    modal.show();
}