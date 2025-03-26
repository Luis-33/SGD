<?php

require_once MODEL_PATH . 'TimeByTimeModel.php';
require_once MODEL_PATH . 'UserModel.php';
require_once EMAIL_PATH . 'Exception.php';
require_once EMAIL_PATH . 'PHPMailer.php';
require_once EMAIL_PATH . 'SMTP.PHP';
require_once PDF_PATH . 'library/fpdf.php';
require_once UTIL_PATH . 'Session.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class TimeByTimeController
{
    private $TimeByTimeModel;

    public function __construct($db)
    {
        $this->TimeByTimeModel = new TimeByTimeModel($db);
    }

    public function generarRegistro($data) {
        $user_ID = intval($data["usuario_id"]);
        $num_registros = intval($data["num_registros"]);
        $folio = $data["folio"];
        $fechaR = $data["fechaR"];
        $fechasF = $data["fechaF"];
        $horasF = $data["horasF"];
        $fechasP = $data["fechaP"];
        $horasP = $data["horasP"];
        $estatus = 'pendiente';
        $estatusP = 0;
    
        // Validación de campos obligatorios
        $campos_obligatorios = [
            "user_ID" => $user_ID,
            "num_registros" => $num_registros,
            "folio" => $folio,
            "fechaR" => $fechaR,
            "fechasF" => $fechasF,
            "horasF" => $horasF,
            "fechasP" => $fechasP,
            "horasP" => $horasP
        ];
    
        foreach ($campos_obligatorios as $campo => $valor) {
            if (empty($valor) && $valor !== 0) {
                Session::set('registro_warning', 'Error al generar el registro, no puede omitir ningun campo.');
                return;
            }
        }
    
        // Intentar generar el registro
        $result = $this->TimeByTimeModel->generarRegistro(
            $user_ID, $folio, $fechaR, $num_registros, $fechasF, $horasF, $fechasP, $horasP, $estatus, $estatusP
        );
    
        if ($result) {
            Session::set('registro_success', 'Registro generado correctamente.');
        } else {
            Session::set('registro_warning', 'Error al generar el registro, por favor intente nuevamente.');
        }
    
        require VIEW_PATH . 'TimeByTime/list.php';
    }
    
    
    public function showTimeByTime($role, $userID)
    {
        $documents = $this->TimeByTimeModel->getAllDocuments($role, $userID);
        require VIEW_PATH . 'TimeByTime/list.php';

    }
}    