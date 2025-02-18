<?php

namespace App\Controllers;
use Exception;

class ProduccionController extends BaseController
{
    protected $produccionModel;

    public function __construct()
    {
        $this->produccionModel = new \App\Models\ProduccionModel();
    }

    public function index()
    {
        try {
            // Obtener parámetros de filtrado
            $tipo = $this->request->getGet('tipo');
            $anio = $this->request->getGet('anio');
            
            // Construir la consulta base
            $builder = $this->produccionModel->db->table('produccion_cientifica_tecnica')
                ->select('produccion_cientifica_tecnica.*, 
                    campo_amplio.nombre_amplio as nombre_amplio,
                    campo_especifico.nombre_especifico as nombre_especifico,
                    campo_detallado.nombre_detallado as nombre_detallado,
                    base_datos_indexada.nombre as nombre_base_datos');

            $builder->join('campo_amplio', 
                'campo_amplio.id = produccion_cientifica_tecnica.campo_amplio_id', 'left');
            $builder->join('campo_especifico', 
                'campo_especifico.id = produccion_cientifica_tecnica.campo_especifico_id', 'left');
            $builder->join('campo_detallado', 
                'campo_detallado.id = produccion_cientifica_tecnica.campo_detallado_id', 'left');
            $builder->join('base_datos_indexada', 
                'base_datos_indexada.id = produccion_cientifica_tecnica.base_datos_id', 'left');

            // Aplicar filtros si existen
            if ($tipo) {
                $builder->where('produccion_cientifica_tecnica.tipo', $tipo);
            }
            if ($anio) {
                $builder->where('YEAR(produccion_cientifica_tecnica.created_at)', $anio);
            }

            // Ordenar por fecha de creación descendente
            $builder->orderBy('produccion_cientifica_tecnica.created_at', 'DESC');
            
            // Limitar a 100 registros
            $builder->limit(100);

            // Ejecutar la consulta
            $producciones = $builder->get()->getResultArray();

            // Obtener años únicos para el filtro
            $years = $this->produccionModel->db->query(
                "SELECT DISTINCT YEAR(created_at) as year 
                 FROM produccion_cientifica_tecnica 
                 ORDER BY year DESC"
            )->getResultArray();

            // Obtener enums de la base de datos
            $enums = $this->produccionModel->getAllEnums();

            $data = [
                'producciones' => $producciones,
                'tipos' => $enums['tipo'],
                'years' => array_column($years, 'year'),
                'selected_tipo' => $tipo,
                'selected_anio' => $anio
            ];
            
            return view('produccion/index', $data);

        } catch (Exception $e) {
            return view('produccion/index', ['error' => 'Error al cargar las producciones científicas']);
        }
    }

    public function new()
    {
        try {
            $data = [
                'campos_amplios' => $this->produccionModel->getCamposAmplios(),
                'bases_datos' => $this->produccionModel->getBaseDatos(),
                'enumData' => $this->produccionModel->getAllEnums()
            ];

            return view('produccion/create', $data);
        } catch (Exception $e) {
            return view('produccion/create', [
                'error' => 'Error al cargar los datos del formulario'
            ]);
        }
    }

    


    public function create()
    {
        try {
            

            // Validar datos del formulario
            if (!$this->validate($this->produccionModel->validationRules, $this->produccionModel->validationMessages)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }


            // Procesar el archivo si existe
            $documento = $this->request->getFile('documento');

            $documentoPath = null;

            if ($documento && $documento->isValid() && !$documento->hasMoved()) {
                $newName = $documento->getRandomName();
                if ($documento->move(ROOTPATH . 'public/uploads/produccion', $newName)) {
                    $documentoPath = 'uploads/produccion/' . $newName;
                } else {
                    return redirect()->back()->withInput()->with('error', 'Error al guardar el documento');
                }
            }

            // Preparar datos para guardar
            $data = $this->request->getPost();
            if ($documentoPath) {
                $data['documento_path'] = $documentoPath;
            }



            // Convertir campos vacíos a null
            if (empty($data['campo_amplio_id'])) {
                $data['campo_amplio_id'] = null;
            }
            if (empty($data['campo_especifico_id'])) {
                $data['campo_especifico_id'] = null;
            }
            if (empty($data['campo_detallado_id'])) {
                $data['campo_detallado_id'] = null;
            }




            // Intentar guardar en la base de datos
            $this->produccionModel->db->transBegin();

            try {
                // Insertar producción
                $inserted = $this->produccionModel->insert($data);
                
                if ($inserted) {
                    $produccionId = $this->produccionModel->getInsertID();
                    
                    // Procesar participantes
                    $participantesData = $this->request->getPost('participantes_data');

                    if (!empty($participantesData)) {
                        $participantes = json_decode($participantesData, true);
                        $tipo = $this->request->getPost('tipo_participante');
                        
                        
                        foreach ($participantes as $participante) {
                            // Insertar o recuperar el participante
                            $participanteExistente = $this->produccionModel->db->table('participantes')
                                ->where('cedula', $participante['cedula'])
                                ->get()
                                ->getRowArray();
                
                            if ($participanteExistente) {
                                $participanteId = $participanteExistente['id'];
                            } else {
                                // Insertar nuevo participante
                                $this->produccionModel->db->table('participantes')->insert([
                                    'nombre' => $participante['nombre'],
                                    'cedula' => $participante['cedula']
                                ]);
                                $participanteId = $this->produccionModel->db->insertID();
                            }
                
                            // Crear relación producción-participante
                            $this->produccionModel->db->table('produccion_participantes')->insert([
                                'produccion_id' => $produccionId,
                                'participante_id' => $participanteId,
                                'tipo' => $tipo
                            ]);
                        }


                    }

                    $this->produccionModel->db->transCommit();
                    return redirect()->to('produccion')->with('message', 'Producción guardada exitosamente');
                }

            } catch (Exception $e) {
                $this->produccionModel->db->transRollback();
                throw $e;
            }

            return redirect()->back()->withInput()->with('error', 'Error al guardar en la base de datos');

        } catch (Exception $e) {
            if (isset($documentoPath)) {
                @unlink(ROOTPATH . 'public/' . $documentoPath);
            }
            return redirect()->back()->withInput()
                ->with('error', 'Error al guardar la producción: ' . $e->getMessage());
        }
    }




    // Método auxiliar para insertar o obtener participante
    private function insertOrGetParticipante($data)
    {
        $participante = $this->produccionModel->db->table('participantes')
            ->where('cedula', $data['cedula'])
            ->get()
            ->getRowArray();

        if ($participante) {
            return $participante['id'];
        }

        $this->produccionModel->db->table('participantes')->insert($data);
        return $this->produccionModel->db->insertID();
    }

    // Método auxiliar para crear relación producción-participante
    private function insertProduccionParticipante($produccionId, $participanteId, $tipo)
    {
        $data = [
            'produccion_id' => $produccionId,
            'participante_id' => $participanteId,
            'tipo' => $tipo
        ];

        $this->produccionModel->db->table('produccion_participantes')->insert($data);
    }


    public function getCamposEspecificos($amplioId)
    {
        try {
            return $this->response->setJSON(
                $this->produccionModel->getCamposEspecificos($amplioId)
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
                $this->produccionModel->getCamposDetallados($especificoId)
            );
        } catch (Exception $e) {
            return $this->response->setStatusCode(500)
                                ->setJSON(['error' => 'Error al cargar los campos detallados']);
        }
    }

    public function edit($id)
    {
        try {
            $produccion = $this->produccionModel->getProduccionWithParticipantes($id);

            if (!$produccion) {
                throw new Exception('Producción no encontrada');
            }

            $data = [
                'produccion' => $produccion,
                'campos_amplios' => $this->produccionModel->getCamposAmplios(),
                'campos_especificos' => $this->produccionModel->getCamposEspecificos($produccion['campo_amplio_id']),
                'campos_detallados' => $this->produccionModel->getCamposDetallados($produccion['campo_especifico_id']),
                'bases_datos' => $this->produccionModel->getBaseDatos(),
                'enumData' => $this->produccionModel->getAllEnums()
            ];

            return view('produccion/edit', $data);
        } catch (Exception $e) {
            return redirect()->to('produccion')->with('error', 'Error al cargar la producción');
        }
    }

    


    public function update($id)
    {
        try {
            if (!$this->validate($this->produccionModel->validationRules, $this->produccionModel->validationMessages)) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $this->validator->getErrors()
                ])->setStatusCode(400);
            }

            $produccion = $this->produccionModel->find($id);
            if (!$produccion) {
                return $this->response->setJSON([
                    'success' => false,
                    'error' => 'Producción no encontrada'
                ])->setStatusCode(404);
            }

            $data = $this->request->getPost();
            
            // Procesar documento
            $documento = $this->request->getFile('documento');
            if ($documento && $documento->isValid() && !$documento->hasMoved()) {
                if (!empty($produccion['documento_path'])) {
                    @unlink(ROOTPATH . 'public/' . $produccion['documento_path']);
                }
                
                $newName = $documento->getRandomName();
                if ($documento->move(ROOTPATH . 'public/uploads/produccion', $newName)) {
                    $data['documento_path'] = 'uploads/produccion/' . $newName;
                }
            }

            $this->produccionModel->db->transBegin();

            try {
                // Actualizar producción
                $this->produccionModel->update($id, $data);

                // Actualizar participantes
                $this->produccionModel->db->table('produccion_participantes')
                    ->where('produccion_id', $id)
                    ->delete();

                $participantesData = $this->request->getPost('participantes_data');

                if (!empty($participantesData)) {
                    $participantes = json_decode($participantesData, true);

                    $tipo = $this->request->getPost('tipo_participante');

                    foreach ($participantes as $participante) {

                        $participanteId = $this->insertOrGetParticipante([
                            'nombre' => $participante['nombre'],
                            'cedula' => $participante['cedula']
                        ]);

                        $this->insertProduccionParticipante($id, $participanteId, $tipo);
                    }
                }

                $this->produccionModel->db->transCommit();
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Producción actualizada exitosamente'
                ]);

            } catch (Exception $e) {
                $this->produccionModel->db->transRollback();
                
                return $this->response->setJSON([
                    'success' => false,
                    'error' => 'Error al actualizar la producción: ' . $e->getMessage()
                ])->setStatusCode(500);
            }

        } catch (Exception $e) {
            
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }





    public function delete($id)
    {
        try {
            $produccion = $this->produccionModel->find($id);
            
            if (!$produccion) {
                throw new Exception('Producción no encontrada');
            }

            // Eliminar documento si existe
            if (!empty($produccion['documento_path'])) {
                @unlink(ROOTPATH . 'public/' . $produccion['documento_path']);
            }

            // Eliminar registro y sus relaciones
            $this->produccionModel->db->transBegin();

            try {
                // Eliminar relaciones de participantes
                $this->produccionModel->db->table('produccion_participantes')
                    ->where('produccion_id', $id)
                    ->delete();

                // Eliminar la producción
                $this->produccionModel->delete($id);

                $this->produccionModel->db->transCommit();
                return redirect()->to('produccion')->with('message', 'Producción eliminada exitosamente');

            } catch (Exception $e) {
                $this->produccionModel->db->transRollback();
                throw $e;
            }

        } catch (Exception $e) {
            return redirect()->to('produccion')->with('error', 'Error al eliminar la producción');
        }
    }

    public function download($id)
    {
        try {
            $produccion = $this->produccionModel->find($id);
            
            if (!$produccion || empty($produccion['documento_path'])) {
                throw new Exception('Documento no encontrado');
            }

            $path = ROOTPATH . 'public/' . $produccion['documento_path'];
            
            if (!file_exists($path)) {
                throw new Exception('Documento no encontrado en el servidor');
            }

            return $this->response->download($path, null);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al descargar el documento');
        }
    }

    public function getParticipantes($id)
    {
        try {
            $produccion = $this->produccionModel->getProduccionWithParticipantes($id);
            
            if (!$produccion) {
                return $this->response->setJSON([
                    'success' => false,
                    'error' => 'Producción no encontrada'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'tipo' => $produccion['participantes']['tipo'],
                    'participantes' => $produccion['participantes']['lista']
                ]
            ]);

        } catch (Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Error al obtener los participantes'
            ]);
        }
    }







    
}