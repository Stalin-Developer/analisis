<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Nuevo Trabajo de Titulación
<?= $this->endSection() ?>

<?= $this->section('page_title') ?>
Nuevo Trabajo de Titulación
<?= $this->endSection() ?>

<?= $this->section('breadcrumb') ?>
<li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
<li class="breadcrumb-item"><a href="<?= base_url('trabajos-titulacion') ?>">Trabajos de Titulación</a></li>
<li class="breadcrumb-item active">Nuevo</li>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
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

        <form action="<?= base_url('trabajos-titulacion/create') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="documento_path">Documento PDF</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="documento_path" name="documento_path" 
                           accept=".pdf" onchange="handlePDFUpload(this)" required>
                    <label class="custom-file-label" for="documento_path">Seleccionar archivo</label>
                </div>
            </div>

            <!--He creado lo del poster en tdt, pero estos van en pis. Nos los elimino porque me pueden servir para el pis.-->
            <!-- <div class="form-group">
                <label for="poster_path">Póster (PDF)</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="poster_path" name="poster_path" 
                           accept=".pdf">
                    <label class="custom-file-label" for="poster_path">Seleccionar archivo</label>
                </div>
            </div> -->

            
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" 
                       value="<?= old('titulo') ?>" required>
            </div>

            <div class="form-group">
                <label for="linea_investigacion">Línea de Investigación</label>
                <input type="text" class="form-control" id="linea_investigacion" name="linea_investigacion" 
                       value="<?= old('linea_investigacion') ?>">
            </div>

            <div class="form-group">
                <label for="autores">Autor/es</label>
                <input type="text" class="form-control" id="autores" name="autores" 
                       value="<?= old('autores') ?>" required>
                <small class="form-text text-muted">Separe los autores con comas</small>
            </div>

            <div class="form-group">
                <label for="career_id">Carrera</label>
                <select class="form-control" id="career_id" name="career_id" required>
                    <option value="">Seleccione una carrera</option>
                    <?php foreach ($careers as $career): ?>
                        <option value="<?= $career['id'] ?>" <?= old('career_id') == $career['id'] ? 'selected' : '' ?>>
                            <?= $career['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="year">Año</label>
                        <input type="number" 
                            class="form-control" 
                            id="year" 
                            name="year" 
                            min="1000" 
                            max="9999" 
                            step="1" 
                            value="<?= old('year', date('Y')) ?>"
                            placeholder="YYYY" 
                            required>
                        <small class="form-text text-muted">Ingrese un año de 4 dígitos (ejemplo: 2024)</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mes_id">Mes</label>
                        <select class="form-control" id="mes_id" name="mes_id" required>
                            <option value="">Seleccione un mes</option>
                            <?php foreach ($meses as $mes): ?>
                                <option value="<?= $mes['id'] ?>" <?= old('mes_id') == $mes['id'] ? 'selected' : '' ?>>
                                    <?= $mes['mes'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="academic_period_id">Periodo Académico</label>
                        <select class="form-control" id="academic_period_id" name="academic_period_id" required>
                            <option value="">Seleccione un periodo</option>
                            <?php foreach ($academic_periods as $period): ?>
                                <option value="<?= $period['id'] ?>" <?= old('academic_period_id') == $period['id'] ? 'selected' : '' ?>>
                                    <?= $period['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="resumen">Resumen</label>
                <textarea class="form-control" id="resumen" name="resumen" style="resize: none;" rows="3"><?= old('resumen') ?></textarea>
            </div>

            

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?= base_url('trabajos-titulacion') ?>" class="btn btn-secondary">Cancelar</a>
        </form>





        <!-- Agregar el modal -->
        <div class="modal fade" id="analyzeModal" data-backdrop="static" data-keyboard="false" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="spinner-border text-primary mb-3" role="status">
                            <span class="sr-only">Analizando...</span>
                        </div>
                        <h5>Analizando documento, por favor espere...</h5>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal para mostrar el texto extraído -->
        <div class="modal fade" id="textModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Texto Extraído</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"  style="max-height: 400px; overflow-y: auto;">
                        <pre id="extractedText" style="white-space: pre-wrap;"></pre>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
















    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>


    <script>
        function handlePDFUpload(input) {
            if (input.files && input.files[0]) {
                // Mostrar modal de análisis
                $('#analyzeModal').modal('show');

                // Crear FormData y agregar el archivo
                const formData = new FormData();
                formData.append('pdf_file', input.files[0]);

                // Enviar archivo al servidor
                $.ajax({
                    url: '<?= base_url('trabajos-titulacion/extract-text') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Ocultar modal de análisis
                        $('#analyzeModal').modal('hide');
                        
                        //Si hubo exito al llamar al modelo.
                        if (response.success) {
                            if (response.prompts_responses) {
                                // Procesar las respuestas
                                const respuestas = procesarRespuestas(response.prompts_responses);
                                
                                // Crear contenido para mostrar en el modal
                                let content = "Información extraída:\n\n";
                                content += `Título1: ${respuestas.titulo}\n\n`;
                                content += `Autores2: ${respuestas.autores}\n\n`;
                                content += `Carrera3: ${respuestas.carrera}`;

                                // $('#extractedText').text(content);
                                // $('#textModal').modal('show');

                            } else {
                                $('#extractedText').text('No se pudo procesar el texto');
                                $('#textModal').modal('show');
                            }


                            //Vamos a utilizar el texto extraido.
                            if(response.text){
                                let contenido = response.text; //Texto de la primera pagina.

                                const linea_investigacion = buscarLineaInvestigacion(contenido);
                                const anio = buscarAnio(contenido);
                                const mes = buscarMes(contenido);

                                contenido += `\n\nLínea de investigacion4: ${linea_investigacion}`;
                                contenido += `\n\nAño5: ${anio}`;
                                contenido += `\n\nMes6: ${mes}`;

                                $('#extractedText').text(contenido);
                                $('#textModal').modal('show');

                                console.log("El código dentro de response.text se ejecuta.");
                            }
                            
                        } else {
                            alert('Error al extraer texto: ' + response.error);
                        }
                    },
                    error: function() {
                        $('#analyzeModal').modal('hide');
                        alert('Error al procesar el archivo');
                    }
                });
            }
        }







        // Función para procesar cada tipo de respuesta
        function procesarRespuestas(responses) {
            const respuestas = {
                titulo: 'No extraído',
                autores: 'No extraído',
                carrera: 'No extraído'
            };

            // Procesar respuesta del título
            if (responses[0]?.success && responses[0]?.data) { //Se valida la respuesta del primer mensaje.
                const tituloExtraido = (responses[0].data[0].generated_text).match(/\(el título solicitado\).*?Título_Solicitado:\s*(.+)$/s);

                if (tituloExtraido && tituloExtraido[1]) { //El if valida que el tituloExtraido no sea null y que no este vacio.
                    // Limpiar el título de espacios extra
                    respuestas.titulo = tituloExtraido[1].trim();
                    
                    // Insertar en el campo del formulario
                    $('#titulo').val(respuestas.titulo);
                }


                //respuestas.titulo = responses[0].data[0].generated_text; //Aqui le modifica al titulo, ya dejaria de decir no extraido.
                //console.log('Respuesta título:', respuestas.titulo);
            }

            
            // Procesar respuesta de autores
            if (responses[1]?.success && responses[1]?.data) {
                const autoresExtraidos = (responses[1].data[0].generated_text).match(/no incluir el asesor\).*?Autor_Solicitado:\s*(.+)$/s);

                if (autoresExtraidos && autoresExtraidos[1]) {
                    respuestas.autores = autoresExtraidos[1].trim();
                    $('#autores').val(respuestas.autores);
                }


                // respuestas.autores = responses[1].data[0].generated_text;
                // console.log('Respuesta autores:', respuestas.autores);
            }
            
            // Procesar respuesta de carrera
            if (responses[2]?.success && responses[2]?.data) {
                const numeroCarrera = (responses[2].data[0].generated_text).match(/número de la lista\)\s*([1-7])/);
                if (numeroCarrera && numeroCarrera[1]) {
                    respuestas.carrera = numeroCarrera[1].trim();
                    // Seleccionar la carrera en el select
                    $('#career_id').val(respuestas.carrera);
                }

                // respuestas.carrera = responses[2].data[0].generated_text;
                // console.log('Respuesta carrera:', respuestas.carrera);
            }

            return respuestas;
        }








        // Función para extraer el título y actualizar el formulario
        function buscarLineaInvestigacion(texto) {
            // Extraer línea de investigación
            const lineaMatch = texto.match(/[Ll]ínea\s+de\s+[Ii]nvestigación:\s*(.*?)(?=\n|$)/);
            let linea = '';
            if (lineaMatch && lineaMatch[1]) {
                linea = lineaMatch[1].trim();
                $('#linea_investigacion').val(linea);
            } else{
                linea= "No encontrado";
                $('#linea_investigacion').val(linea);
            }

            return linea;
        }




        // Función para extraer el anio y actualizar el formulario
        function buscarAnio(texto) {
            // Expresión regular para encontrar el año en formato YYYY en la última línea
            const anioMatch = texto.match(/\b(20\d{2})\s*$/);
            let anio = '';
            if (anioMatch && anioMatch[1]) {
                anio = anioMatch[1].trim();
                $('#year').val(anio);
            } else{
                anio= "No encontrado";
            }

            return anio;
        }





        // Función para extraer el anio y actualizar el formulario
        function buscarMes(texto) {
            // Expresión regular para encontrar el mes en la última línea
            const mesMatch = texto.match(/\b([Ee]nero|[Ff]ebrero|[Mm]arzo|[Aa]bril|[Mm]ayo|[Jj]unio|[Jj]ulio|[Aa]gosto|[Ss]eptiembre|[Oo]ctubre|[Nn]oviembre|[Dd]iciembre)\b/);
            let mes = '';
            if (mesMatch && mesMatch[1]) {
                // Convertir primera letra a mayúscula y el resto a minúscula
                mes = mesMatch[1].charAt(0).toUpperCase() + mesMatch[1].slice(1).toLowerCase();
                
                // Obtener el id del mes y seleccionarlo en el select
                const mesSelect = document.getElementById('mes_id');
                Array.from(mesSelect.options).forEach(option => {
                    if (option.text === mes) {
                        mesSelect.value = option.value;

                        // Determinar el periodo académico
                        const periodoSelect = document.getElementById('academic_period_id');
                        const idMes = parseInt(option.value); // Convertir value (o id) a número
                        
                        if (idMes >= 4 && idMes <= 9) {
                            periodoSelect.value = 1; // Primer periodo académico
                        } else {
                            periodoSelect.value = 2; // Segundo periodo académico
                        }
                    }
                });
            } else{
                mes= "No encontrado";
            }

            return mes;
        }










    </script>









<script src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
<script>
$(function () {
    bsCustomFileInput.init();
});
</script>
<?= $this->endSection() ?>