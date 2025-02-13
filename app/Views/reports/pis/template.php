<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Proyectos Integradores de Saberes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 10px;
        }
        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .department {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .report-info {
            font-size: 12px;
            margin-bottom: 20px;
        }
        .filter-info {
            font-size: 12px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .estado {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9px;
            color: white;
            display: inline-block;
        }
        .estado-finalizado { background-color: #28a745; }
        .estado-en-cierre { background-color: #17a2b8; }
        .estado-en-ejecucion { background-color: #007bff; }
        .estado-detenido { background-color: #ffc107; color: #000; }
        .estado-cancelado { background-color: #dc3545; }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 10px;
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            background-color: white;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(200, 200, 200, 0.2);
            z-index: -1;
        }
        /* Ajustes para tabla horizontal */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        th {
            white-space: nowrap;
        }
        td {
            word-wrap: break-word;
            max-width: 200px;
        }
    </style>
</head>
<body>
    <div class="watermark">ITSI</div>
    
    <div class="header">
        <!-- Logo del ITSI -->        
        <img src="<?= base_url('uploads/logo.png'); ?>" class="logo" alt="ITSI Logo">
        <div class="department"><?= $department ?></div>
        <div class="report-title"><?= $reportTitle ?></div>
        
        <?php if (!empty($filterInfo)): ?>
            <div class="filter-info">
                <?= implode(' | ', $filterInfo) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Programa</th>
                    <th>Estado</th>
                    <th>Línea de Investigación</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Fuente Financiamiento</th>
                    <th>Año</th>
                    <th>Participante</th>
                    <th>Objetivo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proyectos as $proyecto): ?>
                <tr>
                    <td><?= $proyecto['nombre'] ?></td>
                    <td><?= $proyecto['nombre_programa'] ?? 'No asignado' ?></td>
                    <td>
                        <?php
                        $estadoClass = '';
                        switch($proyecto['estado']) {
                            case 'Finalizado': $estadoClass = 'estado-finalizado'; break;
                            case 'En Cierre': $estadoClass = 'estado-en-cierre'; break;
                            case 'En Ejecución': $estadoClass = 'estado-en-ejecucion'; break;
                            case 'Detenido': $estadoClass = 'estado-detenido'; break;
                            case 'Cancelado': $estadoClass = 'estado-cancelado'; break;
                        }
                        ?>
                        <span class="estado <?= $estadoClass ?>"><?= $proyecto['estado'] ?></span>
                    </td>
                    <td><?= $proyecto['nombre_linea'] ?? 'No asignado' ?></td>
                    <td><?= date('d/m/Y', strtotime($proyecto['fecha_inicio'])) ?></td>
                    <td><?= $proyecto['fecha_fin_real'] ? date('d/m/Y', strtotime($proyecto['fecha_fin_real'])) : date('d/m/Y', strtotime($proyecto['fecha_fin_planificado'])) ?></td>
                    <td><?= $proyecto['fuente_financiamiento'] ?></td>
                    <td><?= $proyecto['anio'] ?></td>
                    <td><?= $proyecto['participante'] ?></td>
                    <td><?= $proyecto['objetivo'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        Instituto Tecnológico Superior Ibarra<br>
        Departamento de Investigación<br>
        Fecha de generación: <?= $generated_date ?><br>
        Página <script type="text/php">
            if (isset($pdf)) {
                $x = 490;  // Ajustado para orientación horizontal
                $y = 791;
                $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
                $font = $fontMetrics->getFont("Helvetica");
                $size = 8;
                $color = array(0,0,0);
                $word_space = 0.0;  // Espacio entre palabras
                $char_space = 0.0;  // Espacio entre caracteres
                $angle = 0.0;       // Ángulo de rotación
                $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            }
        </script>
    </div>
</body>
</html>