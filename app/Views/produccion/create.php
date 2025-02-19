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
                <?= $this->include('produccion/articulo') ?>
            </div>

            <!-- Pestaña Capítulo de Libro -->
            <div class="tab-pane fade" id="capitulo" role="tabpanel" aria-labelledby="capitulo-tab">
                <?= $this->include('produccion/capitulo') ?>
            </div>

            <!-- Pestaña Libro -->
            <div class="tab-pane fade" id="libro" role="tabpanel" aria-labelledby="libro-tab">
                <?= $this->include('produccion/libro') ?>
            </div>

            <!-- Pestaña Otro -->
            <div class="tab-pane fade" id="otro" role="tabpanel" aria-labelledby="otro-tab">
                <?= $this->include('produccion/otro') ?>
            </div>
        </div>

        <!-- Modal para agregar participantes -->
        <?= $this->include('produccion/participante') ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Plugin para el manejo de archivos -->
<script src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>

<script>
$(function() {
    // =========================================
    // INICIALIZACIÓN DE PLUGINS Y COMPONENTES
    // =========================================
    bsCustomFileInput.init();

    // =========================================
    // MANEJO DE CAMPOS DEPENDIENTES
    // =========================================
    function setupCamposSelect(prefijo = '_articulo') { // Cambiado el valor por defecto
        $(`#campo_amplio_id${prefijo}`).change(function() {
            const amplioId = $(this).val();
            $(`#campo_especifico_id${prefijo}`).html('<option value="">Seleccione un campo específico</option>');
            $(`#campo_detallado_id${prefijo}`).html('<option value="">Seleccione un campo detallado</option>');

            if (amplioId) {
                $.get(`<?= base_url('produccion/get-campos-especificos') ?>/${amplioId}`, function(data) {
                    let options = '<option value="">Seleccione un campo específico</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_especifico}</option>`;
                    });
                    $(`#campo_especifico_id${prefijo}`).html(options);
                });
            }
        });

        $(`#campo_especifico_id${prefijo}`).change(function() {
            const especificoId = $(this).val();
            $(`#campo_detallado_id${prefijo}`).html('<option value="">Seleccione un campo detallado</option>');

            if (especificoId) {
                $.get(`<?= base_url('produccion/get-campos-detallados') ?>/${especificoId}`, function(data) {
                    let options = '<option value="">Seleccione un campo detallado</option>';
                    data.forEach(function(campo) {
                        options += `<option value="${campo.id}">${campo.nombre_detallado}</option>`;
                    });
                    $(`#campo_detallado_id${prefijo}`).html(options);
                });
            }
        });
    }

    // Inicializar selects para cada pestaña
    setupCamposSelect('_articulo');
    setupCamposSelect('_capitulo');
    setupCamposSelect('_libro');
    setupCamposSelect('_otro');

    // Restaurar valores antiguos si existen
    const oldAmplioId = $('#campo_amplio_id_articulo').val(); // Actualizado el ID
    if (oldAmplioId) {
        $('#campo_amplio_id_articulo').trigger('change');
    }

    // =========================================
    // MANEJO DE PARTICIPANTES
    // =========================================
    let participantesData = [];
    let currentTab = 'articulo';

    // Manejar cambio de pestañas
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        const tabId = $(e.target).attr('id');
        switch (tabId) {
            case 'articulo-tab':
                currentTab = 'articulo';
                break;
            case 'capitulo-tab':
                currentTab = 'capitulo';
                break;
            case 'libro-tab':
                currentTab = 'libro';
                break;
            case 'otro-tab':
                currentTab = 'otro';
                break;
        }
        participantesData = [];
        $('.nombre-participante, .cedula-participante').val('');
    });

    // Handler para guardar datos de participantes
    $('.nombre-participante, .cedula-participante').on('input', function() {
        const index = $(this).data('index');
        const isNombre = $(this).hasClass('nombre-participante');

        if (!participantesData[index]) {
            participantesData[index] = {
                nombre: '',
                cedula: ''
            };
        }

        if (isNombre) {
            participantesData[index].nombre = $(this).val();
        } else {
            participantesData[index].cedula = $(this).val();
        }

        const participantesValidos = participantesData.filter(p => p && p.nombre && p.cedula);
        $(`#participantes_data_${currentTab}`).val(JSON.stringify(participantesValidos));
    });

    // Función auxiliar para abrir el modal de participantes
    function abrirModalParticipantes(selectorTipo) {
        const tipo = $(selectorTipo).val();
        if (tipo) {
            $('#tipoParticipanteSeleccionado').text(tipo);
            $('.tipo-texto').text(tipo);
            $('#modalParticipantes').modal('show');
        } else {
            alert('Por favor seleccione un tipo de participante');
        }
    }

    // Manejadores de botones para agregar participantes
    $('#btnAgregarParticipante_articulo').click(function() {
        currentTab = 'articulo';
        abrirModalParticipantes('#tipo_participante_articulo');
    });

    $('#btnAgregarParticipante_capitulo').click(function() {
        currentTab = 'capitulo';
        abrirModalParticipantes('#tipo_participante_capitulo');
    });

    $('#btnAgregarParticipante_libro').click(function() {
        currentTab = 'libro';
        abrirModalParticipantes('#tipo_participante_libro');
    });

    $('#btnAgregarParticipante_otro').click(function() {
        currentTab = 'otro';
        abrirModalParticipantes('#tipo_participante_otro');
    });
});
</script>
<?= $this->endSection() ?>