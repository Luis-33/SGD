<?php

class absenceModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $query = "SELECT
                    absences.*,
                    usuario.usuario_nombre AS full_name
                FROM absences
                LEFT JOIN usuario ON usuario.usuario_id = absences.user_id
                WHERE absences.is_deleted = '0'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id)
    {
        $query = "SELECT * FROM absences WHERE absence_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($data)
    {
        $query = "INSERT INTO absences (
        user_id,
            parent_id,
            folio_number,
            document,
            total_days,
            start_date,
            end_date,
            is_open,
            created_at,
            updated_at,
            deleted_at,
            is_deleted
        ) VALUES (
            :user_id,
            :parent_id,
            :folio_number,
            :document,
            :total_days,
            :start_date,
            :end_date,
            :is_open,
            NOW(),
            NOW(),
            NULL,
            '0'
        )";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':parent_id', $data['parent_id'], PDO::PARAM_INT);
        $stmt->bindParam(':folio_number', $data['folio_number'], PDO::PARAM_STR);
        $stmt->bindParam(':document', $data['document'], PDO::PARAM_LOB); // NULL si no hay
        $stmt->bindParam(':total_days', $data['total_days'], PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':is_open', $data['is_open']); // '1' o '0'

        return $stmt->execute();
    }

    public function update($absenceId, $data)
    {
        $query = "UPDATE absences SET
        user_id = :user_id,
        parent_id = :parent_id,
        folio_number = :folio_number,
        document = :document,
        total_days = :total_days,
        start_date = :start_date,
        end_date = :end_date,
        is_open = :is_open,
        updated_at = NOW()
    WHERE absence_id = :absence_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':absence_id', $absenceId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':parent_id', $data['parent_id'], PDO::PARAM_INT);
        $stmt->bindParam(':folio_number', $data['folio_number'], PDO::PARAM_STR);
        $stmt->bindParam(':document', $data['document'], PDO::PARAM_LOB);
        $stmt->bindParam(':total_days', $data['total_days'], PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':is_open', $data['is_open']);

        return $stmt->execute();
    }

    public function delete($absenceId)
    {
        $query = "UPDATE absences 
              SET is_deleted = '1', is_open = '0', deleted_at = NOW() 
              WHERE absence_id = :absence_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':absence_id', $absenceId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAbsenceChain($absenceId)
    {
        $chain = [];
        var_dump($absenceId); // 👈 Agrega esto para ver el resultado

        while ($absenceId !== null) {
            $stmt = $this->db->prepare("SELECT * FROM absences WHERE absence_id = :id AND is_deleted = '0'");
            $stmt->execute(['id' => $absenceId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            var_dump($row); // 👈 Agrega esto para ver el resultado

            if (!$row) break;

            $chain[] = $row;
            $absenceId = $row['parent_id']; // continuar hacia arriba
        }

        return $chain;
    }



}
