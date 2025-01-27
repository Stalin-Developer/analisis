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
            $query = $this->pisModel->select('proyectos_integradores_saberes.*, 
                programas.nombre_programa,
                lineas_investigacion_carreras.nombre_linea,
                campo_amplio.nombre_amplio,
                campo_especifico.nombre_especifico,
                campo_detallado.nombre_detallado,
                produccion_cientifica_tecnica.nombre as nombre_publicacion')
                ->join('programas', 'programas.id = proyectos_integradores_saberes.programa_id', 'left')
                ->join('lineas_investigacion_carreras', 'lineas_investigacion_carreras.id = proyectos_integradores_saberes.linea_investigacion_carrera_id', 'left')
                ->join('campo_amplio', 'campo_amplio.id = proyectos_integradores_saberes.campo_amplio_id', 'left')
                ->join('campo_especifico', 'campo_especifico.id = proyectos_integradores_saberes.campo_especifico_id', 'left')
                ->join('campo_detallado', 'campo_detallado.id = proyectos_integradores_saberes.campo_detallado_id', 'left')
                ->join('produccion_cientifica_tecnica', 'produccion_cientifica_tecnica.id = proyectos_integradores_saberes.publicaciones_id', 'left')
                ->orderBy('proyectos_integradores_saberes.created_at', 'DESC')
                ->limit(100);








            // Aplicar filtros si existen
            if ($tipo) {
                $query->where('tipo', $tipo);
            }
            if ($estado) {
                $query->where('estado', $estado);
            }
            if ($anio) {
                $query->where('anio', $anio);
            }

            // Obtener años únicos para el filtro
            $years = $this->pisModel->select('anio')
                        ->groupBy('anio')
                        ->orderBy('anio', 'DESC')
                        ->findAll();


            // Obtener enums de la base de datos
            $enums = $this->pisModel->getAllEnums();




            $data = [
                'proyectos' => $query->findAll(),
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
            $data = [
                'programas' => $this->pisModel->getProgramas(),
                'lineas_investigacion' => $this->pisModel->getLineasInvestigacion(),
                'campos_amplios' => $this->pisModel->getCamposAmplios(),
                'publicaciones' => $this->pisModel->getProduccionesCientificas(),
                'enums' => $this->pisModel->getAllEnums()
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


            // Procesar el archivo del proyecto
            $proyecto = $this->request->getFile('proyecto');
            $proyectoPath = null;

            if ($proyecto && $proyecto->isValid() && !$proyecto->hasMoved()) {
                $newNameProyecto = $proyecto->getRandomName();
                if ($proyecto->move(ROOTPATH . 'public/uploads/proyectos', $newNameProyecto)) {
                    $proyectoPath = 'uploads/proyectos/' . $newNameProyecto;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Error al guardar el archivo del proyecto');
                }
            }

            // Procesar el póster si existe
            $posterPath = null;
            $poster = $this->request->getFile('poster');
            if ($poster && $poster->isValid() && !$poster->hasMoved()) {
                $newNamePoster = $poster->getRandomName();
                if ($poster->move(ROOTPATH . 'public/uploads/posters', $newNamePoster)) {
                    $posterPath = 'uploads/posters/' . $newNamePoster;
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
            $proyecto = $this->pisModel->find($id);
            
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
                'publicaciones' => $this->pisModel->getProduccionesCientificas()
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
                if ($proyectoFile->move(ROOTPATH . 'public/uploads/proyectos', $newNameProyecto)) {
                    $data['proyecto_path'] = 'uploads/proyectos/' . $newNameProyecto;
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
                if ($posterFile->move(ROOTPATH . 'public/uploads/posters', $newNamePoster)) {
                    $data['poster_path'] = 'uploads/posters/' . $newNamePoster;
                }
            }

            // Actualizar en la base de datos
            $this->pisModel->update($id, $data);
            return redirect()->to('pis')->with('message', 'Proyecto actualizado exitosamente');

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
}