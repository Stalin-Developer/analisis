<form id="formCapitulo" action="<?= base_url('produccion/create') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="tipo" value="Capítulo de Libro">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="codigo">Código *</label>
                <input type="text" class="form-control" id="codigo" name="codigo"
                    value="<?= old('codigo') ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="titulo">Título Capítulo *</label>
                <input type="text" class="form-control" id="titulo" name="titulo"
                    value="<?= old('titulo') ?>" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="titulo_libro">Título Libro *</label>
                <input type="text" class="form-control" id="titulo_libro" name="titulo_libro"
                    value="<?= old('titulo_libro') ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="total_capitulos_libro">Total Capítulos del Libro *</label>
                <input type="number" class="form-control" id="total_capitulos_libro"
                    name="total_capitulos_libro" min="1"
                    value="<?= old('total_capitulos_libro') ?>" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="codigo_capitulo_isbn">Código ISBN *</label>
                <input type="text" class="form-control" id="codigo_capitulo_isbn"
                    name="codigo_capitulo_isbn"
                    value="<?= old('codigo_capitulo_isbn') ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="editor_copilador">Editor o Compilador *</label>
                <input type="text" class="form-control" id="editor_copilador"
                    name="editor_copilador"
                    value="<?= old('editor_copilador') ?>" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="fecha_publicacion">Fecha de Publicación *</label>
                <input type="date" class="form-control" id="fecha_publicacion"
                    name="fecha_publicacion"
                    value="<?= old('fecha_publicacion') ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="paginas">Páginas *</label>
                <input type="text" class="form-control" id="paginas" name="paginas"
                    value="<?= old('paginas') ?>" required
                    placeholder="Ejemplo: 45-60">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="campo_amplio_id_capitulo">Campo Amplio</label>
                <select class="form-control" id="campo_amplio_id_capitulo" name="campo_amplio_id">
                    <option value="">Seleccione un campo amplio</option>
                    <?php foreach ($campos_amplios as $campo): ?>
                        <option value="<?= $campo['id'] ?>" <?= old('campo_amplio_id') == $campo['id'] ? 'selected' : '' ?>>
                            <?= $campo['nombre_amplio'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="campo_especifico_id_capitulo">Campo Específico</label>
                <select class="form-control" id="campo_especifico_id_capitulo" name="campo_especifico_id">
                    <option value="">Seleccione primero un campo amplio</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="campo_detallado_id_capitulo">Campo Detallado</label>
                <select class="form-control" id="campo_detallado_id_capitulo" name="campo_detallado_id">
                    <option value="">Seleccione primero un campo específico</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="filiacion_capitulo">Filiación *</label>
                <select class="form-control" id="filiacion_capitulo" name="filiacion" required>
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($enumData['filiacion'] as $filiacion): ?>
                        <option value="<?= $filiacion ?>" <?= old('filiacion') == $filiacion ? 'selected' : '' ?>>
                            <?= $filiacion ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="documento_capitulo">Documento (Word/PDF)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="documento_capitulo" name="documento"
                        accept=".doc,.docx,.pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                    <label class="custom-file-label" for="documento_capitulo">Seleccionar archivo</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Participantes -->
    <div class="card mt-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Participantes</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tipo de Participante *</label>
                        <div class="d-flex">
                            <select class="form-control" id="tipo_participante_capitulo" name="tipo_participante" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="Autor">Autor</option>
                                <option value="Coautor">Coautor</option>
                            </select>
                            <button type="button" id="btnAgregarParticipanteCapitulo" class="btn btn-primary ml-2">
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campo oculto para datos de participantes -->
    <input type="hidden" id="participantes_data_capitulo" name="participantes_data" value="">

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?= base_url('produccion') ?>" class="btn btn-secondary">Cancelar</a>
    </div>
</form>