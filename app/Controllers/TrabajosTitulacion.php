<?php

namespace App\Controllers;

use App\Models\TrabajoTitulacionModel;
use App\Models\CareerModel;
use App\Models\YearModel;
use App\Models\MesModel;
use App\Models\AcademicPeriodModel;

class TrabajosTitulacion extends BaseController
{
    protected $trabajoModel;
    protected $careerModel;
    protected $yearModel;
    protected $mesModel;
    protected $academicPeriodModel;

    public function __construct()
    {
        $this->trabajoModel = new TrabajoTitulacionModel();
        $this->careerModel = new CareerModel();
        $this->yearModel = new YearModel();
        $this->mesModel = new MesModel();
        $this->academicPeriodModel = new AcademicPeriodModel();
    }

    public function index()
    {
        $career_id = $this->request->getGet('career_id');
        $year_id = $this->request->getGet('year_id');
        $mes_id = $this->request->getGet('mes_id');
        $period_id = $this->request->getGet('period_id');

        // Construir la consulta base
        $query = $this->trabajoModel->select('trabajos_de_titulacion.*, careers.name as career_name, academic_periods.name as period_name, year.anio as anio')
            ->join('careers', 'careers.id = trabajos_de_titulacion.career_id')
            ->join('academic_periods', 'academic_periods.id = trabajos_de_titulacion.academic_period_id')
            ->join('year', 'year.id = trabajos_de_titulacion.year_id')
            ->join('meses', 'meses.id = trabajos_de_titulacion.mes_id');

        // Aplicar filtros si existen
        //Los filtros siguen formando parte del query.
        if ($career_id) {
            $query->where('trabajos_de_titulacion.career_id', $career_id);
        }
        if ($year_id) {
            $query->where('trabajos_de_titulacion.year_id', $year_id);
        }
        if ($mes_id) {
            $query->where('trabajos_de_titulacion.mes_id', $mes_id);
        }
        if ($period_id) {
            $query->where('trabajos_de_titulacion.academic_period_id', $period_id);
        }

        $data = [
            'trabajos' => $query->findAll(),
            'careers' => $this->careerModel->findAll(),
            'years' => $this->yearModel->findAll(),
            'meses' => $this->mesModel->findAll(),
            'periods' => $this->academicPeriodModel->findAll(),
            // Mantener los filtros seleccionados
            'selected_career' => $career_id,
            'selected_year' => $year_id,
            'selected_mes' => $mes_id,
            'selected_period' => $period_id
        ];
        
        return view('tdt/index', $data);
    }

    public function new()
    {
        $data = [
            'careers' => $this->careerModel->findAll(),
            'meses' => $this->mesModel->findAll(),
            'academic_periods' => $this->academicPeriodModel->findAll()
        ];
        
        return view('tdt/create', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            // Obtener los archivos
            $documento = $this->request->getFile('documento_path');
            $poster = $this->request->getFile('poster_path');

            // Validar que sean PDFs válidos
            if ($documento->isValid() && !$documento->hasMoved() && 
                $documento->getClientMimeType() === 'application/pdf') {
                
                // Generar nombre único para el documento
                $documentoName = $documento->getRandomName();

                // Crear directorio si no existe
                $uploadPath = 'uploads/trabajos_titulacion/' . date('Y') . '/' . date('m');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Mover el documento
                if ($documento->move($uploadPath, $documentoName)) {
                    
                    // Preparar datos para guardar
                    $data = $this->request->getPost();
                    $data['documento_path'] = $uploadPath . '/' . $documentoName;
                    
                    //He creado lo del poster en tdt, pero estos van en pis. Nos los elimino porque me pueden servir para el pis.
                    // Procesar el póster solo si se subió uno
                    // if ($poster->isValid() && !$poster->hasMoved() && 
                    //     $poster->getClientMimeType() === 'application/pdf') {
                    //     $posterName = $poster->getRandomName();

                    //     //Mover el poster.
                    //     if ($poster->move($uploadPath, $posterName)) {
                    //         $data['poster_path'] = $uploadPath . '/' . $posterName;
                    //     }
                    // } else {
                    //     // Si no hay póster, establecer como NULL
                    //     $data['poster_path'] = NULL;
                    // }



                    // En el método create() del controlador, antes de guardar en trabajos_de_titulacion
                    $year = $this->request->getPost('year');
                    $yearModel = new \App\Models\YearModel();

                    // Buscar si el año ya existe
                    $existingYear = $yearModel->where('anio', $year)->first();

                    if ($existingYear) {
                        // Si existe, usar su ID
                        $data['year_id'] = $existingYear['id'];
                    } else {
                        // Si no existe, crear nuevo registro
                        $yearData = ['anio' => $year];
                        $yearModel->insert($yearData);
                        $data['year_id'] = $yearModel->getInsertID();
                    }

                    // Eliminar el campo 'year' ya que usaremos year_id
                    unset($data['year']);




                    // Guardar en la base de datos
                    if ($this->trabajoModel->save($data)) {
                        return redirect()->to('/trabajos-titulacion')
                            ->with('message', 'Trabajo de titulación guardado exitosamente');
                    } else {
                        // Eliminar el documento si falla el guardado
                        unlink($uploadPath . '/' . $documentoName);
                        // Eliminar el póster si existe y falla el guardado
                        if (isset($data['poster_path']) && file_exists($data['poster_path'])) {
                            unlink($data['poster_path']);
                        }
                        return redirect()->back()
                            ->with('errors', $this->trabajoModel->errors())
                            ->withInput();
                    }
                }
            }

            return redirect()->back()
                ->with('error', 'Error al subir los archivos. Asegúrese de que sean PDFs válidos.')
                ->withInput();
        }
    }

    public function edit($id = null)
    {
        // Obtener el trabajo de titulación
        $trabajo = $this->trabajoModel->find($id);
        
        if (empty($trabajo)) {
            return redirect()->to('/trabajos-titulacion')
                ->with('error', 'Trabajo no encontrado');
        }

        // Obtener el año actual del trabajo
        $yearModel = new \App\Models\YearModel();
        $yearData = $yearModel->find($trabajo['year_id']);

        $data = [
            'trabajo' => $trabajo,
            'yearData' => $yearData,
            'careers' => $this->careerModel->findAll(),
            'meses' => $this->mesModel->findAll(),
            'academic_periods' => $this->academicPeriodModel->findAll()
        ];

        return view('tdt/edit', $data);
    }

    public function update($id = null)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $oldTrabajo = $this->trabajoModel->find($id);



            // Manejar el año
            $year = $this->request->getPost('year');
            $yearModel = new \App\Models\YearModel();

            // Buscar si el año ya existe
            $existingYear = $yearModel->where('anio', $year)->first();

            if ($existingYear) {
                // Si existe, usar su ID
                $data['year_id'] = $existingYear['id'];
            } else {
                // Si no existe, crear nuevo registro
                $yearData = ['anio' => $year];
                $yearModel->insert($yearData);
                $data['year_id'] = $yearModel->getInsertID();
            }

            // Eliminar el campo 'year' ya que usaremos year_id
            unset($data['year']);




            
            // Verificar si hay nuevos archivos
            $documento = $this->request->getFile('documento_path');
            //$poster = $this->request->getFile('poster_path');
            
 
            $uploadPath = 'uploads/trabajos_titulacion/' . date('Y') . '/' . date('m');

            // Procesar documento si se subió uno nuevo
            if ($documento->isValid() && !$documento->hasMoved() && 
                $documento->getClientMimeType() === 'application/pdf') {
                
                // Eliminar documento anterior
                if (file_exists($oldTrabajo['documento_path'])) {
                    unlink($oldTrabajo['documento_path']);
                }

                // Subir nuevo documento
                $documentoName = $documento->getRandomName();
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                if ($documento->move($uploadPath, $documentoName)) {
                    $data['documento_path'] = $uploadPath . '/' . $documentoName;
                }
            }

            //He creado lo del poster en tdt, pero estos van en pis. Nos los elimino porque me pueden servir para el pis.
            // Procesar póster si se subió uno nuevo
            // if ($poster->isValid() && !$poster->hasMoved() && 
            //     $poster->getClientMimeType() === 'application/pdf') {
                
            //     // Eliminar póster anterior
            //     if (file_exists($oldTrabajo['poster_path'])) {
            //         unlink($oldTrabajo['poster_path']);
            //     }

            //     // Subir nuevo póster
            //     $posterName = $poster->getRandomName();
            //     if (!is_dir($uploadPath)) {
            //         mkdir($uploadPath, 0777, true);
            //     }
            //     if ($poster->move($uploadPath, $posterName)) {
            //         $data['poster_path'] = $uploadPath . '/' . $posterName;
            //     }
            // }

            if ($this->trabajoModel->update($id, $data)) {
                return redirect()->to('/trabajos-titulacion')
                    ->with('message', 'Trabajo de titulación actualizado exitosamente');
            } else {
                return redirect()->back()
                    ->with('errors', $this->trabajoModel->errors())
                    ->withInput();
            }
        }
    }

    public function delete($id = null)
    {
        $trabajo = $this->trabajoModel->find($id);
        if ($trabajo) {
            // Eliminar archivos físicos
            if (file_exists($trabajo['documento_path'])) {
                unlink($trabajo['documento_path']);
            }
            if (file_exists($trabajo['poster_path'])) {
                unlink($trabajo['poster_path']);
            }
            
            // Eliminar registro de la base de datos
            if ($this->trabajoModel->delete($id)) {
                return redirect()->to('/trabajos-titulacion')
                    ->with('message', 'Trabajo de titulación eliminado exitosamente');
            }
        }
        
        return redirect()->to('/trabajos-titulacion')
            ->with('error', 'No se pudo eliminar el trabajo de titulación');
    }

    public function download($id = null)
    {
        $trabajo = $this->trabajoModel->find($id);
        if ($trabajo && file_exists($trabajo['documento_path'])) {
            return $this->response->download($trabajo['documento_path'], null);
        }
        
        return redirect()->to('/trabajos-titulacion')
            ->with('error', 'No se pudo descargar el documento');
    }

    

    //He creado lo del poster en tdt, pero estos van en pis. Nos los elimino porque me pueden servir para el pis.
    // public function downloadPoster($id = null)
    // {
    //     $trabajo = $this->trabajoModel->find($id);
    //     if ($trabajo && file_exists($trabajo['poster_path'])) {
    //         return $this->response->download($trabajo['poster_path'], null);
    //     }
        
    //     return redirect()->to('/trabajos-titulacion')
    //         ->with('error', 'No se pudo descargar el póster');
    // }
}