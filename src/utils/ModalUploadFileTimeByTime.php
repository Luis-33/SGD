<?php 

function generateModalUploadFile($docID){
    $modal = "
    <div class=\"modal timebytimeUploadFile{$docID}\">
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2>Subir documento</h2>
                <button onclick=\"closeModal('timebytimeUploadFile{$docID}')\">Cerrar</button>
            </div>
            <div class=\"modal_body\">
                <form action=\"admin_home.php?page=TimeByTime&action=timebytimeUploadFile\" method=\"POST\" enctype=\"multipart/form-data\">
                    <label for=\"document\">Seleccionar documento:</label>
                    <input type=\"file\" name=\"archivo\" id=\"document\" requiered>
                    <input type=\"hidden\" name=\"docID\" value=\"{$docID}\">
                    <button type=\"submit\">Subir documento</button>
                </form>
            </div>
        </div>
    </div>";
    
    return $modal;
}

?>