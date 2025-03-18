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

    public function generarRegistro($userID, $fechaF, $horaF, $fechaP, $horaP)
    {
        if ($this->TimeByTimeModel->create($userID, $fechaF, $horaF, $fechaP, $horaP)) {
            Session::set('document_success', 'Documento creado correctamente.');
        } else {
            Session::set('document_error', 'No se pudo crear el documento.');
        }
        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
    }
    
    public function showTimeByTime($role, $userID)
    {
        $documents = $this->TimeByTimeModel->getAllDocuments($role, $userID);
        require VIEW_PATH . 'TimeByTime/list.php';

    }
}    