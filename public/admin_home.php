<?php

require_once '../src/config/config.php';
require_once CONTROLLER_PATH . 'DocumentController.php';
require_once CONTROLLER_PATH . 'TimeByTimeController.php';
require_once CONTROLLER_PATH . 'CommissionController.php';
require_once CONTROLLER_PATH . 'UserController.php';
require_once CONTROLLER_PATH . 'RolesController.php';
require_once CONTROLLER_PATH . 'PdfController.php';
require_once SERVER_PATH . 'DB.php';
require_once UTIL_PATH . 'Session.php';
require_once CONTROLLER_PATH . 'LicenciasController.php';

// Verify if session is active
Session::start();
if (!Session::isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$action = isset($_GET['action']) ? $_GET['action'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEW_PATH . 'content/include/header.php'; ?>

</head>

<body>

    <?php include VIEW_PATH . 'content/template/sidebar.php'; ?>

    <div class="container_main">

        <?php include VIEW_PATH . 'content/template/navbar.php'; ?>
        <div class="content">

            <?php

            $db = new DB();
            $userID = Session::get('user_id');
            $userRole = Session::get('user_role');
            $userController = new UserController($db);
            $documentController = new DocumentController($db);
            $CommissionController = new CommissionController($db);
            $RolesController = new RolesController($db);
            $TimeByTimeController = new TimeByTimeController($db);
            $licenciasController = new LicenciasController($db);
            $PdfController = new PdfController($db);

            switch ($page) {

                case 'dashboard':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if ($action === 'addDiaEconomico' && isset($_POST['permiso'], $_POST['start-date'], $_POST['end-date'])) {
                            $permiso = $_POST['permiso'];
                            $startDate = $_POST['start-date'];
                            $endDate = $_POST['end-date'];
                            $documentController->generateDiaEconomico($db, $userID, $startDate, $endDate, $permiso);
                            $documentController->sendEmail($db, $userID, null, 'created', 'Creación de documento', 'Dia economico', null);
                        } else if ($action === 'addDiaCumple' && isset($_POST['dayOption'])) {
                            $dayOption = $_POST['dayOption'];
                            $documentController->generateDiaCumple($db, $userID, $dayOption);
                            $documentController->sendEmail($db, $userID, null, 'created', 'Creación de documento', 'Dia de cumpleaños', null);
                        } else if ($action === 'addReporteIncidencia' && isset($_POST['fecha'], $_POST['incidencia'], $_POST['motivo'])) {
                            $date = $_POST['fecha'];
                            $incidencia = $_POST['incidencia'];
                            $motivo = $_POST['motivo'];
                            $documentController->generateReporteIncidencia($db, $userID, $incidencia, $date);
                            $documentController->sendEmail($db, $userID, null, 'created', 'Creación de documento', 'Reporte de incidencia', null);
                        } else if ($action === 'addDocument' && isset($_POST['user'], $_POST['documentType'], $_POST['date'], $_POST['status'])) {
                            $user = $_POST['user'];
                            $documentType = $_POST['documentType'];
                            $date = $_POST['date'];
                            $status = $_POST['status'];
                            $documentController->addDocument($user, $documentType, $date, $status);
                        } else if ($action === 'editDocument' && ($_POST['docID']) !== null && isset($_POST['documentoEstatus'])) {
                            $docID = $_POST['docID'];
                            $status = $_POST['documentoEstatus'];
                            $documentController->updateDocument($docID, $status);
                            $documentController->sendEmail($db, null, $docID, 'updated', 'Cambio de estatus del documento', null, $status);
                        } else {
                            $documentController->showAllDocuments($userRole, $userID);
                        }
                    } else {
                        $documentController->showAllDocuments($userRole, $userID);
                    }
                    break;
                case 'manage_users':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        print_r("usera");
                        if (
                            $action === 'addUser'
                            && isset($_POST['empleadoNomina'])
                            && isset($_POST['empleadoNombre'])
                            && isset($_POST['empleadoCurp'])
                            && isset($_POST['empleadoRFC'])
                            && isset($_POST['empleadoCorreo'])
                            && isset($_POST['empleadoGenero'])
                            && isset($_POST['empleadoIngreso'])
                            && isset($_POST['empleadoCumple'])
                            && isset($_POST['empleadoPuesto'])
                            && isset($_POST['empleadoAdscripcion'])
                            && isset($_POST['empleadoJefe'])
                            && isset($_POST['empleadoSindicato'])
                            && isset($_POST['empleadoRol'])
                        ) {
                            print_r("user");
                            $userNomina = $_POST['empleadoNomina'];
                            $userName = $_POST['empleadoNombre'];
                            $userCurp = $_POST['empleadoCurp'];
                            $userRFC = $_POST['empleadoRFC'];
                            $userEmail = $_POST['empleadoCorreo'];
                            $userGenero = $_POST['empleadoGenero'];
                            $userIngreso = $_POST['empleadoIngreso'];
                            $userCumple = $_POST['empleadoCumple'];
                            $userPuesto = $_POST['empleadoPuesto'];
                            $userAdscripcion = $_POST['empleadoAdscripcion'];
                            $userJefe = $_POST['empleadoJefe'];
                            $userSindicato = $_POST['empleadoSindicato'];
                            $userRol = $_POST['empleadoRol'];
                            $userController->addUser($userNomina, $userName, $userCurp, $userRFC, $userEmail, $userGenero, $userIngreso, $userCumple, $userPuesto, $userAdscripcion, $userJefe, $userSindicato, $userRol);
                        } else if (
                            $action === 'editUser'
                            && isset($_POST['empleadoID'])
                            && isset($_POST['empleadoNomina'])
                            && isset($_POST['empleadoNombre'])
                            && isset($_POST['empleadoCurp'])
                            && isset($_POST['empleadoRFC'])
                            && isset($_POST['empleadoCorreo'])
                            && isset($_POST['empleadoPuesto'])
                            && isset($_POST['empleadoAdscripcion'])
                            && isset($_POST['empleadoJefe'])
                            && isset($_POST['empleadoSindicato'])
                            && isset($_POST['empleadoRol'])
                            && isset($_POST['empleadoEstatus'])
                        ) {
                            $userID = $_POST['empleadoID'];
                            $userNomina = $_POST['empleadoNomina'];
                            $userName = $_POST['empleadoNombre'];
                            $userCurp = $_POST['empleadoCurp'];
                            $userRFC = $_POST['empleadoRFC'];
                            $userEmail = $_POST['empleadoCorreo'];
                            $userPuesto = $_POST['empleadoPuesto'];
                            $userAdscripcion = $_POST['empleadoAdscripcion'];
                            $userJefe = $_POST['empleadoJefe'];
                            $userSindicato = $_POST['empleadoSindicato'];
                            $userRol = $_POST['empleadoRol'];
                            $userStatus = $_POST['empleadoEstatus'];
                            $userController->updateUser($userID, $userNomina, $userName, $userCurp, $userRFC, $userEmail, $userPuesto, $userAdscripcion, $userJefe, $userSindicato, $userRol, $userStatus);
                        } else {
                            $userController->showAllUsers($userRole);
                        }
                        break;
                    } else {
                        $userController->showAllUsers($userRole);
                    }
                    break;
                case 'see_user':
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        if ($action === 'seeUser' && isset($_GET['userID'])) {
                            $userID = $_GET['userID'];
                            $userController->seeUser($userID);
                        }
                    }
                    break;
                case 'my_profile':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if ($action === 'update_password' && isset($_POST['new_password'])) {
                            $newPassword = $_POST['new_password'];
                            $userController->updatePassword($userID, $newPassword);
                        } else {
                            $userController->showProfile($userID);
                        }
                        break;
                    } else {
                        $userController->showProfile($userID);
                    }
                    break;
                

                case 'roles':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if ($action === 'save' && isset($_POST['rolNombre'])) {
                            $rolNombre = $_POST['rolNombre'];
                            $RolesController->addRole($rolNombre);
                        } else if ($action === 'delete' && isset($_POST['rolId'])) {
                            $rolId = $_POST['rolId'];
                            $RolesController->deleteRole($rolId);
                        } else if ($action === 'editRol' && isset($_POST['rolId'], $_POST['rolNombre'])) {
                            $rolId = $_POST['rolId'];
                            $rolNombre = $_POST['rolNombre'];
                            $RolesController->updateRole($rolId, $rolNombre);
                        } else {
                            $RolesController->showRoles($userRole, $userID);
                        }
                    } else {
                        $RolesController->showRoles($userRole, $userID);
                    }
                    break;
                case 'TimeByTime':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
                        if ($action === 'timebytime') {
                        $TimeByTimeController->generarRegistro($_POST); 
                        }else if ($action === 'timebytimeEdit') {
                            $TimeByTimeController->updateTimebyTimePagos($_POST);
                        }elseif ($action === 'timebytimeUploadFile') {
                            $TimeByTimeController->uploadFile($_POST, $_FILES);
                        }elseif ($action === 'timebytimeDeleteFile') {
                            $TimeByTimeController->deleteLogical($_POST);
                        }else {
                            $TimeByTimeController->showTimeByTime($userRole, $userID);
                        }
                    }else if($_SERVER['REQUEST_METHOD'] === 'GET'){
                        if ($action === 'timebytimeGenerarPdf') {
                            $id = isset($_GET['registro_id']) && !empty($_GET['registro_id']) ? intval($_GET['registro_id']) : null;
                            $PdfController->generarPdfTimeByTime($id);
                        }else {
                            $TimeByTimeController->showTimeByTime($userRole, $userID);
                        }
                     
                    }else{
                        $TimeByTimeController->showTimeByTime($userRole, $userID);
                    }
                    break;
                
                case 'commissions':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if ($action === 'comision') {
                            $return_data = array("success" => "0"); $fields = array();
                            $data = $CommissionController->describeTable("comisiones");

                            
                            if (!empty($data)) {
                                $fields = array_column($data, 'Field');
                                
                                foreach ($fields as $field) {
                                    $return_data[$field] = (isset($_POST[$field])) ? $_POST[$field] : false;
                                }
                                
                                $return_data["fecha_elaboracion"] = date("Y-m-d");
                                $return_data["status"] = "Pendiente";

                                $CommissionController->addComision($return_data);
                            }

                            header('Location: ' . $_SERVER['PHP_SELF'] . '?page=commissions');
                            exit;
                        } else if ($action === 'editCommissions') {
                            $return_data = array("success" => "0"); $fields = array();
                            $data = $CommissionController->describeTable("comisiones");
                            if (!empty($data)) {
                                $fields = array_column($data, 'Field');

                                foreach ($fields as $field) {
                                    $return_data[$field] = (isset($_POST[$field])) ? $_POST[$field] : false;
                                }

                                $return_data["status"] = "Entregado";
                                $CommissionController->updateCommission($return_data);
                            }
                            header('Location: ' . $_SERVER['PHP_SELF'] . '?page=commissions');
                            exit;
                        }else if ($action === 'deleteCommissions') {
                            $return_data = array("success" => "0"); $fields = array();
                            $data = $CommissionController->describeTable("comisiones");
                            if (!empty($data)) {
                                $fields = array_column($data, 'Field');

                                foreach ($fields as $field) {
                                    $return_data[$field] = (isset($_POST[$field])) ? $_POST[$field] : false;
                                }

                                $return_data["status"] = "Cancelado";
                                $CommissionController->updateCommission($return_data);
                            }
                            header('Location: ' . $_SERVER['PHP_SELF'] . '?page=commissions');
                            exit;
                        }
                    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        if ($action === 'generarPdfComissions') {
                            $id = isset($_GET['registro_id']) && !empty($_GET['registro_id']) ? intval($_GET['registro_id']) : null;
                            $PdfController->generarPdfComision($id);
                        } else {
                            $CommissionController->showCommission($userRole, $userID);
                        }
                    }else{
                        $CommissionController->showCommission($userRole, $userID);
                    }
                    break;
                case 'licencias':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if ($action === 'licencias') {
                            $return_data = array("success" => "0"); $fields = array();
                            $data = $CommissionController->describeTable("licencias");
                            if (!empty($data)) {
                                $fields = array_column($data, 'Field');

                                foreach ($fields as $field) {
                                    $return_data[$field] = (isset($_POST[$field])) ? $_POST[$field] : false;
                                }

                                $return_data["fecha_elaboracion"] = date("Y-m-d");
                                $return_data["status"] = "Pendiente";

                                $licenciasController->addLicencias($return_data);
                            }

                            header('Location: ' . $_SERVER['PHP_SELF'] . '?page=licencias');
                            exit;
                        } else if ($action === 'editlicencias') {
                            
                            $return_data = array("success" => "0"); $fields = array();
                            $data = $licenciasController->describeTable("licencias");
                            if (!empty($data)) {
                                $fields = array_column($data, 'Field');

                                foreach ($fields as $field) {
                                    $return_data[$field] = (isset($_POST[$field])) ? $_POST[$field] : false;
                                }

                                $return_data["status"] = "Entregado";
                                $licenciasController->updateLicencias($return_data);
                            }
                            header('Location: ' . $_SERVER['PHP_SELF'] . '?page=licencias');
                            exit;
                            
                        }
                        if ($action === 'deleteLicencia') {
                            $return_data = array("success" => "0"); $fields = array();
                            $data = $licenciasController->describeTable("licencias");
                            if (!empty($data)) {
                                $fields = array_column($data, 'Field');

                                foreach ($fields as $field) {
                                    $return_data[$field] = (isset($_POST[$field])) ? $_POST[$field] : false;
                                }

                                $return_data["status"] = "Cancelado";

                                
                                $licenciasController->updateLicencias($return_data);
                            }
                            header('Location: ' . $_SERVER['PHP_SELF'] . '?page=licencias');
                            exit;
                        }
                    
                    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        if ($action === 'generarPdfLicencias') {
                            $id = isset($_GET['Licencias_id']) && !empty($_GET['Licencias_id']) ? intval($_GET['Licencias_id']) : null;
                            // print_r($_GET['Licencias_id']);
                            // exit;   
                            $PdfController->generarPdfLicencias($id);
                        } else {
                            $licenciasController->showLicencias($userRole, $userID);
                        }
                    } else {
                        $licenciasController->showLicencias($userRole, $userID);
                        
                    }
                    break;    
                case 'configs':
                    break;

                default:
                    include VIEW_PATH . 'content/404.php';
                    break;
                }
            ?>
        </div>
    </div>

</body>

</html>