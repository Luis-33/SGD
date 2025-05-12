<?php

require_once MODEL_PATH . "ConfigModel.php";
require_once MODEL_PATH . "UserModel.php";
require_once SERVER_PATH . "DB.php";

function generateModalexceldiaseco()
{
    $db = new DB();
    $configModel = new ConfigModel($db);

    $modal = "
    <div class=\"modal exceldiaseco\">
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2>Cargar Días Económicos Masivo</h2>
                <button onclick=\"closeModal('exceldiaseco')\">Cerrar</button>
            </div>
            <div class=\"modal_body\">
                <form id=\"uploadExcelForm\"  admin_home.php?page=manage_users&action=addUser\"http://localhost/SGD/public/admin_home.php\" method=\"POST\" enctype=\"multipart/form-data\">
                    
                    <!-- Botón para descargar plantilla de CSV -->
                    <div class=\"input_group\">
                        <label>Descargar plantilla</label>
                        <a href=\"data:text/csv;charset=utf-8,Nombre,Numero%20Nomina,Dias%20Economicos\" 
                           class=\"btn_download\" 
                           download=\"plantilla_dias_economicos.csv\">
                           Descargar plantilla
                        </a>
                    </div>

                    <!-- Campo para adjuntar archivo CSV -->
                    <div class=\"input_group\">
                        <label for=\"excelFile\">Selecciona un archivo CSV</label>
                        <input type=\"file\" name=\"excelFile\" id=\"csvFile\" accept=\".csv\" required>
                    </div>

                    <div class=\"modal_actions\">
                        <button type=\"submit\" class=\"btn_confirm\">Cargar</button>
                        <button type=\"button\" onclick=\"closeModal('exceldiaseco')\" class=\"btn_cancel\">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript para manejar el modal
        $(document).ready(function () {
            $('#uploadExcelForm').on('submit', function(event) {
                const fileInput = $('#excelFile').val().trim();
                if (!fileInput) {
                    event.preventDefault();
                    alert('Por favor, selecciona un archivo CSV antes de enviar.');
                }
            });
        });
    </script>
    ";

    return $modal;
}
