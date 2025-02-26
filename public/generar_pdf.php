<?php
require __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial'); // Fuente predeterminada
$dompdf = new Dompdf($options);

// Contenido HTML del PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Mi PDF</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
    </style>
</head>
<body>
    <h1>Hola Mundo</h1>
    <h1>Hola juanito</h1>
    
    
        <table style="width:100%">
              <tr>
                <td>DIRECTOR(A) DE UNIDAD ACADÉMICA
Álvarez Arévalo Santiago Hommar
Ingeniero en Sistemas ZAA0256 Zapopan
Por este medio y de la mejor manera el (la) que suscribe trabajador (a) solicitante ____________________________________
con puesto de ______________________ y número de nómina ___________, de la Unidad Académica _____________________,
solicito DÍA DE CUMPLEAÑOS de conformidad a la Cláusula 54, párrafo primero de las Condiciones Generales de Trabajo del
Instituto Tecnológico José Mario Molina Pasquel y Henríquez</td>
              </tr>
        </table>
    

    <table style="width:100%">
  <tr>
    <td>Fecha de ingreso:</td>
    <td>1996-03-25</td>
  </tr>
  <tr>
    <td>Fecha de Cumpleaños::</td>
    <td>1983-04-25</td>
  </tr>
  
</table>
</body>
</html>';

// Cargar el HTML en Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait'); // Formato A4, vertical
$dompdf->render();

// Mostrar el PDF en el navegador
$dompdf->stream("hola_mundo.pdf", ["Attachment" => false]);
