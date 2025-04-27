<link rel="stylesheet" href="assets/css/components/table.css">
<link rel="stylesheet" href="assets/css/components/modal.css">
<link rel="stylesheet" href="assets/css/components/dropdown.css">
<link rel="stylesheet" href="assets/css/components/chips.css">
<link rel="stylesheet" href="assets/css/components/alerts.css">
<link rel="stylesheet" href="assets/css/admin/dashboard.css">
<link rel="stylesheet" href="assets/css/admin/see_user.css">
<link rel="stylesheet" href="assets/css/admin/manage_users.css">

<script>
    function confirmDelete(id, data) {
        const modalContent = `
        <div class="modal confirmDelete">
            <div class="modal_content">
               <form method="post" action="admin_home.php?page=absences&action=remove">
                <input type="hidden" name="absence_id" value="${id}">
                 <div class="modal_header">
                    <h2>Confirmar Eliminación</h2>
                        <button onclick="closeModal('confirmDelete')">Cerrar</button>
                    </div>
                    <div class="modal_body">
                        <p>¿Estás seguro de que deseas eliminar el registro de: <strong>${data}</strong>?</p>
                        <div class="modal_actions">
                            <button type="submit" class="btn_confirm">Eliminar</button>
                            <button onclick="closeModal('confirmDelete')" class="btn_cancel">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `;
        document.body.insertAdjacentHTML('beforeend', modalContent);
        openModal('confirmDelete');
    }

    function addRol() {
        const modalContent = `
        <div class="modal addRol">
            <div class="modal_content">
                <div class="modal_header">
                    <h2>Agregar Rol</h2>
                    <button onclick="closeModal('addRol')">Cerrar</button>
                </div>
                <div class="modal_body
                ">
                    <form action="index.php?page=roles" method="POST" id="addRolForm">
                        <div class="form_group
                        ">
                            <label for="rolNombre">Nombre del Rol</label>
                            <div class=\"input_group\">
                                <input class="search_input" type="text" name="rolNombre" id="rolNombre" required>
                            </div>
                        </div>
                        <div class="modal_actions">
                            <button type="submit" class="btn_confirm">Agregar</button>
                            <button type="button" onclick="closeModal('addRol')" class="btn_cancel">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
        document.body.insertAdjacentHTML('beforeend', modalContent);
        openModal('addRol');
    }

    function editRol(rolId, rolName) {
        const modalContent = `
        <div class="modal editRol">
            <div class="modal_content">
                <div class="modal_header">
                    <h2>Editar Rol</h2>
                    <button onclick="closeModal('editRol')">Cerrar</button>
                </div>
                <div class="modal_body">
                    <form action="admin_home.php?page=roles&action=editRol" method="POST" id="editRolForm">
                        <input type="hidden" name="rolId" value="${rolId}">
                        <div class="form_group">
                            <label for="rolNombre">Nombre del Rol</label>
                            <div class="input_group">
                                <input class="search_input" type="text" name="rolNombre" id="rolNombre" value="${rolName}" required>
                            </div>
                        </div>
                        <div class="modal_actions">
                            <button type="submit" class="btn_confirm">Guardar cambios</button>
                            <button type="button" onclick="closeModal('editRol')" class="btn_cancel">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;
        document.body.insertAdjacentHTML('beforeend', modalContent);
        openModal('editRol');
    }

</script>


<?php if (!empty($return_data)) : ?>

    <div class="card_table">
        <div class="card_table_header">
            <h2>Incapacidades</h2>
            <div class="card_header_actions">
                <button class="btn_documento" onclick="addRol()">Agregar</button>
            </div>
        </div>
        <div class="card_table_body">
        <div class="search_input" id="searchForm">
            <input type="text" id="searchInput" placeholder="Buscar">
            <i class="fa-solid fa-xmark" id="clear_input"></i>
        </div>
            <div class="table_header">
                <span class="header_tipo">ID</span>
                <span class="header_fecha">Usuario</span>
                <span class="header_fecha">Folio</span>
                <span class="header_fecha">Inicio</span>
                <span class="header_fecha">Fin</span>
                <span class="header_fecha">Estado</span>
                <span class="header_actions">Acciones</span>
            </div>
            <div class="table_body" id="tableContainer">
                <?php foreach ($return_data as $absence) : ?>
                    <div class="table_body_item">
                        <span class="row_tipo"><?php echo $absence["absence_id"]; ?></span>
                        <span class="row_fecha"><?php echo htmlspecialchars($absence["full_name"]); ?></span>
                        <span class="row_fecha"><?php echo htmlspecialchars($absence["folio_number"]); ?></span>
                        <span class="row_fecha"><?php echo htmlspecialchars($absence["start_date"]); ?></span>
                        <span class="row_fecha"><?php echo htmlspecialchars($absence["end_date"]); ?></span>
                        <span class="row_fecha">
                <?php echo $absence["is_open"] === '1' ? 'Abierto' : 'Cerrado'; ?>
            </span>
                        <?php if ($_SESSION['user_role'] == 1) : ?>
                            <div class="row_actions">
                                <i class="fa-solid fa-pen-to-square"
                                   title="Modificar"
                                   data-id="<?= $absence['absence_id']; ?>"
                                   onclick="editAbsence(
                                   <?= $absence['absence_id']; ?>,
                                           '<?= addslashes($absence['folio_number']); ?>',
                                           '<?= $absence['start_date']; ?>',
                                           '<?= $absence['end_date']; ?>',
                                           '<?= $absence['is_open']; ?>'
                                           )">
                                </i>
                                <i class="fa-solid fa-trash-can"
                                   title="Eliminar"
                                   onclick="confirmDelete(<?= $absence['absence_id']; ?>, '<?= addslashes($absence['full_name']); ?>')">
                                </i>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        <div class="no_result_message" id="noResultsMessage" style="display: none;">
            <span>No se roles con el nombre ingresado</span>
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </div>
    </div>

<?php

?>

<script src="assets/js/search_document.js"></script>
<script src="assets/js/alert.js"></script>
<script src="assets/js/modal.js"></script>

<?php endif; ?>

<?php

if ($_SESSION['user_role'] == 1) {
//echo generateModalRol();
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