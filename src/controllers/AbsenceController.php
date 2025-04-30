<?php

require_once MODEL_PATH . 'RolesModel.php';
require_once MODEL_PATH . 'absenceModel.php';
require_once MODEL_PATH . 'UserModel.php';
require_once EMAIL_PATH . 'Exception.php';
require_once EMAIL_PATH . 'PHPMailer.php';
require_once EMAIL_PATH . 'SMTP.PHP';
require_once PDF_PATH . 'library/fpdf.php';
require_once UTIL_PATH . 'Session.php';

class AbsenceController
{
    private $absenceModel;
    private $userModel;

    public function __construct($db)
    {
        $this->absenceModel = new absenceModel($db);
        $this->userModel = new UserModel($db);
    }
    public function show()
    {
        $return_data = $this->absenceModel->getAll();
        $users = $this->userModel->getAll();

        require VIEW_PATH . 'document/absence_list.php';
    }

    public function remove($id)
    {
        if ($this->absenceModel->delete($id)) {
            Session::set('document_success', 'Incapacidad eliminada exitosamente.');
            header('Location: admin_home.php?page=absences');
        } else {
            Session::set('document_error', 'Error al eliminar la incapacidad.');
        }
    }

    public function save($data){
        if ($this->absenceModel->save($data)) {
            Session::set('document_success', 'Incapacidad guardada exitosamente.');
            header('Location: admin_home.php?page=absences');
        } else {
            Session::set('document_error', 'Error al guardar la incapacidad.');
        }
    }
}
?>   