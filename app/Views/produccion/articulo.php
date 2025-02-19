<form id="formArticulo" action="<?= base_url('produccion/create') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="tipo" value="Artículo">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="tipo_articulo_articulo">Tipo de Artículo *</label>
                <select class="form-control" id="tipo_articulo_articulo" name="tipo_articulo" required>
                    <option value="">Seleccione un tipo</option>
                    <?php foreach ($enumData['tipo_articulo'] as $tipo): ?>
                        <option value="<?= $tipo ?>" <?= old('tipo_articulo') == $tipo ? 'selected' : '' ?>>
                            <?= $tipo ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="base_datos_id_articulo">Base de Datos Indexada</label>
                <select class="form-control" id="base_datos_id_articulo" name="base_datos_id">
                    <option value="">Seleccione una base de datos</option>
                    <?php foreach ($bases_datos as $base): ?>
                        <option value="<?= $base['id'] ?>" <?= old('base_datos_id') == $base['id'] ? 'selected' : '' ?>>
                            <?= $base['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="codigo_articulo">Código DOI *</label>
                <input type="text" class="form-control" id="codigo_articulo" name="codigo"
                    value="<?= old('codigo') ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="titulo_articulo">Título Artículo *</label>
                <input type="text" class="form-control" id="titulo_articulo" name="titulo"
                    value="<?= old('titulo') ?>" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="codigo_issn_articulo">Código ISSN</label>
                <input type="text" class="form-control" id="codigo_issn_articulo" name="codigo_issn"
                    value="<?= old('codigo_issn') ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nombre_revista_articulo">Nombre Revista</label>
                <input type="text" class="form-control" id="nombre_revista_articulo" name="nombre_revista"
                    value="<?= old('nombre_revista') ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="fecha_publicacion_articulo">Fecha de Publicación *</label>
                <input type="date" class="form-control" id="fecha_publicacion_articulo" name="fecha_publicacion"
                    value="<?= old('fecha_publicacion') ?>" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="estado_articulo">Estado *</label>
                <select class="form-control" id="estado_articulo" name="estado" required>
                    <option value="">Seleccione un estado</option>
                    <?php foreach ($enumData['estado'] as $estado): ?>
                        <option value="<?= $estado ?>" <?= old('estado') == $estado ? 'selected' : '' ?>>
                            <?= $estado ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="filiacion_articulo">Filiación *</label>
                <select class="form-control" id="filiacion_articulo" name="filiacion" required>
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($enumData['filiacion'] as $filiacion): ?>
                        <option value="<?= $filiacion ?>" <?= old('filiacion') == $filiacion ? 'selected' : '' ?>>
                            <?= $filiacion ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="campo_amplio_id_articulo">Campo Amplio</label>
                <select class="form-control" id="campo_amplio_id_articulo" name="campo_amplio_id">
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
                <label for="campo_especifico_id_articulo">Campo Específico</label>
                <select class="form-control" id="campo_especifico_id_articulo" name="campo_especifico_id">
                    <option value="">Seleccione primero un campo amplio</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="campo_detallado_id_articulo">Campo Detallado</label>
                <select class="form-control" id="campo_detallado_id_articulo" name="campo_detallado_id">
                    <option value="">Seleccione primero un campo específico</option>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="link_publicacion_articulo">Link de la Publicación</label>
                <input type="text" class="form-control" id="link_publicacion_articulo" name="link_publicacion"
                    value="<?= old('link_publicacion') ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="link_revista_articulo">Link de la Revista</label>
                <input type="text" class="form-control" id="link_revista_articulo" name="link_revista"
                    value="<?= old('link_revista') ?>">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="intercultural_articulo">Intercultural</label>
                <select class="form-control" id="intercultural_articulo" name="intercultural">
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($enumData['intercultural'] as $intercultural): ?>
                        <option value="<?= $intercultural ?>" <?= old('intercultural') == $intercultural ? 'selected' : '' ?>>
                            <?= $intercultural ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="documento_articulo">Documento (Word/PDF)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="documento_articulo" name="documento"
                        accept=".doc,.docx,.pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                    <label class="custom-file-label" for="documento_articulo">Seleccionar archivo</label>
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
                            <select class="form-control" id="tipo_participante_articulo" name="tipo_participante" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="Autor">Autor</option>
                                <option value="Coautor">Coautor</option>
                            </select>
                            <button type="button" id="btnAgregarParticipante_articulo" class="btn btn-primary ml-2">
                                Agregar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campo oculto para datos de participantes -->
    <input type="hidden" id="participantes_data_articulo" name="participantes_data" value="">

    <div class="mt-4 text-right">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?= base_url('produccion') ?>" class="btn btn-secondary">Cancelar</a>
    </div>
</form>