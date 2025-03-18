<?php

require_once MODEL_PATH . 'DocumentModel.php';
require_once MODEL_PATH . 'CommissionsModel.php';
require_once MODEL_PATH . 'UserModel.php';
require_once EMAIL_PATH . 'Exception.php';
require_once EMAIL_PATH . 'PHPMailer.php';
require_once EMAIL_PATH . 'SMTP.PHP';
require_once PDF_PATH . 'library/fpdf.php';
require_once UTIL_PATH . 'Session.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class CommissionController
{
    private $CommissionsModel;
    public  $table_name = 'comiciones';

    public function __construct($db)
    {
        $this->CommissionsModel = new CommissionsModel($db);
    }


    public function showCommission($role, $userID)
    {
        $documents = $this->CommissionsModel->getAllCommissions($role, $userID);
        require VIEW_PATH . 'document/commission_list.php';

    }

    public function showAllDocuments($role, $userID)
    {
        $documents = $this->CommissionsModel->getAllDocuments($role, $userID);
        require VIEW_PATH . 'document/list.php';
    }

    public function addComision($data) {
        if ($this->CommissionsModel->addComision($data, $this->table_name)) {
            Session::set('user_success', 'Comisión registrada correctamente.');
        } else {
            Session::set('user_error', 'No se pudo registrar la comisión.');
        }
        //echo "<script>$(location).attr('href', 'admin_home.php?page=manage_commissions');</script>";
    }

    public function describeTable($name)
    {
        return $this->CommissionsModel->describeTable($name);

    }

}    