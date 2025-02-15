<!-- Modal para gestionar participantes -->
<div class="modal fade" id="modalParticipantes" tabindex="-1" role="dialog" aria-labelledby="modalParticipantesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-gray-light">
            <div class="modal-header bg-gradient-primary">
                <h4 class="modal-title w-100 text-center font-weight-bold" id="modalParticipantesLabel">
                    <span id="tipoParticipanteSeleccionado"></span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <!-- Formulario para agregar participantes -->
                <form id="formParticipantes">
                    <?php for($i = 0; $i < 5; $i++): ?>
                        <div class="row mb-3 p-2">
                            <!-- Encabezado del participante -->
                            <div class="col-12" style="background-color:rgb(114, 187, 237);">
                                <h5 class="font-weight-bold text-center">
                                    <span class="tipo-texto">Participante</span> <?= $i + 1 ?>
                                </h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="nombre_participante_<?= $i ?>">Nombres Completos:</label>
                                    <input type="text" class="form-control nombre-participante" 
                                           id="nombre_participante_<?= $i ?>" 
                                           name="participantes[<?= $i ?>][nombre]" 
                                           data-index="<?= $i ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="cedula_participante_<?= $i ?>">Cédula:</label>
                                    <input type="number" class="form-control cedula-participante" 
                                           id="cedula_participante_<?= $i ?>" 
                                           name="participantes[<?= $i ?>][cedula]"
                                           maxlength="10" 
                                           pattern="[0-9]{10}" 
                                           title="La cédula debe tener 10 dígitos"
                                           data-index="<?= $i ?>">
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Campo oculto para almacenar los datos -->
<input type="hidden" id="participantes_data" name="participantes_data" value="">

<script>
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