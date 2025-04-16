<?php

require_once MODEL_PATH . "TimebyTimeModel.php";
require_once SERVER_PATH . "DB.php";

function generateModalEditTimeByTime($docID, $folio)
{
    $db = new DB();
    $TimebyTimeModel = new TimebyTimeModel($db);
    $resultados = $TimebyTimeModel->getValidationRegistro($docID);
    
    $faltas = $resultados['faltas'];
    $pagos = $resultados['pagos'];
    
    $fechasFaltas = array_column($faltas, 'fechaF');
    $horasFaltas = array_column($faltas, 'horasF');
    $totalHorasFaltas = array_sum($horasFaltas);
    $totalHorasPagosMarcados = array_sum(array_map(function($pago) {
        return ($pago['estatusP'] == 1) ? $pago['horaP'] : 0;
    }, $pagos));

    // Modal con ID único
    $modal = "
    <div class=\"modal timebytimeEdit{$docID}\">
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2>Validar Registro Folio - {$folio}</h2>
                <button onclick=\"closeModal('timebytimeEdit{$docID}')\">Cerrar</button>
            </div>
            <div class=\"modal_body\">
                <form action=\"admin_home.php?page=TimeByTime&action=timebytimeEdit\" method=\"POST\">
                    <input type=\"hidden\" name=\"docID\" value=\"{$docID}\">
                    
                    <!-- 📌 Mostrar fechas de falta y total de horas faltadas -->
                    <div class=\"faltas_info\">
                        <label><strong>Días de falta:</strong> " . implode(' - ', $fechasFaltas) . "</label>
                        <label><strong>Total de horas faltadas:</strong> <span id=\"totalHorasFaltas{$docID}\">{$totalHorasFaltas}</span></label>
                    </div>

                    <!-- 📌 Tabla para mostrar pagos -->
                    <table border=\"1\">
                        <thead>
                            <tr>
                                <th>Fecha de Pago</th>
                                <th>Horas</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>";
    
    foreach ($pagos as $index => $pago) {
        $checkboxId = "checkbox_{$docID}_{$index}"; // ID único para el checkbox

        // Si el checkbox está marcado en el inicio, ajustamos el valor
        $isChecked = ($pago['estatusP'] == 1) ? 'checked' : ''; // Si estatusP es 1, marcar el checkbox
        $hiddenValue = ($pago['estatusP'] == 1) ? 1 : 0; // Si estatusP es 1, el hidden será 1, de lo contrario 0
       
        $modal .= "
                            <tr>
                                <td>{$pago['fechaP']}</td>
                                <td class=\"horaP\">{$pago['horaP']}</td>
                                <td>
                                    <!-- Campo Hidden con valor 1 si está marcado, 0 si no -->
                                    <input type=\"hidden\" name=\"estatusP_{$pago['id']}\" value=\"{$hiddenValue}\">
                                    <input type=\"checkbox\" id=\"{$checkboxId}\" class=\"estatusP\" data-horas=\"{$pago['horaP']}\"{$isChecked}>
                                </td>
                            </tr>";
    }
    
    $modal .= "
                        </tbody>
                    </table>
                    
                    <!-- 📌 Mostrar total de horas pagadas -->
                    <label><strong>Total de horas pagadas:</strong> <span id=\"totalHorasPagos{$docID}\">{$totalHorasPagosMarcados}</span></label>
                    
                    <button type=\"submit\">Actualizar documento</button>
                </form>
            </div>
        </div>
    </div>";

    $modal .= "
    <script>
    document.addEventListener(\"DOMContentLoaded\", function() {
        function actualizarTotalHoras(idTotalHoras, modalSelector) {
            let totalHoras = 0;
            const totalHorasElement = document.getElementById(idTotalHoras);

            if (!totalHorasElement) {
                console.error(\"No se encontró el elemento con ID:\", idTotalHoras);
                return;
            }

            // Buscar solo checkboxes dentro del modal actual
            document.querySelectorAll(modalSelector + \" .estatusP:checked\").forEach(function(checkbox) {
                totalHoras += parseFloat(checkbox.dataset.horas) || 0;
            });

            // Actualizar el total de horas en la interfaz
            totalHorasElement.textContent = totalHoras.toFixed(2);
        }

        document.querySelectorAll(\".modal\").forEach(function(modal) {
            // Solo continuar si el modal tiene alguna clase que empieza con 'timebytimeEdit'
            const timebyClass = Array.from(modal.classList).find(c => c.startsWith(\"timebytimeEdit\"));
        
            if (timebyClass) {
                const docID = timebyClass.replace(\"timebytimeEdit\", \"\"); // Extraer el docID

                // Al abrir el modal, calcular el total de horas automáticamente
                actualizarTotalHoras(\"totalHorasPagos\" + docID, \".timebytimeEdit\" + docID);

                modal.querySelectorAll(\".estatusP\").forEach(function(checkbox) {
                    checkbox.addEventListener(\"change\", function() {
                        actualizarTotalHoras(\"totalHorasPagos\" + docID, \".timebytimeEdit\" + docID);

                        // Obtener el campo hidden asociado al checkbox
                        var hiddenInput = this.previousElementSibling;
                        hiddenInput.value = this.checked ? 1 : 0;
                    });
                });
            }
        });

    });
    </script>";


    return $modal;
}
?>
