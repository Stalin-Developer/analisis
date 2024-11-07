<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Editar Documento
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Editar Documento
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('documents') ?>">Documentos</a></li>
<li class="breadcrumb-item active">Editar</li>
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

        <form action="<?= base_url('documents/update/' . $document['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="title">Título</label>
                <input type="text" class="form-control" id="title" name="title" 
                       value="<?= old('title', $document['title']) ?>" required>
            </div>

            <div class="form-group">
                <label for="authors">Autores</label>
                <input type="text" class="form-control" id="authors" name="authors" 
                       value="<?= old('authors', $document['authors']) ?>" required>
                <small class="form-text text-muted">Separe los autores con comas</small>
            </div>


            <!-- Agregar después del campo de autores -->
            <div class="form-group">
                <label for="publication_year">Año de Publicación</label>
                <input type="number" 
                    class="form-control" 
                    id="publication_year" 
                    name="publication_year" 
                    min="1900" 
                    max="2099" 
                    step="1" 
                    value="<?= old('publication_year', $document['publication_year']) ?>" 
                    required>
                <small class="form-text text-muted">Ingrese el año en formato YYYY (ejemplo: 2024)</small>
            </div>



            <div class="form-group">
                <label for="category_id">Categoría</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Seleccione una categoría</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" 
                                <?= old('category_id', $document['category_id']) == $category['id'] ? 'selected' : '' ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="career_id">Carrera</label>
                <select class="form-control" id="career_id" name="career_id" required>
                    <option value="">Seleccione una carrera</option>
                    <?php foreach ($careers as $career): ?>
                        <option value="<?= $career['id'] ?>" 
                                <?= old('career_id', $document['career_id']) == $career['id'] ? 'selected' : '' ?>>
                            <?= $career['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="academic_period_id">Periodo Académico</label>
                <select class="form-control" id="academic_period_id" name="academic_period_id" required>
                    <option value="">Seleccione un periodo</option>
                    <?php foreach ($academic_periods as $period): ?>
                        <option value="<?= $period['id'] ?>" 
                                <?= old('academic_period_id', $document['academic_period_id']) == $period['id'] ? 'selected' : '' ?>>
                            <?= $period['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="summary">Resumen</label>
                <textarea class="form-control" id="summary" name="summary" rows="3"><?= old('summary', $document['summary']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="pdf_file">Archivo PDF (opcional)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="pdf_file" name="pdf_file" accept=".pdf">
                    <label class="custom-file-label" for="pdf_file">Seleccionar nuevo archivo</label>
                </div>
                <small class="form-text text-muted">Deje en blanco para mantener el archivo actual</small>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="<?= base_url('documents') ?>" class="btn btn-secondary">Cancelar</a>
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