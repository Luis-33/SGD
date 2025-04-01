<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formato Comisión</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            width: 90%;
            margin: auto;
            border: 2px solid black;
            padding: 20px;
            text-align: left;
        }
        .header, .footer {
            width: 100%;
            margin-bottom: 10px;
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .table th, .table td {
            border: 1px solid black;
            padding: 6px;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .center {
            text-align: center;
            font-weight: bold;
        }
        .note {
            font-size: 10px;
            text-align: justify;
        }
        .signature {
            margin-top: 30px;
            text-align: center;
        }
        .signature p {
            margin: 0;
            font-size: 12px;
        }
        .footer img {
            width: 100%;
            height: 70px;
        }
    </style>
</head>
<body>
<?php
?>

    <div class="header">
        <img src="./head.jpg" width="100%" height="70px">
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
                <th>Requiere Transporte:</th><td colspan="3">&lt;&lt;transporte&gt;&gt;</td>
            </tr>
            <tr>
                <th>Requiere viáticos:</th><td colspan="3">&lt;&lt;viaticos&gt;&gt;</td>
            <tr>
                <th>Especifique viáticos:</th><td colspan="3"><span style="color: red;">&lt;&lt;Eviaticos&gt;&gt;</span></td>
            </tr>
        </table>

        <h3 class="center">Observaciones</h3>
        <table class="table">
            <tr>
                <td colspan="4">&lt;&lt;obs&gt;&gt;</td>
            </tr>
        </table>

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

        <table class="table">
            <tr>
                <th>Unidad Académica</th>
                <td>Zapopan del <strong>ITJMMPyH</strong></td>
            </tr>
            <tr>
                <th>Nombre del Director</th>
                <td>Cinthia Lizbeth Ramos Osuna</td>
            </tr>
            <tr>
                <th>Puesto</th>
                <td>Directora de la Unidad Académica Zapopan del ITJMMPyH</td>
            </tr>
        </table>

        <p class="note">
            <strong>Nota:</strong> Se le recuerda que tiene 2 días naturales después de su regreso indicado, para entregar esta comisión SELLADA Y FIRMADA como a continuación se detalla: En el Depto. de Recursos Humanos: Comisión en original, ficha informativa y copia del reporte de incidencias.
        </p>

    </div>
    <div class="footer">
        <img src="./footer.jpg" width="100%" height="50px">
    </div>
</body>
</html>
