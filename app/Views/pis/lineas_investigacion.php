<!-- Modal para administrar líneas de investigación -->
<div class="modal fade" id="modalLineasInvestigacion" tabindex="-1" role="dialog" aria-labelledby="modalLineasInvestigacionLabel" aria-hidden="true">
    <!-- Estilos CSS que para manejar mejor el z-index de los modales -->
    <style>
    .modal-backdrop + .modal-backdrop {
        opacity: 0.15;
    }
    #modalEditarLinea {
        z-index: 1060;
    }
    </style>




    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLineasInvestigacionLabel">Administrar Líneas de Investigación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Mensajes de error y éxito -->
                <div id="modalMessages">
                    <div class="alert alert-danger" id="modalErrorAlert" style="display: none;">
                        <ul id="modalErrorList"></ul>
                    </div>
                    <div class="alert alert-success" id="modalSuccessAlert" style="display: none;">
                        <span id="modalSuccessMessage"></span>
                    </div>
                </div>

                <!-- Formulario para agregar/editar línea -->
                <form id="formNuevaLinea" class="mb-4">
                    <input type="hidden" id="linea_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre_linea">Nombre de la Línea *</label>
                                <input type="text" class="form-control" id="nombre_linea" name="nombre_linea" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="carrera_id">Área *</label>
                                <select class="form-control" id="carrera_id" name="carrera_id" required>
                                    <option value="">Seleccionar un área</option>
                                    <?php foreach ($careers as $career): ?>
                                        <option value="<?= $career['id'] ?>"><?= $career['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block" form="formNuevaLinea">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Botón fuera del formulario pero vinculado mediante el atributo form -->
                <!-- <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block" form="formNuevaLinea">Guardar</button>
                    </div>
                </div> -->




                <!-- Tabla de líneas de investigación -->
                <div class="table-responsive">
                    <table id="tablasLineasInvestigacion" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Área</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyLineasInvestigacion">
                            <!-- Los datos se cargarán dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal para editar línea de investigación -->
<div class="modal fade" id="modalEditarLinea" tabindex="-1" role="dialog" aria-labelledby="modalEditarLineaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLineaLabel">Editar Línea de Investigación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Mensajes de error y éxito para el modal de edición -->
                <div id="modalEditMessages">
                    <div class="alert alert-danger" id="modalEditErrorAlert" style="display: none;">
                        <ul id="modalEditErrorList"></ul>
                    </div>
                    <div class="alert alert-success" id="modalEditSuccessAlert" style="display: none;">
                        <span id="modalEditSuccessMessage"></span>
                    </div>
                </div>

                <!-- Formulario de edición -->
                <form id="formEditarLinea">
                    <input type="hidden" id="edit_linea_id">
                    <div class="form-group">
                        <label for="edit_nombre_linea">Nombre de la Línea *</label>
                        <input type="text" class="form-control" id="edit_nombre_linea" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_carrera_id">Área *</label>
                        <select class="form-control" id="edit_carrera_id" required>
                            <option value="">Seleccionar un área</option>
                            <?php foreach ($careers as $career): ?>
                                <option value="<?= $career['id'] ?>"><?= $career['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>