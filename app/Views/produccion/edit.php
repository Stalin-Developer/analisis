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
            $('#tipo_articulo_articulo').val(produccion.tipo_articulo);
            $('#base_datos_id_articulo').val(produccion.base_datos_id);
            $('#codigo_articulo').val(produccion.codigo);
            $('#titulo_articulo').val(produccion.titulo);
            $('#codigo_issn_articulo').val(produccion.codigo_issn);
            $('#nombre_revista_articulo').val(produccion.nombre_revista);
            $('#fecha_publicacion_articulo').val(produccion.fecha_publicacion);
            $('#estado_articulo').val(produccion.estado);
            $('#filiacion_articulo').val(produccion.filiacion);
            $('#campo_amplio_id_articulo').val(produccion.campo_amplio_id);
            $('#link_publicacion_articulo').val(produccion.link_publicacion);
            $('#link_revista_articulo').val(produccion.link_revista);
            $('#intercultural_articulo').val(produccion.intercultural);

            if (produccion.documento_path) {
                const fileName = produccion.documento_path.split('/').pop();
                $('#documento_articulo').next('.custom-file-label').text(fileName);
            }
        }

        // Función para llenar campos de Capítulo
        function llenarCamposCapitulo(produccion) {
            $('#codigo_capitulo').val(produccion.codigo);
            $('#titulo_capitulo').val(produccion.titulo);
            $('#titulo_libro_capitulo').val(produccion.titulo_libro);
            $('#total_capitulos_libro_capitulo').val(produccion.total_capitulos_libro);
            $('#codigo_isbn_capitulo').val(produccion.codigo_capitulo_isbn);
            $('#editor_copilador_capitulo').val(produccion.editor_copilador);
            $('#fecha_publicacion_capitulo').val(produccion.fecha_publicacion);
            $('#paginas_capitulo').val(produccion.paginas);
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
            $('#codigo_isbn_libro').val(produccion.codigo_libro_isbn);
            $('#fecha_publicacion_libro').val(produccion.fecha_publicacion);
            $('#revisado_pares_libro').val(produccion.revisado_pares);
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
            $('#tipo_apoyo_ies_otro').val(produccion.tipo_apoyo_ies);
            $('#campo_amplio_id_otro').val(produccion.campo_amplio_id);
            $('#filiacion_otro').val(produccion.filiacion);

            if (produccion.documento_path) {
                const fileName = produccion.documento_path.split('/').pop();
                $('#documento_otro').next('.custom-file-label').text(fileName);
            }
        }

        

        //=============================================
        // SECCIÓN DE CAMPOS DEPENDIENTES
        //=============================================
        // Si hay campos dependientes, disparar sus eventos
        function llenarCamposDependientes(currentTab) {
            // Obtener el prefijo según la pestaña actual
            const prefijo = `_${currentTab.replace(' ', '_')}`;

            // Obtener los valores guardados
            const amplioId = produccion.campo_amplio_id;
            const especificoId = produccion.campo_especifico_id;
            const detalladoId = produccion.campo_detallado_id;

            // Si hay un campo amplio seleccionado
            if (amplioId) {
                // Cargar campos específicos
                $.get(`<?= base_url('produccion/get-campos-especificos') ?>/${amplioId}`, function(data) {
                    let options = '<option value="">Seleccione un campo específico</option>';
                    data.forEach(function(campo) {
                        const selected = campo.id == especificoId ? 'selected' : '';
                        options += `<option value="${campo.id}" ${selected}>${campo.nombre_especifico}</option>`;
                    });
                    $(`#campo_amplio_id${prefijo}`).val(amplioId);
                    $(`#campo_especifico_id${prefijo}`).html(options);

                    // Si hay un campo específico seleccionado
                    if (especificoId) {
                        // Cargar campos detallados
                        $.get(`<?= base_url('produccion/get-campos-detallados') ?>/${especificoId}`, function(data) {
                            let options = '<option value="">Seleccione un campo detallado</option>';
                            data.forEach(function(campo) {
                                const selected = campo.id == detalladoId ? 'selected' : '';
                                options += `<option value="${campo.id}" ${selected}>${campo.nombre_detallado}</option>`;
                            });
                            $(`#campo_detallado_id${prefijo}`).html(options);
                        });
                    }
                });
            }

            // Activar los listeners para cambios futuros
            setupCamposSelect(prefijo);
        }

        // Función para configurar los listeners de los campos dependientes
        function setupCamposSelect(prefijo) {
            // Listener para campo amplio
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

            // Listener para campo específico
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



        //=============================================
        // SECCIÓN DE CARGA INICIAL DE DATOS
        //=============================================
        // Cargar datos según el tipo de producción
        switch (currentTab) {
            case 'artículo':
                llenarCamposArticulo(produccion);
                llenarCamposDependientes('articulo');
                break;
            case 'capítulo de libro':
                llenarCamposCapitulo(produccion);
                llenarCamposDependientes('capitulo');
                break;
            case 'libro':
                llenarCamposLibro(produccion);
                llenarCamposDependientes('libro');
                break;
            case 'otro':
                llenarCamposOtro(produccion);
                llenarCamposDependientes('otro');
                break;
        }


        

        //=============================================
        // SECCIÓN DE MANEJO DE PARTICIPANTES
        //=============================================
        llenarCamposParticipantes(produccion);

        // Función para llenar campos de participantes
        function llenarCamposParticipantes(produccion) {
            if (produccion.participantes && produccion.participantes.tipo) {
                // Limpiar y normalizar el currentTab para el ID del selector
                const tabId = currentTab.replace('capítulo de libro', 'capitulo')
                                    .replace('artículo', 'articulo')
                                    .replace(' ', '_');
                
                // Establecer el tipo de participante en el select correspondiente
                const selectId = `tipo_participante_${tabId}`;
                
                
                $(`#${selectId}`).val(produccion.participantes.tipo);

                // Guardar datos en el campo oculto
                $(`#participantes_data_${tabId}`).val(
                    JSON.stringify(produccion.participantes.lista || [])
                );

                // Llenar campos del modal
                if (produccion.participantes.lista && produccion.participantes.lista.length > 0) {
                    participantesData = produccion.participantes.lista; // Actualizar variable global
                    
                    produccion.participantes.lista.forEach((participante, index) => {
                        $(`#nombre_participante_${index}`).val(participante.nombre);
                        $(`#cedula_participante_${index}`).val(participante.cedula);
                    });
                }
            }
        }

        // Manejadores para el modal de participantes
        $('[id^=btnAgregarParticipante_]').click(function() {
            const tabId = currentTab.replace('capítulo de libro', 'capitulo')
                                .replace('artículo', 'articulo')
                                .replace(' ', '_');
            const tipo = $(`#tipo_participante_${tabId}`).val();
            
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

            actualizarCamposOcultos();
        });

        // Función para actualizar campos ocultos
        function actualizarCamposOcultos() {
            const participantesValidos = participantesData.filter(p => p && p.nombre && p.cedula);
            const participantesJson = JSON.stringify(participantesValidos);
            
            const tabId = currentTab.replace('capítulo de libro', 'capitulo')
                                .replace('artículo', 'articulo')
                                .replace(' ', '_');
            
            $(`#participantes_data_${tabId}`).val(participantesJson);
            $('input[name="participantes_data"]').val(participantesJson);
        }

        // Actualizar cuando se cierra el modal
        $('#modalParticipantes').on('hidden.bs.modal', function() {
            actualizarCamposOcultos();
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