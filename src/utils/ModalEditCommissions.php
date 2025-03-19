<?php

require_once MODEL_PATH . "CommissionsModel.php";
require_once SERVER_PATH . "DB.php";

function generateModalEditComision($id)
{
    
    $db = new DB();
    $CommissionsModel = new CommissionsModel($db);
    $Commissions = $CommissionsModel->getCommissionsById($id);

    $modal = "
    <div class=\"modal editCommissions\"> 
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2>Actualizar comision</h2>
                <button onclick=\"closeModal('editCommissions')\">Cerrar</button> 
            </div>
            <div class=\"modal_body\">
                <form action=\"admin_home.php?page=commissions&action=editCommissions\" method=\"POST\">
                $id
                    <input type=\"hidden\" name=\"id\" value=\"{$Commissions['id']}\">
                        <div class=\"input_group\">
                            <label>Adjuntar documento</label>
                            <input type=\"file\" name=\"pdf\">
                            <input type=\"hidden\" name=\"pdf\" id=\"pdf\">
                        </div>
                        
                    <input type=\"hidden\" name=\"CommissionsoEstatus\" id=\"estatus\" value=\"{$Commissions['status']}\">

                    <button type=\"submit\">Actualizar Commissionso</button>
                </form>
            </div>
        </div>
    </div>
";

    return $modal;
}
