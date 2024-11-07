<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Documentos
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Gestión de Documentos
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Documentos</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Documentos</h3>
        <div class="card-tools">
            <a href="<?= base_url('documents/new') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Documento
            </a>
        </div>
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
                    <th>Autores</th>
                    <th>Año</th>
                    <th>Categoría</th>
                    <th>Carrera</th>
                    <th>Periodo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documents as $doc): ?>
                <tr>
                    <td><?= $doc['id'] ?></td>
                    <td><?= $doc['title'] ?></td>
                    <td><?= $doc['authors'] ?></td>
                    <td><?= $doc['publication_year'] ?></td>
                    <td><?= $doc['category_name'] ?></td>
                    <td><?= $doc['career_name'] ?></td>
                    <td><?= $doc['period_name'] ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="<?= base_url('documents/download/' . $doc['id']) ?>" 
                               class="btn btn-sm btn-info" title="Descargar">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="<?= base_url('documents/edit/' . $doc['id']) ?>" 
                               class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('documents/delete/' . $doc['id']) ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('¿Está seguro de eliminar este documento?')"
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
    });
});
</script>
<?= $this->endSection() ?>