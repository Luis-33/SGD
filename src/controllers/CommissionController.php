<?php

require_once MODEL_PATH . 'DocumentModel.php';
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
    private $documentModel;

    public function __construct($db)
    {
        $this->documentModel = new DocumentModel($db);
    }


    public function showCommission($role, $userID)
    {
        $documents = $this->documentModel->getAllDocuments($role, $userID);
        require VIEW_PATH . 'document/commission_list.php';

    }
}    