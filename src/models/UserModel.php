<?php

class UserModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUserById($userID)
    {
        $query = "SELECT usuario.*, rol.*, puesto.*, areaAdscripcion.*, jefeinmediato.*, sindicato.* 
                  FROM usuario 
                  LEFT JOIN rol ON usuario.rol_id = rol.rol_id 
                  LEFT JOIN puesto ON usuario.puesto_id = puesto.puesto_id 
                  LEFT JOIN areaAdscripcion ON usuario.areaAdscripcion_id = areaAdscripcion.areaAdscripcion_id 
                  LEFT JOIN jefeinmediato ON usuario.jefeInmediato_id = jefeinmediato.jefeInmediato_id 
                  LEFT JOIN sindicato ON usuario.sindicato_id = sindicato.sindicato_id 
                  WHERE usuario.usuario_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers($userRole)
    {

        $query = "SELECT usuario.*, rol.*, puesto.*, jefeinmediato.* 
                  FROM usuario 
                  LEFT JOIN rol ON usuario.rol_id = rol.rol_id 
                  LEFT JOIN puesto ON usuario.puesto_id = puesto.puesto_id 
                  LEFT JOIN areaAdscripcion ON usuario.areaAdscripcion_id = areaAdscripcion.areaAdscripcion_id 
                  LEFT JOIN jefeinmediato ON usuario.jefeInmediato_id = jefeinmediato.jefeInmediato_id 
                  LEFT JOIN sindicato ON usuario.sindicato_id = sindicato.sindicato_id";

        if ($userRole == 4) {
            $area_adscripcion = $_SESSION['user_area'];
            $query .= " WHERE usuario.areaAdscripcion_id = :areaAdscripcion";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':areaAdscripcion', $area_adscripcion, PDO::PARAM_INT);
        } else if ($userRole == 5) {
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

    public function getUsersList()
    {
        $query = "SELECT * FROM usuario ORDER BY usuario_nombre";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDirectorName()
    {
        $query = "SELECT usuario.usuario_nombre FROM usuario WHERE usuario.rol_id = 2";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($userNomina, $userName, $userCurp, $userRFC, $userEmail, $userGenero, $userIngreso, $userCumple, $userPuesto, $userAdscripcion, $userJefe, $userSindicato, $userRol)
    {
        $query = "INSERT INTO usuario (usuario_nomina, usuario_nombre, usuario_curp, usuario_rfc, usuario_email, usuario_password, usuario_genero, usuario_fechaIngreso, usuario_fechaCumpleaños, puesto_id, areaAdscripcion_id, jefeInmediato_id, sindicato_id, rol_id, usuario_estatus) 
                  VALUES(:userNomina, :userName, :userCurp, :userRFC, :userEmail, :userPassword, :userGenero, :userIngreso, :userCumple, :userPuesto, :userAdscripcion, :userJefe, :userSindicato, :userRol, :userStatus)";
        $stmt = $this->db->prepare($query);
        $hashedPassword = password_hash('12345', PASSWORD_BCRYPT);
        $userStatus = 'Vigente';
        $stmt->bindParam(':userNomina', $userNomina, PDO::PARAM_STR);
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':userCurp', $userCurp, PDO::PARAM_STR);
        $stmt->bindParam(':userRFC', $userRFC, PDO::PARAM_STR);
        $stmt->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
        $stmt->bindParam(':userPassword', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':userGenero', $userGenero, PDO::PARAM_STR);
        $stmt->bindParam(':userIngreso', $userIngreso, PDO::PARAM_STR);
        $stmt->bindParam(':userCumple', $userCumple, PDO::PARAM_STR);
        $stmt->bindParam(':userPuesto', $userPuesto, PDO::PARAM_INT);
        $stmt->bindParam(':userAdscripcion', $userAdscripcion, PDO::PARAM_INT);
        $stmt->bindParam(':userJefe', $userJefe, PDO::PARAM_INT);
        $stmt->bindParam(':userSindicato', $userSindicato, PDO::PARAM_INT);
        $stmt->bindParam(':userRol', $userRol, PDO::PARAM_INT);
        $stmt->bindParam(':userStatus', $userStatus, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updateUser($userID, $userNomina, $userName, $userCurp, $userRFC, $userEmail, $userPuesto, $userAdscripcion, $userJefe, $userSindicato, $userRol, $userStatus)
    {
        $query = "UPDATE usuario SET usuario_nomina = :userNomina, usuario_nombre = :userName, usuario_curp = :userCurp, usuario_rfc = :userRFC, usuario_email = :userEmail,  puesto_id = :userPuesto, areaAdscripcion_id = :userAdscripcion, jefeInmediato_id = :userJefe, sindicato_id = :userSindicato, rol_id = :userRol, usuario_estatus = :userStatus WHERE usuario_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':userNomina', $userNomina, PDO::PARAM_STR);
        $stmt->bindParam(':userName', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':userCurp', $userCurp, PDO::PARAM_STR);
        $stmt->bindParam(':userRFC', $userRFC, PDO::PARAM_STR);
        $stmt->bindParam(':userEmail', $userEmail, PDO::PARAM_STR);
        $stmt->bindParam(':userPuesto', $userPuesto, PDO::PARAM_INT);
        $stmt->bindParam(':userAdscripcion', $userAdscripcion, PDO::PARAM_INT);
        $stmt->bindParam(':userJefe', $userJefe, PDO::PARAM_INT);
        $stmt->bindParam(':userSindicato', $userSindicato, PDO::PARAM_INT);
        $stmt->bindParam(':userRol', $userRol, PDO::PARAM_INT);
        $stmt->bindParam(':userStatus', $userStatus, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function updatePassword($userID, $newPassword)
    {
        $query = "UPDATE usuario SET usuario_password = :password WHERE usuario_id = :userID";
        $stmt = $this->db->prepare($query);
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function ressetPassword($userID)
    {
        $query = "UPDATE usuario SET usuario_password = :password WHERE usuario_id = :userID";
        $stmt = $this->db->prepare($query);
        $hashedPassword = password_hash('12345', PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateAvatar($userID, $avatarData)
    {
        $query = "UPDATE usuario SET usuario_foto = :avatar WHERE usuario_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':avatar', $avatarData, PDO::PARAM_LOB);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteUser($userID)
    {
        $query = "DELETE FROM usuario WHERE usuario_id = :userID";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
