<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Trabajos de Titulación</title>
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
        .deparment {
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
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 10px;
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
        .page-break {
            page-break-after: always;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(200, 200, 200, 0.2);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">ITSI</div>
    
    <div class="header">
        <!-- Logo del ITSI -->        
        <img src="<?= base_url('uploads/logo.png'); ?>" class="logo" alt="ITSI Logo">
        <div class="deparment"><?= $department ?></div>
        <div class="report-title"><?= $reportTitle ?></div>
        
        <?php if (!empty($filterInfo)): ?>
            <div class="filter-info">
                <?= implode(' | ', $filterInfo) ?>
            </div>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autores</th>
                <th>Línea de Investigación</th>
                <th>Carrera</th>
                <th>Año</th>
                <th>Mes</th>
                <th>Periodo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $doc): ?>
            <tr>
                <td><?= $doc['titulo'] ?></td>
                <td><?= $doc['autores'] ?></td>
                <td><?= $doc['linea_investigacion'] ?></td>
                <td><?= $doc['career_name'] ?></td>
                <td><?= $doc['year_value'] ?></td>
                <td><?= $doc['mes_name'] ?></td>
                <td><?= $doc['period_name'] ?></td>
            </tr>
            <?php if (!empty($doc['resumen'])): ?>
            <tr>
                <td colspan="7">
                    <strong>Resumen:</strong><br>
                    <?= $doc['resumen'] ?>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
        Instituto Tecnológico Superior Ibarra<br>
        Departamento de Investigación<br>
        Fecha de generación: <?= $generated_date ?><br>
        Página <script type="text/php">
        if (isset($pdf)) {
            $font = $fontMetrics->getFont("Serif");
            $pdf->page_text(327, 791, "{PAGE_NUM} de {PAGE_COUNT}", $font, 8, array(0,0,0));
        }
        </script>
    </div>
</body>
</html>