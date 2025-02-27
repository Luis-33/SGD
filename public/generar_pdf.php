<?php
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial'); // Fuente predeterminada
$dompdf = new Dompdf($options);


// Contenido HTML del PDF
$path_template = __DIR__ . '/template.php';
// Cargar el HTML en Dompdf
$html_content = file_get_contents($path_template);

$dompdf->loadHtml($html_content);
$dompdf->setPaper('A4', 'portrait'); // Formato A4, vertical
$dompdf->render();

// Mostrar el PDF en el navegador
$dompdf->stream("hola_mundo.pdf", ["Attachment" => false]);


function getPDF($name, $params)
{

}