<?php

require_once MODEL_PATH . "ConfigModel.php";
require_once MODEL_PATH . "UserModel.php";
require_once SERVER_PATH . "DB.php";

function generateModalAddUser()
{

    $db = new DB();
    $configModel = new ConfigModel($db);

    $modal = "
    <div class=\"modal addUser\">
        <div class=\"modal_content\">
            <div class=\"modal_header\">
                <h2></h2>
                <button onclick=\"closeModal('addUser')\">Cerrar</button>
            </div>
            <div class=\"modal_body\">
                <form action=\"admin_home.php?page=manage_users&action=addUser\" method=\"POST\">
                    
                    <div class=\"input_group\">
                        <label for=\"empleadoNombre\">Nombre</label>
                        <input type=\"text\" name=\"empleadoNombre\" id=\"empleadoNombre\" placeholder=\"Ingresa el nombre del empleado\" required>
                    </div>

                    <div class=\"input_group\">
                        <label for=\"empleadoCorreo\">Correo</label>
                        <input type=\"email\" name=\"empleadoCorreo\" id=\"empleadoCorreo\" placeholder=\"Ingresa el correo del empleado\">
                    </div>

                    <div class=\"input_group\">
                        <label for=\"empleadoCurp\">Curp</label>
                        <input type=\"text\" name=\"empleadoCurp\" id=\"empleadoCurp\" placeholder=\"Ingresa el curp del empleado\"  
                        pattern=\"^[A-Z]{4}[0-9]{6}[HM]{1}[A-Z]{2}[A-Z0-9]{3}[0-9A-Z]{2}$\" 
                        title=\"El CURP debe seguir el formato correcto (AAAA000101HDFRRL09)\" required >
                    </div>

                    <div class=\"input_group\">
                        <label for=\"empleadoRFC\">RFC</label>
                        <input type=\"text\" name=\"empleadoRFC\" id=\"empleadoRFC\" placeholder=\"Ingresa el rfc del empleado\"
                        pattern=\"^[A-ZÑ&]{3,4}[0-9]{6}[A-Z0-9]{3}$\"
                        title=\"El RFC debe seguir el formato correcto (por ejemplo, ABCD123456XYZ)\" required>
                    </div>

                    <div class=\"input_group\">
                        <label for=\"empleadoNomina\">Numero de nomina</label>
                        <input type=\"text\" name=\"empleadoNomina\" id=\"empleadoNomina\" placeholder=\"Ingresa el numero de nomina del empleado\" 
                        pattern=\"^[A-ZÑ&]{3}[0-9]{4}$\"
                        title=\"El RFC debe seguir el formato correcto (por ejemplo, ABC1234 )\" required>required >
                    </div>

                    <div class=\"input_group\">
                        <label for=\"empleadoIngreso\">Fecha de ingreso</label>
                        <input type=\"date\" name=\"empleadoIngreso\" id=\"empleadoIngreso\" placeholder=\"Selecciona la fecha de ingreso del empleado\" required>
                    </div>

                    <div class=\"input_group\">
                        <label for=\"empleadoCumple\">Dia de cumpleaños</label>
                        <input type=\"date\" name=\"empleadoCumple\" id=\"empleadoCumple\" required>
                    </div>
                
                    <div class=\"input_group\">
                        <label for=\"empleadoGenero\">Genero</label>
                        <div class=\"select_menu\" id=\"empleadoGenero\">
                            <div class=\"select_btn\">
                                <span class=\"sBtn_text\">Selecciona el genero del empleado</span>
                                <i class=\"fa-solid fa-chevron-down\"></i>
                            </div>
                            <ul class=\"options\">
                                <li class=\"option\" data-value=\"H\">
                                    <span>Hombre</span>
                                </li>
                                <li class=\"option\" data-value=\"M\">
                                    <span>Mujer</span>
                                </li>
                            </ul>
                        </div>
                        <input type=\"hidden\" id=\"selectedGenero\" name=\"empleadoGenero\" required>
                            
                        <script>
                                // Función para mostrar/ocultar el dropdown
                                function toggleDropdown() {
                                    const menu = document.getElementById(\"empleadoGenero\");
                                    menu.classList.toggle(\"active\");
                                }

                                // Función para manejar la selección
                                const options = document.querySelectorAll(\".option\");
                                options.forEach(option => {
                                    option.addEventListener(\"click\", () => {
                                        const selectedValue = option.getAttribute(\"data-value\");
                                        const displayText = option.innerText;
                                        
                                        // Establecer el valor seleccionado en el input oculto
                                        document.getElementById(\"selectedGenero\").value = selectedValue;

                                        // Actualizar el texto en el botón
                                        document.querySelector(\".sBtn_text\").innerText = displayText;
                                        
                                        // Cerrar el menú
                                        toggleDropdown();
                                    });
                                });

                                // Validación del formulario
                                const form = document.querySelector(\"form\"); // Asegúrate de que esté en un formulario
                                form.addEventListener(\"submit\", function(event) {
                                    if (!document.getElementById(\"selectedGenero\").value) {
                                        alert(\"Por favor, selecciona un género.\");
                                        event.preventDefault(); // Evitar el envío del formulario
                                    }
                                });
                                </script>

                    </div>

                    <div class=\"input_group\">
                        <label for=\"empleadoRol\">Rol</label>
                        <div class=\"select_menu\" id=\"empleadoRol\">
                            <div class=\"select_btn\">
                                <span class=\"sBtn_text\">Selecciona el rol del empleado</span>
                                <i class=\"fa-solid fa-chevron-down\"></i>
                            </div>
                            <ul class=\"options\">";

    $rolList = $configModel->getRoles();

    foreach ($rolList as $rol) {
        $modal .= "<li class=\"option\" data-value=\"" . $rol["rol_id"] . "\">
                       <span>" . $rol["rol_nombre"] . "</span>
                   </li>
                   
                   ";
    }


    $modal .= "
                            </ul>

                        </div>

                    </div>
                    
                    <div class=\"input_group\">
                        <label for=\"empleadoRol\">Puesto</label>
                        <div class=\"select_menu\" id=\"empleadoPuesto\">
                            <div class=\"select_btn\">
                                <span class=\"sBtn_text\">Selecciona el puesto del empleado</span>
                                <i class=\"fa-solid fa-chevron-down\"></i>
                            </div>
                            <ul class=\"options\">";

    $puestoList = $configModel->getPuestos();

    foreach ($puestoList as $puesto) {
        $modal .= "<li class=\"option\" data-value=\"" . $puesto["puesto_id"] . "\">
                       <span>" . $puesto["puesto_nombre"] . "</span> 
                   </li>";
    }


    $modal .= "
                            </ul>

                        </div>

                    </div>
                    
                    <div class=\"input_group\">
                        <label for=\"empleadoRol\">Jefe inmediato</label>
                        <div class=\"select_menu\" id=\"empleadoInmediato\">
                            <div class=\"select_btn\">
                                <span class=\"sBtn_text\">Selecciona al jefe inmediato</span>
                                <i class=\"fa-solid fa-chevron-down\"></i>
                            </div>
                            <ul class=\"options\">";

    $jefesList = $configModel->getJefes();

    foreach ($jefesList as $jefe) {
        $modal .= "<li class=\"option\" data-value=\"" . $jefe["jefeInmediato_id"] . "\">
                        " . (empty($jefe["usuario_foto"]) ? '<img src="assets/images/avatar.png">' : '<img src="data:image;base64,' . base64_encode($jefe['usuario_foto']) . '" >') . "
                        <div class=\"jefeInmediato_info\">
                            <h3>" . $jefe['jefeInmediato_nombre'] . "</h3>
                            <span>" . $jefe["areaAdscripcion_nombre"] . "</span> 
                        </div>
                   </li>";
    }


    $modal .= "
                            </ul>

                        </div>

                    </div>
                    
                    <div class=\"input_group\">
                        <label for=\"empleadoRol\">Area de adscripción</label>
                        <div class=\"select_menu\" id=\"empleadoAdscripcion\">
                            <div class=\"select_btn\">
                                <span class=\"sBtn_text\">Selecciona el area de adscripción</span>
                                <i class=\"fa-solid fa-chevron-down\"></i>
                            </div>
                            <ul class=\"options\">";

    $areasList = $configModel->getAreas();

    foreach ($areasList as $area) {
        $modal .= "<li class=\"option\" data-value=\"" . $area["areaAdscripcion_id"] . "\">
                        <span>" . $area["areaAdscripcion_nombre"] . "</span> 
                   </li>";
    }


    $modal .= "
                            </ul>

                        </div>

                    </div>
                    
                    <div class=\"input_group\">
                        <label for=\"empleadoRol\">Sindicato</label>
                        <div class=\"select_menu\" id=\"empleadoSindicato\">
                            <div class=\"select_btn\">
                                <span class=\"sBtn_text\">Selecciona el sindicato</span>
                                <i class=\"fa-solid fa-chevron-down\"></i>
                            </div>
                            <ul class=\"options\">";

    $sindicatosList = $configModel->getSindicatos();

    foreach ($sindicatosList as $sindicato) {
        $modal .= "<li class=\"option\" data-value=\"" . $sindicato["sindicato_id"] . "\">
                        <span>" . $sindicato["sindicato_nombre"] . "</span> 
                   </li>";
    }


    $modal .= "
                            </ul>

                        </div>

                    </div>

                    <input type=\"hidden\" name=\"empleadoGenero\" id=\"genero\">
                    <input type=\"hidden\" name=\"empleadoRol\" id=\"rol\">
                    <input type=\"hidden\" name=\"empleadoPuesto\" id=\"puesto\">
                    <input type=\"hidden\" name=\"empleadoJefe\" id=\"jefe\">
                    <input type=\"hidden\" name=\"empleadoAdscripcion\" id=\"adscripcion\">
                    <input type=\"hidden\" name=\"empleadoSindicato\" id=\"sindicato\">

                    <button type=\"submit\">Agregar empleado</button>
                </form>
            </div>
        </div>
    </div>

<script>

$(document).ready(function () {
    $(document).on(\"click\", \".select_menu .select_btn\", function () {
        $(this).closest(\".select_menu\").toggleClass(\"active\");
    });

    $(document).on(\"click\", \".options .option\", function (e) {
        e.stopPropagation();

        $(this).closest('.options').find('.option').removeClass('selected');
        $(this).addClass('selected');

        let selectedOption = $(this).find(\"h3, span\").first().text();
        let selectedValue = $(this).data('value');

        $(this).closest(\".select_menu\").find(\".sBtn_text\").text(selectedOption);
        $(this).closest(\".select_menu\").toggleClass(\"active\");

        if ($(this).closest('.select_menu').attr('id') === 'empleadoGenero') {
            $('#genero').val(selectedValue);
        } else if ($(this).closest('.select_menu').attr('id') === 'empleadoRol') {
            $('#rol').val(selectedValue);
        } else if($(this).closest('.select_menu').attr('id') === 'empleadoPuesto'){
            $('#puesto').val(selectedValue);
        }else if($(this).closest('.select_menu').attr('id') === 'empleadoInmediato'){
            $('#jefe').val(selectedValue);
        }else if($(this).closest('.select_menu').attr('id') === 'empleadoAdscripcion'){
            $('#adscripcion').val(selectedValue);
        }else if($(this).closest('.select_menu').attr('id') === 'empleadoSindicato'){
            $('#sindicato').val(selectedValue);
        }
    });

});

</script>

";

    return $modal;
}
