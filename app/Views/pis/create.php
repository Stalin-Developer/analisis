<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Nuevo Proyecto Integrador de Saberes
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Nuevo Proyecto Integrador de Saberes
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('pis') ?>">Proyectos Integradores</a></li>
<li class="breadcrumb-item active">Nuevo</li>
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

        <form action="<?= base_url('pis/create') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <!-- Información básica del proyecto -->
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="nombre">Nombre del Proyecto *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                               value="<?= old('nombre') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="codigo">Código *</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" 
                               value="<?= old('codigo') ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipo">Tipo de Proyecto *</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="">Seleccione un tipo</option>
                            <?php foreach ($enumData['tipo'] as $tipo): ?>
                                <option value="<?= $tipo ?>" <?= old('tipo') == $tipo ? 'selected' : '' ?>>
                                    <?= $tipo ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="objetivo">Objetivo *</label>
                        <textarea class="form-control" id="objetivo" name="objetivo" rows="2" required><?= old('objetivo') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="programa_id">Programa *</label>
                        <select class="form-control" id="programa_id" name="programa_id" require>
                            <option value="">Seleccione un programa</option>
                            <?php foreach ($programas as $programa): ?>
                                <option value="<?= $programa['id'] ?>" <?= old('programa_id') == $programa['id'] ? 'selected' : '' ?>>
                                    <?= $programa['nombre_programa'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
                        <label for="linea_investigacion_carrera_id">Línea de Investigación *</label>
                        <div class="d-flex">
                            <select class="form-control" id="linea_investigacion_carrera_id" name="linea_investigacion_carrera_id" required>
                                <option value="">Seleccione una línea</option>
                                <?php foreach ($lineas_investigacion as $linea): ?>
                                    <option value="<?= $linea['id'] ?>" <?= old('linea_investigacion_carrera_id') == $linea['id'] ? 'selected' : '' ?>>
                                        <?= $linea['nombre_linea'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#modalLineasInvestigacion">Administrar</button>
                        </div>
                    </div>
                </div>

                <!-- La logica del modal esta en este archivo: Views/pis/lineas_investigacion.php -->
                <?= $this->include('pis/lineas_investigacion') ?>



            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="facultad_entidad_area">Facultad/Entidad/Área *</label>
                        <input type="text" class="form-control" id="facultad_entidad_area" name="facultad_entidad_area" 
                               value="<?= old('facultad_entidad_area') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="coordinador_director">Coordinador/Director *</label>
                        <input type="text" class="form-control" id="coordinador_director" name="coordinador_director" 
                               value="<?= old('coordinador_director') ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de Inicio *</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                               value="<?= old('fecha_inicio') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fecha_fin_planificado">Fecha de Fin Planificada *</label>
                        <input type="date" class="form-control" id="fecha_fin_planificado" name="fecha_fin_planificado" 
                               value="<?= old('fecha_fin_planificado') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fecha_fin_real">Fecha de Fin Real *</label>
                        <input type="date" class="form-control" id="fecha_fin_real" name="fecha_fin_real" 
                               value="<?= old('fecha_fin_real') ?>" require>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="correo_coordinador">Correo del Coordinador *</label>
                        <input type="email" class="form-control" id="correo_coordinador" name="correo_coordinador" 
                               value="<?= old('correo_coordinador') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefono_coordinador">Teléfono del Coordinador *</label>
                        <input type="number" class="form-control" id="telefono_coordinador" name="telefono_coordinador" 
                               value="<?= old('telefono_coordinador') ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="campo_amplio_id">Campo Amplio</label>
                        <select class="form-control" id="campo_amplio_id" name="campo_amplio_id">
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
                        <label for="campo_especifico_id">Campo Específico</label>
                        <select class="form-control" id="campo_especifico_id" name="campo_especifico_id">
                            <option value="">Seleccione primero un campo amplio</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="campo_detallado_id">Campo Detallado</label>
                        <select class="form-control" id="campo_detallado_id" name="campo_detallado_id">
                            <option value="">Seleccione primero un campo específico</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="alcance_territorial">Alcance Territorial *</label>
                        <select class="form-control" id="alcance_territorial" name="alcance_territorial" required>
                            <option value="">Seleccione un alcance</option>
                            <?php foreach ($enumData['alcance_territorial'] as $alcance): ?>
                                <option value="<?= $alcance ?>" <?= old('alcance_territorial') == $alcance ? 'selected' : '' ?>>
                                    <?= $alcance ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="investigadores_acreditados">Investigadores Acreditados *</label>
                        <select class="form-control" id="investigadores_acreditados" name="investigadores_acreditados" required>
                            <option value="">Seleccione una opción</option>
                            <?php foreach ($enumData['investigadores_acreditados'] as $opcion): ?>
                                <option value="<?= $opcion ?>" <?= old('investigadores_acreditados') == $opcion ? 'selected' : '' ?>>
                                    <?= $opcion ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
                            
            <!-- Sección de Impactos -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Impactos del Proyecto</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="impacto_social">Impacto Social</label>
                                <textarea class="form-control" id="impacto_social" name="impacto_social" rows="2"><?= old('impacto_social') ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="impacto_cientifico">Impacto Científico</label>
                                <textarea class="form-control" id="impacto_cientifico" name="impacto_cientifico" rows="2"><?= old('impacto_cientifico') ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="impacto_economico">Impacto Económico</label>
                                <textarea class="form-control" id="impacto_economico" name="impacto_economico" rows="2"><?= old('impacto_economico') ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="impacto_politico">Impacto Político</label>
                                <textarea class="form-control" id="impacto_politico" name="impacto_politico" rows="2"><?= old('impacto_politico') ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="impacto_ambiental">Impacto Ambiental</label>
                                <textarea class="form-control" id="impacto_ambiental" name="impacto_ambiental" rows="2"><?= old('impacto_ambiental') ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="otro_impacto">Otro Impacto</label>
                                <textarea class="form-control" id="otro_impacto" name="otro_impacto" rows="2"><?= old('otro_impacto') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Información Financiera y Administrativa -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Información Financiera y Administrativa</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fuente_financiamiento">Fuente de Financiamiento *</label>
                                <select class="form-control" id="fuente_financiamiento" name="fuente_financiamiento" required>
                                    <option value="">Seleccione una fuente</option>
                                    <?php foreach ($enumData['fuente_financiamiento'] as $fuente): ?>
                                        <option value="<?= $fuente ?>" <?= old('fuente_financiamiento') == $fuente ? 'selected' : '' ?>>
                                            <?= $fuente ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion_actividad">Descripción de la Actividad I + D *</label>
                                <textarea class="form-control" id="descripcion_actividad" name="descripcion_actividad" rows="2" required><?= old('descripcion_actividad') ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parametro_cumplimiento">Parámetro de Cumplimiento *</label>
                                <select class="form-control" id="parametro_cumplimiento" name="parametro_cumplimiento" required>
                                    <option value="">Seleccione un parámetro</option>
                                    <?php foreach ($enumData['parametro_cumplimiento'] as $parametro): ?>
                                        <option value="<?= $parametro ?>" <?= old('parametro_cumplimiento') == $parametro ? 'selected' : '' ?>>
                                            <?= $parametro ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cooperacion">Cooperación *</label>
                                <select class="form-control" id="cooperacion" name="cooperacion" required>
                                    <option value="">Seleccione un tipo</option>
                                    <?php foreach ($enumData['cooperacion'] as $coop): ?>
                                        <option value="<?= $coop ?>" <?= old('cooperacion') == $coop ? 'selected' : '' ?>>
                                            <?= $coop ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="red">Red *</label>
                                <select class="form-control" id="red" name="red" required>
                                    <option value="">Seleccione un tipo</option>
                                    <?php foreach ($enumData['red'] as $red): ?>
                                        <option value="<?= $red ?>" <?= old('red') == $red ? 'selected' : '' ?>>
                                            <?= $red ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="resultados_verificables">Resultados Verificables *</label>
                                <select class="form-control" id="resultados_verificables" name="resultados_verificables" required>
                                    <option value="">Seleccione un tipo</option>
                                    <?php foreach ($enumData['resultados_verificables'] as $resultado): ?>
                                        <option value="<?= $resultado ?>" <?= old('resultados_verificables') == $resultado ? 'selected' : '' ?>>
                                            <?= $resultado ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="anio">Año *</label>
                                <input type="number" class="form-control" id="anio" name="anio" 
                                    min="1000" max="9999" value="<?= old('anio', date('Y')) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="presupuesto_planificado">Presupuesto Planificado *</label>
                                <input type="number" class="form-control" id="presupuesto_planificado" 
                                    name="presupuesto_planificado" step="0.01" min="0" 
                                    value="<?= old('presupuesto_planificado') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="presupuesto_ejecutado">Presupuesto Ejecutado *</label>
                                <input type="number" class="form-control" id="presupuesto_ejecutado" 
                                    name="presupuesto_ejecutado" step="0.01" min="0" 
                                    value="<?= old('presupuesto_ejecutado') ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Participación y Documentación -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Participación y Documentación</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo_participante">Tipo de Participante *</label>
                                <select class="form-control" id="tipo_participante" name="tipo_participante" required>
                                    <option value="">Seleccione un tipo</option>
                                    <?php foreach ($enumData['tipo_participante'] as $tipo): ?>
                                        <option value="<?= $tipo ?>" <?= old('tipo_participante') == $tipo ? 'selected' : '' ?>>
                                            <?= $tipo ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="horas">Horas *</label>
                                <input type="number" class="form-control" id="horas" name="horas" 
                                    min="1" value="<?= old('horas') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="publicaciones_id">Publicación</label>
                                <select class="form-control" id="publicaciones_id" name="publicaciones_id">
                                    <option value="">Seleccione una publicación</option>
                                    <?php foreach ($publicaciones as $publicacion): ?>
                                        <option value="<?= $publicacion['id'] ?>" <?= old('publicaciones_id') == $publicacion['id'] ? 'selected' : '' ?>>
                                            <?= $publicacion['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proyecto">Documento del Proyecto (Word/PDF)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="proyecto" name="proyecto" 
                                        accept=".doc,.docx,.pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf">
                                    <label class="custom-file-label" for="proyecto">Seleccionar archivo</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="poster">Póster (PowerPoint/PDF)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="poster" name="poster" 
                                        accept=".ppt,.pptx,.pdf,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/pdf">
                                    <label class="custom-file-label" for="poster">Seleccionar archivo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-right">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="<?= base_url('pis') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <!-- Mensaje de carga mientras se suben los archivos -->
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
// ===============================================
// Manejo de campos dependientes (amplio, específico, detallado)
// ===============================================
$(function() {
    // Manejar cambios en campo amplio
    $('#campo_amplio_id').change(function() {
        const amplioId = $(this).val();
        if (amplioId) {
            $.get(`<?= base_url('pis/get-campos-especificos') ?>/${amplioId}`, function(data) {
                let options = '<option value="">Seleccione un campo específico</option>';
                data.forEach(function(campo) {
                    options += `<option value="${campo.id}">${campo.nombre_especifico}</option>`;
                });
                $('#campo_especifico_id').html(options);
                $('#campo_detallado_id').html('<option value="">Seleccione primero un campo específico</option>');
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alert('Error al cargar los campos específicos. Por favor, intente nuevamente.');
                console.error('Error:', errorThrown);
            });
        } else {
            $('#campo_especifico_id').html('<option value="">Seleccione primero un campo amplio</option>');
            $('#campo_detallado_id').html('<option value="">Seleccione primero un campo específico</option>');
        }
    });

    // Manejar cambios en campo específico
    $('#campo_especifico_id').change(function() {
        const especificoId = $(this).val();
        if (especificoId) {
            $.get(`<?= base_url('pis/get-campos-detallados') ?>/${especificoId}`, function(data) {
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
});

// ===============================================
// Inicialización y manejo de archivos
// ===============================================
$(document).ready(function() {
    // Inicializar el plugin de archivo personalizado
    bsCustomFileInput.init();

    // Mostrar el nombre del archivo seleccionado
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    
    // Validar tamaño y tipo de archivo antes de enviar
    $('form').on('submit', function(e) {
        const maxSize = 10 * 1024 * 1024; // 10MB
        const proyecto = $('#proyecto')[0].files[0];
        const poster = $('#poster')[0].files[0];
        
        if (proyecto && proyecto.size > maxSize) {
            e.preventDefault();
            alert('El archivo del proyecto no debe exceder los 10MB');
            return false;
        }
        
        if (poster && poster.size > maxSize) {
            e.preventDefault();
            alert('El archivo del póster no debe exceder los 10MB');
            return false;
        }
        
        return true;
    });

    // Para manejar el mensaje de carga mientras se suben los archivos
    $('form').on('submit', function() {
        $('#loadingOverlay').show();
    });
});

// ===============================================
// Restaurar valores antiguos
// ===============================================
$(document).ready(function() {
    const oldAmplioId = $('#campo_amplio_id').val();
    const oldEspecificoId = '<?= old('campo_especifico_id') ?>';
    const oldDetalladoId = '<?= old('campo_detallado_id') ?>';

    if (oldAmplioId) {
        $.get(`<?= base_url('pis/get-campos-especificos') ?>/${oldAmplioId}`, function(data) {
            let options = '<option value="">Seleccione un campo específico</option>';
            data.forEach(function(campo) {
                options += `<option value="${campo.id}" ${campo.id == oldEspecificoId ? 'selected' : ''}>${campo.nombre_especifico}</option>`;
            });
            $('#campo_especifico_id').html(options);

            if (oldEspecificoId) {
                $.get(`<?= base_url('pis/get-campos-detallados') ?>/${oldEspecificoId}`, function(data) {
                    let options = '<option value="">Seleccione un campo detallado</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}" ${campo.id == oldDetalladoId ? 'selected' : ''}>${campo.nombre_detallado}</option>`;
                    });
                    $('#campo_detallado_id').html(options);
                });
            }
        });
    }
});




// ===============================================
// Código para el manejo de líneas de investigación
// ===============================================
$(function() {
    // Cargar líneas al abrir el modal
    $('#modalLineasInvestigacion').on('show.bs.modal', function () {
        console.log('Modal está abriéndose');
        cargarLineasInvestigacion();
    });

    

    function cargarLineasInvestigacion() {
        $.get('<?= base_url('pis/lineas-investigacion/list') ?>')
            .done(function(response) {
                let html = '';
                clearModalMessages();
                
                if (!response.success) {
                    showModalError(response.error);
                    $('#tbodyLineasInvestigacion').html('<tr><td colspan="3" class="text-center">Error al cargar los datos</td></tr>');
                    return;
                }

                const lineas = response.data;
                
                if (!lineas || lineas.length === 0) {
                    html = '<tr><td colspan="3" class="text-center">No hay líneas de investigación registradas</td></tr>';
                } else {
                    lineas.forEach(function(linea) {
                        html += `
                            <tr>
                                <td>${linea.nombre_linea || ''}</td>
                                <td>${linea.carrera_nombre || ''}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editarLinea(${linea.id})" type="button">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarLinea(${linea.id})" type="button">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }
                
                $('#tbodyLineasInvestigacion').html(html);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Error en la petición:', {
                    status: jqXHR.status,
                    textStatus: textStatus,
                    error: errorThrown
                });
                clearModalMessages();
                showModalError('Error al cargar las líneas de investigación');
                $('#tbodyLineasInvestigacion').html('<tr><td colspan="3" class="text-center">Error al cargar los datos</td></tr>');
            });
    }

    // Función para editar una línea
    window.editarLinea = function(id) {
        // Cerrar el primer modal
        //$('#modalLineasInvestigacion').modal('hide');
        
        // Obtener los datos de la línea y cargarlos en el formulario de edición
        $.get(`<?= base_url('pis/lineas-investigacion/get') ?>/${id}`, function(data) {
            $('#edit_linea_id').val(data.id);
            $('#edit_nombre_linea').val(data.nombre_linea);
            $('#edit_carrera_id').val(data.carrera_id);
            
            // Abrir el modal de edición
            $('#modalEditarLinea').modal('show');
        });
    };

    // Función para eliminar una línea
    window.eliminarLinea = function(id) {
        if(confirm('¿Está seguro de eliminar esta línea de investigación?')) {
            clearModalMessages();
            
            $.ajax({
                url: `<?= base_url('pis/lineas-investigacion/delete') ?>/${id}`,
                type: 'DELETE',
                success: function(response) {
                    if(response.success) {
                        showModalSuccess(response.message);

                        // Esperar 2 segundos antes de actualizar la tabla
                        setTimeout(function() {
                            cargarLineasInvestigacion();
                            actualizarSelectLineasInvestigacion();
                        }, 1000); // 2000 milisegundos = 2 segundos

                    } else {
                        showModalError(response.error);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Error al eliminar la línea';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                    showModalError(errorMsg);
                }
            });
        }
    };

    // Función para resetear el formulario
    function resetearFormulario() {
        $('#linea_id').val('');
        $('#formLineasInvestigacion')[0].reset();
    }

    // Función para actualizar el select en el formulario principal
    function actualizarSelectLineasInvestigacion() {
        $.get('<?= base_url('pis/lineas-investigacion/list') ?>', function(response) {
            let options = '<option value="">Seleccione una línea</option>';
            if (response.success && response.data) {
                response.data.forEach(function(linea) {
                    options += `<option value="${linea.id}">${linea.nombre_linea}</option>`;
                });
            }
            $('#linea_investigacion_carrera_id').html(options);
        });
    }

    // Funciones para manejar mensajes
    window.clearModalMessages = function() {
        $('#modalErrorAlert').hide();
        $('#modalSuccessAlert').hide();
    };

    window.showModalError = function(message) {
        const errorList = $('#modalErrorList');
        errorList.empty();
        
        if (Array.isArray(message)) {
            message.forEach(msg => {
                errorList.append(`<li>${msg}</li>`);
            });
        } else {
            errorList.append(`<li>${message}</li>`);
        }
        
        $('#modalErrorAlert').show();
        $('#modalSuccessAlert').hide();
    };

    window.showModalSuccess = function(message) {
        $('#modalSuccessMessage').text(message);
        $('#modalSuccessAlert').show();
        $('#modalErrorAlert').hide();
    };




    // Handler para el formulario de nueva línea
    $(document).ready(function() {
        $('button[form="formNuevaLinea"]').on('click', function(e) {
            e.preventDefault();
            
            const data = {
                nombre_linea: $('#nombre_linea').val(),
                carrera_id: $('#carrera_id').val()
            };

            // Validar campos manualmente ya que no usamos el submit del formulario
            if (!data.nombre_linea || !data.carrera_id) {
                showModalError('El nombre de la línea y la carrera son obligatorios');
                return;
            }

            $.ajax({
                url: '<?= base_url('pis/lineas-investigacion/create') ?>',
                type: 'POST',
                data: data,
                success: function(response) {
                    if(response.success) {
                        showModalSuccess(response.message);
                        // Limpiar los campos individualmente
                        $('#nombre_linea').val('');  // Limpia el input de nombre
                        $('#carrera_id').val('');    // Resetea el select de carrera


                        // Esperar 2 segundos antes de actualizar la tabla
                        setTimeout(function() {
                            cargarLineasInvestigacion();
                            actualizarSelectLineasInvestigacion();
                            
                        }, 1500);

                    } else {
                        showModalError(response.error);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Error al crear la línea de investigación';
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMsg = xhr.responseJSON.error;
                    }
                    showModalError(errorMsg);
                }
            });
        });
    });







    // Agregar el handler para el formulario de edición
    $('#formEditarLinea').on('submit', function(e) {
        e.preventDefault();
        const lineaId = $('#edit_linea_id').val();
        const data = {
            nombre_linea: $('#edit_nombre_linea').val(),
            carrera_id: $('#edit_carrera_id').val()
        };

        $.ajax({
            url: `<?= base_url('pis/lineas-investigacion/update') ?>/${lineaId}`,
            type: 'PUT',
            data: data,
            success: function(response) {
                if(response.success) {
                    // Mostrar mensaje de éxito
                    $('#modalEditSuccessMessage').text(response.message);
                    $('#modalEditSuccessAlert').show();
                    $('#modalEditErrorAlert').hide();
                    
                    // Cerrar el modal de edición después de un breve delay
                    setTimeout(function() {
                        $('#modalEditarLinea').modal('hide');
                        // Reabrir el modal principal y actualizar la tabla
                        //$('#modalLineasInvestigacion').modal('show');
                        cargarLineasInvestigacion();
                    }, 1000);
                } else {
                    $('#modalEditErrorList').html(`<li>${response.error}</li>`);
                    $('#modalEditErrorAlert').show();
                    $('#modalEditSuccessAlert').hide();
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error al actualizar la línea de investigación';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                $('#modalEditErrorList').html(`<li>${errorMsg}</li>`);
                $('#modalEditErrorAlert').show();
                $('#modalEditSuccessAlert').hide();
            }
        });
    });












});


</script>
<?= $this->endSection() ?>                             