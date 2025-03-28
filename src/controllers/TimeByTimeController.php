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

    public function showTimeByTime($role, $userID)
    {
        $registros = $this->TimeByTimeModel->getAllDocuments($role, $userID);
        require VIEW_PATH . 'TimeByTime/list.php';

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

        // Calculamos la suma de los valores de ambos arrays
        $sumaHorasF = array_sum($horasF);  // Suma de los valores de $horasF
        $sumaHorasP = array_sum($horasP);  // Suma de los valores de $horasP

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
                Session::set('document_warning', 'Error al generar el registro, no puede omitir ningun campo.');
                echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                return;
            }
        }
        
        // Validación: Verificar que el folio no exista en la base de datos
        if ($this->TimeByTimeModel->existeFolio($folio)) {
            Session::set('document_warning', 'El folio ingresado ya existe en la base de datos.');
            echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            return;
        }

        // Validacion: Verifica que el total de horas falta coincida con el total de horas pago
        if ($sumaHorasF !== $sumaHorasP) {
            // Si las sumas no son iguales, se marca el error
            Session::set('document_warning', 'La suma de las horas finales debe coincidir con la suma de las horas programadas.');
            echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            exit; // Detenemos la ejecución
        }

    
        // Intentar generar el registro
        if ($result = $this->TimeByTimeModel->generarRegistro(
            $user_ID, $folio, $fechaR, $num_registros, $fechasF, $horasF, $fechasP, $horasP, $estatus, $estatusP)) {
            Session::set('document_success', 'Registro generado correctamente.');
        } else {
            Session::set('document_warning', 'Error al generar el registro, por favor intente nuevamente.');
        }
        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
    }
    
    
    public function updateTimebyTimePagos ($data)
    {
        
    }
}    