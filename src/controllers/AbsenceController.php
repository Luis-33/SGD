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

    public function viewChain($absenceId)
    {
        $chain = $this->absenceModel->getAbsenceChain($absenceId);

        echo "<h1>Cadena de ausencias para la incapacidad ID: $absenceId</h1>";

        if (!empty($chain)) {
            echo "<table border='1' cellpadding='5' cellspacing='0'>";
            echo "<thead><tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Folio</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Estado</th>
              </tr></thead>";
            echo "<tbody>";
            foreach (array_reverse($chain) as $item) {
                echo "<tr>
                    <td>{$item['absence_id']}</td>
                    <td>" . htmlspecialchars($item['full_name']) . "</td>
                    <td>" . htmlspecialchars($item['folio_number']) . "</td>
                    <td>{$item['start_date']}</td>
                    <td>{$item['end_date']}</td>
                    <td>" . ($item['is_open'] === '1' ? 'Abierto' : 'Cerrado') . "</td>
                  </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No se encontró la cadena de ausencias</p>";
        }
    }

}
?>   