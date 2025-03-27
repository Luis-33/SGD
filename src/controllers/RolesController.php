<?php

require_once MODEL_PATH . 'RolesModel.php';
require_once MODEL_PATH . 'UserModel.php';
require_once EMAIL_PATH . 'Exception.php';
require_once EMAIL_PATH . 'PHPMailer.php';
require_once EMAIL_PATH . 'SMTP.PHP';
require_once PDF_PATH . 'library/fpdf.php';
require_once UTIL_PATH . 'Session.php';

class RolesController
{
    private $rolModel;

    public function __construct($db)
    {
        $this->rolModel = new RolesModel($db);
    }
    public function showRoles($role, $userID)
    {
        $roles = $this->rolModel->getAllRoles($role, $userID);
        require VIEW_PATH . 'document/roles_list.php';
    }

    public function deleteRol($rolId)
    {
        $response = ['success' => false];
        if ($this->rolModel->deleteRol($rolId)) {
            $response['success'] = true;
            Session::set('document_success', 'Rol eliminado exitosamente.');
        } else {
            Session::set('document_error', 'Error al eliminar el rol.');
        }
        echo json_encode($response);
        exit;
    }
}