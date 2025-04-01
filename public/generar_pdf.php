<?php
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$options->setChroot(__DIR__);
$dompdf = new Dompdf($options);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id == 2) {
        $path_template = __DIR__ . '/template-2.php';
    } elseif ($id == 3) {
        $path_template = __DIR__ . '/template-3.php';
    } else {
        $path_template = __DIR__ . '/template.php';
    }
} elseif (isset($_POST['template'])) {
    if ($_POST['template'] == 2) {
        $path_template = __DIR__ . '/template-2.php';
    } elseif ($_POST['template'] == 3) {
        $path_template = __DIR__ . '/template-3.php';
    } else {
        $path_template = __DIR__ . '/template.php';
    }
} else {
    
    $path_template = __DIR__ . '/template.php';
}

$html_content = file_get_contents($path_template);

$dompdf->loadHtml($html_content);
$dompdf->setPaper('A4', 'portrait'); 
$dompdf->render();

$dompdf->stream("hola_mundo.pdf", ["Attachment" => false]);
