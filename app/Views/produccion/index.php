<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Producción Científica y Técnica
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Gestión de Producción Científica y Técnica
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item active">Producción Científica y Técnica</li>
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
        width: 100%;
    }

    .actions-column {
        position: sticky;
        right: 0;
        background-color: #fff;
        box-shadow: -5px 0 5px -5px rgba(0,0,0,.15);
        width: 120px;
        white-space: nowrap;
    }

    .table-container .table th,
    .table-container .table td {
        text-align: center;
        vertical-align: middle;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Producción Científica y Técnica</h3>
        <div class="card-tools">
            <a href="<?= base_url('produccion/new') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Producción
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- Filtros -->
        <form action="<?= base_url('produccion') ?>" method="get">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
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
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                            <a href="<?= base_url('produccion') ?>" class="btn btn-secondary">
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

        <!-- Tabla de producción -->
        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Fecha Publicación</th>
                        <th>Campo Amplio</th>
                        <th>Campo Específico</th>
                        <th>Campo Detallado</th>
                        <th>Filiación</th>
                        <th>Tipo Artículo</th>
                        <th>Base de Datos</th>
                        <th>ISSN</th>
                        <th>Nombre Revista</th>
                        <th>Estado</th>
                        <th>Link Publicación</th>
                        <th>Link Revista</th>
                        <th>Intercultural</th>
                        <th>Título Libro</th>
                        <th>Total Capítulos</th>
                        <th>ISBN Capítulo</th>
                        <th>Editor/Copilador</th>
                        <th>Páginas</th>
                        <th>ISBN Libro</th>
                        <th>Revisado por Pares</th>
                        <th>Tipo Apoyo IES</th>
                        <th>Participantes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($producciones as $produccion): ?>
                    <tr>
                        <td><?= $produccion['id'] ?></td>
                        <td><?= $produccion['tipo'] ?></td>
                        <td><?= $produccion['codigo'] ?></td>
                        <td><?= $produccion['titulo'] ?></td>
                        <td><?= date('d/m/Y', strtotime($produccion['fecha_publicacion'])) ?></td>
                        <td><?= $produccion['nombre_amplio'] ?? 'No asignado' ?></td>
                        <td><?= $produccion['nombre_especifico'] ?? 'No asignado' ?></td>
                        <td><?= $produccion['nombre_detallado'] ?? 'No asignado' ?></td>
                        <td><?= $produccion['filiacion'] ?></td>
                        <td><?= $produccion['tipo_articulo'] ?? 'No aplica' ?></td>
                        <td><?= $produccion['nombre_base_datos'] ?? 'No asignado' ?></td>
                        <td><?= $produccion['codigo_issn'] ?? 'No aplica' ?></td>
                        <td><?= $produccion['nombre_revista'] ?? 'No aplica' ?></td>
                        <td><?= $produccion['estado'] ?? 'No aplica' ?></td>
                        <td><?= $produccion['link_publicacion'] ?? 'No disponible' ?></td>
                        <td><?= $produccion['link_revista'] ?? 'No disponible' ?></td>
                        <td><?= $produccion['intercultural'] ?? 'No registra' ?></td>
                        <td><?= $produccion['titulo_libro'] ?? 'No aplica' ?></td>
                        <td><?= $produccion['total_capitulos_libro'] ?? 'N/A' ?></td>
                        <td><?= $produccion['codigo_capitulo_isbn'] ?? 'No aplica' ?></td>
                        <td><?= $produccion['editor_copilador'] ?? 'No aplica' ?></td>
                        <td><?= $produccion['paginas'] ?? 'No especificado' ?></td>
                        <td><?= $produccion['codigo_libro_isbn'] ?? 'No aplica' ?></td>
                        <td><?= $produccion['revisado_pares'] ?? 'No especificado' ?></td>
                        <td><?= $produccion['tipo_apoyo_ies'] ?? 'No especificado' ?></td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm view-participants" 
                                    data-pid="<?= $produccion['id'] ?>">
                                Ver Detalles
                            </button>
                        </td>
                        <td class="actions-column">
                            <div class="btn-group">
                                <?php if ($produccion['documento_path']): ?>
                                    <a href="<?= base_url('produccion/download/' . $produccion['id']) ?>" 
                                       class="btn btn-sm btn-info" title="Descargar Documento">
                                        <i class="fas fa-download"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url('produccion/edit/' . $produccion['id']) ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= base_url('produccion/delete/' . $produccion['id']) ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('¿Está seguro de eliminar esta producción?')"
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

        <!-- Modal para mostrar participantes -->
        <?= $this->include('produccion/participante') ?>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- DataTables -->
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script>

//EL ANCHO DE LAS COLUMNAS DE ESTA TABLA SON DINAMICOS. SE BASA EN LA CELDA QUE TENGA MAS TEXTO EN DICHA COLUMNA.
$(function () {
    // Función para calcular el ancho basado en la longitud del texto
    function calcularAncho(length) {
        if (length <= 10) return 75;
        if (length <= 30) return 120;
        if (length <= 60) return 200;
        return 300;
    }

    // Función para obtener el contenido más largo de una columna
    function obtenerLongitudMaxima(table, columnIndex) {
        let maxLength = 0;
        
        // Revisar encabezado
        const headerText = table.column(columnIndex).header().textContent.trim();
        maxLength = headerText.length;

        // Revisar celdas visibles
        table.column(columnIndex).nodes().each(function(node) {
            const cellText = $(node).text().trim();
            if (cellText.length > maxLength) {
                maxLength = cellText.length;
            }
        });

        return maxLength;
    }

    // Función para aplicar los anchos a una columna
    function aplicarAnchoColumna(table, columnIndex) {
        if (columnIndex === table.columns().nodes().length - 1) return; // Ignorar última columna (acciones)
        
        const maxLength = obtenerLongitudMaxima(table, columnIndex);
        const width = calcularAncho(maxLength);

        // Aplicar el ancho usando columnDefs
        table.column(columnIndex).nodes().each(function(node) {
            $(node).css({
                'min-width': width + 'px',
                'max-width': width + 'px',
                'width': width + 'px',
                'white-space': 'normal',
                'word-wrap': 'break-word'
            });
        });

        // Aplicar también al encabezado
        $(table.column(columnIndex).header()).css({
            'min-width': width + 'px',
            'max-width': width + 'px',
            'width': width + 'px',
            'white-space': 'normal',
            'word-wrap': 'break-word'
        });
    }

    // Inicializar DataTable
    const dataTable = $('.table').DataTable({
        "responsive": false, // Cambiado a false para evitar conflictos
        "scrollX": true,
        "autoWidth": false, // Cambiado a false para control manual
        "order": [],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
        },
        "fixedColumns": {
            rightColumns: 1
        },
        "pageLength": 10,
        "initComplete": function(settings, json) {
            const table = this.api();
            
            // Aplicar anchos iniciales
            for(let i = 0; i < table.columns().nodes().length; i++) {
                aplicarAnchoColumna(table, i);
            }

            // Forzar recálculo de anchos
            setTimeout(function() {
                table.columns.adjust();
            }, 100);
        },
        "drawCallback": function(settings) {
            const table = this.api();
            
            // Reaplicar anchos después de cualquier redibujado
            for(let i = 0; i < table.columns().nodes().length; i++) {
                aplicarAnchoColumna(table, i);
            }

            // Forzar recálculo de anchos
            setTimeout(function() {
                table.columns.adjust();
            }, 100);
        }
    });

    // También ajustar cuando se cambie de página o se filtre
    dataTable.on('page.dt search.dt', function() {
        const table = dataTable;
        setTimeout(function() {
            for(let i = 0; i < table.columns().nodes().length; i++) {
                aplicarAnchoColumna(table, i);
            }
            table.columns.adjust();
        }, 100);
    });
});




</script>
<?= $this->endSection() ?>