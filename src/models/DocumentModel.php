<?php

class DocumentModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllDocuments($role, $userID)
    {

        $query = "SELECT documento.*, usuario.* FROM documento LEFT JOIN usuario ON usuario.usuario_id = documento.usuario_id";

        if ($role == 3) {
            $query .= " WHERE documento.usuario_id = :userID";
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
        $query = "SELECT * FROM documento WHERE documento_id = :docID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertDocument($user, $tipo, $pathPDF, $actualDate, $status)
    {
        $query = "INSERT INTO documento (usuario_id, documento_tipo, documento_file, documento_fechaCreacion, documento_estatus) 
                  VALUES (:userID, :tipo, :pathPDF, :actualDate, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userID', $user, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->bindParam(':pathPDF', $pathPDF, PDO::PARAM_LOB);
        $stmt->bindParam(':actualDate', $actualDate, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateDocument($docID, $status)
    {
        $query = "UPDATE documento SET documento_estatus = :estatus WHERE documento_id = :docID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
        $stmt->bindParam(':estatus', $status, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteDocument($docID)
    {
        $query = "DELETE FROM documento WHERE documento_id = :docID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function countDiasEconomicos($userID)
    {
        $query = "SELECT COUNT(documento_id) AS diasEconomicos FROM documento WHERE documento_tipo = 'Dia economico' AND usuario_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countDiaCumple($userID)
    {
        $query = "SELECT COUNT(documento_id) AS diaCumple FROM documento WHERE documento_tipo = 'Dia de cumpleaños' AND usuario_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countReportesIncidencia($userID)
    {
        $query = "SELECT COUNT(documento_id) AS reportesIncidencia FROM documento WHERE documento_tipo = 'Reporte de incidencia' AND usuario_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
