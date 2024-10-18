export function addDiaCumple() {
    var modal = $(".addDiaCumple");
    modal.find(".modal_body").html(
        `<form action="admin_home.php?page=dashboard&action=addDiaCumple" method="POST">
            <button type="submit">Generar dia de cumpleaños</button>
        </form>`
    );

    modal.show();
}