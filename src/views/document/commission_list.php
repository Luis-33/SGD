<?php if (!empty($documents)) : ?>
    <div class="card_table">
        <div class="card_table_header">
            <h2><?php echo ($_SESSION['user_role'] == 3) ? "Mis Comisiones" : "Comisiones"; ?></h2>
            <div class="card_header_actions">
                <?php if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 4) : ?>
                    <button class="btn_documento" onclick="openModal('comision')">Crear Comisión</button>
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
                
                <span class="header_fecha">Fecha de Elaboración</span>
                <span class="header_estatus">Estatus</span>
                <?php if ($_SESSION['user_role'] == 1) : ?>
                    <span class="header_actions">Acciones</span>
                <?php endif; ?>
            </div>
            <div class="table_body" id="tableContainer">
                <?php foreach ($documents as $Commission) : ?>
                    <div class="table_body_item">
                        <span class="row_pdf" title="Descargar Comisión">
                            <a href="download.php?docID=<?php echo $Commission['id']; ?>"><i class="fa-solid fa-file-pdf"></i></a>
                        </span>
                        <?php if ($_SESSION['user_role'] != 3) : ?>
                            <div class="row_user_info">
                                <?php if ($Commission['usuario_genero'] === 'H') {
                                    echo '<img src="assets/images/hombre.png">';
                                } else {
                                    echo '<img src="assets/images/mujer.png">';
                                } ?>
                                <div class="info">
                                    <span class="user_name"><?php echo $Commission["usuario_nombre"]; ?></span>
                                    <span><?php echo $Commission["usuario_email"]; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <span class="row_fecha"><?php echo $Commission["fecha_elaboracion"]; ?></span>
                        <?php 
                        $estatusClass = '';
                        switch ($Commission['status']) {
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
                        echo "<span class=\"row_estatus {$estatusClass}\">{$Commission['status']}</span>"; ?>
                        <?php if ($_SESSION['user_role'] == 1) : ?>
                            <div class="row_actions">
                                
                                <i class="fa-solid fa-pen-to-square" 
                                    title="Modificar Comisión de <?= $Commission["usuario_nombre"]; ?> " 
                                    data-id="<?php echo $Commission['id']; ?>" 
                                    onclick="openModal('editCommissions<?php echo $Commission['id']; ?>')">
                                </i>        
                            </div>
                        <?php endif; ?>
                        <?php echo generateModalEditComision($Commission["id"]); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="no_result_message" id="noResultsMessage" style="display: none;">
                <span>No se encontraron coincidencias.</span>
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="card_table">
        <div class="card_table_header">
            <h2><?php echo ($_SESSION['user_role'] == 3 || $_SESSION['user_role'] == 4) ? "Mis Comisiones" : "Comisiones"; ?></h2>
            <div class="card_header_actions">
                <?php if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 4) : ?>
                    <button class="btn_documento" onclick="openModal('editCommissions')">Crear Comisión</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="card_table_body">
            <div class="card_table_message">
                <div class="no_result_message">
                    <span>Aún no hay comisiones por mostrar</span>
                    <i class="fa-regular fa-folder-open"></i>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script src="assets/js/modal.js"></script>

<?php
if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 4) {
    echo generateModalComision();
}

if (Session::exists('Commission_success')) {
    echo showAlert('success', Session::get('Commission_success'));
    echo "<script>hideAlert('success');</script>";
    Session::delete('Commission_success');
}
if (Session::exists('Commission_warning')) {
    echo showAlert('warning', Session::get('Commission_warning'));
    echo "<script>hideAlert('warning');</script>";
    Session::delete('Commission_warning');
}
if (Session::exists('Commission_error')) {
    echo showAlert('error', Session::get('Commission_error'));
    echo "<script>hideAlert('error');</script>";
    Session::delete('Commission_error');
}
?>
