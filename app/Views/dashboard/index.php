<?= $this->extend('layouts/admin_layout') ?>

/**
Pagina del dashboard de prueba:
http://localhost/analisis/public/
*/


<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Dashboard</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Bienvenido</h5>
                <p class="card-text">
                    Sistema de Administración de Documentos del Departamento de Investigación
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>