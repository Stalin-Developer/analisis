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
                       value="<?= old('linea_investigacion') ?>" required>
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
                            if (response.analysis) {

                                rellenarCampos(response.analysis, response.resume, response.idCarrera);

                                let content = `${response.analysis}\n\n`;
                                content += `${response.resume}\n\n`;

                                $('#extractedText').text(content);
                                //$('#textModal').modal('show');

                            } else {
                                $('#extractedText').text('No se pudo procesar el texto');
                                $('#textModal').modal('show');
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




        //Rellenamos los campos.
        function rellenarCampos(analysis, resume, idCarrera){
            //Rellenamos el titulo.
            // Expresión regular para el título que maneja ambos formatos
            const tituloPattern = /[Tt]ítulo[*:\s]+(.*?)(?=\n|$)/;

            // Intentar extraer el título
            const tituloMatch = analysis.match(tituloPattern);
            if (tituloMatch) { //Si se encontro el titulo.
                const titulo = tituloMatch[1].trim();
                $('#titulo').val(titulo);
            }



            // Extracción de la línea de investigación
            const lineaPattern = /[Ll]ínea\s+de\s+[Ii]nvestigación[*:\s]+(.*?)(?=\n|$)/;
            const lineaMatch = analysis.match(lineaPattern);
            if (lineaMatch) {
                const linea = lineaMatch[1].trim();

                // Verificar si la línea empieza con "No"
                if (!linea.startsWith('No')) {
                    $('#linea_investigacion').val(linea);
                }
            } 




            // Extracción de autores
            const autoresPattern = /[Aa]utor(?:es)?(?:\so\sautores)?[*:\s]+(.*?)(?=\n|$)/;
            const autoresMatch = analysis.match(autoresPattern);
            if (autoresMatch) {
                let autores = autoresMatch[1].trim();
                
                // Convertir separación con "y" a coma
                autores = autores.replace(/\sy\s/g, ', ');
                
                // Dividir por comas para analizar cada autor
                let listaAutores = autores.split(',').map(autor => autor.trim());
                
                // Filtrar autores que parezcan ser asesores (que empiecen con títulos académicos)
                listaAutores = listaAutores.filter(autor => {
                    return !autor.match(/^(Msc\.|PhD\.|Ing\.)/i);
                });
                
                // Volver a unir los autores con comas
                const autoresFinales = listaAutores.join(', ');
                
                console.log('Autores encontrados:', autoresFinales);
                $('#autores').val(autoresFinales);
            }





            //Seleccionamos la carrera.
            if(idCarrera != 0){ //Cero es cuando la carrera que nos envia el modelo no coincide con ninguna carrera de la base de datos.
                // Seleccionar la carrera en el select
                $('#career_id').val(idCarrera);
            }





            //Extraccion del anio.
            const anioPattern = /[Aa]ño\s+de\s+[Pp]ublicación[*:\s]+(\d{4})\.?/;
            const anioMatch = analysis.match(anioPattern);

            if (anioMatch) {
                const anio = anioMatch[1]; // Esto dará solo los 4 dígitos del año
                $('#year').val(anio);
            }




            //Extraccion del mes de publicacion.
            // Variable para almacenar la opción encontrada (declarada fuera del if)
            let opcionEncontrada = null;

            const mesPattern = /[Mm]es\s+de\s+[Pp]ublicación[*:\s]+(\w+)/;
            const mesMatch = analysis.match(mesPattern);
            if (mesMatch) {
                const mesExtraido = mesMatch[1].trim(); // Captura solo la primera palabra
                
                // Obtener todas las opciones del select, excluyendo la primera (Seleccione un mes)
                const opciones = Array.from($('#mes_id option')).slice(1);
                
                // Convertir el mes extraído a formato título (primera letra mayúscula, resto minúsculas)
                const mesFormateado = mesExtraido.charAt(0).toUpperCase() + mesExtraido.slice(1).toLowerCase();
                
                // Buscar coincidencia en las opciones
                opcionEncontrada = opciones.find(opcion => 
                    opcion.text.trim() === mesFormateado
                );
                
                // Si se encuentra una coincidencia, seleccionar ese mes
                if (opcionEncontrada) {
                    $('#mes_id').val(opcionEncontrada.value);
                }
            }





                      
            // Determinar el periodo académico basado en el mes seleccionado
            if (opcionEncontrada) {
                const mesId = parseInt(opcionEncontrada.value);
                
                // Arrays con los IDs de los meses para cada periodo
                const primerPeriodo = [4, 5, 6, 7, 8, 9]; // abril a septiembre
                const segundoPeriodo = [10, 11, 12, 1, 2, 3]; // octubre a marzo
                
                if (primerPeriodo.includes(mesId)) {
                    $('#academic_period_id').val(1); // ID del primer periodo
                } else if (segundoPeriodo.includes(mesId)) {
                    $('#academic_period_id').val(2); // ID del segundo periodo
                }
            }






            //Insertar el resumen.
            $('#resumen').val(resume);







        }


        







    </script>









<script src="<?= base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
<script>
$(function () {
    bsCustomFileInput.init();
});
</script>
<?= $this->endSection() ?>