<form id="formLibro" action="<?= base_url('produccion/create') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="tipo" value="Libro">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="codigo_libro">Código *</label>
                <input type="text" class="form-control" id="codigo_libro" name="codigo"
                    value="<?= old('codigo') ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="titulo_libro">Título Libro *</label>
                <input type="text" class="form-control" id="titulo_libro" name="titulo"
                    value="<?= old('titulo') ?>" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="codigo_isbn_libro">Código ISBN *</label>
                <input type="text" class="form-control" id="codigo_isbn_libro"
                    name="codigo_libro_isbn"
                    value="<?= old('codigo_libro_isbn') ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="fecha_publicacion_libro">Fecha de Publicación *</label>
                <input type="date" class="form-control" id="fecha_publicacion_libro"
                    name="fecha_publicacion"
                    value="<?= old('fecha_publicacion') ?>" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="revisado_pares_libro">Revisado por Pares *</label>
                <select class="form-control" id="revisado_pares_libro" name="revisado_pares" required>
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($enumData['revisado_pares'] as $opcion): ?>
                        <option value="<?= $opcion ?>" <?= old('revisado_pares') == $opcion ? 'selected' : '' ?>>
                            <?= $opcion ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="filiacion_libro">Filiación *</label>
                <select class="form-control" id="filiacion_libro" name="filiacion" required>
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($enumData['filiacion'] as $filiacion): ?>
                        <option value="<?= $filiacion ?>" <?= old('filiacion') == $filiacion ? 'selected' : '' ?>>
                            <?= $filiacion ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="documento_libro">Documento (Word/PDF)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="documento_libro" name="documento"
                        accept=".doc,.docx,.pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                    <label class="custom-file-label" for="documento_libro">Seleccionar archivo</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="campo_amplio_id_libro">Campo Amplio</label>
                <select class="form-control" id="campo_amplio_id_libro" name="campo_amplio_id">
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
                <label for="campo_especifico_id_libro">Campo Específico</label>
                <select class="form-control" id="campo_especifico_id_libro" name="campo_especifico_id">
                    <option value="">Seleccione primero un campo amplio</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="campo_detallado_id_libro">Campo Detallado</label>
                <select class="form-control" id="campo_detallado_id_libro" name="campo_detallado_id">
                    <option value="">Seleccione primero un campo específico</option>
                </select>
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
                            <select class="form-control" id="tipo_participante_libro" name="tipo_participante" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="Autor">Autor</option>
                                <option value="Coautor">Coautor</option>
                            </select>
                            <button type="button" id="btnAgregarParticipante_libro" class="btn btn-primary ml-2">
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campo oculto para datos de participantes -->
    <input type="hidden" id="participantes_data_libro" name="participantes_data" value="">

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?= base_url('produccion') ?>" class="btn btn-secondary">Cancelar</a>
    </div>
</form>