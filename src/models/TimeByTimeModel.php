<?php

class TimeByTimeModel
{
    private $db;

    public function __construct($db)
    { 
        $this->db = $db;
    }

    public function create ($userID, $fechaF, $horaF, $fechaP, $horaP, ){

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

}
?>