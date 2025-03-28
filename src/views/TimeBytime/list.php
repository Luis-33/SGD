
<?php if (!empty($registros)) : ?>

<div class="card_table">
    <div class="card_table_header">
        <h2><?php echo ($_SESSION['user_role'] == 3) ? "Mis registros" : "Tiempo por Tiempo"; ?></h2>
        <div class="card_header_actions">
            <?php if ($_SESSION['user_role'] == 1) : ?>
                <button class="btn_documento" onclick="openModal('timebytime')">Generar Registro</button>
            <?php endif; ?>
        </div>  
    </div>
    <div class="card_table_body">
        <div class="search_input" id="searchForm">
            <input type="text" id="searchInput" placeholder="<?php echo ($_SESSION['user_role'] == 3) ? "Buscar Documento por Tipo - Fecha - Estatus" : "Buscar Documento por Empleado " ?>">
            <i class="fa-solid fa-xmark" id="clear_input"></i>
        </div>
        <div class="table_header">
            <span class="header_pdf"></span>
            <?php if ($_SESSION['user_role'] != 3) : ?>
                <span class="header_empleado">Empleado</span>
            <?php endif; ?>
            <span class="header_folio">Folio</span>
            <span class="header_fecha">Fecha de registro</span>
            <span class="header_estatus">Estatus</span>
            <?php if ($_SESSION['user_role'] == 1) : ?>
                <span class="header_actions">Acciones</span>
            <?php endif; ?>
        </div>
        <div class="table_body" id="tableContainer">
            <?php foreach ($registros as $registro) : ?>
                <div class="table_body_item">
                    <span class="row_pdf" title="Descargar <?php echo $registro['id']; ?>">
                        <a href="download.php?docID=<?php echo $registro['id']; ?>"><i class="fa-solid fa-file-pdf"></i></a>
                    </span>
                    <?php if ($_SESSION['user_role'] != 3) : ?>
                        <div class="row_user_info">
                            <?php if ($registro['usuario_genero'] === 'H') {
                                echo '<img src="assets/images/hombre.png">';
                            } else {
                                echo '<img src="assets/images/mujer.png">';
                            } ?>
                            <div class="info">
                                <span class="user_name"><?php echo $registro["usuario_nombre"]; ?></span>
                                <span><?php echo $registro["usuario_email"] ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <span class="row_folio"><?php echo $registro["folio"] ?></span>
                    <span class="row_fecha"><?php echo $registro["fechaR"] ?></span>
                    <?php 
                    $estatusClass = '';
                    switch ($registro['estatus']) {
                        case "Entregado":
                            $estatusClass = 'success';
                            break;
                        case "Pendiente":
                            $estatusClass = 'warning';
                            break;
                        case "Sin Entregar":
                            $estatusClass = 'danger';
                            break;
                    }
                    echo "<span class=\"row_estatus {$estatusClass}\">{$registro['estatus']}</span>"; ?>
                    <?php if ($_SESSION['user_role'] == 1) : ?>
                        <div class="row_actions">
                            <i class="fa-solid fa-pen-to-square" title="Modificar de <?= $registro["usuario_nombre"]; ?>" data-id="<?php echo $registro['id']; ?>" onclick="openModal('timebytimeEdit<?php echo $registro['id']; ?>')"></i>
                            <?php echo generateModalEditTimeByTime($registro["id"], $registro["folio"]);?>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php endforeach; ?>
        </div>
        <div class="no_result_message" id="noResultsMessage" style="display: none;">
            <span>No se encontraron coincidencias.</span>
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </div>
</div>

<script src="assets/js/search_document.js"></script>

<?php else : ?>
<div class="card_table">
    <div class="card_table_header">
        <h2><?php echo ($_SESSION['user_role'] == 3) ? "Mis registros" : "Tiempo por Tiempo"; ?></h2>
        <div class="card_header_actions">
            <?php if ($_SESSION['user_role'] == 1) : ?>
                <button class="btn_documento" onclick="openModal('timebytime')">Generar Registro</button>
            <?php endif; ?>
        </div>
    </div>
    <div class="card_table_body">
        <div class="card_table_message">
            <div class="no_result_message">
                <span>Aun no hay Tiempo por Tiempo por mostrar</span>
                <i class="fa-regular fa-folder-open"></i>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="assets/js/alert.js"></script>
<script src="assets/js/modal.js"></script>

<?php
//generar modal para subir documentos
if ($_SESSION['user_role'] == 1) {
echo generateModalDocumentForTime();
}

if (Session::exists('document_success')) {
echo showAlert('success', Session::get('document_success'));
echo "<script>hideAlert('success');</script>";
Session::delete('document_success');
}

if (Session::exists('document_warning')) {
echo showAlert('warning', Session::get('document_warning'));
echo "<script>hideAlert('warning');</script>";
Session::delete('document_warning');
}

if (Session::exists('document_error')) {
echo showAlert('error', Session::get('document_error'));
echo "<script>hideAlert('error');</script>";
Session::delete('document_error');
}
?>