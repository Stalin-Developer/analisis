<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Nuevo Trabajo de Titulación
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Nuevo Trabajo de Titulación
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('trabajos-titulacion') ?>">Trabajos de Titulación</a></li>
<li class="breadcrumb-item active">Nuevo</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-body">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('trabajos-titulacion/create') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="documento_path">Documento PDF</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="documento_path" name="documento_path" 
                           accept=".pdf" required>
                    <label class="custom-file-label" for="documento_path">Seleccionar archivo</label>
                </div>
            </div>

            <!--He creado lo del poster en tdt, pero estos van en pis. Nos los elimino porque me pueden servir para el pis.-->
            <!-- <div class="form-group">
                <label for="poster_path">Póster (PDF)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="poster_path" name="poster_path" 
                           accept=".pdf">
                    <label class="custom-file-label" for="poster_path">Seleccionar archivo</label>
                </div>
            </div> -->

            
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" 
                       value="<?= old('titulo') ?>" required>
            </div>

            <div class="form-group">
                <label for="linea_investigacion">Línea de Investigación</label>
                <input type="text" class="form-control" id="linea_investigacion" name="linea_investigacion" 
                       value="<?= old('linea_investigacion') ?>">
            </div>

            <div class="form-group">
                <label for="autores">Autor/es</label>
                <input type="text" class="form-control" id="autores" name="autores" 
                       value="<?= old('autores') ?>" required>
                <small class="form-text text-muted">Separe los autores con comas</small>
            </div>

            <div class="form-group">
                <label for="career_id">Carrera</label>
                <select class="form-control" id="career_id" name="career_id" required>
                    <option value="">Seleccione una carrera</option>
                    <?php foreach ($careers as $career): ?>
                        <option value="<?= $career['id'] ?>" <?= old('career_id') == $career['id'] ? 'selected' : '' ?>>
                            <?= $career['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="year">Año</label>
                        <input type="number" 
                            class="form-control" 
                            id="year" 
                            name="year" 
                            min="1000" 
                            max="9999" 
                            step="1" 
                            value="<?= old('year', date('Y')) ?>"
                            placeholder="YYYY" 
                            required>
                        <small class="form-text text-muted">Ingrese un año de 4 dígitos (ejemplo: 2024)</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mes_id">Mes</label>
                        <select class="form-control" id="mes_id" name="mes_id" required>
                            <option value="">Seleccione un mes</option>
                            <?php foreach ($meses as $mes): ?>
                                <option value="<?= $mes['id'] ?>" <?= old('mes_id') == $mes['id'] ? 'selected' : '' ?>>
                                    <?= $mes['mes'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="academic_period_id">Periodo Académico</label>
                        <select class="form-control" id="academic_period_id" name="academic_period_id" required>
                            <option value="">Seleccione un periodo</option>
                            <?php foreach ($academic_periods as $period): ?>
                                <option value="<?= $period['id'] ?>" <?= old('academic_period_id') == $period['id'] ? 'selected' : '' ?>>
                                    <?= $period['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="resumen">Resumen</label>
                <textarea class="form-control" id="resumen" name="resumen" style="resize: none;" rows="3"><?= old('resumen') ?></textarea>
            </div>

            

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?= base_url('trabajos-titulacion') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
<script>
$(function () {
    bsCustomFileInput.init();
});
</script>
<?= $this->endSection() ?>