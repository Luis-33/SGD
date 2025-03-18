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

    public function addComision($data, $table_name) {
        $describe = $this->describeTable($table_name);
        $fields = array_column($describe, 'Field');
        $data = array_map('trim', array_merge(array_fill_keys($fields, ''), $data));
        $fieldsList = implode(', ', $fields);

        $query = "INSERT INTO " . $table_name . " ($fieldsList) VALUES ($data)";

        $stmt = $this->db->prepare($query);

        foreach ($fields as $field) {
            $stmt->bindParam(":$field", $data[$field]);
        }
    
        try {
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            // Mostrar el error
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function describeTable($name) {
        $name = preg_replace('/[^a-zA-Z0-9_]/', '', $name);
        $query = "DESCRIBE `$name`";
        $stmt = $this->db->prepare($query);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>