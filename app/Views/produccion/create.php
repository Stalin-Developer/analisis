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
                                <label for="documento">Documento (Word/PDF)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documento" name="documento"
                                        accept=".doc,.docx,.pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
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
                                <label for="documento_capitulo">Documento (Word/PDF)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documento_capitulo" name="documento"
                                        accept=".doc,.docx,.pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                                    <label class="custom-file-label" for="documento_capitulo">Seleccionar archivo</label>
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
                                <label for="titulo_libro_completo">Título Libro *</label>
                                <input type="text" class="form-control" id="titulo_libro_completo" name="titulo"
                                    value="<?= old('titulo') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo_libro_isbn">Código ISBN *</label>
                                <input type="text" class="form-control" id="codigo_libro_isbn"
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
                                <label for="revisado_pares">Revisado por Pares *</label>
                                <select class="form-control" id="revisado_pares" name="revisado_pares" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach ($enumData['revisado_pares'] as $opcion): ?>
                                        <option value="<?= $opcion ?>"
                                            <?= old('revisado_pares') == $opcion ? 'selected' : '' ?>>
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
                                        <option value="<?= $filiacion ?>"
                                            <?= old('filiacion') == $filiacion ? 'selected' : '' ?>>
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
                                <label for="campo_amplio_id_libro">Campo Amplio *</label>
                                <select class="form-control" id="campo_amplio_id_libro"
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
                                <label for="campo_especifico_id_libro">Campo Específico *</label>
                                <select class="form-control" id="campo_especifico_id_libro"
                                    name="campo_especifico_id" required>
                                    <option value="">Seleccione primero un campo amplio</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="campo_detallado_id_libro">Campo Detallado *</label>
                                <select class="form-control" id="campo_detallado_id_libro"
                                    name="campo_detallado_id" required>
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
                                            <select class="form-control" id="tipo_participante_libro"
                                                name="tipo_participante" required>
                                                <option value="">Seleccione un tipo</option>
                                                <option value="Autor">Autor</option>
                                                <option value="Coautor">Coautor</option>
                                            </select>
                                            <button type="button" id="btnAgregarParticipanteLibro"
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









                <!-- Pestaña Otro -->
                <div class="tab-pane fade" id="otro" role="tabpanel" aria-labelledby="otro-tab">
                    <input type="hidden" name="tipo" value="Otro">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo_otro">Código *</label>
                                <input type="text" class="form-control" id="codigo_otro" name="codigo"
                                    value="<?= old('codigo') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_publicacion">Nombre Publicación *</label>
                                <input type="text" class="form-control" id="nombre_publicacion" name="titulo"
                                    value="<?= old('titulo') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_publicacion_otro">Fecha de Publicación *</label>
                                <input type="date" class="form-control" id="fecha_publicacion_otro"
                                    name="fecha_publicacion"
                                    value="<?= old('fecha_publicacion') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_apoyo_ies">Tipo de Apoyo Recibido por la IES</label>
                                <input type="text" class="form-control" id="tipo_apoyo_ies"
                                    name="tipo_apoyo_ies"
                                    value="<?= old('tipo_apoyo_ies') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="campo_amplio_id_otro">Campo Amplio *</label>
                                <select class="form-control" id="campo_amplio_id_otro"
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
                                <label for="campo_especifico_id_otro">Campo Específico *</label>
                                <select class="form-control" id="campo_especifico_id_otro"
                                    name="campo_especifico_id" required>
                                    <option value="">Seleccione primero un campo amplio</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="campo_detallado_id_otro">Campo Detallado *</label>
                                <select class="form-control" id="campo_detallado_id_otro"
                                    name="campo_detallado_id" required>
                                    <option value="">Seleccione primero un campo específico</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="documento_otro">Documento (Word/PDF)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documento_otro" name="documento"
                                        accept=".doc,.docx,.pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                                    <label class="custom-file-label" for="documento_otro">Seleccionar archivo</label>
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
                                            <select class="form-control" id="tipo_participante_otro"
                                                name="tipo_participante" required>
                                                <option value="">Seleccione un tipo</option>
                                                <option value="Autor">Autor</option>
                                                <option value="Coautor">Coautor</option>
                                            </select>
                                            <button type="button" id="btnAgregarParticipanteOtro"
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





        //CODIGO JAVASCRIPT PARA LA PESTANA LIBRO.
        $('#campo_amplio_id_libro').change(function() {
            const amplioId = $(this).val();
            if (amplioId) {
                $.get(`<?= base_url('produccion/get-campos-especificos') ?>/${amplioId}`, function(data) {
                    let options = '<option value="">Seleccione un campo específico</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_especifico}</option>`;
                    });
                    $('#campo_especifico_id_libro').html(options);
                    $('#campo_detallado_id_libro').html('<option value="">Seleccione primero un campo específico</option>');
                });
            } else {
                $('#campo_especifico_id_libro').html('<option value="">Seleccione primero un campo amplio</option>');
                $('#campo_detallado_id_libro').html('<option value="">Seleccione primero un campo específico</option>');
            }
        });

        $('#campo_especifico_id_libro').change(function() {
            const especificoId = $(this).val();
            if (especificoId) {
                $.get(`<?= base_url('produccion/get-campos-detallados') ?>/${especificoId}`, function(data) {
                    let options = '<option value="">Seleccione un campo detallado</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_detallado}</option>`;
                    });
                    $('#campo_detallado_id_libro').html(options);
                });
            } else {
                $('#campo_detallado_id_libro').html('<option value="">Seleccione primero un campo específico</option>');
            }
        });

        // Manejar el botón de agregar participantes para libro
        $('#btnAgregarParticipanteLibro').click(function() {
            const tipo = $('#tipo_participante_libro').val();
            if (tipo) {
                $('#tipoParticipanteSeleccionado').text(tipo);
                $('.tipo-texto').text(tipo);
                $('#modalParticipantes').modal('show');
            } else {
                alert('Por favor seleccione un tipo de participante');
            }
        });







        //CODIGO JAVASCRIPT PARA LA PESTANA OTRO.
        $('#campo_amplio_id_otro').change(function() {
            const amplioId = $(this).val();
            if (amplioId) {
                $.get(`<?= base_url('produccion/get-campos-especificos') ?>/${amplioId}`, function(data) {
                    let options = '<option value="">Seleccione un campo específico</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_especifico}</option>`;
                    });
                    $('#campo_especifico_id_otro').html(options);
                    $('#campo_detallado_id_otro').html('<option value="">Seleccione primero un campo específico</option>');
                });
            } else {
                $('#campo_especifico_id_otro').html('<option value="">Seleccione primero un campo amplio</option>');
                $('#campo_detallado_id_otro').html('<option value="">Seleccione primero un campo específico</option>');
            }
        });

        $('#campo_especifico_id_otro').change(function() {
            const especificoId = $(this).val();
            if (especificoId) {
                $.get(`<?= base_url('produccion/get-campos-detallados') ?>/${especificoId}`, function(data) {
                    let options = '<option value="">Seleccione un campo detallado</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_detallado}</option>`;
                    });
                    $('#campo_detallado_id_otro').html(options);
                });
            } else {
                $('#campo_detallado_id_otro').html('<option value="">Seleccione primero un campo específico</option>');
            }
        });

        // Manejar el botón de agregar participantes para otro
        $('#btnAgregarParticipanteOtro').click(function() {
            const tipo = $('#tipo_participante_otro').val();
            if (tipo) {
                $('#tipoParticipanteSeleccionado').text(tipo);
                $('.tipo-texto').text(tipo);
                $('#modalParticipantes').modal('show');
            } else {
                alert('Por favor seleccione un tipo de participante');
            }
        });






        //CODIGO PARA ACTULIZAR EL CAMPO TIPO SEGUN LA PESTANA ACTIVA.
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            // Obtener el ID de la pestaña activa
            const activeTabId = $(e.target).attr('id');

            // Actualizar el valor del campo tipo según la pestaña
            switch (activeTabId) {
                case 'articulo-tab':
                    $('input[name="tipo"]').val('Artículo');
                    break;
                case 'capitulo-tab':
                    $('input[name="tipo"]').val('Capítulo de Libro');
                    break;
                case 'libro-tab':
                    $('input[name="tipo"]').val('Libro');
                    break;
                case 'otro-tab':
                    $('input[name="tipo"]').val('Otro');
                    break;
            }


        });



    });





    









    //CODIGO PARA LA LOGICA DE PARTICIPANTES.
    $(function() {
        // Variables para almacenar participantes por pestaña
        let participantesArticulo = [];
        let participantesCapitulo = [];
        let participantesLibro = [];
        let participantesOtro = [];
        let participantesActuales = participantesArticulo; // Por defecto, estamos en la pestaña artículo

        // Manejar cambio de pestañas
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            // Guardar los datos actuales en la variable correspondiente
            const previousTab = $(e.relatedTarget).attr('id');
            const currentTab = $(e.target).attr('id');

            // Guardar datos de la pestaña anterior
            switch (previousTab) {
                case 'articulo-tab':
                    participantesArticulo = JSON.parse($('#participantes_data').val() || '[]');
                    break;
                case 'capitulo-tab':
                    participantesCapitulo = JSON.parse($('#participantes_data').val() || '[]');
                    break;
                case 'libro-tab':
                    participantesLibro = JSON.parse($('#participantes_data').val() || '[]');
                    break;
                case 'otro-tab':
                    participantesOtro = JSON.parse($('#participantes_data').val() || '[]');
                    break;
            }

            // Cargar datos de la nueva pestaña
            switch (currentTab) {
                case 'articulo-tab':
                    $('#participantes_data').val(JSON.stringify(participantesArticulo));
                    participantesActuales = participantesArticulo;
                    break;
                case 'capitulo-tab':
                    $('#participantes_data').val(JSON.stringify(participantesCapitulo));
                    participantesActuales = participantesCapitulo;
                    break;
                case 'libro-tab':
                    $('#participantes_data').val(JSON.stringify(participantesLibro));
                    participantesActuales = participantesLibro;
                    break;
                case 'otro-tab':
                    $('#participantes_data').val(JSON.stringify(participantesOtro));
                    participantesActuales = participantesOtro;
                    break;
            }

            // Limpiar y actualizar el modal con los nuevos datos
            $('#formParticipantes')[0].reset();
            cargarDatosParticipantes();
        });

        // Modificar la función existente de guardar participantes
        $('.nombre-participante, .cedula-participante').on('input', function() {
            const index = $(this).data('index');
            const isNombre = $(this).hasClass('nombre-participante');

            if (!participantesActuales[index]) {
                participantesActuales[index] = {
                    nombre: '',
                    cedula: ''
                };
            }

            if (isNombre) {
                participantesActuales[index].nombre = $(this).val();
            } else {
                participantesActuales[index].cedula = $(this).val();
            }

            $('#participantes_data').val(JSON.stringify(participantesActuales));
        });

        // Manejar el envío del formulario
        $('#formProduccion').on('submit', function(e) {
            const tabActiva = $('.nav-tabs .active').attr('id');
            let participantesValidos;

            // Obtener los participantes según la pestaña activa
            switch (tabActiva) {
                case 'articulo-tab':
                    participantesValidos = participantesArticulo.filter(p => p && p.nombre && p.cedula);
                    break;
                case 'capitulo-tab':
                    participantesValidos = participantesCapitulo.filter(p => p && p.nombre && p.cedula);
                    break;
                case 'libro-tab':
                    participantesValidos = participantesLibro.filter(p => p && p.nombre && p.cedula);
                    break;
                case 'otro-tab':
                    participantesValidos = participantesOtro.filter(p => p && p.nombre && p.cedula);
                    break;
            }

            // Verificar que haya al menos un participante
            if (!participantesValidos || participantesValidos.length === 0) {
                e.preventDefault();
                alert('Debe agregar al menos un participante');
                return false;
            }

            // Actualizar el campo oculto con los participantes válidos
            $('#participantes_data').val(JSON.stringify(participantesValidos));
            return true;
        });
    });









    //CODIGO JAVASCRIPT DE LOS MODALES DE PARTICPANTES.
    $(function() {
        let participantesData = [];

        // Actualizar el título del modal según el tipo seleccionado
        $('#btnAgregarParticipante').click(function() {
            const tipo = $('#tipo_participante').val();
            if(tipo) {
                $('#tipoParticipanteSeleccionado').text(tipo);
                $('.tipo-texto').text(tipo);
                $('#modalParticipantes').modal('show');
            } else {
                alert('Por favor seleccione un tipo de participante');
            }
        });

        // Handler para guardar datos cuando se ingresan
        $('.nombre-participante, .cedula-participante').on('input', function() {
            const index = $(this).data('index');
            const isNombre = $(this).hasClass('nombre-participante');
            
            if (!participantesData[index]) {
                participantesData[index] = { nombre: '', cedula: '' };
            }
            
            if (isNombre) {
                participantesData[index].nombre = $(this).val();
            } else {
                participantesData[index].cedula = $(this).val();
            }
            
            $('#participantes_data').val(JSON.stringify(participantesData));
        });

        // Cargar datos previos al abrir el modal
        $('#modalParticipantes').on('show.bs.modal', function() {
            cargarDatosParticipantes();
        });

        // Función para cargar datos previos
        function cargarDatosParticipantes() {
            const datosGuardados = $('#participantes_data').val();
            if(datosGuardados) {
                participantesData = JSON.parse(datosGuardados);
                participantesData.forEach((participante, index) => {
                    if(participante) {
                        $(`#nombre_participante_${index}`).val(participante.nombre || '');
                        $(`#cedula_participante_${index}`).val(participante.cedula || '');
                    }
                });
            }
        }

        // Limpiar datos al cerrar el modal
        $('#modalParticipantes').on('hidden.bs.modal', function() {
            const tipoActual = $('#tipo_participante').val();
            if(!tipoActual) {
                participantesData = [];
                $('#participantes_data').val('');
                $('#formParticipantes')[0].reset();
            }
        });
    });






</script>
<?= $this->endSection() ?>