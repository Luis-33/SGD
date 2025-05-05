<?php
require_once MODEL_PATH . "UserModel.php";
require_once SERVER_PATH . "DB.php";

function generateModalLicencias($areaAdscripcion_id)
{
    $db = new DB();
    $userModel = new UserModel($db);
    $usersList = $userModel->getUsersList();
    $areaAdscripcionId = $_SESSION['user_area'];
    $useName = $_SESSION['user_name'];
    $userRoleId = $_SESSION['user_role'];

    
    $diasRestantesPorUsuario = [];

    foreach ($usersList as $usuario) {
        $usuarioId = $usuario["usuario_id"];
        $fechaIngreso = new DateTime($usuario['usuario_fechaIngreso']);
        $fechaActual = new DateTime();
        $diferenciaDias = $fechaIngreso->diff($fechaActual)->days;

        $puestosEspeciales = [16, 17, 18, 19, 20, 21];
        $diasTotales = 0;
        if (in_array($usuario['puesto_id'], $puestosEspeciales)) {
            if ($diferenciaDias < 90) $diasTotales = 15;
            elseif ($diferenciaDias < 180) $diasTotales = 30;
            elseif ($diferenciaDias < 365) $diasTotales = 60;
            else $diasTotales = 180;
        } else {
            if ($diferenciaDias < 90) $diasTotales = 15;
            elseif ($diferenciaDias < 180) $diasTotales = 30;
            else $diasTotales = 60;
        }

        $diasUtilizados = 0;
        $licencias = $userModel->getLicenciasByUsuarioId($usuarioId);
        foreach ($licencias as $licencia) {
            if ($licencia['status'] === 'Entregado') {
                $inicio = new DateTime($licencia['fecha_salida']);
                $fin = new DateTime($licencia['fecha_regreso']);
                while ($inicio <= $fin) {
                    $dia = $inicio->format('N');
                    if ($dia < 6) $diasUtilizados++;
                    $inicio->modify('+1 day');
                }
            }
        }

        $diasRestantesPorUsuario[$usuarioId] = max(0, $diasTotales - $diasUtilizados);
    }

    $diasRestantesJson = json_encode($diasRestantesPorUsuario);

    $modal = "
    <div class=\"modal licencias\">
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2>Crear Licencias</h2>
                <button onclick=\"closeModal('licencias')\">Cerrar</button>
            </div>
            <div class=\"modal_body\">
                <form action=\"admin_home.php?page=licencias&action=licencias\" method=\"POST\" enctype=\"multipart/form-data\">

                <div class=\"input_group\">
                    <label for=\"empleado\">Empleado</label>
                    <div class=\"select_menu\" id=\"usuario_id_menu\">
                        <div class=\"select_btn\">
                            <span class=\"sBtn_text\">Selecciona al empleado</span>
                            <i class=\"fa-solid fa-chevron-down\"></i>
                        </div>
                        <ul class=\"options\">
                            <li class=\"input_group\">
                                <input type=\"text\" class=\"search_input\" placeholder=\"Buscar empleado...\" />
                            </li>";
    foreach ($usersList as $usuario) {
        if (($userRoleId != 1 && $userRoleId != 2) && $usuario['usuario_nombre'] == $useName) {
            continue;
        }
        if ($userRoleId == 4 && $usuario['areaAdscripcion_id'] != $areaAdscripcionId) {
            continue;
        }

        $modal .= "<li class=\"option\" data-value=\"" . $usuario["usuario_id"] . "\">
                       " . (empty($usuario["usuario_foto"]) ? '<img src="assets/images/avatar.png">' : '<img src="data:image;base64,' . base64_encode($usuario['usuario_foto']) . '" >') . "
                       <span>" . $usuario["usuario_nombre"] . "</span>
                   </li>";
    }

    $modal .= "
                        </ul>
                    </div>
                    <input type=\"hidden\" name=\"usuario_id\" id=\"usuario_id\" required>
                </div>

                <div id=\"dias_restantes_info\" style=\"margin-bottom:10px; font-weight:bold;\"></div>

                <div class=\"input_group\">
                    <label for=\"fecha_salida\">Fecha de Salida</label>
                    <input type=\"date\" id=\"fecha_salida\" name=\"fecha_salida\" required>
                </div>

                <div class=\"input_group\">
                    <label for=\"fecha_regreso\">Fecha de Regreso</label>
                    <input type=\"date\" id=\"fecha_regreso\" name=\"fecha_regreso\" required>
                </div>

                <input type=\"hidden\" name=\"status\" id=\"status\">
                <button class=\"insert_Licencias_btn\">Crear Licencias</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const diasRestantesPorUsuario = $diasRestantesJson;
        let diasRestantes = 0;

        $(document).ready(function () {
            $(document).on(\"click\", \".select_menu .select_btn\", function () {
                $(this).closest(\".select_menu\").toggleClass(\"active\");
            });

            $(document).on(\"click\", \".options .option\", function (e) {
                e.stopPropagation();

                $(this).closest('.options').find('.option').removeClass('selected');
                $(this).addClass('selected');

                let selectedOption = $(this).find(\"h3, span\").first().text() || $(this).text().trim();
                let selectedValue = $(this).data('value');

                $(this).closest(\".select_menu\").find(\".sBtn_text\").text(selectedOption);
                $(this).closest(\".select_menu\").toggleClass(\"active\");
                $('#usuario_id').val(selectedValue);

                diasRestantes = diasRestantesPorUsuario[selectedValue] || 0;
                document.getElementById('dias_restantes_info').innerText = 'Días restantes: ' + diasRestantes;
            });

            const searchInput = document.querySelector(\"#usuario_id_menu .search_input\");
            const options = document.querySelectorAll(\"#usuario_id_menu .option\");
            searchInput.addEventListener(\"input\", function () {
                const filter = this.value.toLowerCase().normalize(\"NFD\").replace(/[\u0300-\u036f]/g, \"\");
                options.forEach(option => {
                    const text = option.textContent.toLowerCase().normalize(\"NFD\").replace(/[\u0300-\u036f]/g, \"\");
                    option.style.display = text.includes(filter) ? \"\" : \"none\";
                });
            });

            const fechaSalidaInput = document.getElementById('fecha_salida');
            const fechaRegresoInput = document.getElementById('fecha_regreso');

            fechaSalidaInput.addEventListener('change', function () {
                const fechaSalida = new Date(this.value);
                if (isNaN(fechaSalida.getTime())) return;

                let diasDisponibles = diasRestantes;
                let fechaMaxima = new Date(fechaSalida);
                while (diasDisponibles > 0) {
                    fechaMaxima.setDate(fechaMaxima.getDate() + 1);
                    const diaSemana = fechaMaxima.getDay();
                    if (diaSemana !== 0 && diaSemana !== 6) {
                        diasDisponibles--;
                    }
                }

                fechaRegresoInput.max = fechaMaxima.toISOString().split('T')[0];
            });

            fechaRegresoInput.addEventListener('change', function () {
    const fechaSalida = new Date(fechaSalidaInput.value);
    const fechaRegreso = new Date(this.value);
    if (isNaN(fechaSalida.getTime()) || isNaN(fechaRegreso.getTime())) return;

    if (fechaRegreso < fechaSalida) {
        alert('La fecha de regreso no puede ser anterior a la fecha de salida.');
        this.value = '';
        return;
    }

    let diasSeleccionados = 0;
    let fechaTemp = new Date(fechaSalida);
    while (fechaTemp <= fechaRegreso) {
        const diaSemana = fechaTemp.getDay();
        if (diaSemana !== 0 && diaSemana !== 6) {
            diasSeleccionados++;
        }
        fechaTemp.setDate(fechaTemp.getDate() + 1);
    }

    if (diasSeleccionados > diasRestantes) {
        alert('No puedes seleccionar más días de los disponibles. Te quedan ' + diasRestantes + ' días.');
        this.value = '';
    }
});

            document.querySelector('form').addEventListener('submit', function (event) {
                const usuarioInput = document.getElementById('usuario_id');
                const sBtnText = document.querySelector('#usuario_id_menu .sBtn_text');
                if (sBtnText.innerText.trim() === 'Selecciona al empleado' || !usuarioInput.value.trim()) {
                    alert('Por favor selecciona un empleado antes de enviar el formulario.');
                    event.preventDefault();
                }
            });
        });
    </script>
    ";

    return $modal;
}
