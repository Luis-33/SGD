<?php

class CommissionsModel
{
    private $db;

    public function __construct($db)
    { 
        $this->db = $db;
    }

    public function getAllCommissions($role, $userID)
    {
        $query = "SELECT comiciones.*, usuario.* FROM comiciones LEFT JOIN usuario ON usuario.usuario_id = comiciones.Usuario_id";

        if ($role == 3) { 
            $query .= " WHERE comiciones.Usuario_id = :userID";
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
            $stmt->bindParam(':userSindicato', $user_sindicato, PDO::PARAM_INT);
        } else { 
            $stmt = $this->db->prepare($query);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
    // public function insertCommission($data)
    // {
    //     $query = "INSERT INTO Comiciones 
    //              (Fecha_de_Elaboracion, Usuario_Id, Lugar, Asunto, Viaticos, Especificacion_Viaticos, Observaciones, 
    //              Fecha_De_Salida, Fecha_De_Regreso, Transporte_propio, marca, modelo, color, Placas, Transporte, kilometraje, Status) 
    //              VALUES (:fecha_elaboracion, :usuario_id, :lugar, :asunto, :viaticos, :especificacion_viaticos, :observaciones, 
    //              :fecha_salida, :fecha_regreso, :transporte_propio, :marca, :modelo, :color, :placas, :transporte, :kilometraje, :status)";

    //     $stmt = $this->db->prepare($query);
        
    //     return $stmt->execute($data);
    // }
}
?>