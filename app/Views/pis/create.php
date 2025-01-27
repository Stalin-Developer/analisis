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
                            <option value="Investigación" <?= old('tipo') == 'Investigación' ? 'selected' : '' ?>>Investigación</option>
                            <option value="Vinculación" <?= old('tipo') == 'Vinculación' ? 'selected' : '' ?>>Vinculación</option>
                            <option value="Investigación y Vinculación" <?= old('tipo') == 'Investigación y Vinculación' ? 'selected' : '' ?>>Investigación y Vinculación</option>
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
                        <label for="programa_id">Programa</label>
                        <select class="form-control" id="programa_id" name="programa_id">
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
                            <option value="Finalizado" <?= old('estado') == 'Finalizado' ? 'selected' : '' ?>>Finalizado</option>
                            <option value="En Cierre" <?= old('estado') == 'En Cierre' ? 'selected' : '' ?>>En Cierre</option>
                            <option value="En Ejecución" <?= old('estado') == 'En Ejecución' ? 'selected' : '' ?>>En Ejecución</option>
                            <option value="Detenido" <?= old('estado') == 'Detenido' ? 'selected' : '' ?>>Detenido</option>
                            <option value="Cancelado" <?= old('estado') == 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="linea_investigacion_carrera_id">Línea de Investigación</label>
                        <select class="form-control" id="linea_investigacion_carrera_id" name="linea_investigacion_carrera_id">
                            <option value="">Seleccione una línea</option>
                            <?php foreach ($lineas_investigacion as $linea): ?>
                                <option value="<?= $linea['id'] ?>" <?= old('linea_investigacion_carrera_id') == $linea['id'] ? 'selected' : '' ?>>
                                    <?= $linea['nombre_linea'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
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
                        <label for="fecha_fin_real">Fecha de Fin Real</label>
                        <input type="date" class="form-control" id="fecha_fin_real" name="fecha_fin_real" 
                               value="<?= old('fecha_fin_real') ?>">
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
                            <option value="Cantonal" <?= old('alcance_territorial') == 'Cantonal' ? 'selected' : '' ?>>Cantonal</option>
                            <option value="Institucional" <?= old('alcance_territorial') == 'Institucional' ? 'selected' : '' ?>>Institucional</option>
                            <option value="Internacional" <?= old('alcance_territorial') == 'Internacional' ? 'selected' : '' ?>>Internacional</option>
                            <option value="Nacional" <?= old('alcance_territorial') == 'Nacional' ? 'selected' : '' ?>>Nacional</option>
                            <option value="Parroquial" <?= old('alcance_territorial') == 'Parroquial' ? 'selected' : '' ?>>Parroquial</option>
                            <option value="Provincial" <?= old('alcance_territorial') == 'Provincial' ? 'selected' : '' ?>>Provincial</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="investigadores_acreditados">Investigadores Acreditados *</label>
                        <select class="form-control" id="investigadores_acreditados" name="investigadores_acreditados" required>
                            <option value="">Seleccione una opción</option>
                            <option value="Si" <?= old('investigadores_acreditados') == 'Si' ? 'selected' : '' ?>>Sí</option>
                            <option value="No" <?= old('investigadores_acreditados') == 'No' ? 'selected' : '' ?>>No</option>
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
                                    <option value="Asignación Regular IES" <?= old('fuente_financiamiento') == 'Asignación Regular IES' ? 'selected' : '' ?>>Asignación Regular IES</option>
                                    <option value="Fondos Concursables Interno IES" <?= old('fuente_financiamiento') == 'Fondos Concursables Interno IES' ? 'selected' : '' ?>>Fondos Concursables Interno IES</option>
                                    <option value="Fondos Concursables Nacionales" <?= old('fuente_financiamiento') == 'Fondos Concursables Nacionales' ? 'selected' : '' ?>>Fondos Concursables Nacionales</option>
                                    <option value="Fondos Concursables Internacionales" <?= old('fuente_financiamiento') == 'Fondos Concursables Internacionales' ? 'selected' : '' ?>>Fondos Concursables Internacionales</option>
                                    <option value="Fondos No Concursables Internacionales" <?= old('fuente_financiamiento') == 'Fondos No Concursables Internacionales' ? 'selected' : '' ?>>Fondos No Concursables Internacionales</option>
                                    <option value="Fondos No Concursables Nacionales Externos a la IES" <?= old('fuente_financiamiento') == 'Fondos No Concursables Nacionales Externos a la IES' ? 'selected' : '' ?>>Fondos No Concursables Nacionales Externos a la IES</option>
                                    <option value="Otros" <?= old('fuente_financiamiento') == 'Otros' ? 'selected' : '' ?>>Otros</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion_actividad">Descripción de la Actividad *</label>
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
                                    <option value="Gasto Interno" <?= old('parametro_cumplimiento') == 'Gasto Interno' ? 'selected' : '' ?>>Gasto Interno</option>
                                    <option value="Gasto Externo" <?= old('parametro_cumplimiento') == 'Gasto Externo' ? 'selected' : '' ?>>Gasto Externo</option>
                                    <option value="Gasto de Capital" <?= old('parametro_cumplimiento') == 'Gasto de Capital' ? 'selected' : '' ?>>Gasto de Capital</option>
                                    <option value="Gasto Interno Bruto en I + D + I" <?= old('parametro_cumplimiento') == 'Gasto Interno Bruto en I + D + I' ? 'selected' : '' ?>>Gasto Interno Bruto en I + D + I</option>
                                    <option value="Gasto Nacional Bruto en I + D + I" <?= old('parametro_cumplimiento') == 'Gasto Nacional Bruto en I + D + I' ? 'selected' : '' ?>>Gasto Nacional Bruto en I + D + I</option>
                                    <option value="Créditos Presupuestarios Públicos en I + D + I" <?= old('parametro_cumplimiento') == 'Créditos Presupuestarios Públicos en I + D + I' ? 'selected' : '' ?>>Créditos Presupuestarios Públicos en I + D + I</option>
                                    <option value="Costos Salariales Personal  I +D + I" <?= old('parametro_cumplimiento') == 'Costos Salariales Personal  I +D + I' ? 'selected' : '' ?>>Costos Salariales Personal I +D + I</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cooperacion">Cooperación *</label>
                                <select class="form-control" id="cooperacion" name="cooperacion" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="Internacional" <?= old('cooperacion') == 'Internacional' ? 'selected' : '' ?>>Internacional</option>
                                    <option value="Nacional" <?= old('cooperacion') == 'Nacional' ? 'selected' : '' ?>>Nacional</option>
                                    <option value="Internacional y Nacional" <?= old('cooperacion') == 'Internacional y Nacional' ? 'selected' : '' ?>>Internacional y Nacional</option>
                                    <option value="No Aplica" <?= old('cooperacion') == 'No Aplica' ? 'selected' : '' ?>>No Aplica</option>
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
                                    <option value="Internacional" <?= old('red') == 'Internacional' ? 'selected' : '' ?>>Internacional</option>
                                    <option value="Nacional" <?= old('red') == 'Nacional' ? 'selected' : '' ?>>Nacional</option>
                                    <option value="Internacional y Nacional" <?= old('red') == 'Internacional y Nacional' ? 'selected' : '' ?>>Internacional y Nacional</option>
                                    <option value="No Aplica" <?= old('red') == 'No Aplica' ? 'selected' : '' ?>>No Aplica</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="resultados_verificables">Resultados Verificables *</label>
                                <select class="form-control" id="resultados_verificables" name="resultados_verificables" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="Totales" <?= old('resultados_verificables') == 'Totales' ? 'selected' : '' ?>>Totales</option>
                                    <option value="Parciales" <?= old('resultados_verificables') == 'Parciales' ? 'selected' : '' ?>>Parciales</option>
                                    <option value="Sin Resultados" <?= old('resultados_verificables') == 'Sin Resultados' ? 'selected' : '' ?>>Sin Resultados</option>
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
                                    <option value="Docente" <?= old('tipo_participante') == 'Docente' ? 'selected' : '' ?>>Docente</option>
                                    <option value="Estudiante" <?= old('tipo_participante') == 'Estudiante' ? 'selected' : '' ?>>Estudiante</option>
                                    <option value="Ambos" <?= old('tipo_participante') == 'Ambos' ? 'selected' : '' ?>>Ambos</option>
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
                                <label for="proyecto">Documento del Proyecto (PDF)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="proyecto" name="proyecto" accept=".pdf">
                                    <label class="custom-file-label" for="proyecto">Seleccionar archivo</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="poster">Póster (PDF/Imagen)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="poster" name="poster" 
                                        accept=".pdf,.jpg,.jpeg,.png">
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

// Restaurar campos específicos y detallados si hay valores antiguos
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
</script>
<?= $this->endSection() ?>                                