<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Trabajos de Titulación
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Gestión de Trabajos de Titulación
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Trabajos de Titulación</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Trabajos de Titulación</h3>
        <div class="card-tools">
            <a href="<?= base_url('trabajos-titulacion/new') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Trabajo
            </a>
        </div>
    </div>

    <div class="card-body">
        <form action="<?= base_url('trabajos-titulacion') ?>" method="get">
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
                <!-- <div class="col-md-3">
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
                </div> -->
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="<?= base_url('trabajos-titulacion') ?>" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Limpiar Filtros
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="card-body">
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Línea de Investigación</th>
                    <th>Autor/es</th>
                    <th>Carrera</th>
                    <th>Año</th>
                    <th>Periodo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trabajos as $trabajo): ?>
                <tr>
                    <td><?= $trabajo['id'] ?></td>
                    <td><?= $trabajo['titulo'] ?></td>
                    <td><?= $trabajo['linea_investigacion'] ?></td>
                    <td><?= $trabajo['autores'] ?></td>
                    <td><?= $trabajo['career_name'] ?></td>
                    <td><?= $trabajo['anio'] ?></td>
                    <td><?= $trabajo['period_name'] ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="<?= base_url('trabajos-titulacion/download/' . $trabajo['id']) ?>" 
                               class="btn btn-sm btn-info" title="Descargar">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="<?= base_url('trabajos-titulacion/edit/' . $trabajo['id']) ?>" 
                               class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('trabajos-titulacion/delete/' . $trabajo['id']) ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('¿Está seguro de eliminar este trabajo?')"
                               title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
    $('.table').DataTable({
        "responsive": true,
        "autoWidth": false,
        "order": [], // Deshabilita el ordenamiento inicial de DataTables

    });
});
</script>
<?= $this->endSection() ?>