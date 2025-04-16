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
        
            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                $this->db->prepare("ROLLBACK")->execute();
                return false;
            }

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

        try {
     
            $this->db->prepare("START TRANSACTION")->execute();
        
                $queryMain = "SELECT timebytime.*, usuario.*
                            FROM timebytime
                            LEFT JOIN usuario ON timebytime.usuario_id = usuario.usuario_id
                            WHERE timebytime.id = :id";
                $stmtMain = $this->db->prepare($queryMain);
                $stmtMain->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtMain->execute();
                if (!$stmtMain->execute()) {
                    $errorInfo = $stmtMain->errorInfo();
                    error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                    $this->db->prepare("ROLLBACK")->execute();
                    return false;
                }
                $registro = $stmtMain->fetch(PDO::FETCH_ASSOC);
            
                $queryFaltas = "SELECT * FROM timebytimefaltas WHERE timebytime_id = :id";
                $stmtFaltas = $this->db->prepare($queryFaltas);
                $stmtFaltas->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtFaltas->execute();

                if (!$stmtFaltas->execute()) {
                    $errorInfo = $stmtFaltas->errorInfo();
                    error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                    $this->db->prepare("ROLLBACK")->execute();
                    return false;
                }
                $faltas = $stmtFaltas->fetchAll(PDO::FETCH_ASSOC);
            
                $queryPagos = "SELECT * FROM timebytimepagos WHERE timebytime_id = :id";
                $stmtPagos = $this->db->prepare($queryPagos);
                $stmtPagos->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtPagos->execute();

                if (!$stmtPagos->execute()) {
                    $errorInfo = $stmtPagos->errorInfo();
                    error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                    $this->db->prepare("ROLLBACK")->execute();
                    return false;
                }

                $pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);
            
                $registro['faltas'] = $faltas;
                $registro['pagos'] = $pagos;

           $this->db->prepare("COMMIT")->execute();
           return $registro;

        } catch (PDOException $e) {
            // Rollback si algo falla
            $this->db->prepare("ROLLBACK")->execute();
            error_log("Error al iniciar la transacción: " . $e->getMessage());
            return false;
        } 
    }
    

    public function createRegistro($user_ID, $folio, $fechaR, $num_registros, $fechaF, $horasF, $fechaP, $horasP) 
    {
        try {
         
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
        
                // Obtener el ID del último registro insertado
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
            
            $this->db->prepare("COMMIT")->execute();
            return true;
    
        } catch (PDOException $e) {
    
                $this->db->prepare("ROLLBACK")->execute();
                error_log("Error al iniciar la transacción: " . $e->getMessage());
                return false;
            }
    }
    
    public function getValidationFolio($folio) {
        try {
            $this->db->prepare("START TRANSACTION")->execute();
                $sql = "SELECT folio FROM timebytime WHERE folio = :folio LIMIT 1";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':folio', $folio, PDO::PARAM_STR);
                $stmt->execute();

                if (!$stmt->execute()) {
                    $errorInfo = $stmt->errorInfo(); 
                    error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                    $this->db->prepare("ROLLBACK")->execute();
                    return false;   
                }
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->db->prepare("COMMIT")->execute();
            return $result ? true : false;
            
        } catch (Exception $e) {
            error_log("Error al iniciar la transacción: " . $e->getMessage());
            return false;
        }
        
    }

    public function getValidationRegistro($docID)
    {
        try{
            $queryFaltas = "SELECT * FROM timebytimefaltas WHERE timebytime_id = :docID";
            $stmtFaltas = $this->db->prepare($queryFaltas);
            $stmtFaltas->bindParam(':docID', $docID, PDO::PARAM_INT);
            $stmtFaltas->execute();

            if (!$stmtFaltas->execute()) {
                $errorInfo = $stmtFaltas->errorInfo(); 
                error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                $this->db->prepare("ROLLBACK")->execute();
                return false;   
            }
            $faltas = $stmtFaltas->fetchAll(PDO::FETCH_ASSOC);

            $queryPagos = "SELECT * FROM timebytimepagos WHERE timebytime_id = :docID";
            $stmtPagos = $this->db->prepare($queryPagos);
            $stmtPagos->bindParam(':docID', $docID, PDO::PARAM_INT);
            $stmtPagos->execute();

            if (!$stmtPagos->execute()) {
                $errorInfo = $stmtPagos->errorInfo(); 
                error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                $this->db->prepare("ROLLBACK")->execute();
                return false;   
            }
            $pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);

            $resultadoFinal = [
                'faltas' => $faltas,
                'pagos' => $pagos
            ];

            $this->db->prepare("COMMIT")->execute();
            return $resultadoFinal;

        }catch (Exception $e) {
            error_log("Error al iniciar la transacción: " . $e->getMessage());
            return false;
        }
        
    }

    public function updateEstatusTimebyTimePagos($docID, $estatusFields)
    {
        try {
            
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
                        $this->db->prepare("ROLLBACK")->execute();
                        return false;
                    }
                }
    
            $this->db->prepare("COMMIT")->execute();
            return true;
    
        } catch (Exception $e) {
            
            $this->db->prepare("ROLLBACK")->execute();
            error_log("Error en actualizarPagos: " . $e->getMessage());
            return false;
        }
    }


    public function UpdateUploadFile($docID, $archivo, $estatus)
    {
        try {
           
            $this->db->prepare("START TRANSACTION")->execute();
    
                $query = "UPDATE timebytime SET archivo = :archivo, estatus = :estatus WHERE id = :docID";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
                $stmt->bindParam(':archivo', $archivo, PDO::PARAM_LOB);
                $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        
                if (!$stmt->execute()) {
                    $errorInfo = $stmt->errorInfo(); 
                    error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                    $this->db->prepare("ROLLBACK")->execute();
                    return false;   
                }
    
            $this->db->prepare("COMMIT")->execute();
            return true;
    
        } catch (Exception $e) {
            
            $this->db->prepare("ROLLBACK")->execute();
            error_log("Error al actualizar archivo: " . $e->getMessage());
            return false;
        }
    }

    public function getDownloadFile($docID)
    {
        try{
            $this->db->prepare("START TRANSACTION")->execute();
                $query = "SELECT archivo, folio FROM timebytime WHERE id = :docID";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
                $stmt->execute();

                if (!$stmt->execute()) {
                    $errorInfo = $stmt->errorInfo(); 
                    error_log("Error al ejecutar la consulta: " . implode(", ", $errorInfo));
                    $this->db->prepare("ROLLBACK")->execute();
                    return false;   
                }
                $archivo = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->db->prepare("COMMIT")->execute();
            return $archivo;

        } catch (Exception $e) {
            error_log("Error al iniciar la transacción: " . $e->getMessage());
            return false;
        }
    
    }

    public function updateDeleteLogical($docID){
        try {
            
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
    
            $this->db->prepare("COMMIT")->execute();
            return true;
    
        } catch (Exception $e) {
            
            $this->db->prepare("ROLLBACK")->execute();
            error_log("Error al eliminar registro: " . $e->getMessage());
            return false;
        }
    }
}
?>
