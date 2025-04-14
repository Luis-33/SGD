<?php

class TimeByTimeModel
{
    private $db;

    public function __construct($db)
    { 
        $this->db = $db;
    }

    public function getAllRegistros($role, $userID)
    {
        try {
        
            $this->db->prepare("START TRANSACTION")->execute();
        
            $query = "SELECT 
                        timebytime.*, 
                        usuario.*,
                        (SELECT COUNT(*) FROM timebytimepagos WHERE timebytimepagos.timebytime_id = timebytime.id AND estatusP = 0) AS incidencia
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
            $query .= " ORDER BY timebytime.folio ASC";
        
            // Ejecutar la consulta y verificar si se ejecutó correctamente
            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                $this->db->prepare("ROLLBACK")->execute();
                return false;
            }

            // Commit la transacción
            $this->db->prepare("COMMIT")->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $this->db->prepare("ROLLBACK")->execute();
            error_log("Excepción capturada: " . $e->getMessage());
            return false;
        }        
    }

    public function getLastRegistro()
    {
        try {
            $this->db->prepare("START TRANSACTION")->execute();
            $query = "SELECT * FROM timebytime ORDER BY id DESC LIMIT 1";
            $stmt = $this->db->prepare($query);

            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                $this->db->prepare("ROLLBACK")->execute();
                return false;
            }

            $this->db->prepare("COMMIT")->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $this->db->prepare("ROLLBACK")->execute();
            error_log("Error al iniciar la transacción: " . $e->getMessage());
            return false;
        }
    
    }

    public function getRegistroById($id){
       
        $query = "SELECT timebytime.*, usuario.*
                  FROM timebytime
                  LEFT JOIN usuario ON timebytime.usuario_id = usuario.usuario_id
                  WHERE timebytime.id = :id";        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRegistro($user_ID, $folio, $fechaR, $num_registros, $fechaF, $horasF, $fechaP, $horasP) 
    {
        try {
            // Iniciar la transacción
            $this->db->prepare("START TRANSACTION")->execute();

            // Insertar el documento en la tabla timebytime
            $query = "INSERT INTO timebytime (usuario_id, folio, fechaR) VALUES (:user_ID, :folio, :fechaR)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_ID', $user_ID, PDO::PARAM_INT);
            $stmt->bindParam(':folio', $folio, PDO::PARAM_STR);
            $stmt->bindParam(':fechaR', $fechaR, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                $this->db->prepare("ROLLBACK")->execute();
                return false;
            }
    
            // Obtener el ID del documento insertado
            $timeByTimeId = $this->db->lastInsertId();
    
            // Insertar las faltas
            $queryF = "INSERT INTO timebytimefaltas (timebytime_id, fechaF, horasF) VALUES (:timeByTimeId, :fechaF, :horasF)";
            $stmtF = $this->db->prepare($queryF);
            for ($i = 0; $i < $num_registros; $i++) {
                $stmtF->bindParam(':timeByTimeId', $timeByTimeId, PDO::PARAM_INT);
                $stmtF->bindParam(':fechaF', $fechaF[$i], PDO::PARAM_STR);
                $stmtF->bindParam(':horasF', $horasF[$i], PDO::PARAM_INT);
                
                if (!$stmtF->execute()) {
                    $errorInfo = $stmt->errorInfo();
                    error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                    $this->db->prepare("ROLLBACK")->execute();
                    return false;
                }
            }
    
            // Insertar los pagos
            $queryP = "INSERT INTO timebytimepagos (timebytime_id, fechaP, horaP) VALUES (:timeByTimeId, :fechaP, :horaP)";
            $stmtP = $this->db->prepare($queryP);
            foreach ($fechaP as $index => $fecha) {
                $stmtP->bindParam(':timeByTimeId', $timeByTimeId, PDO::PARAM_INT);
                $stmtP->bindParam(':fechaP', $fecha, PDO::PARAM_STR);
                $stmtP->bindParam(':horaP', $horasP[$index], PDO::PARAM_INT);

                if (!$stmtP->execute()) {
                    $errorInfo = $stmt->errorInfo();
                    error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                    $this->db->prepare("ROLLBACK")->execute();
                    return false;
                }
            }
            
    
            // Confirmar la transacción
            $this->db->prepare("COMMIT")->execute();
            return true;
    
        } catch (PDOException $e) {
                // Si ocurre un error, revertimos la transacción
                $this->db->prepare("ROLLBACK")->execute();
                error_log("Error al iniciar la transacción: " . $e->getMessage());
                return false;
            }
    }
    
    public function getValidationFolio($folio) {
        
        $sql = "SELECT folio FROM timebytime WHERE folio = :folio LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':folio', $folio, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result ? true : false; // Si hay un resultado, el folio ya existe.
    }

    public function getValidationRegistro($docID)
    {
        $queryFaltas = "SELECT * FROM timebytimefaltas WHERE timebytime_id = :docID";
        $stmtFaltas = $this->db->prepare($queryFaltas);
        $stmtFaltas->bindParam(':docID', $docID, PDO::PARAM_INT);
        $stmtFaltas->execute();
        $faltas = $stmtFaltas->fetchAll(PDO::FETCH_ASSOC);

        $queryPagos = "SELECT * FROM timebytimepagos WHERE timebytime_id = :docID";
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

    public function updateEstatusTimebyTimePagos($docID, $estatusFields)
    {
        try {
            // Iniciar la transacción
            $this->db->prepare("START TRANSACTION")->execute();
    
            $query = "UPDATE timebytimePagos 
                      SET estatusP = :estatus 
                      WHERE timebytime_id = :docID AND id = :pagoID";
    
            $stmt = $this->db->prepare($query);
    
            foreach ($estatusFields as $pagoID => $estatus) {
                $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
                $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
                $stmt->bindParam(':pagoID', $pagoID, PDO::PARAM_INT);
    
                if (!$stmt->execute()) {
                    // Si falla una ejecución, revierte todo
                    $this->db->rollBack();
                    return false;
                }
            }
    
            // Si todo fue bien, confirma la transacción
            $this->db->prepare("COMMIT")->execute();
            return true;
    
        } catch (Exception $e) {
            // Captura cualquier excepción y revierte
            $this->db->prepare("ROLLBACK")->execute();
            error_log("Error en actualizarPagos: " . $e->getMessage());
            return false;
        }
    }


    public function UpdateUploadFile($docID, $archivo, $estatus)
    {
        try {
            // Iniciar la transacción
            $this->db->prepare("START TRANSACTION")->execute();
    
            $query = "UPDATE timebytime SET archivo = :archivo, estatus = :estatus WHERE id = :docID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
            $stmt->bindParam(':archivo', $archivo, PDO::PARAM_LOB);
            $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);
    
            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();  // Obtener información sobre el error
                error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                $this->db->prepare("ROLLBACK")->execute();
                return false;   
            }
    
            // Confirmar los cambios
            $this->db->prepare("COMMIT")->execute();
            return true;
    
        } catch (Exception $e) {
            // En caso de excepción, revertir la transacción
            $this->db->prepare("ROLLBACK")->execute();
            error_log("Error al actualizar archivo: " . $e->getMessage());
            return false;
        }
    }

    public function getDownloadFile($docID)
    {
        $query = "SELECT archivo, folio FROM timebytime WHERE id = :docID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
        $stmt->execute();
        $archivo = $stmt->fetch(PDO::FETCH_ASSOC);

        return $archivo;
    }

    public function updateDeleteLogical($docID){
        try {
            // Iniciar la transacción
            $this->db->prepare("START TRANSACTION")->execute();
    
            $query = "UPDATE timebytime SET estatus = 'cancelado' WHERE id = :docID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
    
            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();  // Obtener información sobre el error
                error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                $this->db->prepare("ROLLBACK")->execute();
                return false;   
            }
    
            // Confirmar los cambios
            $this->db->prepare("COMMIT")->execute();
            return true;
    
        } catch (Exception $e) {
            // En caso de excepción, revertir la transacción
            $this->db->prepare("ROLLBACK")->execute();
            error_log("Error al eliminar registro: " . $e->getMessage());
            return false;
        }
    }
}
?>
