<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formato Comisión</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 0; text-align: center; }
        .container { width: 90%; margin: auto; border: 2px solid black; padding: 20px; text-align: left; }
        .header, .footer { width: 100%; margin-bottom: 10px; text-align: center; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table th, .table td { border: 1px solid black; padding: 6px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .center { text-align: center; font-weight: bold; }
        .note { font-size: 10px; }
    </style>
</head>
<body>
<?php
include "./header.jpg";
$nombreImagen = "./header.jpg";
$imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));
?>

    <div class="header">
        <img src="./header.jpg" width="100%" height="50px">
        <!-- <img src="{{ url('./header.jpg') }}" width="100%" height="50px" /> -->
        <!-- <img src="<?php echo $imagenBase64 ?>" /> -->
    </div>

    <div class="container">
        <h2 class="center">TECNOLÓGICO SUPERIOR DE JALISCO ZAPOPAN</h2>
        <h3 class="center">COMISIÓN</h3>

        <table class="table">
            <tr>
                <th>Nombre:</th><td>&lt;&lt;nombre&gt;&gt;</td>
                <th>Fecha de elaboración:</th><td>&lt;&lt;fecha&gt;&gt;</td>
            </tr>
            <tr>
                <th>Cargo:</th><td>&lt;&lt;cargo&gt;&gt;</td>
                <th>Folio:</th><td><span style="color: red;">&lt;&lt;folio&gt;&gt;</span></td>
            </tr>
            <tr>
                <th>Departamento:</th><td>&lt;&lt;area&gt;&gt;</td>
                <th>Nómina:</th><td>&lt;&lt;nomina&gt;&gt;</td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th>LUGAR(ES):</th><td colspan="3">&lt;&lt;lugar&gt;&gt;</td>
            </tr>
            <tr>
                <th>ASUNTO:</th><td colspan="3">&lt;&lt;asunto&gt;&gt;</td>
            </tr>
            <tr>
                <th>Requiere Transporte:</th><td>&lt;&lt;transporte&gt;&gt;</td>
                <th>Requiere viáticos:</th><td>&lt;&lt;viaticos&gt;&gt;</td>
            </tr>
            <tr>
                <th>Especifique viáticos:</th><td colspan="3"><span style="color: red;">&lt;&lt;Eviaticos&gt;&gt;</span></td>
            </tr>
        </table>

        <h3 class="center">Fechas y Horarios</h3>
        <table class="table">
            <tr>
                <th>Fecha de Salida</th><th>Hora</th>
                <th>Fecha de Regreso</th><th>Hora</th>
            </tr>
            <tr>
                <td>&lt;&lt;salida&gt;&gt;</td><td>&lt;&lt;horas&gt;&gt;</td>
                <td>&lt;&lt;regreso&gt;&gt;</td><td>&lt;&lt;horar&gt;&gt;</td>
            </tr>
        </table>

        <h3 class="center">Observaciones</h3>
        <table class="table">
            <tr>
                <td colspan="4">&lt;&lt;obs&gt;&gt;</td>
            </tr>
        </table>

        <h3 class="center">Aprobaciones</h3>
        <table class="table">
            <tr>
                <th>Jefe Inmediato</th><td>&lt;&lt;Jefe Inmediato&gt;&gt;</td>
            </tr>
            <tr>
                <th>Puesto del Jefe</th><td>&lt;&lt;Puesto del Jefe&gt;&gt;</td>
            </tr>
            <tr>
                <th>Área de Adscripción</th><td>&lt;&lt;Area de Adscripcion&gt;&gt;</td>
            </tr>
        </table>

        <p class="center">Unidad Académica Zapopan del <a href="#">ITJMMPyH</a></p>
        <p class="center"><strong>Cinthia Lizeth Ramos Osuna</strong><br>Directora de la Unidad Académica Zapopan del ITJMMPyH</p>

        <p class="note">
            <strong>Nota:</strong> Se le recuerda que tiene 2 días naturales después de su regreso indicado, para entregar esta comisión SELLADA Y FIRMADA en el Depto. de Recursos Humanos.
        </p>
    </div>

    <div class="footer">
        <img src="./header.jpg" width="100%" height="50px">
    </div>

</body>
</html>
