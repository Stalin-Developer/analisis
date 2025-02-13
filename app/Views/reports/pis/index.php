<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Reportes de Proyectos Integradores de Saberes
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Generación de Reportes - Proyectos Integradores de Saberes
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('show_reports') ?>">Reportes</a></li>
<li class="breadcrumb-item active">Proyectos Integradores de Saberes</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Proyectos Integradores de Saberes</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" id="generateReport">
                <i class="fas fa-file-pdf"></i> Generar Reporte PDF
            </button>
        </div>
    </div>
    
    <div class="card-body">
        <form action="<?= base_url('reports_pis') ?>" method="get" id="filterForm">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="programa_id">Programa</label>
                        <select class="form-control" id="programa_id" name="programa_id">
                            <option value="">Todos los programas</option>
                            <?php foreach ($programas as $programa): ?>
                                <option value="<?= $programa['id'] ?>" <?= $selected_programa == $programa['id'] ? 'selected' : '' ?>>
                                    <?= $programa['nombre_programa'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="linea_id">Línea de Investigación</label>
                        <select class="form-control" id="linea_id" name="linea_id">
                            <option value="">Todas las líneas</option>
                            <?php foreach ($lineas as $linea): ?>
                                <option value="<?= $linea['id'] ?>" <?= $selected_linea == $linea['id'] ? 'selected' : '' ?>>
                                    <?= $linea['nombre_linea'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="anio">Año</label>
                        <select class="form-control" id="anio" name="anio">
                            <option value="">Todos los años</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year ?>" <?= $selected_anio == $year ? 'selected' : '' ?>>
                                    <?= $year ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="<?= base_url('reports_pis') ?>" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Limpiar Filtros
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form id="reportForm" action="<?= base_url('reports_pis/generate') ?>" method="POST" target="_blank">
            <?= csrf_field() ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll">
                            </th>
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
                            <td>
                                <input type="checkbox" name="selected_docs[]" value="<?= $proyecto['id'] ?>" class="doc-checkbox">
                            </td>
                            <td><?= $proyecto['nombre'] ?></td>
                            <td><?= $proyecto['nombre_programa'] ?? 'No asignado' ?></td>
                            <td>
                                <?php
                                $estadoClass = '';
                                switch($proyecto['estado']) {
                                    case 'Finalizado': $estadoClass = 'badge badge-success'; break;
                                    case 'En Cierre': $estadoClass = 'badge badge-info'; break;
                                    case 'En Ejecución': $estadoClass = 'badge badge-primary'; break;
                                    case 'Detenido': $estadoClass = 'badge badge-warning'; break;
                                    case 'Cancelado': $estadoClass = 'badge badge-danger'; break;
                                }
                                ?>
                                <span class="<?= $estadoClass ?>"><?= $proyecto['estado'] ?></span>
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
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>



<script>
$(function () {
    // Función para calcular el ancho basado en la longitud del texto
    function calcularAncho(length, isObjetivo = false) {
        // Ancho especial para la columna objetivo
        if (isObjetivo) {
            return 400; // Ancho fijo más grande para la columna objetivo
        }
        // Anchos para otras columnas
        if (length <= 10) return 100;
        if (length <= 30) return 150;
        if (length <= 60) return 200;
        return 250;
    }

    // Función para obtener el contenido más largo de una columna
    function obtenerLongitudMaxima(table, columnIndex) {
        let maxLength = 0;
        
        // Revisar encabezado
        const headerText = table.column(columnIndex).header().textContent.trim();
        maxLength = headerText.length;

        // Revisar celdas visibles
        table.column(columnIndex).nodes().each(function(node) {
            const cellText = $(node).text().trim();
            if (cellText.length > maxLength) {
                maxLength = cellText.length;
            }
        });

        return maxLength;
    }

    // Función para aplicar los anchos a una columna
    function aplicarAnchoColumna(table, columnIndex) {
        if (columnIndex === 0) return; // Ignorar columna de checkbox
        
        const maxLength = obtenerLongitudMaxima(table, columnIndex);
        const isObjetivo = table.column(columnIndex).header().textContent.trim() === 'Objetivo';
        const width = calcularAncho(maxLength, isObjetivo);

        // Aplicar el ancho usando columnDefs
        table.column(columnIndex).nodes().each(function(node) {
            $(node).css({
                'min-width': width + 'px',
                'max-width': width + 'px',
                'width': width + 'px',
                'white-space': 'normal',
                'word-wrap': 'break-word'
            });
        });

        // Aplicar también al encabezado
        $(table.column(columnIndex).header()).css({
            'min-width': width + 'px',
            'max-width': width + 'px',
            'width': width + 'px',
            'white-space': 'normal',
            'word-wrap': 'break-word'
        });
    }

    var table = $('.table').DataTable({
        "responsive": false,
        "scrollX": true,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "pageLength": 10,

        // Agregamos esta configuración para las clases de las celdas
        "columnDefs": [{
            "targets": '_all',
            "createdCell": function(td, cellData, rowData, row, col) {
                $(td).addClass('align-middle');
            }
        }],

        "initComplete": function(settings, json) {
            const table = this.api();
            
            // Aplicar anchos iniciales
            for(let i = 0; i < table.columns().nodes().length; i++) {
                aplicarAnchoColumna(table, i);
            }

            // Forzar recálculo de anchos
            setTimeout(function() {
                table.columns.adjust();
            }, 100);

            // Inicializar checkboxes
            $('#selectAll').prop('checked', true);
            $('.doc-checkbox').prop('checked', true);
        },
        "drawCallback": function(settings) {
            const table = this.api();
            
            // Reaplicar anchos después de cualquier redibujado
            for(let i = 0; i < table.columns().nodes().length; i++) {
                aplicarAnchoColumna(table, i);
            }

            setTimeout(function() {
                table.columns.adjust();
            }, 100);
        }
    });

    // Ajustar cuando se cambie de página o se filtre
    table.on('page.dt search.dt', function() {
        setTimeout(function() {
            for(let i = 0; i < table.columns().nodes().length; i++) {
                aplicarAnchoColumna(table, i);
            }
            table.columns.adjust();
        }, 100);
    });

    // Mantener la funcionalidad de selección
    $('#selectAll').change(function() {
        $('.doc-checkbox').prop('checked', $(this).prop('checked'));
    });

    $('.doc-checkbox').change(function() {
        if (!$(this).prop('checked')) {
            $('#selectAll').prop('checked', false);
        } else {
            var allChecked = $('.doc-checkbox:not(:checked)').length === 0;
            $('#selectAll').prop('checked', allChecked);
        }
    });

    $('#generateReport').click(function() {
        if ($('.doc-checkbox:checked').length === 0) {
            alert('Por favor, seleccione al menos un proyecto para generar el reporte.');
            return;
        }
        $('#reportForm').submit();
    });
});
</script>




<?= $this->endSection() ?>