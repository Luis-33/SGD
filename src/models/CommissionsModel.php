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

    public function addComision(
        $usuarioId, $fechaElaboracion, $lugar, $asunto, $viaticos, $especificacionViaticos,
        $observaciones, $fechaSalida, $fechaRegreso, $transportePropio, $marca, $modelo,
        $color, $placas, $transporte, $kilometraje, $status
    ) {
        $data = [
            'usuarioId' => $usuarioId,
            'fechaElaboracion' => $fechaElaboracion,
            'lugar' => $lugar,
            'asunto' => $asunto,
            'viaticos' => $viaticos,
            'especificacionViaticos' => $especificacionViaticos,
            'observaciones' => $observaciones,
            'fechaSalida' => $fechaSalida,
            'fechaRegreso' => $fechaRegreso,
            'transportePropio' => $transportePropio,
            'marca' => $marca,
            'modelo' => $modelo,
            'color' => $color,
            'placas' => $placas,
            'transporte' => $transporte,
            'kilometraje' => $kilometraje,
            'status' => $status
        ];

        $query = "INSERT INTO Comiciones (  
                    Usuario_Id, Fecha_de_Elaboracion, Lugar, Asunto, Viaticos, Especificacion_Viaticos,
                    Observaciones, Fecha_De_Salida, Fecha_De_Regreso, Transporte_propio, Marca, Modelo,
                    Color, Placas, Transporte, Kilometraje, Status
                  ) 
                  VALUES (
                    :usuarioId, :fechaElaboracion, :lugar, :asunto, :viaticos, :especificacionViaticos,
                    :observaciones, :fechaSalida, :fechaRegreso, :transportePropio, :marca, :modelo,
                    :color, :placas, :transporte, :kilometraje, :status
                  )";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(':fechaElaboracion', $fechaElaboracion, PDO::PARAM_STR);
        $stmt->bindParam(':lugar', $lugar, PDO::PARAM_STR);
        $stmt->bindParam(':asunto', $asunto, PDO::PARAM_STR);
        $stmt->bindParam(':viaticos', $viaticos, PDO::PARAM_STR);
        $stmt->bindParam(':especificacionViaticos', $especificacionViaticos, PDO::PARAM_STR);
        $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
        $stmt->bindParam(':fechaSalida', $fechaSalida, PDO::PARAM_STR);
        $stmt->bindParam(':fechaRegreso', $fechaRegreso, PDO::PARAM_STR);
        $stmt->bindParam(':transportePropio', $transportePropio, PDO::PARAM_STR);
        $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
        $stmt->bindParam(':modelo', $modelo, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->bindParam(':placas', $placas, PDO::PARAM_STR);
        $stmt->bindParam(':transporte', $transporte, PDO::PARAM_INT);
        $stmt->bindParam(':kilometraje', $kilometraje, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    
        $result = $stmt->execute();
    
        return $result;
    }
    
    
    


}
?>