<?php

require_once MODEL_PATH . 'DocumentModel.php';
require_once MODEL_PATH . 'CommissionsModel.php';
require_once MODEL_PATH . 'UserModel.php';
require_once EMAIL_PATH . 'Exception.php';
require_once EMAIL_PATH . 'PHPMailer.php';
require_once EMAIL_PATH . 'SMTP.PHP';
require_once PDF_PATH . 'library/fpdf.php';
require_once UTIL_PATH . 'Session.php';

use FontLib\Table\Type\head;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class CommissionController
{
    private $CommissionsModel;
    public  $table_name = 'comisiones';

    public function __construct($db)
    {
        $this->CommissionsModel = new CommissionsModel($db);
    }


    public function showCommission($role, $userID)
    {
        $documents = $this->CommissionsModel->getAllCommissions($role, $userID, $this->table_name);
        require VIEW_PATH . 'document/commission_list.php';

    }

    public function addComision($data) {
        if ($this->CommissionsModel->addComision($data, $this->table_name)) {
            Session::set('user_success', 'Comisión registrada correctamente.');
        } else {
            Session::set('user_error', 'No se pudo registrar la comisión.');
        }
    }

    public function updateCommission($data) {
        if ($this->CommissionsModel->updateComision($data, $this->table_name)) {
            Session::set('user_success', 'Comisión registrada correctamente.');
        } else {
            Session::set('user_error', 'No se pudo registrar la comisión.');
        }
    }

    public function describeTable($name)
    {
        return $this->CommissionsModel->describeTable($name);

    }

    public function downloadDCommission($id)
    {
        $Commision = $this->CommissionsModel->getCommissionsById($id);

        if ($Commision && isset($Commision['pdf'])) {
            $pdfContent = $Commision['pdf']; 
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="documento.pdf"');
            header('Content-Length: ' . strlen($pdfContent));
            echo $pdfContent;
            exit;
        } else {
            echo '<h1>Error</h1>';
            echo '<p>No se encontró la comisión solicitada o el archivo PDF.</p>';
            exit;
        }
    }
}