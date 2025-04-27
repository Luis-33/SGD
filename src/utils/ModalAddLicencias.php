<?php

require_once MODEL_PATH . "UserModel.php";
require_once SERVER_PATH . "DB.php";

function generateModalLicencias($areaAdscripcion_id)

{
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
    $db = new DB();
    $userModel = new UserModel($db);
    $jefeInmediato = $userModel->getJefeInmediato($areaAdscripcion_id);
    $jefeInmediatoId = is_array($jefeInmediato) && isset($jefeInmediato[0]) ? $jefeInmediato[0] : null;
    if($jefeInmediatoId == 0){
        $usersList = $userModel->getUsersList1();
    }else{
        $usersList = $userModel->getUsersListJefeInmediato($jefeInmediatoId);
    }
    
    foreach ($usersList as $usuario) {
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
        var map;
        var marker;

        function openMapModal() {
            document.getElementById(\"mapModal\").style.display = \"block\";

            if (!map) {
                map = L.map('map').setView([20.6597, -103.3496], 13); // Coordenadas de CDMX

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(map);

                map.on('click', function(e) {
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    marker = L.marker(e.latlng).addTo(map);
                });
            }
        }

        function closeMapModal() {
            document.getElementById(\"mapModal\").style.display = \"none\";
        }



        function saveLocation() {
            if (marker) {
                var latlng = marker.getLatLng();
                var lat = latlng.lat;
                var lng = latlng.lng;

                // Llamar a la API de Nominatim para obtener la dirección
                var url = \"https://nominatim.openstreetmap.org/reverse?format=json&lat=\" + lat + \"&lon=\" + lng;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.display_name) {
                            document.getElementById(\"lugar\").value = data.display_name;
                        } else {
                            document.getElementById(\"lugar\").value = \"Ubicación no encontrada\";
                        }
                        closeMapModal();
                    })
                    .catch(error => {
                        console.error(\"Error obteniendo la dirección:\", error);
                        alert(\"No se pudo obtener la dirección. Intenta de nuevo.\");
                    });
            } else {
                alert(\"Por favor selecciona una ubicación en el mapa.\");
            }
        }
        
        function toggleTransporteFields() {
            var transporte = document.getElementById('transporte').value;
            var transporteFields = document.getElementById('transporte_fields');
            transporteFields.style.display = (transporte === 'Si') ? 'block' : 'none';
        }

        function togglekilometrajeField() {
            var transportePropio = document.getElementById('transporte_propio').value;
            var kilometrajeField = document.getElementById('kilometraje_field');
            kilometrajeField.style.display = (transportePropio === 'Si') ? 'none' : 'block';
        }
        
        function toggleViaticosField() {
            var viaticos = document.getElementById('viaticos').value;
            var especificacionViaticosField = document.getElementById('especificacion_viaticos_field');
            especificacionViaticosField.style.display = (viaticos === 'Si') ? 'block' : 'none';
        }

        $(document).ready(function () {
            $(document).on(\"click\", \".select_menu .select_btn\", function () {
                $(this).closest(\".select_menu\").toggleClass(\"active\");
            });

            $(document).on(\"click\", \".options .option\", function (e) {
                e.stopPropagation();

                $(this).closest('.options').find('.option').removeClass('selected');
                $(this).addClass('selected');

                // Se obtiene el texto de la opción; si no tiene <span> o <h3>, se toma el texto directo
                let selectedOption = $(this).find(\"h3, span\").first().text();
                if (!selectedOption) {
                    selectedOption = $(this).text().trim();
                }
                let selectedValue = $(this).data('value');

                $(this).closest(\".select_menu\").find(\".sBtn_text\").text(selectedOption);
                $(this).closest(\".select_menu\").toggleClass(\"active\");

                if ($(this).closest('.select_menu').attr('id') === 'usuario_id_menu') {
                    $('#usuario_id').val(selectedValue); // Asigna el ID del usuario al campo oculto
                } else if ($(this).closest('.select_menu').attr('id') === 'viaticos_menu') {
                    $('#viaticos').val(selectedValue);
                    toggleViaticosField();
                } else if ($(this).closest('.select_menu').attr('id') === 'transporte_menu') {
                    $('#transporte').val(selectedValue);
                    toggleTransporteFields();
                } else if ($(this).closest('.select_menu').attr('id') === 'transporte_propio_menu') {
                    $('#transporte_propio').val(selectedValue);
                    togglekilometrajeField();
                }
            });

            const chips = document.querySelectorAll('.chip');
            const input = document.getElementById('documentType');

            chips.forEach(chip => {
                chip.addEventListener('click', function () {
                    chips.forEach(c => {
                        c.classList.remove('selected');
                    });

                    this.classList.add('selected');
                    input.value = this.getAttribute('data-value');
                });
            });

        });

    document.addEventListener(\"DOMContentLoaded\", function () {
        const searchInput = document.querySelector(\"#usuario_id_menu .search_input\");
        const options = document.querySelectorAll(\"#usuario_id_menu .option\");

        // Filtrado en tiempo real
        searchInput.addEventListener(\"input\", function () {
            const filter = this.value.toLowerCase().normalize(\"NFD\").replace(/[\u0300-\u036f]/g, \"\");

            options.forEach(option => {
                const text = option.textContent.toLowerCase().normalize(\"NFD\").replace(/[\u0300-\u036f]/g, \"\");
                option.style.display = text.includes(filter) ? \"\" : \"none\";
            });
        });
    });
    
    </script>
    
    ";

    $diasTotalesPermitidos = 0;
    $fechaIngreso = new DateTime($usuario['usuario_fechaIngreso']);
    $fechaActual = new DateTime();
    $diferenciaAnios = $fechaIngreso->diff($fechaActual)->y;

    
    if ($diferenciaAnios >= 1 && $diferenciaAnios < 3) {
        $diasTotalesPermitidos = 15;
    } elseif ($diferenciaAnios >= 3 && $diferenciaAnios < 6) {
        $diasTotalesPermitidos = 30;
    } elseif ($diferenciaAnios >= 6) {
        $diasTotalesPermitidos = 60;
    }
    $diasUtilizados = 0;
    foreach ($userModel->getLicenciasByUsuarioId($usuario['usuario_id']) as $licencia) {
        if ($licencia['status'] === 'Entregado') {
            $fechaSalida = new DateTime($licencia['fecha_salida']);
            $fechaRegreso = new DateTime($licencia['fecha_regreso']);
            while ($fechaSalida <= $fechaRegreso) {
                $diaSemana = $fechaSalida->format('N'); 
                if ($diaSemana < 6) {
                    $diasUtilizados++;
                }
                $fechaSalida->modify('+1 day');
            }
        }
    }

    $diasRestantes = $diasTotalesPermitidos - $diasUtilizados;

    $modal .= "
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fechaSalidaInput = document.getElementById('fecha_salida');
            const fechaRegresoInput = document.getElementById('fecha_regreso');
            const diasRestantes = $diasRestantes;

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
        });
    </script>";

    return $modal;
}
