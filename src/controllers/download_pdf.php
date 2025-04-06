<?php
require_once '../../server/DB.php'; // Ajusta la ruta según la ubicación real de tu archivo DB.php

class DownloadPDFController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function download($id)
    {
        $query = $this->db->prepare("SELECT pdf FROM comisiones WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result && !empty($result['pdf'])) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="documento.pdf"');
            header('Content-Length: ' . strlen($result['pdf']));
            echo $result['pdf'];
        } else {
            header('HTTP/1.0 404 Not Found');
            echo "Archivo no encontrado.";
        }
    }
}
?>
