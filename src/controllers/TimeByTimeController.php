<?php

require_once MODEL_PATH . 'TimeByTimeModel.php';
require_once MODEL_PATH . 'UserModel.php';
require_once UTIL_PATH . 'Session.php';

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

    public function generarRegistro($data)
    {

        $user_ID = isset($data["usuario_id"]) ? intval($data["usuario_id"]) : null;
        $num_registros = isset($data["num_registros"]) ?  intval($data["num_registros"]): null;
        $folio = isset($data["folio"]) ? trim($data["folio"]) : null;
        $fechaR = isset($data["fechaR"]) ? trim($data["fechaR"]) : null;
        $fechasF = isset($data["fechaF"]) ? $data["fechaF"] : null;
        $horasF = isset($data["horasF"]) ? $data["horasF"] : null;
        $fechasP = isset($data["fechaP"]) ? $data["fechaP"] : null;
        $horasP = isset($data["horasP"])? $data["horasP"] : null;
        $estatus = 'pendiente';
        $estatusP = 1;

        // Array asociativo para validar los campos obligatorios
        $campos_obligatorios = [
            "usuario" => ["valor" => $user_ID, "tipo" => "int"],
            "numero_de_Registros" => ["valor" => $num_registros, "tipo" => "int"],
            "folio" => ["valor" => $folio, "tipo" => "string"],
            "fecha_de_Registro" => ["valor" => $fechaR, "tipo" => "date"],
            "fechas_de_falta" => ["valor" => $fechasF, "tipo" => "array"],
            "horas_de_falta" => ["valor" => $horasF, "tipo" => "array"],
            "fechas_de_pago" => ["valor" => $fechasP, "tipo" => "array"],
            "horas_de_pago" => ["valor" => $horasP, "tipo" => "array"]
        ];
        // Validación de campos obligatorios
        // Recorre el array asociativo y valida cada campo
        foreach ($campos_obligatorios as $campo => $info) {
            $valor = $info["valor"];
            $tipo = $info["tipo"];
        
            if ($valor === null) {
                Session::set('document_warning', "Error: el campo {$campo} es obligatorio.");
                echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                exit;
            }
            // Validación del tipo de dato
            switch ($tipo) {
                case "int":
                    if (!is_int($valor)) {
                        Session::set('document_warning', "Error: el campo {$campo} debe ser un número entero.");
                        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                        exit;
                    }
                    break;
        
                case "string":
                    if (!is_string($valor) || empty(trim($valor))) {
                        Session::set('document_warning', "Error: el campo {$campo} debe ser una cadena de texto.");
                        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                        exit;
                    }
                    break;
        
                case "date":
                    if (!DateTime::createFromFormat('Y-m-d', $valor)) {
                        Session::set('document_warning', "Error: el campo {$campo} debe ser una fecha válida.");
                        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                        exit;
                    }
                    break;
        
                case "array":
                    if (!is_array($valor) || empty($valor)) {
                        Session::set('document_warning', "Error: el campo {$campo} debe ser un array.");
                        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                        exit;
                    }
                    break;
            }
            // Validación de fechas (únicas y válidas)
            if (in_array($campo, ["fechas_de_falta", "fechas_de_pago"])) {
                $total_original = count($valor);
                $valor = array_unique($valor); // Eliminar duplicados
                $total_sin_duplicados = count($valor);
            
                // Verificar si había duplicados
                if ($total_original !== $total_sin_duplicados) {
                    Session::set('document_warning', "Error: el campo {$campo} contiene fechas duplicadas.");
                    echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                    exit;
                }
                // Validar que todas las fechas sean válidas
                foreach ($valor as $item) {
                    if (!DateTime::createFromFormat('Y-m-d', $item)) {
                        Session::set('document_warning', "Error: el campo {$campo} debe contener solo fechas válidas y únicas.");
                        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                        exit;
                    }
                }
            }
        
            // Validación de los arrays de horas contengan enteros
            if (in_array($campo, ["horas_de_falta", "horas_de_pago"])) {
                foreach ($valor as $item) {
                    if (filter_var($item, FILTER_VALIDATE_INT) === false) {
                        Session::set('document_warning', "Error: el campo {$campo} debe contener solo valores enteros.");
                        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                        exit;
                    }
                }
            }
                  
        }

        //Validación: saber si el folio ya existe en la base de datos
        if ($this->TimeByTimeModel->existeFolio($folio)) {
            Session::set('document_warning', 'El folio ingresado ya existe en la base de datos.');
            echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            exit;
        }
        // Validación: la suma de horas finales debe coincidir con la suma de horas programadas
        $sumaHorasF = array_sum($horasF);
        $sumaHorasP = array_sum($horasP);

        if ($sumaHorasF !== $sumaHorasP) {
            Session::set('document_warning', "La suma de las horas de asusencia {$sumaHorasF} debe coincidir con la suma de las horas a pagar {$sumaHorasP}.");
            echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            exit;
        }

        if ($this->TimeByTimeModel->generarRegistro(
            $user_ID, $folio, $fechaR, $num_registros, $fechasF, $horasF, $fechasP, $horasP, $estatus, $estatusP
        )) {
            Session::set('document_success', 'Registro generado correctamente.');
        } else {
            Session::set('document_warning', 'Error al generar el registro, por favor intente nuevamente.');
        }

        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
    }

    public function updateTimebyTimePagos($data)
    {
        if (!isset($_POST['docID']) || empty($_POST['docID'])) {
            Session::set('document_warning', 'Error al modificar el registro. No se ha podido encontrar el documento.');
            echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            exit;
        }

        $docID = intval($_POST['docID']);
        $estatusFields = [];

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'estatusP_') === 0) {
                $pagoID = str_replace('estatusP_', '', $key);
                $estatusFields[$pagoID] = intval($value);
            }
        }

        if (empty($estatusFields)) {
            Session::set('document_warning', 'Error al modificar el registro. No se han encontrado cambios en los pagos.');
            echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            exit;
        }

        if ($this->TimeByTimeModel->updateTimebyTimePagos($docID, $estatusFields)) {
            Session::set('document_success', 'Registro modificado correctamente.');
        } else {
            Session::set('document_warning', 'Error al modificar el registro, por favor intente nuevamente.');
        }

        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
    }

    public function uploadFile($data, $dataFile)
    {
        $docID = isset($data['docID']) ? intval($data['docID']) : null; 
        $file = isset($dataFile['archivo']) && !empty($dataFile['archivo']['tmp_name']) ? $dataFile['archivo'] : null;
        $estatus = 'entregado';

        if ($docID === null || $file === null) {
            Session::set('document_warning', 'Error al subir el archivo. No se ha subido ningun archivo.');
            echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            exit;
        }


        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);  
        $mimeType = finfo_file($fileInfo, $file['tmp_name']);
        finfo_close($fileInfo);
        // Validar que sea un archivo PDF
        if ($extension !== 'pdf' || $mimeType !== 'application/pdf') {
            Session::set('document_warning', 'Error: el archivo no es un PDF válido.');
            echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            exit;
        } else{
            $fileData = file_get_contents($file['tmp_name']);
            if ($fileData === false) {
                Session::set('document_warning', 'Error al leer el archivo.');
                echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
                exit;
            }
        }
        //var_dump($file); exit;
        //var_dump($docID); exit;
        if ($this->TimeByTimeModel->uploadFile($docID, $fileData, $estatus)) {
            Session::set('document_success', 'Archivo subido correctamente.');
        } else {
            Session::set('document_warning', 'Error al subir el archivo, por favor intente nuevamente.');
        }

        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
    } 
    public function downloadDocument($docID)
    {   
        if ($archivo = $this->TimeByTimeModel->downloadDocument($docID)) {
            // Establecer encabezados para la descarga
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="documento.pdf"');
            echo $archivo;
        } else {
            Session::set('document_warning', 'Archivo no encontrado.');
        }
        echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
    }
}
