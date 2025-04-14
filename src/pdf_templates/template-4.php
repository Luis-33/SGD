<?php
    $imagePath = 'C:/laragon/www/SGD/src/assets/images/header.jpg';
    $imageData = base64_encode(file_get_contents($imagePath));
    $header = 'data:image/jpeg;base64,' . $imageData;

    $imagePath2 = 'C:/laragon/www/SGD/src/assets/images/footer_3.jpg';
    $imageData2 = base64_encode(file_get_contents($imagePath2));
    $footer_3 = 'data:image/jpeg;base64,' . $imageData2;

    $imagePath3 = 'C:/laragon/www/SGD/src/assets/images/footer_2.jpg';
    $imageData3 = base64_encode(file_get_contents($imagePath3));
    $footer_2 = 'data:image/jpeg;base64,' . $imageData3;

    $imagePath4 = 'C:/laragon/www/SGD/src/assets/images/footer_1.jpg';
    $imageData4 = base64_encode(file_get_contents($imagePath4));
    $footer_1 = 'data:image/jpeg;base64,' . $imageData4;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte <?=htmlspecialchars($nombreArchivo)?></title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { margin: 20px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
    <img src="<?= $header ?>" style="width:100%; height:70px;">
    </div>

    <div class="container">
        <h1>Reporte TimeByTime</h1>
        <p><strong>Folio:</strong><?=htmlspecialchars($registro['folio'])?></p>
        <p><strong>Usuario:</strong><?=htmlspecialchars($registro['usuario_nombre'] ?? 'No registrado')?></p>
        <p><strong>Fecha:</strong><?=htmlspecialchars($registro['fechaR'])?></p>
        <!-- Agrega más datos según los campos disponibles -->
    </div>
    <div class="footer">
        <img src="<?= $footer_3 ?>" width="100%" height="50px">
    </div>
</body>
</html>