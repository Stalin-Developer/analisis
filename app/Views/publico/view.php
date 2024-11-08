<?= $this->extend('layouts/public_layout') ?>

<?= $this->section('title') ?>
Ver Documento
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Detalles del Documento
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-12 mb-3">
                <a href="<?= base_url('publico') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">Título</th>
                        <td><?= $document['title'] ?></td>
                    </tr>
                    <tr>
                        <th>Autores</th>
                        <td><?= $document['authors'] ?></td>
                    </tr>
                    <tr>
                        <th>Año de Publicación</th>
                        <td><?= $document['publication_year'] ?></td>
                    </tr>
                    <tr>
                        <th>Categoría</th>
                        <td><?= $document['category_name'] ?></td>
                    </tr>
                    <tr>
                        <th>Carrera</th>
                        <td><?= $document['career_name'] ?></td>
                    </tr>
                    <tr>
                        <th>Periodo Académico</th>
                        <td><?= $document['period_name'] ?></td>
                    </tr>
                    <tr>
                        <th>Resumen</th>
                        <td><?= nl2br($document['summary']) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <i class="fas fa-info-circle"></i> 
            Para obtener una copia de este documento, por favor contacte al Departamento de Investigación.
        </div>
    </div>
</div>
<?= $this->endSection() ?>