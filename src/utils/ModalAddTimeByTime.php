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
                <form action=\"admin_home.php?page=TimeByTime&action=addDocument\" method=\"POST\" enctype=\"multipart/form-data\">
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
                    <label for=\"num_registros\">Cantidad de registros a ingresar</label>
                    <input type=\"number\" id=\"num_registros\" name=\"num_registros\" min=\"1\" max=\"10\" onchange=\"generateFields(this.value)\">
                </div>
                <div id=\"dynamic_fields\"></div>
                <button type=\"submit\">Guardar</button>
           
            </div>
        </div>
    </div>";

    echo $modal;
}

?>

<script>
function generateFields(num) {
    const container = document.getElementById('dynamic_fields');
    container.innerHTML = '';
    for (let i = 0; i < num; i++) {
        const fieldSet = document.createElement('div');
        fieldSet.className = 'input_group';
        fieldSet.innerHTML = `
            <table>
                <tr>
                    <td>
                        <label for=\"fecha_falta_${i}\">Fecha de falta</label>
                        <input type=\"date\" id=\"fecha_falta_${i}\" name=\"fecha_falta_${i}\">
                        <label for=\"horas_falta_${i}\">Cantidad de horas de falta</label>
                        <input type=\"number\" id=\"horas_falta_${i}\" name=\"horas_falta_${i}\" step=\"0.01\">
                    </td>
                    <td>
                        <div id=\"pagos_${i}\">
                            <label for=\"fecha_pago_${i}_0\">Fecha de pago</label>
                            <input type=\"date\" id=\"fecha_pago_${i}_0\" name=\"fecha_pago_${i}[]\">
                            <label for=\"horas_pago_${i}_0\">Cantidad de horas a pagar</label>
                            <input type=\"number\" id=\"horas_pago_${i}_0\" name=\"horas_pago_${i}[]\" step=\"0.01\">
                            <button type=\"button\" onclick=\"addPaymentField(${i})\">Agregar pago</button>
                        </div>
                    </td>
                </tr>
                </form>
            </table>
        `;
        container.appendChild(fieldSet);
    }
}

function addPaymentField(index) {
    const pagosContainer = document.getElementById(`pagos_${index}`);
    const numPagos = pagosContainer.querySelectorAll('input[type="date"]').length;
    const newPaymentField = document.createElement('div');
    newPaymentField.innerHTML = `
        <label for=\"fecha_pago_${index}_${numPagos}\">Fecha de pago</label>
        <input type=\"date\" id=\"fecha_pago_${index}_${numPagos}\" name=\"fecha_pago_${index}[]\">
        <label for=\"horas_pago_${index}_${numPagos}\">Cantidad de horas a pagar</label>
        <input type=\"number\" id=\"horas_pago_${index}_${numPagos}\" name=\"horas_pago_${index}[]\" step=\"0.01\">
    `;
    pagosContainer.appendChild(newPaymentField);
}
</script>