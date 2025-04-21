<?php if (!empty($documents)) : ?>
    <div class="card_table">
        <div class="card_table_header">
            <h2><?php echo ($_SESSION['user_role'] == 3) ? "Mis Licencias" : "Licencias"; ?></h2>
            <div class="card_header_actions">

                <?php 
                $fechaIngreso = new DateTime($user['usuario_fechaIngreso']);
                $fechaActual = new DateTime();
                $diferenciaAnios = $fechaIngreso->diff($fechaActual)->y;
                $diasHabiles = 0;
                foreach ($documents as $licencia) {
                    if ($licencia['usuario_id'] == $user['usuario_id'] && $licencia['status'] === 'Entregado') {
                        $fechaSalida = new DateTime($licencia['fecha_salida']);
                        $fechaRegreso = new DateTime($licencia['fecha_regreso']);
                        while ($fechaSalida <= $fechaRegreso) {
                            $diaSemana = $fechaSalida->format('N'); 
                            if ($diaSemana < 6) {
                                $diasHabiles++;
                            }
                            $fechaSalida->modify('+1 day');
                        }
                    }
                }

                if ($diferenciaAnios >= 1 && $diferenciaAnios < 3) {
                    echo '<span class="dias_economicos"><span>' . $diasHabiles . '/15 días</span><i class="fa-solid fa-file-lines" title="Licencias"></i></span>';
                } elseif ($diferenciaAnios >= 3 && $diferenciaAnios < 6) {
                    echo '<span class="dias_economicos"><span>' . $diasHabiles . '/30 días</span><i class="fa-solid fa-file-lines" title="Licencias"></i></span>';
                } elseif ($diferenciaAnios >= 6) {
                    echo '<span class="dias_economicos"><span>' . $diasHabiles . '/60 días</span><i class="fa-solid fa-file-lines" title="Licencias"></i></span>';
                }
                ?>
                <button class="btn_entregadoo" data-status="Entregado" onclick="filterLicenciass('Entregado')">Entregados</button>
                <button class="btn_Pendiente" data-status="Pendiente" onclick="filterLicenciass('Pendiente')">Pendientes</button>
                <?php if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 4 || $_SESSION['user_role'] == 2) : ?>
                    <button class="btn_documento" onclick="openModal('licencias')">Crear Licencia</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="card_table_body">
            <div class="search_input" id="searchForm">
                <input type="text" id="searchInput" placeholder="<?php echo ($_SESSION['user_role'] == 3) ? "Buscar Licencia por Empleado - Fecha " : "Buscar Licencia por Empleado - Fecha " ?>">
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
                <?php foreach ($documents as $Licencias) : ?>
                    <div class="table_body_item" data-status="<?php echo $Licencias['status']; ?>">
                        <span class="row_pdf" title="Descargar Licencia">
                            <?php if ($Licencias['status'] === 'Entregado') : ?>
                                <a href="descargarlicencia.php?id=<?php echo $Licencias['id']; ?>" target="_blank">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                            <?php else : ?>
                                <a href="admin_home.php?registro_id=<?php echo $Licencias['id']; ?>&action=generarPdfLicencias&page=licencias" target="_blank" title="Generar PDF de <?= $Licencias["usuario_nombre"];?>"><i class="fa-solid fa-file-pdf"></i></a>
                            <?php endif; ?>
                        </span>
                        <?php if ($_SESSION['user_role'] != 3) : ?>
                            <div class="row_user_info">
                                <?php if ($Licencias['usuario_genero'] === 'H') {
                                    echo '<img src="assets/images/hombre.png">';
                                } else {
                                    echo '<img src="assets/images/mujer.png">';
                                } ?>
                                <div class="info">
                                    <span class="user_name"><?php echo $Licencias["usuario_nombre"]; ?></span>
                                    <span><?php echo $Licencias["usuario_email"]; ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <span class="row_fecha"><?php echo $Licencias["fecha_elaboracion"]; ?></span>
                        <?php 
                        $estatusClass = '';
                        switch ($Licencias['status']) {
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
                        echo "<span class=\"row_estatus {$estatusClass}\">{$Licencias['status']}</span>"; ?>
                        <?php if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 2  && $Licencias['status'] != 'Entregado') : ?>
                            <div class="row_actions">
                                
                                <i class="fa-solid fa-pen-to-square" 
                                    title="Modificar Licencia de <?= $Licencias["usuario_nombre"]; ?> " 
                                    data-id="<?php echo $Licencias['id']; ?>" 
                                    onclick="openModal('editlicencias<?php echo $Licencias['id']; ?>')">
                                </i>        
                            </div>
                        <?php endif; ?>
                        <?php echo generateModalEditLicencias($Licencias["id"]); ?>
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
            <h2><?php echo ($_SESSION['user_role'] == 3 || $_SESSION['user_role'] == 4) ? "Mis Licencias" : "Licencias"; ?></h2>
            <div class="card_header_actions">
                <?php if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 4 || $_SESSION['user_role'] == 2) : ?>
                    <button class="btn_documento" onclick="openModal('licencias')">Crear Licencia</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="card_table_body">
            <div class="card_table_message">
                <div class="no_result_message">
                    <span>Aún no hay Licencias por mostrar</span>
                    <i class="fa-regular fa-folder-open"></i>
                </div>
            </div>
        </div>
    </div>
    
<?php endif;  
?>

<script src="assets/js/modal.js"></script>
<script>
let currentStatusFilter = 'Pendiente';

function filterLicenciass(status) {
    currentStatusFilter = status;
    const items = document.querySelectorAll('.table_body_item');
    items.forEach(item => {
        if (status === 'Entregado') {
            item.style.display = item.getAttribute('data-status') === 'Entregado' ? '' : 'none';
        } else if (status === 'Pendiente') {
            item.style.display = item.getAttribute('data-status') !== 'Entregado' ? '' : 'none';
        }
    });
    filterSearch();
}

function filterSearch() {
    const filter = document.getElementById('searchInput').value.toLowerCase();
    const items = document.querySelectorAll('.table_body_item');
    items.forEach(item => {
        const userName = item.querySelector('.user_name') ? item.querySelector('.user_name').textContent.toLowerCase() : '';
        const fechaElaboracion = item.querySelector('.row_fecha').textContent.toLowerCase();
        const matchesFilter = userName.includes(filter) || fechaElaboracion.includes(filter);
        const matchesStatus = currentStatusFilter === 'Entregado' ? item.getAttribute('data-status') === 'Entregado' : item.getAttribute('data-status') !== 'Entregado';
        if (matchesFilter && matchesStatus) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) { 
        searchInput.addEventListener('input', filterSearch);
    }
    filterLicenciass('Pendiente');
});
</script>

<?php
if ($_SESSION['user_role'] == 1 || $_SESSION['user_role'] == 4 || $_SESSION['user_role'] == 2) {
    echo generateModalLicencias($_SESSION['user_area']);
}

if (Session::exists('Licencias_success')) {
    echo showAlert('success', Session::get('Licencias_success'));
    echo "<script>hideAlert('success');</script>";
    Session::delete('Licencias_success');
}
if (Session::exists('Licencias_warning')) {
    echo showAlert('warning', Session::get('Licencias_warning'));
    echo "<script>hideAlert('warning');</script>";
    Session::delete('Licencias_warning');
}
if (Session::exists('Licencias_error')) {
    echo showAlert('error', Session::get('Licencias_error'));
    echo "<script>hideAlert('error');</script>";
    Session::delete('Licencias_error');
}
?>
