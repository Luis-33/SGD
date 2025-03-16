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
    //private $documentModel;
    private $CommissionsModel;

    public function __construct($db)
    {
        //$this->documentModel = new DocumentModel($db);
        $this->CommissionsModel = new CommissionsModel($db);
    }


    public function showCommission($role, $userID)
    {
        //$commissions = $this->CommissionsModel->getAllCommissions($role, $userID);
        $documents = $this->CommissionsModel->getAllCommissions($role, $userID);
//         echo "<pre>";
// print_r($commissions);
// echo "</pre>";
// die();
        require VIEW_PATH . 'document/commission_list.php';

    }

    public function showAllDocuments($role, $userID)
    {
        $documents = $this->CommissionsModel->getAllDocuments($role, $userID);
        require VIEW_PATH . 'document/list.php';
    }


    // public function addCommission()
    // {
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $data = [
    //             'fecha_elaboracion' => date("Y-m-d"),
    //             'usuario_id' => $_POST["user"],
    //             'lugar' => $_POST["lugar"],
    //             'asunto' => $_POST["asunto"],
    //             'viaticos' => $_POST["viaticos"],
    //             'especificacion_viaticos' => $_POST["especificacion_viaticos"] ?? null,
    //             'observaciones' => $_POST["observaciones"] ?? "",
    //             'fecha_salida' => $_POST["fecha_salida"],
    //             'fecha_regreso' => $_POST["fecha_regreso"],
    //             'transporte_propio' => $_POST["transporte_propio"] ?? 'No',
    //             'marca' => $_POST["marca"] ?? null,
    //             'modelo' => $_POST["modelo"] ?? null,
    //             'color' => $_POST["color"] ?? null,
    //             'placas' => $_POST["placas"] ?? null,
    //             'transporte' => isset($_POST["transporte"]) && $_POST["transporte"] == "Si" ? 1 : 0,
    //             'kilometraje' => $_POST["kilometraje"] ?? null,
    //             'status' => $_POST["status"] ?? 'Pendiente',
    //         ];

    //         if ($this->CommissionsModel->insertCommission($data)) {
    //             Session::set('commission_success', 'Comisión guardada con éxito.');
    //         } else {
    //             Session::set('commission_error', 'Error al guardar la comisión.');
    //         }

    //         header("Location: admin_home.php?page=dashboard");
    //         exit();
    //     }
    // }


}    