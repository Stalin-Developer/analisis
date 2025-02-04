<!-- Modal para gestionar docentes -->
<div class="modal fade" id="modalParticipantes" tabindex="-1" role="dialog" aria-labelledby="modalParticipantesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-gray-light">
            <div class="modal-header bg-gradient-primary">
                <h4 class="modal-title w-100 text-center font-weight-bold" id="modalParticipantesLabel">Tipo: <span id="tipoParticipanteSeleccionado"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <!-- Formulario para agregar docentes -->
                <form id="formParticipantes">
                    <?php for($i = 0; $i < 10; $i++): ?>
                        <div class="row mb-3 p-2">
                            <!-- Encabezado del docente -->
                            <div class="col-12" style="background-color:rgb(114, 187, 237);">
                                <h5 class="font-weight-bold text-center">Docente <?= $i + 1 ?></h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="nombre_docente_<?= $i ?>">Nombres Completos:</label>
                                    <input type="text" class="form-control nombre-docente" 
                                           id="nombre_docente_<?= $i ?>" 
                                           name="docentes[<?= $i ?>][nombre]" 
                                           data-index="<?= $i ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="cedula_docente_<?= $i ?>">Cédula:</label>
                                    <input type="number" class="form-control cedula-docente" 
                                           id="cedula_docente_<?= $i ?>" 
                                           name="docentes[<?= $i ?>][cedula]"
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

<!-- Modal para gestionar estudiantes -->
<div class="modal fade" id="modalEstudiantes" tabindex="-1" role="dialog" aria-labelledby="modalEstudiantesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-gray-light">
            <div class="modal-header bg-gradient-primary">
                <h4 class="modal-title w-100 text-center font-weight-bold" id="modalEstudiantesLabel">Tipo: <span id="tipoParticipanteSeleccionado2"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <!-- Formulario para agregar estudiantes -->
                <form id="formEstudiantes">
                    <?php for($i = 0; $i < 30; $i++): ?>
                        <div class="row mb-3 p-2">
                            <!-- Encabezado del estudiante -->
                            <div class="col-12" style="background-color:rgb(114, 187, 237);">
                                <h5 class="font-weight-bold text-center">Estudiante <?= $i + 1 ?></h5>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="nombre_estudiante_<?= $i ?>">Nombres Completos:</label>
                                    <input type="text" class="form-control nombre-estudiante" 
                                           id="nombre_estudiante_<?= $i ?>" 
                                           name="estudiantes[<?= $i ?>][nombre]" 
                                           data-index="<?= $i ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="cedula_estudiante_<?= $i ?>">Cédula:</label>
                                    <input type="number" class="form-control cedula-estudiante" 
                                           id="cedula_estudiante_<?= $i ?>" 
                                           name="estudiantes[<?= $i ?>][cedula]"
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

<!-- Campos ocultos para almacenar los datos -->
<input type="hidden" id="docentes_data" name="docentes_data" value="">
<input type="hidden" id="estudiantes_data" name="estudiantes_data" value="">