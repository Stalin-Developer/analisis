<?= $this->extend('layouts/public_layout') ?>

/**
Link de la pagina:
http://localhost/analisis/public/
*/


<?= $this->section('title') ?>
Repositorio de Documentos
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Repositorio de Documentos
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filtros de Búsqueda</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('publico') ?>" method="get">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="category_id">Categoría</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">Todas las categorías</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= $selected_category == $category['id'] ? 'selected' : '' ?>>
                                    <?= $category['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
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
                        <label for="year">Año de Publicación</label>
                        <select class="form-control" id="year" name="year">
                            <option value="">Todos los años</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year ?>" <?= $selected_year == $year ? 'selected' : '' ?>>
                                    <?= $year ?>
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
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    <a href="<?= base_url('publico') ?>" class="btn btn-secondary">
                        <i class="fas fa-undo"></i> Limpiar Filtros
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (empty($documents)): ?>
            <div class="alert alert-info">
                No se encontraron documentos con los criterios seleccionados.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autores</th>
                            <th>Año</th>
                            <th>Categoría</th>
                            <th>Carrera</th>
                            <th>Periodo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($documents as $doc): ?>
                            <tr>
                                <td><?= $doc['title'] ?></td>
                                <td><?= $doc['authors'] ?></td>
                                <td><?= $doc['publication_year'] ?></td>
                                <td><?= $doc['category_name'] ?></td>
                                <td><?= $doc['career_name'] ?></td>
                                <td><?= $doc['period_name'] ?></td>
                                <td>
                                    <a href="<?= base_url('publico/view/' . $doc['id']) ?>" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Ver Detalles
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Paginación -->
            <div class="mt-3">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
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
        "pageLength": 10,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        }
    });
});
</script>
<?= $this->endSection() ?>