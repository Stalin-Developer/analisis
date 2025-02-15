<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Nueva Producción Científica y Técnica
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Nueva Producción Científica y Técnica
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('produccion') ?>">Producción Científica</a></li>
<li class="breadcrumb-item active">Nueva</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif; ?>

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

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form id="formProduccion" action="<?= base_url('produccion/create') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Pestañas -->
            <ul class="nav nav-tabs" id="tipoProduccionTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="articulo-tab" data-toggle="tab" href="#articulo" role="tab"
                        aria-controls="articulo" aria-selected="true">Artículo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="capitulo-tab" data-toggle="tab" href="#capitulo" role="tab"
                        aria-controls="capitulo" aria-selected="false">Capítulo de Libro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="libro-tab" data-toggle="tab" href="#libro" role="tab"
                        aria-controls="libro" aria-selected="false">Libro</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="otro-tab" data-toggle="tab" href="#otro" role="tab"
                        aria-controls="otro" aria-selected="false">Otro</a>
                </li>
            </ul>

            <!-- Contenido de las pestañas -->
            <div class="tab-content mt-3" id="tipoProduccionContent">
                <!-- Pestaña Artículo -->
                <div class="tab-pane fade show active" id="articulo" role="tabpanel" aria-labelledby="articulo-tab">
                    <input type="hidden" name="tipo" value="Artículo">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_articulo">Tipo de Artículo *</label>
                                <select class="form-control" id="tipo_articulo" name="tipo_articulo" required>
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
                                <label for="base_datos_id">Base de Datos Indexada</label>
                                <select class="form-control" id="base_datos_id" name="base_datos_id">
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
                                <label for="codigo">Código DOI *</label>
                                <input type="text" class="form-control" id="codigo" name="codigo"
                                    value="<?= old('codigo') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="titulo">Título Artículo *</label>
                                <input type="text" class="form-control" id="titulo" name="titulo"
                                    value="<?= old('titulo') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo_issn">Código ISSN</label>
                                <input type="text" class="form-control" id="codigo_issn" name="codigo_issn"
                                    value="<?= old('codigo_issn') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_revista">Nombre Revista</label>
                                <input type="text" class="form-control" id="nombre_revista" name="nombre_revista"
                                    value="<?= old('nombre_revista') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_publicacion">Fecha de Publicación *</label>
                                <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion"
                                    value="<?= old('fecha_publicacion') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado">Estado *</label>
                                <select class="form-control" id="estado" name="estado" required>
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
                                <label for="filiacion">Filiación *</label>
                                <select class="form-control" id="filiacion" name="filiacion" required>
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
                                <label for="campo_amplio_id">Campo Amplio *</label>
                                <select class="form-control" id="campo_amplio_id" name="campo_amplio_id" required>
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
                                <label for="campo_especifico_id">Campo Específico *</label>
                                <select class="form-control" id="campo_especifico_id" name="campo_especifico_id" required>
                                    <option value="">Seleccione primero un campo amplio</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="campo_detallado_id">Campo Detallado *</label>
                                <select class="form-control" id="campo_detallado_id" name="campo_detallado_id" required>
                                    <option value="">Seleccione primero un campo específico</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link_publicacion">Link de la Publicación</label>
                                <input type="text" class="form-control" id="link_publicacion" name="link_publicacion"
                                    value="<?= old('link_publicacion') ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link_revista">Link de la Revista</label>
                                <input type="text" class="form-control" id="link_revista" name="link_revista"
                                    value="<?= old('link_revista') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="intercultural">Intercultural</label>
                                <select class="form-control" id="intercultural" name="intercultural">
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
                                <label for="documento">Documento (PDF) *</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documento" name="documento"
                                        accept=".pdf" required>
                                    <label class="custom-file-label" for="documento">Seleccionar archivo</label>
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
                                            <select class="form-control" id="tipo_participante" name="tipo_participante" required>
                                                <option value="">Seleccione un tipo</option>
                                                <option value="Autor">Autor</option>
                                                <option value="Coautor">Coautor</option>
                                            </select>
                                            <button type="button" id="btnAgregarParticipante" class="btn btn-primary ml-2">
                                                Agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña Capítulo de Libro -->
                <div class="tab-pane fade" id="capitulo" role="tabpanel" aria-labelledby="capitulo-tab">
                    <input type="hidden" name="tipo" value="Capítulo de Libro">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo_capitulo">Código *</label>
                                <input type="text" class="form-control" id="codigo_capitulo" name="codigo"
                                    value="<?= old('codigo') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="titulo_capitulo">Título Capítulo *</label>
                                <input type="text" class="form-control" id="titulo_capitulo" name="titulo"
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
                                <label for="fecha_publicacion_capitulo">Fecha de Publicación *</label>
                                <input type="date" class="form-control" id="fecha_publicacion_capitulo"
                                    name="fecha_publicacion"
                                    value="<?= old('fecha_publicacion') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paginas">Páginas *</label>
                                <input type="text" class="form-control" id="paginas" name="paginas"
                                    value="<?= old('paginas') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="campo_amplio_id_capitulo">Campo Amplio *</label>
                                <select class="form-control" id="campo_amplio_id_capitulo"
                                    name="campo_amplio_id" required>
                                    <option value="">Seleccione un campo amplio</option>
                                    <?php foreach ($campos_amplios as $campo): ?>
                                        <option value="<?= $campo['id'] ?>"
                                            <?= old('campo_amplio_id') == $campo['id'] ? 'selected' : '' ?>>
                                            <?= $campo['nombre_amplio'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="campo_especifico_id_capitulo">Campo Específico *</label>
                                <select class="form-control" id="campo_especifico_id_capitulo"
                                    name="campo_especifico_id" required>
                                    <option value="">Seleccione primero un campo amplio</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="campo_detallado_id_capitulo">Campo Detallado *</label>
                                <select class="form-control" id="campo_detallado_id_capitulo"
                                    name="campo_detallado_id" required>
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
                                        <option value="<?= $filiacion ?>"
                                            <?= old('filiacion') == $filiacion ? 'selected' : '' ?>>
                                            <?= $filiacion ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="documento_capitulo">Documento (PDF) *</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documento_capitulo"
                                        name="documento" accept=".pdf" required>
                                    <label class="custom-file-label" for="documento_capitulo">
                                        Seleccionar archivo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Participantes (igual que en la pestaña Artículo) -->
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
                                            <select class="form-control" id="tipo_participante_capitulo"
                                                name="tipo_participante" required>
                                                <option value="">Seleccione un tipo</option>
                                                <option value="Autor">Autor</option>
                                                <option value="Coautor">Coautor</option>
                                            </select>
                                            <button type="button" id="btnAgregarParticipanteCapitulo"
                                                class="btn btn-primary ml-2">
                                                Agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Pestaña Libro -->
                <div class="tab-pane fade" id="libro" role="tabpanel" aria-labelledby="libro-tab">
                    <!-- Se implementará después -->
                </div>

                <!-- Pestaña Otro -->
                <div class="tab-pane fade" id="otro" role="tabpanel" aria-labelledby="otro-tab">
                    <!-- Se implementará después -->
                </div>
            </div>

            <div class="mt-4 text-right">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="<?= base_url('produccion') ?>" class="btn btn-secondary">Cancelar</a>
            </div>

            <!-- Campo oculto para datos de participantes -->
            <input type="hidden" id="participantes_data" name="participantes_data" value="">
        </form>

        <!-- Modal para agregar participantes -->
        <?= $this->include('produccion/participante') ?>

        <!-- Mensaje de carga -->
        <div id="loadingOverlay" style="display: none;" class="position-fixed top-0 left-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Guardando...</span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Plugin para el manejo de archivos -->
<script src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>

<script>
    $(function() {
        // Inicializar plugin de archivo personalizado
        bsCustomFileInput.init();

        // Manejo de campos dependientes (Campo amplio, específico, detallado)
        $('#campo_amplio_id').change(function() {
            const amplioId = $(this).val();
            if (amplioId) {
                $.get(`<?= base_url('produccion/get-campos-especificos') ?>/${amplioId}`, function(data) {
                    let options = '<option value="">Seleccione un campo específico</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_especifico}</option>`;
                    });
                    $('#campo_especifico_id').html(options);
                    $('#campo_detallado_id').html('<option value="">Seleccione primero un campo específico</option>');
                });
            } else {
                $('#campo_especifico_id').html('<option value="">Seleccione primero un campo amplio</option>');
                $('#campo_detallado_id').html('<option value="">Seleccione primero un campo específico</option>');
            }
        });

        $('#campo_especifico_id').change(function() {
            const especificoId = $(this).val();
            if (especificoId) {
                $.get(`<?= base_url('produccion/get-campos-detallados') ?>/${especificoId}`, function(data) {
                    let options = '<option value="">Seleccione un campo detallado</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_detallado}</option>`;
                    });
                    $('#campo_detallado_id').html(options);
                });
            } else {
                $('#campo_detallado_id').html('<option value="">Seleccione primero un campo específico</option>');
            }
        });

        // Restaurar valores antiguos si existen
        const oldAmplioId = $('#campo_amplio_id').val();
        const oldEspecificoId = '<?= old('campo_especifico_id') ?>';
        const oldDetalladoId = '<?= old('campo_detallado_id') ?>';

        if (oldAmplioId) {
            $('#campo_amplio_id').trigger('change');
        }







        //Codigo javascript para la pestana capitulo de libro.
        $('#campo_amplio_id_capitulo').change(function() {
            const amplioId = $(this).val();
            if (amplioId) {
                $.get(`<?= base_url('produccion/get-campos-especificos') ?>/${amplioId}`, function(data) {
                    let options = '<option value="">Seleccione un campo específico</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_especifico}</option>`;
                    });
                    $('#campo_especifico_id_capitulo').html(options);
                    $('#campo_detallado_id_capitulo').html('<option value="">Seleccione primero un campo específico</option>');
                });
            } else {
                $('#campo_especifico_id_capitulo').html('<option value="">Seleccione primero un campo amplio</option>');
                $('#campo_detallado_id_capitulo').html('<option value="">Seleccione primero un campo específico</option>');
            }
        });

        $('#campo_especifico_id_capitulo').change(function() {
            const especificoId = $(this).val();
            if (especificoId) {
                $.get(`<?= base_url('produccion/get-campos-detallados') ?>/${especificoId}`, function(data) {
                    let options = '<option value="">Seleccione un campo detallado</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_detallado}</option>`;
                    });
                    $('#campo_detallado_id_capitulo').html(options);
                });
            } else {
                $('#campo_detallado_id_capitulo').html('<option value="">Seleccione primero un campo específico</option>');
            }
        });

        // Manejar el botón de agregar participantes para capítulo
        $('#btnAgregarParticipanteCapitulo').click(function() {
            const tipo = $('#tipo_participante_capitulo').val();
            if (tipo) {
                $('#tipoParticipanteSeleccionado').text(tipo);
                $('.tipo-texto').text(tipo);
                $('#modalParticipantes').modal('show');
            } else {
                alert('Por favor seleccione un tipo de participante');
            }
        });




    });
</script>
<?= $this->endSection() ?>