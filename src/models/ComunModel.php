<?php

class ComunModel
{
    private $db;

    public function __construct($db)
    { 
        $this->db = $db;
    }

    public function getAll($role, $userID, $table_name)
    {
        $query = "SELECT " . $table_name . ".*, usuario.* FROM " . $table_name . " LEFT JOIN usuario ON usuario.usuario_id = " . $table_name . ".Usuario_id";

        if ($role == 3) { 
            $query .= " WHERE " . $table_name . ".Usuario_id = :userID";
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

    public function add($data, $table_name) {
        $describe = $this->describeTable($table_name);
        $fields = array_column($describe, 'Field');
        $data = array_map('trim', $data);
        
        $data = array_intersect_key($data, array_flip($fields));
        
        $data = array_filter($data, function($value) {
            return $value !== '';
        });

        $fieldsList = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO " . $table_name . " ($fieldsList) VALUES ($placeholders)";

        $stmt = $this->db->prepare($query);

        foreach ($data as $field => $value) {
            $stmt->bindValue(":$field", $value);
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