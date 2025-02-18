<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Editar Producción Científica y Técnica
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Editar Producción Científica y Técnica
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('produccion') ?>">Producción Científica</a></li>
<li class="breadcrumb-item active">Editar</li>
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
                <a class="nav-link <?= $produccion['tipo'] === 'Artículo' ? 'active' : '' ?>"
                    id="articulo-tab" data-toggle="tab" href="#articulo" role="tab">Artículo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $produccion['tipo'] === 'Capítulo de Libro' ? 'active' : '' ?>"
                    id="capitulo-tab" data-toggle="tab" href="#capitulo" role="tab">Capítulo de Libro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $produccion['tipo'] === 'Libro' ? 'active' : '' ?>"
                    id="libro-tab" data-toggle="tab" href="#libro" role="tab">Libro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $produccion['tipo'] === 'Otro' ? 'active' : '' ?>"
                    id="otro-tab" data-toggle="tab" href="#otro" role="tab">Otro</a>
            </li>
        </ul>

        <!-- Contenido de las pestañas -->
        <div class="tab-content mt-3" id="tipoProduccionContent">
            <!-- Pestaña Artículo -->
            <div class="tab-pane fade <?= $produccion['tipo'] === 'Artículo' ? 'show active' : '' ?>"
                id="articulo" role="tabpanel">
                <?= $this->include('produccion/articulo') ?>
            </div>

            <!-- Pestaña Capítulo de Libro -->
            <div class="tab-pane fade <?= $produccion['tipo'] === 'Capítulo de Libro' ? 'show active' : '' ?>"
                id="capitulo" role="tabpanel">
                <?= $this->include('produccion/capitulo') ?>
            </div>

            <!-- Pestaña Libro -->
            <div class="tab-pane fade <?= $produccion['tipo'] === 'Libro' ? 'show active' : '' ?>"
                id="libro" role="tabpanel">
                <?= $this->include('produccion/libro') ?>
            </div>

            <!-- Pestaña Otro -->
            <div class="tab-pane fade <?= $produccion['tipo'] === 'Otro' ? 'show active' : '' ?>"
                id="otro" role="tabpanel">
                <?= $this->include('produccion/otro') ?>
            </div>
        </div>

        <!-- Modal para agregar participantes -->
        <?= $this->include('produccion/participante') ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>

<script>
    $(function() {
        //=============================================
        // SECCIÓN DE CONFIGURACIÓN INICIAL
        //=============================================
        bsCustomFileInput.init();
        const produccion = <?= json_encode($produccion) ?>;
        const currentTab = '<?= strtolower($produccion['tipo']) ?>';
        let participantesData = <?= json_encode($produccion['participantes']['lista'] ?? []) ?>;

        // Deshabilitar pestañas no correspondientes al tipo de producción
        $('#tipoProduccionTab a').not(`[href="#${currentTab}"]`).addClass('disabled');

        //=============================================
        // SECCIÓN DE FUNCIONES DE CARGA DE DATOS
        //=============================================

        // Función para llenar campos de Artículo
        function llenarCamposArticulo(produccion) {
            $('#tipo_articulo').val(produccion.tipo_articulo);
            $('#base_datos_id').val(produccion.base_datos_id);
            $('#codigo').val(produccion.codigo);
            $('#titulo').val(produccion.titulo);
            $('#codigo_issn').val(produccion.codigo_issn);
            $('#nombre_revista').val(produccion.nombre_revista);
            $('#fecha_publicacion').val(produccion.fecha_publicacion);
            $('#estado').val(produccion.estado);
            $('#filiacion').val(produccion.filiacion);
            $('#campo_amplio_id').val(produccion.campo_amplio_id);
            $('#link_publicacion').val(produccion.link_publicacion);
            $('#link_revista').val(produccion.link_revista);
            $('#intercultural').val(produccion.intercultural);


            if (produccion.campo_amplio_id) {
                $('#campo_amplio_id').trigger('change');
                // Esperar a que se carguen los campos específicos y luego establecer el valor
                setTimeout(() => {
                    $('#campo_especifico_id').val(produccion.campo_especifico_id);
                    $('#campo_especifico_id').trigger('change');
                    // Esperar a que se carguen los campos detallados y luego establecer el valor
                    setTimeout(() => {
                        $('#campo_detallado_id').val(produccion.campo_detallado_id);
                    }, 500);
                }, 500);
            }


            if (produccion.documento_path) {
                const fileName = produccion.documento_path.split('/').pop();
                $('.custom-file-label').text(fileName);
            }
        }

        // Función para llenar campos de Capítulo
        function llenarCamposCapitulo(produccion) {
            $('#codigo_capitulo').val(produccion.codigo);
            $('#titulo_capitulo').val(produccion.titulo);
            $('#titulo_libro').val(produccion.titulo_libro);
            $('#total_capitulos_libro').val(produccion.total_capitulos_libro);
            $('#codigo_capitulo_isbn').val(produccion.codigo_capitulo_isbn);
            $('#editor_copilador').val(produccion.editor_copilador);
            $('#fecha_publicacion_capitulo').val(produccion.fecha_publicacion);
            $('#paginas').val(produccion.paginas);
            $('#campo_amplio_id_capitulo').val(produccion.campo_amplio_id);
            $('#filiacion_capitulo').val(produccion.filiacion);

            if (produccion.documento_path) {
                const fileName = produccion.documento_path.split('/').pop();
                $('#documento_capitulo').next('.custom-file-label').text(fileName);
            }
        }

        // Función para llenar campos de Libro
        function llenarCamposLibro(produccion) {
            $('#codigo_libro').val(produccion.codigo);
            $('#titulo_libro').val(produccion.titulo);
            $('#codigo_libro_isbn').val(produccion.codigo_libro_isbn);
            $('#fecha_publicacion_libro').val(produccion.fecha_publicacion);
            $('#revisado_pares').val(produccion.revisado_pares);
            $('#filiacion_libro').val(produccion.filiacion);
            $('#campo_amplio_id_libro').val(produccion.campo_amplio_id);

            if (produccion.documento_path) {
                const fileName = produccion.documento_path.split('/').pop();
                $('#documento_libro').next('.custom-file-label').text(fileName);
            }
        }

        // Función para llenar campos de Otro
        function llenarCamposOtro(produccion) {
            $('#codigo_otro').val(produccion.codigo);
            $('#titulo_otro').val(produccion.titulo);
            $('#fecha_publicacion_otro').val(produccion.fecha_publicacion);
            $('#tipo_apoyo_ies').val(produccion.tipo_apoyo_ies);
            $('#campo_amplio_id_otro').val(produccion.campo_amplio_id);
            $('#filiacion_otro').val(produccion.filiacion);

            if (produccion.documento_path) {
                const fileName = produccion.documento_path.split('/').pop();
                $('#documento_otro').next('.custom-file-label').text(fileName);
            }
        }

        // Función para llenar campos de participantes
        function llenarCamposParticipantes(produccion) {
            if (produccion.participantes && produccion.participantes.tipo) {
                // Establecer el tipo de participante en el select correspondiente
                const selectId = currentTab === 'artículo' ? 'tipo_participante' :
                    `tipo_participante_${currentTab.replace(' ', '_')}`;
                $(`#${selectId}`).val(produccion.participantes.tipo);

                // Llenar el campo oculto con los datos de los participantes
                $(`#participantes_data_${currentTab.replace(' ', '_')}`).val(
                    JSON.stringify(produccion.participantes.lista || [])
                );

                // Llenar los campos en el modal
                if (produccion.participantes.lista && produccion.participantes.lista.length > 0) {
                    produccion.participantes.lista.forEach((participante, index) => {
                        $(`#nombre_participante_${index}`).val(participante.nombre);
                        $(`#cedula_participante_${index}`).val(participante.cedula);
                    });
                }
            }
        }

        //=============================================
        // SECCIÓN DE CAMPOS DEPENDIENTES
        //=============================================
        // Si hay campos dependientes, disparar sus eventos


        function setupCamposSelect(prefijo = '') {
            const amplioId = $(`#campo_amplio_id${prefijo}`).val();
            const especificoId = $(`#campo_especifico_id${prefijo}`).val();

            if (amplioId) {
                $.get(`<?= base_url('produccion/get-campos-especificos') ?>/${amplioId}`, function(data) {
                    let options = '<option value="">Seleccione un campo específico</option>';
                    data.forEach(function(campo) {
                        const selected = campo.id == especificoId ? 'selected' : '';
                        options += `<option value="${campo.id}" ${selected}>${campo.nombre_especifico}</option>`;
                    });
                    $(`#campo_especifico_id${prefijo}`).html(options);

                    if (especificoId) {
                        $(`#campo_especifico_id${prefijo}`).trigger('change');
                    }
                });
            }

            // Event handler para campo amplio
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

            // Event handler para campo específico
            $(`#campo_especifico_id${prefijo}`).change(function() {
                const especificoId = $(this).val();
                $(`#campo_detallado_id${prefijo}`).html('<option value="">Seleccione un campo detallado</option>');

                if (especificoId) {
                    $.get(`<?= base_url('produccion/get-campos-detallados') ?>/${especificoId}`, function(data) {
                        let options = '<option value="">Seleccione un campo detallado</option>';
                        data.forEach(function(campo) {
                            const selected = campo.id == <?= json_encode($produccion['campo_detallado_id']) ?> ? 'selected' : '';
                            options += `<option value="${campo.id}" ${selected}>${campo.nombre_detallado}</option>`;
                        });
                        $(`#campo_detallado_id${prefijo}`).html(options);
                    });
                }
            });
        }

        // Inicializar selects para cada pestaña
        setupCamposSelect();
        setupCamposSelect('_capitulo');
        setupCamposSelect('_libro');
        setupCamposSelect('_otro');

        // Cargar campos específicos y detallados iniciales
        ['', '_capitulo', '_libro', '_otro'].forEach(prefijo => {
            if ($(`#campo_amplio_id${prefijo}`).val()) {
                $(`#campo_amplio_id${prefijo}`).trigger('change');
            }
        });

        //=============================================
        // SECCIÓN DE CARGA INICIAL DE DATOS
        //=============================================

        // Cargar datos según el tipo de producción
        switch (currentTab) {
            case 'artículo':
                llenarCamposArticulo(produccion);
                break;
            case 'capítulo de libro':
                llenarCamposCapitulo(produccion);
                break;
            case 'libro':
                llenarCamposLibro(produccion);
                break;
            case 'otro':
                llenarCamposOtro(produccion);
                break;
        }

        // Cargar participantes
        llenarCamposParticipantes(produccion);

        //=============================================
        // SECCIÓN DE MANEJO DE PARTICIPANTES
        //=============================================

        // Manejadores para el modal de participantes
        $('#btnAgregarParticipante').click(function() {
            const tipo = $('#tipo_participante').val();
            if (tipo) {
                $('#tipoParticipanteSeleccionado').text(tipo);
                $('.tipo-texto').text(tipo);
                $('#modalParticipantes').modal('show');
            } else {
                alert('Por favor seleccione un tipo de participante');
            }

        });

        


        // Handler para actualizar datos de participantes
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

            // Filtrar participantes válidos
            const participantesValidos = participantesData.filter(p => p && p.nombre && p.cedula);
            
            
            // Actualizar el campo oculto con el formato correcto
            const participantesJson = JSON.stringify(participantesValidos);
            
            // Guardar en el campo oculto
            $(`#participantes_data_${currentTab}`).val(participantesJson);
            $('input[name="participantes_data"]').val(participantesJson);
        });

        // También actualizar cuando se cierra el modal
        $('#modalParticipantes').on('hidden.bs.modal', function () {
            const participantesValidos = participantesData.filter(p => p && p.nombre && p.cedula);
            const participantesJson = JSON.stringify(participantesValidos);
            $(`#participantes_data_${currentTab}`).val(participantesJson);
            $('input[name="participantes_data"]').val(participantesJson);
        });








        //=============================================
        // SECCIÓN DE GUARDADO DE DATOS
        //=============================================

        // Interceptar envío de formularios
        $('form').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);


        
            $.ajax({
                url: `<?= base_url('produccion/update/') ?>/${<?= $produccion['id'] ?>}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        window.location.href = '<?= base_url('produccion') ?>';
                    } else {
                        let errorHtml = '<div class="alert alert-danger"><ul>';
                        errorHtml += `<li>${response.error}</li>`;
                        errorHtml += '</ul></div>';
                        $('.card-body').prepend(errorHtml);
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Error al actualizar la producción';
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            let errorHtml = '<div class="alert alert-danger"><ul>';
                            Object.values(xhr.responseJSON.errors).forEach(error => {
                                errorHtml += `<li>${error}</li>`;
                            });
                            errorHtml += '</ul></div>';
                            $('.card-body').prepend(errorHtml);
                            return;
                        }
                        errorMessage = xhr.responseJSON.error || errorMessage;
                    }
                    $('.card-body').prepend(
                        `<div class="alert alert-danger"><ul><li>${errorMessage}</li></ul></div>`
                    );
                }
            });

        

        });








    });
</script>
<?= $this->endSection() ?>