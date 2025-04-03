
<?php

require_once MODEL_PATH . "UserModel.php";
require_once SERVER_PATH . "DB.php";

function generateModalDocumentForTime()
{

    $modal = "
    <div class=\"modal timebytime\">
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2>Subir documentos</h2>
                <button onclick=\"closeModal('timebytime')\">Cerrar</button>
            </div>
            <div class=\"modal_body\">
                <form action=\"admin_home.php?page=TimeByTime&action=timebytime\" method=\"POST\" enctype=\"multipart/form-data\">
                <div class=\"input_group\">
                    <label for=\"empleado\">Empleado</label>
                    <div class=\"select_menu\" id=\"empleado\">
                        <div class=\"select_btn\">
                            <span class=\"sBtn_text\">Selecciona al empleado</span>
                            <i class=\"fa-solid fa-chevron-down\"></i>
                        </div>
                        <ul class=\"options\">";

    $db = new DB();
    $userModel = new UserModel($db);
    $usersList = $userModel->getUsersList();

    foreach ($usersList as $usuario) {
        $modal .= "<li class=\"option\" data-value=\"" . $usuario["usuario_id"] . "\">
                       " . (empty($usuario["usuario_foto"]) ? '<img src="assets/images/avatar.png">' : '<img src="data:image;base64,' . base64_encode($usuario['usuario_foto']) . '" >') . "
                       <span>" . $usuario["usuario_nombre"] . "</span>
                   </li>";
    }

    $modal .= "
                        </ul>
                    </div>
            </div>

            <div class=\"input_group\">
                <label for=\"fechaR\">Fecha de registro:</label>
                <input type=\"date\" id=\"fechaR\" name=\"fechaR\" required>
            </div>

            <div class=\"input_group\">
                <label for=\"folio\">Folio:</label>
                <input type=\"text\" id=\"folio\" name=\"folio\" required pattern=\"[0-9]+\" 
                oninput=\"this.value = this.value.replace(/[^0-9]/g, '')\" title=\"Solo se permiten números del 0 al 9\">

            </div>

            <div class=\"input_group\">
                <label for=\"num_registros\">Faltas a registrar</label>
                <input type=\"number\" id=\"num_registros\" name=\"num_registros\" min=\"1\" onchange=\"generateFaltas(this.value)\" 
                required pattern=\"[0-9]+\" oninput=\"this.value = this.value.replace(/[^0-9]/g, '')\" title=\"Solo se permiten números del 0 al 9\"> 
            </div>
            
            <div id=\"Falatas\"></div>

            <div class=\"input_group\">
                <label for=\"num_registros\">Dias a pagar </label>
                <input type=\"number\" id=\"num_registros\" min=\"1\" onchange=\"generatePagos(this.value)\" 
                required pattern=\"[0-9]+\" oninput=\"this.value = this.value.replace(/[^0-9]/g, '')\" title=\"Solo se permiten números del 0 al 9\"> 
            </div>

            <div id=\"Pagos\"></div>
           
                        
            <input type=\"hidden\" name=\"usuario_id\" id=\"user\">
            <button class=\"insert_documento_btn\">Subir documento</button>
            </form>
        </div>
    </div>
</div>

<script>
function generateFaltas(num) {
    let container = document.getElementById('Falatas');
    container.innerHTML = ''; // Limpiar contenido previo
    
    for (let i = 0; i < num; i++) {
        let row = document.createElement('div');
        row.classList.add('record_row');
        row.innerHTML = `
            <div class=\"input_group\">
                <label>Fecha de falta</label>
                <input type=\"date\" name=\"fechaF[]\" required>
            </div>
            <div class=\"input_group\">
                <label>Horas de falta</label>
                <input type=\"number\" name=\"horasF[]\" min=\"1\" required pattern=\"[0-9]+\" 
                oninput=\"this.value = this.value.replace(/[^0-9]/g, '')\" title=\"Solo se permiten números del 0 al 9\">
            </div>
        `;
        container.appendChild(row);
    }
}

function generatePagos(num) {
    let container = document.getElementById('Pagos');
    container.innerHTML = ''; // Limpiar contenido previo
    
    for (let i = 0; i < num; i++) {
        let row = document.createElement('div');
        row.classList.add('record_row');
        row.innerHTML = `
            <div class=\"input_group\">
                <label>Fecha de falta</label>
                <input type=\"date\" name=\"fechaP[]\" required>
            </div>
            <div class=\"input_group\">
                <label>Horas de falta</label>
                <input type=\"number\" name=\"horasP[]\" min=\"1\" required pattern=\"[0-9]+\" 
                oninput=\"this.value = this.value.replace(/[^0-9]/g, '')\" title=\"Solo se permiten números del 0 al 9\">
            </div>
        `;
        container.appendChild(row);
    }
}


//Menu desplegable para usuarios
$(document).ready(function () {
    $(document).on(\"click\", \".select_menu .select_btn\", function () {
        $(this).closest(\".select_menu\").toggleClass(\"active\");
    });

    $(document).on(\"click\", \".options .option\", function (e) {
        e.stopPropagation();

        $(this).closest('.options').find('.option').removeClass('selected');
        $(this).addClass('selected');

        let selectedOption = $(this).find(\"h3, span\").first().text();
        let selectedValue = $(this).data('value');

        $(this).closest(\".select_menu\").find(\".sBtn_text\").text(selectedOption);
        $(this).closest(\".select_menu\").toggleClass(\"active\");

        if ($(this).closest('.select_menu').attr('id') === 'empleado') {
            $('#user').val(selectedValue);
        }
    });
});


</script>

";

    return $modal;
}
