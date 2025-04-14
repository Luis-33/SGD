<?php 
function generateModalDeleteTimeByTime($id) {
    return "
    <div class=\"modal timebytimeDeleteFile{$id}\">
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2>Eliminar archivo</h2>
                <button onclick=\"closeModal('timebytimeDeleteFile{$id}')\">Cerrar</button>
            </div>
            <div class=\"modal_body\">
                <h3>¿Estás seguro de que deseas eliminar este archivo?</h3>
                <form action=\"admin_home.php?page=TimeByTime&action=timebytimeDeleteFile\" method=\"POST\">
                    <input type=\"hidden\" name=\"id\" value=\"$id\" readonly>
                    <button>Eliminar</button>
                    <button onclick=\"closeModal('timebytimeDeleteFile{$id}')\">Cancelar</button>
                </form>
            </div>
        </div>
    </div>";
}
?>