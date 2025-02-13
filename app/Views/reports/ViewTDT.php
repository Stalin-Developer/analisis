<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Reportes de Trabajos de Titulación
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Generación de Reportes - Trabajos de Titulación
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('show_reports') ?>">Reportes</a></li>
<li class="breadcrumb-item active">Trabajos de Titulación</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Trabajos de Titulación</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-primary btn-sm" id="generateReport">
                <i class="fas fa-file-pdf"></i> Generar Reporte PDF
            </button>
        </div>
    </div>
    
    <div class="card-body">
        <form action="<?= base_url('reports_tdt') ?>" method="get" id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="career_id">Carrera</label>
                        <select class="form-control" id="career_id" name="career_id">
                            <option value="">Todas las carreras</option>
                            <?php foreach ($careers as $career): ?>
                                <option value="<?= $career['id'] ?>" <?= $selected_career == $career['id'] ? 'selected' : '' ?>>
                                    <?= $career['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="year_id">Año</label>
                        <select class="form-control" id="year_id" name="year_id">
                            <option value="">Todos los años</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year['id'] ?>" <?= $selected_year == $year['id'] ? 'selected' : '' ?>>
                                    <?= $year['anio'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="period_id">Periodo Académico</label>
                        <select class="form-control" id="period_id" name="period_id">
                            <option value="">Todos los periodos</option>
                            <?php foreach ($periods as $period): ?>
                                <option value="<?= $period['id'] ?>" <?= $selected_period == $period['id'] ? 'selected' : '' ?>>
                                    <?= $period['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="mes_id">Mes</label>
                        <select class="form-control" id="mes_id" name="mes_id">
                            <option value="">Todos los meses</option>
                            <?php foreach ($meses as $mes): ?>
                                <option value="<?= $mes['id'] ?>" <?= $selected_mes == $mes['id'] ? 'selected' : '' ?>>
                                    <?= $mes['mes'] ?>
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
                    <a href="<?= base_url('reports_tdt') ?>" class="btn btn-secondary">
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

        <form id="reportForm" action="<?= base_url('reports_tdt/generate') ?>" method="POST" target="_blank">
            <?= csrf_field() ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll">
                        </th>
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
                        <td>
                            <input type="checkbox" name="selected_docs[]" value="<?= $doc['id'] ?>" class="doc-checkbox">
                        </td>
                        <td><?= $doc['titulo'] ?></td>
                        <td><?= $doc['autores'] ?></td>
                        <td><?= $doc['linea_investigacion'] ?></td>
                        <td><?= $doc['career_name'] ?></td>
                        <td><?= $doc['year_value'] ?></td>
                        <td><?= $doc['mes_name'] ?></td>
                        <td><?= $doc['period_name'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
    var table = $('.table').DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        },
        "initComplete": function(settings, json) {
            $('#selectAll').prop('checked', true);
            $('.doc-checkbox').prop('checked', true);
        }
    });

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
            alert('Por favor, seleccione al menos un trabajo de titulación para generar el reporte.');
            return;
        }
        $('#reportForm').submit();
    });
});
</script>
<?= $this->endSection() ?>