export function addDiaCumple() {
    const publicHolidays = [
        '01-01', // New Year's Day
        '02-05', // Constitution Day
        '03-21', // Benito Juárez's birthday
        '05-01', // Labor Day
        '09-16', // Independence Day
        '11-02', // Day of the Dead
        '11-20', // Revolution Day
        '12-25'  // Christmas Day
    ];

    function isNonWorkingDay(date) {
        const day = date.getDay();
        const formattedDate = date.toISOString().slice(5, 10);

        // Check if the day is Saturday (6) or Sunday (0)
        if (day === 0 || day === 6) {
            return true;
        }

        // Check if the date is a public holiday
        if (publicHolidays.includes(formattedDate)) {
            return true;
        }

        return false;
    }

    const today = new Date();
    let dateInputHtml = '';

    if (!isNonWorkingDay(today)) {
        dateInputHtml = `
            <div class="date_container_birthday">
                <div class="date_input">
                    <label for="before">Dia antes</label>
                    <input type="radio" name="dayOption" id="before" value="before">
                    
                    <label for="after">Dia despues</label>
                    <input type="radio" name="dayOption" id="after" value="after">
                </div>
            </div>
        `;
    }

    var modal = $(".addDiaCumple");
    modal.find(".modal_body").html(
        `<form action="admin_home.php?page=dashboard&action=addDiaCumple" method="POST">
             <div class="input_group date">
                <label>Selecciona el dia que deseas tomar</label>
                ${dateInputHtml}
            </div>

            <button type="submit">Generar dia de cumpleaños </button>
        </form>`
    );

    modal.show();
}