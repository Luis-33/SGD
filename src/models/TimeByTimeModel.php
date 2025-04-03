<?php

class TimeByTimeModel
{
    private $db;

    public function __construct($db)
    { 
        $this->db = $db;
    }

    public function getAllDocuments($role, $userID)
    {

        $query = "SELECT 
        timebytime.*, 
        usuario.*,
        (SELECT COUNT(*) FROM timebytimepagos WHERE timebytimepagos.timebytime_id = timebytime.id AND estatusP = 0) AS tiene_pago_pendiente
      FROM timebytime 
      LEFT JOIN usuario ON usuario.usuario_id = timebytime.usuario_id";

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

    public function generarRegistro($user_ID, $folio, $fechaR, $num_registros, $fechaF, $horasF, $fechaP, $horasP, $estatus, $estatusP) 
    {
        try {
            // Iniciar la transacción
            $this->db->prepare("START TRANSACTION")->execute();

            // Insertar el documento en la tabla timebytime
            $query = "INSERT INTO timebytime (usuario_id, folio, estatus, fechaR) VALUES (:user_ID, :folio, :estatus, :fechaR)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT);
            $stmt->bindParam(':folio', $folio, PDO::PARAM_STR);
            $stmt->bindParam(':fechaR', $fechaR, PDO::PARAM_STR);
            $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);
            $stmt->execute();
    
            // Obtener el ID del documento insertado
            $timeByTimeId = $this->db->lastInsertId();
    
            // Insertar las faltas
            $queryF = "INSERT INTO timebytimefaltas (timebytime_id, fechaF, horasF) VALUES (:timeByTimeId, :fechaF, :horasF)";
            $stmtF = $this->db->prepare($queryF);
            for ($i = 0; $i < $num_registros; $i++) {
                $stmtF->bindParam(':timeByTimeId', $timeByTimeId, PDO::PARAM_INT);
                $stmtF->bindParam(':fechaF', $fechaF[$i], PDO::PARAM_STR);
                $stmtF->bindParam(':horasF', $horasF[$i], PDO::PARAM_INT);
                $stmtF->execute();
            }
    
            // Insertar los pagos
            $queryP = "INSERT INTO timebytimepagos (timebytime_id, fechaP, horaP, estatusP) VALUES (:timeByTimeId, :fechaP, :horaP, :estatusP)";
            $stmtP = $this->db->prepare($queryP);
            foreach ($fechaP as $index => $fecha) {
                $stmtP->bindParam(':timeByTimeId', $timeByTimeId, PDO::PARAM_INT);
                $stmtP->bindParam(':fechaP', $fecha, PDO::PARAM_STR);
                $stmtP->bindParam(':horaP', $horasP[$index], PDO::PARAM_INT);
                $stmtP->bindParam(':estatusP', $estatusP, PDO::PARAM_INT);
                $stmtP->execute();
            }
    
            // Confirmar la transacción
            $this->db->prepare("COMMIT")->execute();
            return true;
    
        } catch (PDOException $e) {
                // Si ocurre un error, revertimos la transacción
                $this->db->prepare("ROLLBACK")->execute();
                return false;
            }
    }
    
    public function existeFolio($folio) {
        $sql = "SELECT folio FROM timebytime WHERE folio = :folio LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':folio', $folio, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result ? true : false; // Si hay un resultado, el folio ya existe.
    }

    public function ValidarTimebyTimePagos($docID)
    {
        $queryFaltas = "SELECT id, timebytime_id, fechaF, horasF 
        FROM timebytimefaltas 
        WHERE timebytime_id = :docID";

        $stmtFaltas = $this->db->prepare($queryFaltas);
        $stmtFaltas->bindParam(':docID', $docID, PDO::PARAM_INT);
        $stmtFaltas->execute();
        $faltas = $stmtFaltas->fetchAll(PDO::FETCH_ASSOC);

        $queryPagos = "SELECT id, timebytime_id, fechaP, horaP, estatusP 
               FROM timebytimepagos 
               WHERE timebytime_id = :docID";

        $stmtPagos = $this->db->prepare($queryPagos);
        $stmtPagos->bindParam(':docID', $docID, PDO::PARAM_INT);
        $stmtPagos->execute();
        $pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);
        
        $resultadoFinal = [
            'faltas' => $faltas,
            'pagos' => $pagos
        ];
        
        return $resultadoFinal;
        

    }

    public function updateTimebyTimePagos($docID, $estatusFields)
    {
        $query = "UPDATE timebytimePagos 
        SET estatusP = :estatus 
        WHERE timebytime_id = :docID AND id = :pagoID";

        $stmt = $this->db->prepare($query);

        foreach ($estatusFields as $pagoID => $estatus) {
        $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
        $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
        $stmt->bindParam(':pagoID', $pagoID, PDO::PARAM_INT);
        
        if (!$stmt->execute()) {
            return false; // Si alguna falla, devuelve false
        }
        }
        return true; // Retorna true si todo se actualiza correctamente
    }

}
?>
