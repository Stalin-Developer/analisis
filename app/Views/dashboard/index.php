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


<!-- Importación del CSS específico del dashboard -->
<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">



<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- Primera fila de cuadros -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="#" class="small-box dashboard-box">
                    <div class="inner">
                        <h3>I + D + i</h3>
                    </div>
                </a>
            </div>


            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="<?= base_url('pis') ?>" class="small-box dashboard-box">
                    <div class="inner">
                        <h3>PIS</h3>
                    </div>
                </a>
            </div>


            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="<?= base_url('trabajos-titulacion') ?>" class="small-box dashboard-box">
                    <div class="inner">
                        <h3>TDT</h3>
                    </div>
                </a>
            </div>


        </div>





        <div class="row justify-content-center">
            <!-- Segunda fila de cuadros -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="#" class="small-box dashboard-box">
                    <div class="inner">
                        <h3>Producción Científica y Técnica</h3>
                    </div>
                </a>
            </div>


            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="#" class="small-box dashboard-box">
                    <div class="inner">
                        <h3>Innovación y Capacidad de Absorción</h3>
                    </div>
                </a>
            </div>


            <div class="col-lg-3 col-md-4 col-sm-6">
                <a href="#" class="small-box dashboard-box">
                    <div class="inner">
                        <h3>Galería</h3>
                    </div>
                </a>
            </div>



        </div>
    </div>
</section>






<?= $this->endSection() ?>