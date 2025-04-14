<?php 
require __DIR__ . '/../../vendor/autoload.php';
require_once MODEL_PATH . 'TimeByTimeModel.php';
require_once MODEL_PATH . 'CommissionsModel.php';

use Dompdf\Dompdf;
use Dompdf\Options;

Class PdfController{

    private $TimeByTimeModel;
    private $ComisionModel;

    public function __construct($db)
    {
        $this->TimeByTimeModel = new TimeByTimeModel($db);
        $this->ComisionModel = new CommissionsModel($db);
    }

    public function generarPdfTimeByTime($id) {
        //print_r($data); exit;
        //print_r($id); exit;
        if($id === null) {
            Session::set('document_warning', 'Error al generar el documento');
            echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            exit;
        }

        $registro = $this->TimeByTimeModel->getRegistroById($id);
        if(!$registro){
           Session::set('document_warning', 'Error al generar el documento, no se ha encontrado el registro en la base de datos');
           echo "<script>$(location).attr('href', 'admin_home.php?page=TimeByTime');</script>";
            exit; 
        }
        $pagosMismoDia = [];

        if (!empty($registro['faltas']) && !empty($registro['pagos'])) {
            foreach ($registro['faltas'] as $falta) {
                foreach ($registro['pagos'] as $pago) {
                    if ($falta['fechaF'] === $pago['fechaP']) {
                        $pagosMismoDia[] = $falta['fechaF'];
                    }
                }
            }
        }
        $pagosMismoDia = array_unique($pagosMismoDia);
        $registro['pagos_mismo_dia'] = $pagosMismoDia;
        //print_r($registro); exit;

        $nombreArchivo = "{$registro['usuario_nombre']} {$registro['usuario_nomina']} Folio {$registro['folio']}";
        
        ob_start();
        include __DIR__ . '/../pdf_templates/template-4.php'; // ruta relativa al archivo actual
        $html = ob_get_clean();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->setChroot('C:/laragon/www/SGD');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        ob_end_clean();
        // 🔥 Nada debe imprimirse antes de esta línea
        $dompdf->stream("$nombreArchivo.pdf", ["Attachment" => false]);
        exit;
    }

    public function generarPdfComision($id) {
        if($id === null) {
            Session::set('document_warning', 'Error al generar el documento');
            echo "<script>$(location).attr('href', 'admin_home.php?page=Commissions');</script>";
            exit;
        }

        $comision = $this->ComisionModel->getCommissionsById($id);
        if(!$comision){
           Session::set('document_warning', 'Error al generar el documento, no se ha encontrado el registro en la base de datos');
           echo "<script>$(location).attr('href', 'admin_home.php?page=Commissions');</script>";
            exit; 
        }
        $nombreArchivo = "{$comision['nombre']} {$comision['usuario_nomina']} Folio {$comision['folio']}";
        //print_r($registro); exit;
        ob_start();
        include __DIR__ . '/../pdf_templates/template-3.php'; // ruta relativa al archivo actual
        $html = ob_get_clean();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->setChroot('C:/laragon/www/SGD');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        ob_end_clean();
        // 🔥 Nada debe imprimirse antes de esta línea
        $dompdf->stream("$nombreArchivo.pdf", ["Attachment" => false]);
        exit;
    }
}
?>