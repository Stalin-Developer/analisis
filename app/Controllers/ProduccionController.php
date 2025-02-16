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
            // Log inicial para verificar que la función se está ejecutando
            log_message('info', '[PRODUCCION] Iniciando función create');
            
            // Log para ver los datos que llegan del formulario
            log_message('info', '[PRODUCCION] Datos POST recibidos: ' . json_encode($this->request->getPost()));

            // Validar datos del formulario
            if (!$this->validate($this->produccionModel->validationRules, $this->produccionModel->validationMessages)) {
                log_message('error', '[PRODUCCION] Error de validación: ' . json_encode($this->validator->getErrors()));
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            log_message('info', '[PRODUCCION] Validación exitosa');

            // Procesar el archivo si existe
            $documento = $this->request->getFile('documento');
            log_message('info', '[PRODUCCION] Archivo recibido: ' . ($documento ? 'Sí' : 'No'));

            $documentoPath = null;

            if ($documento && $documento->isValid() && !$documento->hasMoved()) {
                log_message('info', '[PRODUCCION] Procesando archivo válido');
                $newName = $documento->getRandomName();
                if ($documento->move(ROOTPATH . 'public/uploads/produccion', $newName)) {
                    $documentoPath = 'uploads/produccion/' . $newName;
                    log_message('info', '[PRODUCCION] Archivo guardado en: ' . $documentoPath);
                } else {
                    log_message('error', '[PRODUCCION] Error al mover el archivo');
                    return redirect()->back()->withInput()->with('error', 'Error al guardar el documento');
                }
            }

            // Preparar datos para guardar
            $data = $this->request->getPost();
            if ($documentoPath) {
                $data['documento_path'] = $documentoPath;
            }
            log_message('info', '[PRODUCCION] Datos preparados para inserción: ' . json_encode($data));

            // Intentar guardar en la base de datos
            $this->produccionModel->db->transBegin();
            log_message('info', '[PRODUCCION] Iniciando transacción');

            try {
                // Insertar producción
                $inserted = $this->produccionModel->insert($data);
                log_message('info', '[PRODUCCION] Resultado de inserción: ' . ($inserted ? 'Exitoso' : 'Fallido'));
                
                if ($inserted) {
                    $produccionId = $this->produccionModel->getInsertID();
                    log_message('info', '[PRODUCCION] ID generado: ' . $produccionId);
                    
                    // Procesar participantes
                    $participantesData = $this->request->getPost('participantes_data');
                    log_message('info', '[PRODUCCION] Datos de participantes: ' . ($participantesData ?? 'No hay datos'));

                    if (!empty($participantesData)) {
                        $participantes = json_decode($participantesData, true);
                        $tipo = $this->request->getPost('tipo_participante');
                        log_message('info', '[PRODUCCION] Procesando participantes tipo: ' . $tipo);
                        
                        foreach ($participantes as $participante) {
                            // ... resto del código ...
                        }
                    }

                    $this->produccionModel->db->transCommit();
                    log_message('info', '[PRODUCCION] Transacción completada exitosamente');
                    return redirect()->to('produccion')->with('message', 'Producción guardada exitosamente');
                }

            } catch (Exception $e) {
                log_message('error', '[PRODUCCION] Error en transacción: ' . $e->getMessage());
                $this->produccionModel->db->transRollback();
                throw $e;
            }

            log_message('error', '[PRODUCCION] Error general en la inserción');
            return redirect()->back()->withInput()->with('error', 'Error al guardar en la base de datos');

        } catch (Exception $e) {
            log_message('error', '[PRODUCCION] Excepción general: ' . $e->getMessage());
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
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $produccion = $this->produccionModel->find($id);
            if (!$produccion) {
                throw new Exception('Producción no encontrada');
            }

            $data = $this->request->getPost();

            // Procesar nuevo documento si se subió uno
            $documento = $this->request->getFile('documento');
            if ($documento && $documento->isValid() && !$documento->hasMoved()) {
                // Eliminar documento anterior
                if (!empty($produccion['documento_path'])) {
                    @unlink(ROOTPATH . 'public/' . $produccion['documento_path']);
                }
                
                // Guardar nuevo documento
                $newName = $documento->getRandomName();
                if ($documento->move(ROOTPATH . 'public/uploads/produccion', $newName)) {
                    $data['documento_path'] = 'uploads/produccion/' . $newName;
                }
            }

            // Iniciar transacción
            $this->produccionModel->db->transBegin();

            try {
                // Actualizar datos básicos
                $this->produccionModel->update($id, $data);

                // Eliminar relaciones existentes de participantes
                $this->produccionModel->db->table('produccion_participantes')
                    ->where('produccion_id', $id)
                    ->delete();

                // Procesar participantes
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
                return redirect()->to('produccion')->with('message', 'Producción actualizada exitosamente');

            } catch (Exception $e) {
                $this->produccionModel->db->transRollback();
                throw $e;
            }

        } catch (Exception $e) {
            return redirect()->back()->withInput()
                ->with('error', 'Error al actualizar la producción: ' . $e->getMessage());
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