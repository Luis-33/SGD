<?php

class TimeByTimeModel
{
    private $db;

    public function __construct($db)
    { 
        $this->db = $db;
    }


    public function generarRegistro($user_ID, $folio, $fechaR, $num_registros, $fechaF, $horasF, $fechaP, $horasP, $estatus, $estatusP) 
    {
        // Insertar el documento en la tabla timebytime
        $query = "INSERT INTO timebytime (usuario_id, folio, estatus, fechaR) VALUES (:user_ID, :folio, :estatus, :fechaR)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT);
        $stmt->bindParam(':folio', $folio, PDO::PARAM_STR);
        $stmt->bindParam(':fechaR', $fechaR, PDO::PARAM_STR);
        $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            return false; // Si la ejecución falla, retornamos false
        }
    
        // Obtener el ID del documento insertado
        $timeByTimeId = $this->db->lastInsertId();
    
        // Insertar las faltas
        for ($i = 0; $i < $num_registros; $i++) {
            $queryF = "INSERT INTO timebytimefaltas (timebytime_id, fechaF, horasF) VALUES (:timeByTimeId, :fechaF, :horasF)";
            $stmtF = $this->db->prepare($queryF);
            $stmtF->bindParam(':timeByTimeId', $timeByTimeId, PDO::PARAM_INT);
            $stmtF->bindParam(':fechaF', $fechaF[$i], PDO::PARAM_STR);
            $stmtF->bindParam(':horasF', $horasF[$i], PDO::PARAM_INT);
            if (!$stmtF->execute()) {
                return false; // Si la ejecución falla, retornamos false
            }
        }
    
        // Insertar los pagos
        foreach ($fechaP as $index => $fecha) {
            $queryP = "INSERT INTO timebytimepagos (timebytime_id, fechaP, horaP, estatusP) VALUES (:timeByTimeId, :fechaP, :horaP, :estatusP)";
            $stmtP = $this->db->prepare($queryP);
            $stmtP->bindParam(':timeByTimeId', $timeByTimeId, PDO::PARAM_INT);
            $stmtP->bindParam(':fechaP', $fecha, PDO::PARAM_STR);
            $stmtP->bindParam(':horaP', $horasP[$index], PDO::PARAM_INT);
            $stmtP->bindParam(':estatusP', $estatusP, PDO::PARAM_INT);
            if (!$stmtP->execute()) {
                return false; // Si la ejecución falla, retornamos false
            }
        }
        
        // Si todas las consultas se ejecutaron correctamente, retornamos true
        return true;
    }
    

    // Función para generar el folio, si es necesario
    private function generateFolio() {
        // Generar un folio único (puedes personalizar esta función según lo necesites)
        return 'FOLIO-' . time();
    }



    public function getAllDocuments($role, $userID)
    {

        $query = "SELECT timebytime.*, usuario.* FROM timebytime LEFT JOIN usuario ON usuario.usuario_id = timebytime.usuario_id";

        if ($role == 3) {
            $query .= " WHERE timebytime.usuario_id = :userID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        } else if ($role == 4) {
            $area_adscripcion = $_SESSION['user_area'];
            $query .= " WHERE usuario.areaAdscripcion_id = :areaAdscripcion";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':areaAdscripcion', $area_adscripcion, PDO::PARAM_INT);
        } else if ($role == 5) {
            $user_sindicato = $_SESSION['user_union'];
            $query .= " WHERE usuario.sindicato_id = :userSindicato";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userSindicato', $user_sindicato, PDO::PARAM_STR);
        } else {
            $stmt = $this->db->prepare($query);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDocumentById($docID)
    {
        $query = "SELECT * FROM timebytime WHERE id = :docID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>