<?php

require_once MODEL_PATH . "DocumentModel.php";
require_once SERVER_PATH . "DB.php";

if (isset($_GET['action']) && $_GET['action'] === 'editDocument') {
    if (isset($_POST['docID']) && isset($_POST['documentoEstatus'])) {
        $docID = $_POST['docID'];
        $estatus = $_POST['documentoEstatus'];

        // Conexión a la base de datos
        require_once MODEL_PATH . "DocumentModel.php";
        require_once SERVER_PATH . "DB.php";

        $db = new DB();
        $documentModel = new DocumentModel($db);

        // Actualizar el estatus del documento
        $query = "UPDATE documento SET documento_estatus = :estatus WHERE documento_id = :docID";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);
        $stmt->bindParam(':docID', $docID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirigir con un mensaje de éxito
            header("Location: admin_home.php?page=dashboard&status=success");
        } else {
            // Redirigir con un mensaje de error
            header("Location: admin_home.php?page=dashboard&status=error");
        }
        exit();
    }
}

function generateModalEditDocument($docID)
{
    $db = new DB();
    $documentModel = new DocumentModel($db);
    $document = $documentModel->getDocumentById($docID);

    $modal = "
        <div class=\"modal editDocument{$docID}\" >
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2>Actualizar documento</h2>
                <button onclick=\"closeModal('editDocument{$document['documento_id']}')\">
                    Cerrar <i class=\"fa-solid fa-xmark\"></i>
                </button>
            </div>
            <div class=\"modal_body\">
                <form action=\"admin_home.php?page=dashboard&action=editDocument\" method=\"POST\">
                <div class=\"input_group\">
                <label>Adjuntar documento</label>
                    <input type=\"file\" name=\"documento\">
                </div>
                
                    <input type=\"hidden\" name=\"docID\" value=\"{$document['documento_id']}\">


                    <div class=\"input_group\">
                        <label>Estatus</label>
                        <span class=\"sBtn_text\">" . $document['documento_estatus'] . "</span>
                        <select name=\"documentoEstatus\" id=\"documentoEstatus\">
                            <option value=\"Entregado\" " . ($document['documento_estatus'] === 'Entregado' ? 'selected' : '') . ">Entregado</option>
                            <option value=\"Pendiente\" " . ($document['documento_estatus'] === 'Pendiente' ? 'selected' : '') . ">Pendiente</option>
                            <option value=\"Sin Entregar\" " . ($document['documento_estatus'] === 'Sin Entregar' ? 'selected' : '') . ">Sin Entregar</option>
                        </select>
                    </div>

                    <button type=\"submit\">Actualizar documento</button>
                </form>
               
            </div>
        </div>
    </div>
    <style>
    /* Estilo para el <select> */
    select#documentoEstatus {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color:rgba(0, 162, 154, 0.19);
        font-size: 16px;
        color: #333;
        cursor: pointer;
    }

    /* Estilo para las opciones */
    select#documentoEstatus option {
        padding: 10px;
        background-color:rgba(254, 254, 254, 0.65);
        color: #333;
    }

    /* Cambiar el color de fondo al pasar el mouse */
    select#documentoEstatus option:hover {
        background-color: #f0f0f0;
        
    }

    /* Estilo para el span que muestra el estatus */
    span.sBtn_text {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        color: #fff;
        background-color:rgb(4, 99, 95);
        text-align: center;
        width: 50%; /* Asegura un ancho mínimo */
        margin: 0 auto; /* Centra horizontalmente */

    }

  
    </style>
";

    return $modal;
}
