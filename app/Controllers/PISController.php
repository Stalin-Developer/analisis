<?php

namespace App\Controllers;
use Exception;
use PhpParser\Node\Stmt\TryCatch;

class PISController extends BaseController
{
    protected $pisModel;

    public function __construct()
    {
        $this->pisModel = new \App\Models\PISModelo();
    }




    public function index()
    {
        try {
            // Obtener parámetros de filtrado
            $tipo = $this->request->getGet('tipo');
            $estado = $this->request->getGet('estado');
            $anio = $this->request->getGet('anio');

            
            
            // Construir la consulta base
            $builder = $this->pisModel->db->table('proyectos_integradores_saberes')
            ->select('proyectos_integradores_saberes.*, 
                programas.nombre_programa as nombre_programa,
                lineas_investigacion_carreras.nombre_linea as nombre_linea,
                campo_amplio.nombre_amplio as nombre_amplio,
                campo_especifico.nombre_especifico as nombre_especifico,
                campo_detallado.nombre_detallado as nombre_detallado,
                produccion_cientifica_tecnica.nombre as nombre_publicacion');




            $builder->join('programas', 
                'programas.id = proyectos_integradores_saberes.programa_id', 'left');
            $builder->join('lineas_investigacion_carreras', 
                'lineas_investigacion_carreras.id = proyectos_integradores_saberes.linea_investigacion_carrera_id', 'left');
            $builder->join('campo_amplio', 
                'campo_amplio.id = proyectos_integradores_saberes.campo_amplio_id', 'left');
            $builder->join('campo_especifico', 
                'campo_especifico.id = proyectos_integradores_saberes.campo_especifico_id', 'left');
            $builder->join('campo_detallado', 
                'campo_detallado.id = proyectos_integradores_saberes.campo_detallado_id', 'left');
            $builder->join('produccion_cientifica_tecnica', 
                'produccion_cientifica_tecnica.id = proyectos_integradores_saberes.publicaciones_id', 'left');

            
            



            // Aplicar filtros si existen
            if ($tipo) {
                $builder->where('proyectos_integradores_saberes.tipo', $tipo);
            }
            if ($estado) {
                $builder->where('proyectos_integradores_saberes.estado', $estado);
            }
            if ($anio) {
                $builder->where('proyectos_integradores_saberes.anio', $anio);
            }


            // Ordenar por fecha de creación descendente (más reciente primero)
            $builder->orderBy('proyectos_integradores_saberes.created_at', 'DESC');
            
            // Limitar a 100 registros
            $builder->limit(100);



            // Ejecutar la consulta
            $proyectos = $builder->get()->getResultArray();






            // Obtener años únicos para el filtro
            $years = $this->pisModel->select('anio')
                        ->groupBy('anio')
                        ->orderBy('anio', 'DESC')
                        ->findAll();


            // Obtener enums de la base de datos
            $enums = $this->pisModel->getAllEnums();




            $data = [
                'proyectos' => $proyectos,
                'tipos' => $enums['tipo'],
                'estados' => $enums['estado'],
                'years' => array_unique(array_column($years, 'anio')),
                'selected_tipo' => $tipo,
                'selected_estado' => $estado,
                'selected_anio' => $anio
            ];
            
            return view('pis/index', $data);



        } catch (Exception $e) {
            return view('pis/index', ['error' => 'Error al cargar los proyectos']);
        }
    }



    public function new()
    {
        try {
            // Obtener los enums directamente de la base de datos
            $enumData = [];
            $enumFields = [
                'tipo', 'estado', 'alcance_territorial', 
                'investigadores_acreditados', 'fuente_financiamiento',
                'parametro_cumplimiento', 'cooperacion', 'red',
                'resultados_verificables', 'tipo_participante'
            ];

            foreach ($enumFields as $field) {
                $enumData[$field] = $this->pisModel->getEnumValues($field);
            }

            $data = [
                'programas' => $this->pisModel->getProgramas(),
                'lineas_investigacion' => $this->pisModel->getLineasInvestigacion(),
                'campos_amplios' => $this->pisModel->getCamposAmplios(),
                'publicaciones' => $this->pisModel->getProduccionesCientificas(),
                'enumData' => $enumData,
                'careers' => $this->pisModel->getCareers() //Agregamos esta linea porque necesitamos la variable careers para poder hacer el crud de las lineas de investigacion.
            ];

            return view('pis/create', $data);
        } catch (Exception $e) {
            return view('pis/create', [
                'error' => 'Error al cargar los datos del formulario'
            ]);
        }
    }



    public function create()
    {
        try {

            // Validar datos del formulario
            if (!$this->validate($this->pisModel->validationRules, $this->pisModel->validationMessages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }


            // Procesar el archivo del proyecto si existe
            $proyecto = $this->request->getFile('proyecto');
            $proyectoPath = null;

            if ($proyecto && $proyecto->isValid() && !$proyecto->hasMoved()) {
                $newNameProyecto = $proyecto->getRandomName();
                if ($proyecto->move(ROOTPATH . 'public/uploads/proyectos_integradores_saberes/proyectos', $newNameProyecto)) {
                    $proyectoPath = 'uploads/proyectos_integradores_saberes/proyectos/' . $newNameProyecto;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Error al guardar el archivo del proyecto');
                }
            }

            // Procesar el póster si existe
            $posterPath = null;
            $poster = $this->request->getFile('poster');
            if ($poster && $poster->isValid() && !$poster->hasMoved()) {
                $newNamePoster = $poster->getRandomName();
                if ($poster->move(ROOTPATH . 'public/uploads/proyectos_integradores_saberes/posters', $newNamePoster)) {
                    $posterPath = 'uploads/proyectos_integradores_saberes/posters/' . $newNamePoster;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Error al guardar el archivo del poster');
                }
            }

            // Preparar datos para guardar
            $data = $this->request->getPost();
            if ($proyectoPath) {
                $data['proyecto_path'] = $proyectoPath;
            }
            if ($posterPath) {
                $data['poster_path'] = $posterPath;
            }


            // Intentar guardar en la base de datos
            $inserted = $this->pisModel->insert($data);
            
            

            if ($inserted) {
                // Obtener el ID del PIS recién insertado
                $pisId = $this->pisModel->getInsertID();
                $participanteController = new ParticipanteController();
            
                // Verificar el tipo de participante seleccionado
                $tipoParticipante = $this->request->getPost('tipo_participante');


                


            
                if ($tipoParticipante === 'Docente') {
                    // Verificar si hay datos de docentes
                    $docentesData = $this->request->getPost('docentes_data');
                    if (!empty($docentesData)) {
                        try {
                            // Decodificar los datos de docentes
                            $docentes = json_decode($docentesData, true);
                                                      
                            // Llamar al método para crear docentes
                            $response = $participanteController->createDocente($pisId, $docentes);
                            
                            // Si hay error al guardar los docentes, hacemos rollback
                            if (!$response['success']) {
                                // Eliminar el PIS recién creado
                                $this->pisModel->delete($pisId);
                                return redirect()->back()->withInput()
                                    ->with('error', 'Error al guardar los docentes: ' . ($response['error'] ?? 'Error desconocido'));
                            }
                        } catch (Exception $e) {
                            // Si hay error, eliminar el PIS recién creado
                            $this->pisModel->delete($pisId);
                            return redirect()->back()->withInput()
                                ->with('error', 'Error al procesar los docentes: ' . $e->getMessage());
                        }
                    }
                } 
                else if ($tipoParticipante === 'Estudiante') {
                    // Verificar si hay datos de estudiantes
                    $estudiantesData = $this->request->getPost('estudiantes_data');

                    // Verificar si hay datos de estudiantes
                    $estudiantesData = $this->request->getPost('estudiantes_data');


                    if (!empty($estudiantesData)) {
                        try {
                            // Decodificar los datos de estudiantes
                            $estudiantes = json_decode($estudiantesData, true);
                                                      
                            // Llamar al método para crear estudiantes
                            $response = $participanteController->createEstudiante($pisId, $estudiantes);
                            
                            // Si hay error al guardar los estudiantes, hacemos rollback
                            if (!$response['success']) {
                                // Eliminar el PIS recién creado
                                $this->pisModel->delete($pisId);
                                return redirect()->back()->withInput()
                                    ->with('error', 'Error al guardar los estudiantes: ' . ($response['error'] ?? 'Error desconocido'));
                            }
                        } catch (Exception $e) {
                            // Si hay error, eliminar el PIS recién creado
                            $this->pisModel->delete($pisId);
                            return redirect()->back()->withInput()
                                ->with('error', 'Error al procesar los estudiantes: ' . $e->getMessage());
                        }
                    }
                }
                else if ($tipoParticipante === 'Docente/Estudiante') {
                    $docentesData = $this->request->getPost('docentes_data');
                    $estudiantesData = $this->request->getPost('estudiantes_data');
                    $error = false;
            
                    // Procesar docentes si hay datos
                    if (!empty($docentesData)) {
                        try {
                            $docentes = json_decode($docentesData, true);
                            $response = $participanteController->createDocente($pisId, $docentes);
                            
                            if (!$response['success']) {
                                $error = true;
                                $errorMessage = 'Error al guardar los docentes: ' . ($response['error'] ?? 'Error desconocido');
                            }
                        } catch (Exception $e) {
                            $error = true;
                            $errorMessage = 'Error al procesar los docentes: ' . $e->getMessage();
                        }
                    }
            
                    // Si no hubo error con docentes, procesar estudiantes
                    if (!$error && !empty($estudiantesData)) {
                        try {
                            $estudiantes = json_decode($estudiantesData, true);


                            $response = $participanteController->createEstudiante($pisId, $estudiantes);

                            
                            if (!$response['success']) {
                                $error = true;
                                $errorMessage = 'Error al guardar los estudiantes del modal Docente/Estudiante: ' . ($response['error'] ?? 'Error desconocido');

                            }
                        } catch (Exception $e) {
                            $error = true;
                            $errorMessage = 'Error al procesar los estudiantes: ' . $e->getMessage();
                        }
                    }
            
                    // Si hubo algún error, hacer rollback y retornar
                    if ($error) {
                        $this->pisModel->delete($pisId);
                        return redirect()->back()->withInput()
                            ->with('error', $errorMessage);
                    }
                }

            
                return redirect()->to('pis')->with('message', 'Proyecto guardado exitosamente');
            } else {
                return redirect()->back()->withInput()->with('error', 'Error al guardar en la base de datos');
            }






        } catch (Exception $e) {
            // Limpiar archivos si se subieron
            if (isset($proyectoPath)) {
                @unlink(ROOTPATH . 'public/' . $proyectoPath);
            }
            if (isset($posterPath)) {
                @unlink(ROOTPATH . 'public/' . $posterPath);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Error al guardar el proyecto: ' . $e->getMessage());
        }
    }









    public function getCamposEspecificos($amplioId)
    {
        try {
            return $this->response->setJSON(
                $this->pisModel->getCamposEspecificos($amplioId)
            );
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)
                                ->setJSON(['error' => 'Error al cargar los campos específicos']);
        }
    }

    public function getCamposDetallados($especificoId)
    {
        try {
            return $this->response->setJSON(
                $this->pisModel->getCamposDetallados($especificoId)
            );
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)
                                ->setJSON(['error' => 'Error al cargar los campos detallados']);
        }
    }




    public function edit($id)
    {
        try {
            
            // Obtener proyecto con sus participantes usando el método del modelo
            $proyecto = $this->pisModel->getProyectoWithParticipantes($id);



            if (!$proyecto) {
                throw new Exception('Proyecto no encontrado');
            }

            $data = [
                'proyecto' => $proyecto,
                'programas' => $this->pisModel->getProgramas(),
                'lineas_investigacion' => $this->pisModel->getLineasInvestigacion(),
                'campos_amplios' => $this->pisModel->getCamposAmplios(),
                'campos_especificos' => $this->pisModel->getCamposEspecificos($proyecto['campo_amplio_id']),
                'campos_detallados' => $this->pisModel->getCamposDetallados($proyecto['campo_especifico_id']),
                'publicaciones' => $this->pisModel->getProduccionesCientificas(),
                'enumData' => $this->pisModel->getAllEnums(),
                'careers' => $this->pisModel->getCareers()
            ];

            return view('pis/edit', $data);
        } catch (Exception $e) {
            return redirect()->to('pis')->with('error', 'Error al cargar el proyecto');
        }
    }

    public function update($id)
    {
        try {
            // Validar datos del formulario
            if (!$this->validate($this->pisModel->validationRules, $this->pisModel->validationMessages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $proyecto = $this->pisModel->find($id);
            if (!$proyecto) {
                throw new Exception('Proyecto no encontrado');
            }

            $data = $this->request->getPost();

            // Procesar nuevo archivo de proyecto si se subió uno
            $proyectoFile = $this->request->getFile('proyecto');
            if ($proyectoFile && $proyectoFile->isValid() && !$proyectoFile->hasMoved()) {
                // Eliminar archivo anterior
                if (!empty($proyecto['proyecto_path'])) {
                    @unlink(ROOTPATH . 'public/' . $proyecto['proyecto_path']);
                }
                
                // Guardar nuevo archivo
                $newNameProyecto = $proyectoFile->getRandomName();
                if ($proyectoFile->move(ROOTPATH . 'public/uploads/proyectos_integradores_saberes/proyectos', $newNameProyecto)) {
                    $data['proyecto_path'] = 'uploads/proyectos_integradores_saberes/proyectos/' . $newNameProyecto;
                }
            }

            // Procesar nuevo póster si se subió uno
            $posterFile = $this->request->getFile('poster');
            if ($posterFile && $posterFile->isValid() && !$posterFile->hasMoved()) {
                // Eliminar póster anterior si existe
                if (!empty($proyecto['poster_path'])) {
                    @unlink(ROOTPATH . 'public/' . $proyecto['poster_path']);
                }
                
                // Guardar nuevo póster
                $newNamePoster = $posterFile->getRandomName();
                if ($posterFile->move(ROOTPATH . 'public/uploads/proyectos_integradores_saberes/posters', $newNamePoster)) {
                    $data['poster_path'] = 'uploads/proyectos_integradores_saberes/posters/' . $newNamePoster;
                }
            }



            // Actualizar en la base de datos
            // Iniciar transacción
            $this->pisModel->db->transBegin();

            try {
                // Actualizar datos básicos del proyecto
                $this->pisModel->update($id, $data);

                // Procesar participantes según el tipo
                $participanteController = new ParticipanteController();
                $tipoParticipante = $this->request->getPost('tipo_participante');


                // Eliminar las relaciones de los participantes existentes
                $resultDelete = $participanteController->deleteParticipantes($id);

                if (!$resultDelete['success']) {
                    throw new Exception($resultDelete['error']);
                }


                // Procesar según el tipo de participante
                if ($tipoParticipante === 'Docente') {
                    $docentesData = $this->request->getPost('docentes_data');
                    if (!empty($docentesData)) {
                        $docentes = json_decode($docentesData, true);
                        $response = $participanteController->createDocente($id, $docentes);
                        if (!$response['success']) {
                            throw new Exception('Error al actualizar docentes: ' . ($response['error'] ?? ''));
                        }
                    }
                } 
                else if ($tipoParticipante === 'Estudiante') {
                    $estudiantesData = $this->request->getPost('estudiantes_data');
                    if (!empty($estudiantesData)) {
                        $estudiantes = json_decode($estudiantesData, true);
                        $response = $participanteController->createEstudiante($id, $estudiantes);
                        if (!$response['success']) {
                            throw new Exception('Error al actualizar estudiantes: ' . ($response['error'] ?? ''));
                        }
                    }
                }
                else if ($tipoParticipante === 'Docente/Estudiante') {
                    $docentesData = $this->request->getPost('docentes_data');
                    $estudiantesData = $this->request->getPost('estudiantes_data');

                    if (!empty($docentesData)) {
                        $docentes = json_decode($docentesData, true);
                        $response = $participanteController->createDocente($id, $docentes);
                        if (!$response['success']) {
                            throw new Exception('Error al actualizar docentes: ' . ($response['error'] ?? ''));
                        }
                    }

                    if (!empty($estudiantesData)) {
                        $estudiantes = json_decode($estudiantesData, true);
                        $response = $participanteController->createEstudiante($id, $estudiantes);
                        if (!$response['success']) {
                            throw new Exception('Error al actualizar estudiantes: ' . ($response['error'] ?? ''));
                        }
                    }
                }

                $this->pisModel->db->transCommit();
                return redirect()->to('pis')->with('message', 'Proyecto actualizado exitosamente');

            } catch (Exception $e) {
                $this->pisModel->db->transRollback();
                throw $e;
            }





        } catch (Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Error al actualizar el proyecto: ' . $e->getMessage());
        }
    }











    public function delete($id)
    {
        try {
            $proyecto = $this->pisModel->find($id);
            
            if (!$proyecto) {
                throw new Exception('Proyecto no encontrado');
            }

            // Eliminar archivos
            if (!empty($proyecto['proyecto_path'])) {
                @unlink(ROOTPATH . 'public/' . $proyecto['proyecto_path']);
            }
            if (!empty($proyecto['poster_path'])) {
                @unlink(ROOTPATH . 'public/' . $proyecto['poster_path']);
            }

            // Eliminar registro
            $this->pisModel->delete($id);
            return redirect()->to('pis')->with('message', 'Proyecto eliminado exitosamente');

        } catch (Exception $e) {
            return redirect()->to('pis')->with('error', 'Error al eliminar el proyecto');
        }
    }

    public function download($id)
    {
        try {
            $proyecto = $this->pisModel->find($id);
            
            if (!$proyecto || empty($proyecto['proyecto_path'])) {
                throw new Exception('Archivo no encontrado');
            }

            $path = ROOTPATH . 'public/' . $proyecto['proyecto_path'];
            
            if (!file_exists($path)) {
                throw new Exception('Archivo no encontrado en el servidor');
            }

            return $this->response->download($path, null);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al descargar el archivo');
        }
    }

    public function downloadPoster($id)
    {
        try {
            $proyecto = $this->pisModel->find($id);
            
            if (!$proyecto || empty($proyecto['poster_path'])) {
                throw new Exception('Póster no encontrado');
            }

            $path = ROOTPATH . 'public/' . $proyecto['poster_path'];
            
            if (!file_exists($path)) {
                throw new Exception('Póster no encontrado en el servidor');
            }

            return $this->response->download($path, null);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al descargar el póster');
        }
    }











    //Funciones para el crud de lineas de investigacion.
    public function lineasInvestigacionList()
    {
        try {
            $lineas = $this->pisModel->getLineasConCarrera();
        
            

            $response = [
                'success' => true,
                'data' => $lineas
            ];

            
            return $this->response->setJSON($response);


        } catch (Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Error al cargar las líneas de investigación'
            ]);
        }
    }

    public function lineasInvestigacionGet($id)
    {
        try {
            $linea = $this->pisModel->getLineaInvestigacion($id);
            if (!$linea) {
                return $this->response->setStatusCode(404)
                    ->setJSON(['error' => 'Línea de investigación no encontrada']);
            }
            return $this->response->setJSON($linea);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Error al obtener la línea de investigación'
            ]);
        }
    }

    public function lineasInvestigacionCreate()
    {
        try {
            $data = [
                'nombre_linea' => $this->request->getPost('nombre_linea'),
                'carrera_id' => $this->request->getPost('carrera_id')
            ];
            
            if (empty($data['nombre_linea']) || empty($data['carrera_id'])) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'El nombre de la línea y la carrera son obligatorios']);
            }
            
            if ($this->pisModel->createLineaInvestigacion($data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Línea de investigación creada exitosamente'
                ]);
            }
            
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => 'Error al crear la línea de investigación']);
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => 'Error al crear la línea de investigación']);
        }
    }

    

    
    public function lineasInvestigacionUpdate($id)
    {
        try {
            // Obtener los datos del cuerpo de la petición PUT
            $input = $this->request->getRawInput();
            $data = [
                'nombre_linea' => $input['nombre_linea'] ?? null,
                'carrera_id' => $input['carrera_id'] ?? null
            ];
            
            if (empty($data['nombre_linea']) || empty($data['carrera_id'])) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'El nombre de la línea y la carrera son obligatorios']);
            }
            
            if (!$this->pisModel->getLineaInvestigacion($id)) {
                return $this->response->setStatusCode(404)
                    ->setJSON(['error' => 'Línea de investigación no encontrada']);
            }
            
            if ($this->pisModel->updateLineaInvestigacion($id, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Línea de investigación actualizada exitosamente'
                ]);
            }
            
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => 'Error al actualizar la línea de investigación']);
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => 'Error al actualizar la línea de investigación']);
        }
    }




    public function lineasInvestigacionDelete($id)
    {
        try {
            if (!$this->pisModel->getLineaInvestigacion($id)) {
                return $this->response->setStatusCode(404)
                    ->setJSON(['error' => 'Línea de investigación no encontrada']);
            }
            
            if ($this->pisModel->isLineaEnUso($id)) {
                return $this->response->setStatusCode(400)
                    ->setJSON(['error' => 'No se puede eliminar la línea porque está siendo utilizada en proyectos']);
            }
            
            if ($this->pisModel->deleteLineaInvestigacion($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Línea de investigación eliminada exitosamente'
                ]);
            }
            
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => 'Error al eliminar la línea de investigación']);
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => 'Error al eliminar la línea de investigación']);
        }
    }

    public function getCareers()
    {
        try {
            $careers = $this->pisModel->getCareers();
            return $this->response->setJSON($careers);
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => 'Error al cargar las carreras']);
        }
    }













}