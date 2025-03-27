<?php

require_once MODEL_PATH . 'RolesModel.php';
require_once MODEL_PATH . 'ImssModel.php';
require_once MODEL_PATH . 'UserModel.php';
require_once EMAIL_PATH . 'Exception.php';
require_once EMAIL_PATH . 'PHPMailer.php';
require_once EMAIL_PATH . 'SMTP.PHP';
require_once PDF_PATH . 'library/fpdf.php';
require_once UTIL_PATH . 'Session.php';

class ImssController
{
    private $ImssModel;

    public function __construct($db)
    {
        $this->ImssModel = new ImssModel($db);
    }
    public function showImss($role, $userID)
    {
        $roles = $this->ImssModel->getAllRoles($role, $userID);
        require VIEW_PATH . 'document/imss_list.php';
    }

    public function deleteRol($rolId)
    {
        $response = ['success' => false];
        if ($this->ImssModel->deleteRol($rolId)) {
            $response['success'] = true;
            Session::set('document_success', 'Rol eliminado exitosamente.');
        } else {
            Session::set('document_error', 'Error al eliminar el rol.');
        }
        echo json_encode($response);
        exit;
    }
}
?>   