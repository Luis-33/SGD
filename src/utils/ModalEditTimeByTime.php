<?php

require_once MODEL_PATH . "TimebyTimeModel.php";
require_once SERVER_PATH . "DB.php";

function generateModalEditTimeByTime($docID, $folio)
{
    $db = new DB();
    $TimebyTimeModel = new TimebyTimeModel($db);
    $resultados = $TimebyTimeModel->ValidarTimebyTimePagos($docID);

    print_r($resultados);
    $modal = "
    <div class=\"modal timebytimeEdit{$docID}\">
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2>Validar Registro Folio - {$folio}</h2>
                <button onclick=\"closeModal('timebytimeEdit{$docID}')\">Cerrar</button>
            </div>
            <div class=\"modal_body\">
                <form action=\"admin_home.php?page=TimeByTime&action=timebytimeEdit\" method=\"POST\">
                    

                    <div class=\"input_group\">
                        <label>Estatus</label>
                        <div class=\"select_menu\" id=\"updateStatus\">
                            <div class=\"select_btn\">
                                    
                                <i class=\"fa-solid fa-chevron-down\"></i>
                            </div>
                            <ul class=\"options\">
                                <li class=\"option\" data-value=\"Entregado\">
                                    <span>Entregado</span>
                                </li>
                                <li class=\"option\" data-value=\"Pendiente\">
                                    <span>Pendiente</span>
                                </li>
                                <li class=\"option\" data-value=\"Sin Entregar\">
                                    <span>Sin Entregar</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    

                    <button type=\"submit\">Actualizar documento</button>
                </form>
            </div>
        </div>
    </div>
";

    return $modal;
}
