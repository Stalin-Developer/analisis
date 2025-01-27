<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Proyectos Integradores de Saberes
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Gestión de Proyectos Integradores de Saberes
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Proyectos Integradores de Saberes</li>
<?= $this->endSection() ?>



<?= $this->section('styles') ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<style>
    .table-container {
        width: 100%;
        margin-bottom: 1rem;
        -webkit-overflow-scrolling: touch;
    }
    
    .table-container .table {
        margin-bottom: 0;
        white-space: nowrap;
    }

    /* Para mejorar la visibilidad de las columnas */
    .table td, .table th {
        min-width: 100px; /* ancho mínimo para cada columna */
        padding: 8px;
    }

    /* Para columnas específicas que necesiten más espacio */
    .table .column-description {
        min-width: 200px;
    }

    /* Para mantener la columna de acciones siempre visible */
    .table .actions-column {
        position: sticky;
        right: 0;
        background-color: #fff;
        box-shadow: -5px 0 5px -5px rgba(0,0,0,.15);
    }
</style>
<?= $this->endSection() ?>









<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Proyectos Integradores de Saberes</h3>
        <div class="card-tools">
            <a href="<?= base_url('pis/new') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Proyecto
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Filtros -->
        <form action="<?= base_url('pis') ?>" method="get">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo">Tipo de Proyecto</label>
                        <select class="form-control" id="tipo" name="tipo">
                            <option value="">Todos los tipos</option>
                            <?php foreach ($tipos as $tipo): ?>
                                <option value="<?= $tipo ?>" <?= $selected_tipo == $tipo ? 'selected' : '' ?>>
                                    <?= $tipo ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="">Todos los estados</option>
                            <?php foreach ($estados as $estado): ?>
                                <option value="<?= $estado ?>" <?= $selected_estado == $estado ? 'selected' : '' ?>>
                                    <?= $estado ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="anio">Año</label>
                        <select class="form-control" id="anio" name="anio">
                            <option value="">Todos los años</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year ?>" <?= $selected_anio == $year ? 'selected' : '' ?>>
                                    <?= $year ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="<?= base_url('pis') ?>" class="btn btn-secondary">
                                <i class="fas fa-undo"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Mensajes de éxito/error -->
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success text-center">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger text-center">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de proyectos -->
        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Tipo</th>
                        <th>Objetivo</th>
                        <th>Programa</th>  <!-- nombre_programa de la tabla programas -->
                        <th>Estado</th>
                        <th>Línea de Investigación</th>  <!-- nombre_linea de la tabla lineas_investigacion_carreras -->
                        <th>Facultad/Entidad/Área</th>
                        <th>Fecha Inicio</th>
                        <th>Coordinador/Director</th>
                        <th>Fecha Fin Planificado</th>
                        <th>Correo Coordinador</th>
                        <th>Fecha Fin Real</th>
                        <th>Teléfono Coordinador</th>
                        <th>Campo Amplio</th>  <!-- nombre_amplio de la tabla campo_amplio -->
                        <th>Campo Específico</th>  <!-- nombre_especifico de la tabla campo_especifico -->
                        <th>Campo Detallado</th>  <!-- nombre_detallado de la tabla campo_detallado -->
                        <th>Alcance Territorial</th>
                        <th>Investigadores Acreditados</th>
                        <th>Impacto Social</th>
                        <th>Impacto Científico</th>
                        <th>Impacto Económico</th>
                        <th>Impacto Político</th>
                        <th>Impacto Ambiental</th>
                        <th>Otro Impacto</th>
                        <th>Fuente Financiamiento</th>
                        <th>Descripción Actividad</th>
                        <th>Parámetro Cumplimiento</th>
                        <th>Cooperación</th>
                        <th>Red</th>
                        <th>Resultados Verificables</th>
                        <th>Año</th>
                        <th>Presupuesto Planificado</th>
                        <th>Presupuesto Ejecutado</th>
                        <th>Tipo Participante</th>
                        <th>Horas</th>
                        <th>Publicación</th>  <!-- nombre de la tabla produccion_cientifica_tecnica -->
                        <th class="actions-column">Acciones</th>
                    </tr>
                </thead>




                <tbody>
                    <?php foreach ($proyectos as $proyecto): ?>
                    <tr>
                        <td><?= $proyecto['id'] ?></td>
                        <td><?= $proyecto['nombre'] ?></td>
                        <td><?= $proyecto['codigo'] ?></td>
                        <td><?= $proyecto['tipo'] ?></td>
                        <td class="column-description"><?= $proyecto['objetivo'] ?></td>
                        <td><?= $proyecto['nombre_programa'] ?? 'No asignado' ?></td>
                        <td>
                            <?php
                            $estadoClass = '';
                            switch($proyecto['estado']) {
                                case 'Finalizado':
                                    $estadoClass = 'badge badge-success';
                                    break;
                                case 'En Cierre':
                                    $estadoClass = 'badge badge-info';
                                    break;
                                case 'En Ejecución':
                                    $estadoClass = 'badge badge-primary';
                                    break;
                                case 'Detenido':
                                    $estadoClass = 'badge badge-warning';
                                    break;
                                case 'Cancelado':
                                    $estadoClass = 'badge badge-danger';
                                    break;
                            }
                            ?>
                            <span class="<?= $estadoClass ?>"><?= $proyecto['estado'] ?></span>
                        </td>
                        <td><?= $proyecto['nombre_linea'] ?? 'No asignado' ?></td>
                        <td><?= $proyecto['facultad_entidad_area'] ?></td>
                        <td><?= date('d/m/Y', strtotime($proyecto['fecha_inicio'])) ?></td>
                        <td><?= $proyecto['coordinador_director'] ?></td>
                        <td><?= date('d/m/Y', strtotime($proyecto['fecha_fin_planificado'])) ?></td>
                        <td><?= $proyecto['correo_coordinador'] ?></td>
                        <td><?= $proyecto['fecha_fin_real'] ? date('d/m/Y', strtotime($proyecto['fecha_fin_real'])) : 'No finalizado' ?></td>
                        <td><?= $proyecto['telefono_coordinador'] ?></td>
                        <td><?= $proyecto['nombre_amplio'] ?? 'No asignado' ?></td>
                        <td><?= $proyecto['nombre_especifico'] ?? 'No asignado' ?></td>
                        <td><?= $proyecto['nombre_detallado'] ?? 'No asignado' ?></td>
                        <td><?= $proyecto['alcance_territorial'] ?></td>
                        <td><?= $proyecto['investigadores_acreditados'] ?></td>
                        <td class="column-description"><?= $proyecto['impacto_social'] ?></td>
                        <td class="column-description"><?= $proyecto['impacto_cientifico'] ?></td>
                        <td class="column-description"><?= $proyecto['impacto_economico'] ?></td>
                        <td class="column-description"><?= $proyecto['impacto_politico'] ?></td>
                        <td class="column-description"><?= $proyecto['impacto_ambiental'] ?></td>
                        <td class="column-description"><?= $proyecto['otro_impacto'] ?></td>
                        <td><?= $proyecto['fuente_financiamiento'] ?></td>
                        <td class="column-description"><?= $proyecto['descripcion_actividad'] ?></td>
                        <td><?= $proyecto['parametro_cumplimiento'] ?></td>
                        <td><?= $proyecto['cooperacion'] ?></td>
                        <td><?= $proyecto['red'] ?></td>
                        <td><?= $proyecto['resultados_verificables'] ?></td>
                        <td><?= $proyecto['anio'] ?></td>
                        <td>$<?= number_format($proyecto['presupuesto_planificado'], 2) ?></td>
                        <td>$<?= number_format($proyecto['presupuesto_ejecutado'], 2) ?></td>
                        <td><?= $proyecto['tipo_participante'] ?></td>
                        <td><?= $proyecto['horas'] ?></td>
                        <td><?= $proyecto['nombre_publicacion'] ?? 'No asignado' ?></td>
                        <td class="actions-column">
                            <div class="btn-group">
                                <a href="<?= base_url('pis/download/' . $proyecto['id']) ?>" 
                                class="btn btn-sm btn-info" title="Descargar Proyecto">
                                    <i class="fas fa-download"></i>
                                </a>
                                <?php if ($proyecto['poster_path']): ?>
                                <a href="<?= base_url('pis/download-poster/' . $proyecto['id']) ?>" 
                                class="btn btn-sm btn-success" title="Descargar Póster">
                                    <i class="fas fa-image"></i>
                                </a>
                                <?php endif; ?>
                                <a href="<?= base_url('pis/edit/' . $proyecto['id']) ?>" 
                                class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('pis/delete/' . $proyecto['id']) ?>" 
                                class="btn btn-sm btn-danger" 
                                onclick="return confirm('¿Está seguro de eliminar este proyecto?')"
                                title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>




            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>



<?= $this->section('scripts') ?>
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script>
$(function () {
    $('.table').DataTable({
        "responsive": true,
        "autoWidth": false,
        "scrollX": true,  // Habilitamos scroll horizontal
        "order": [],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        },
        "fixedColumns": {
            rightColumns: 1 // Mantener la columna de acciones fija
        }
    });
});
</script>
<?= $this->endSection() ?>