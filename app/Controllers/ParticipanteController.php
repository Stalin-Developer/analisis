<?php

namespace App\Controllers;
use Exception;

class ParticipanteController extends BaseController
{
    protected $participanteModel;
    protected $pisModel;

    public function __construct()
    {
        $this->participanteModel = new \App\Models\ParticipanteModel();
        $this->pisModel = new \App\Models\PISModelo();
    }

    /**
     * Método para crear un docente
     */
    public function createDocente($pisId = null, $docentesData = null)
    {
        try {
            // Si no recibimos los datos como parámetros, intentamos obtenerlos de la petición
            if ($pisId === null || $docentesData === null) {
                if (!$this->request->isAJAX()) {
                    throw new Exception('Acceso no permitido');
                }
                $data = $this->request->getJSON(true);
                $pisId = $data['pis_id'] ?? null;
                $docentesData = $data['docentes'] ?? null;
            }

            if (!$pisId) {
                throw new Exception('ID del proyecto no proporcionado');
            }

            if (!is_array($docentesData)) {
                throw new Exception('Formato de datos inválido');
            }

            $docentesInsertados = [];
            $db = \Config\Database::connect();
            $db->transStart();

            try {
                foreach ($docentesData as $docente) {
                    if (!empty($docente['nombre']) && !empty($docente['cedula'])) {
                        // Verificar si el docente ya existe
                        $docenteExistente = $this->participanteModel->findByCedula($docente['cedula'], 'docente');
                        
                        if ($docenteExistente) {
                            // Si existe, verificar que no esté ya asociado al proyecto
                            if (!$this->participanteModel->isInPIS($pisId, $docenteExistente['id'], 'docente')) {
                                $this->participanteModel->associateWithPIS($docenteExistente['id'], $pisId, 'docente');
                            }
                            $docentesInsertados[] = $docenteExistente['id'];
                        } else {
                            // Si no existe, crear nuevo docente y asociarlo
                            $docenteId = $this->participanteModel->createAndAssociate([
                                'nombre' => $docente['nombre'],
                                'cedula' => $docente['cedula']
                            ], $pisId, 'docente');
                            
                            if ($docenteId) {
                                $docentesInsertados[] = $docenteId;
                            }
                        }
                    }
                }

                $db->transComplete();

                if ($db->transStatus() === false) {
                    throw new Exception('Error al guardar los docentes');
                }

                return [
                    'success' => true,
                    'message' => 'Docentes guardados exitosamente',
                    'docentes_insertados' => $docentesInsertados
                ];

            } catch (Exception $e) {
                $db->transRollback();
                throw $e;
            }

        } catch (Exception $e) {
            log_message('error', 'Error en ParticipanteController::createDocente: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }



    /**
     * Método para obtener los docentes de un proyecto
     */
    public function getDocentesByPIS($pisId)
    {
        try {
            if (!$this->request->isAJAX()) {
                throw new Exception('Acceso no permitido');
            }

            $docentes = $this->participanteModel->getDocentesByPIS($pisId);
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $docentes
            ]);

        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Error al obtener los docentes'
            ]);
        }
    }

    /**
     * Método para verificar si se alcanzó el límite de docentes
     */
    public function checkDocenteLimit($pisId)
    {
        try {
            if (!$this->request->isAJAX()) {
                throw new Exception('Acceso no permitido');
            }

            $hasReachedLimit = $this->participanteModel->hasReachedDocenteLimit($pisId);
            
            return $this->response->setJSON([
                'success' => true,
                'has_reached_limit' => $hasReachedLimit
            ]);

        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Error al verificar el límite de docentes'
            ]);
        }
    }
















    //PARTE DE ESTUDIANTES.
    /**
    * Método para crear un estudiante
    */
    public function createEstudiante($pisId = null, $estudiantesData = null)
    {
        try {
            // Si no recibimos los datos como parámetros, intentamos obtenerlos de la petición
            if ($pisId === null || $estudiantesData === null) {
                if (!$this->request->isAJAX()) {
                    throw new Exception('Acceso no permitido');
                }
                $data = $this->request->getJSON(true);
                $pisId = $data['pis_id'] ?? null;
                $estudiantesData = $data['estudiantes'] ?? null;
            }

            if (!$pisId) {
                throw new Exception('ID del proyecto no proporcionado');
            }

            if (!is_array($estudiantesData)) {
                throw new Exception('Formato de datos inválido');
            }

            $estudiantesInsertados = [];
            $db = \Config\Database::connect();
            $db->transStart();

            try {
                foreach ($estudiantesData as $estudiante) {
                    if (!empty($estudiante['nombre']) && !empty($estudiante['cedula'])) {
                        // Verificar si el estudiante ya existe
                        $estudianteExistente = $this->participanteModel->findByCedula($estudiante['cedula'], 'estudiante');
                        
                        if ($estudianteExistente) {
                            // Si existe, verificar que no esté ya asociado al proyecto
                            if (!$this->participanteModel->isInPIS($pisId, $estudianteExistente['id'], 'estudiante')) {
                                $this->participanteModel->associateWithPIS($estudianteExistente['id'], $pisId, 'estudiante');
                            }
                            $estudiantesInsertados[] = $estudianteExistente['id'];
                        } else {
                            // Si no existe, crear nuevo estudiante y asociarlo
                            $estudianteId = $this->participanteModel->createAndAssociate([
                                'nombre' => $estudiante['nombre'],
                                'cedula' => $estudiante['cedula']
                            ], $pisId, 'estudiante');
                            
                            if ($estudianteId) {
                                $estudiantesInsertados[] = $estudianteId;
                            }
                        }
                    }
                }

                $db->transComplete();

                if ($db->transStatus() === false) {
                    throw new Exception('Error al guardar los estudiantes');
                }

                return [
                    'success' => true,
                    'message' => 'Estudiantes guardados exitosamente',
                    'estudiantes_insertados' => $estudiantesInsertados
                ];

            } catch (Exception $e) {
                $db->transRollback();
                throw $e;
            }

        } catch (Exception $e) {
            log_message('error', 'Error en ParticipanteController::createEstudiante: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Método para obtener los estudiantes de un proyecto
     */
    public function getEstudiantesByPIS($pisId)
    {
        try {
            if (!$this->request->isAJAX()) {
                throw new Exception('Acceso no permitido');
            }

            $estudiantes = $this->participanteModel->getEstudiantesByPIS($pisId);
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $estudiantes
            ]);

        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Error al obtener los estudiantes'
            ]);
        }
    }

    /**
     * Método para verificar si se alcanzó el límite de estudiantes
     */
    public function checkEstudianteLimit($pisId)
    {
        try {
            if (!$this->request->isAJAX()) {
                throw new Exception('Acceso no permitido');
            }

            $hasReachedLimit = $this->participanteModel->hasReachedEstudianteLimit($pisId);
            
            return $this->response->setJSON([
                'success' => true,
                'has_reached_limit' => $hasReachedLimit
            ]);

        } catch (Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'error' => 'Error al verificar el límite de estudiantes'
            ]);
        }
    }

















}