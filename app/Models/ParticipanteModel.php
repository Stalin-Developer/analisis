<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ParticipanteModel extends Model
{
    // La tabla por defecto será docentes, pero cambiaremos dinámicamente cuando sea necesario
    protected $table = 'docentes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nombre', 'cedula'];

    // Configuración de timestamps
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Método para cambiar la tabla y sus validaciones
    protected function setTableAndValidation($type = 'docente')
    {



        if ($type === 'estudiante') {
            $this->table = 'estudiantes';
            $this->validationRules = [
                'nombre' => 'required|min_length[3]|max_length[255]',
                'cedula' => 'required|numeric|exact_length[10]|is_unique[estudiantes.cedula]'
            ];
        } else {
            $this->table = 'docentes';
            $this->validationRules = [
                'nombre' => 'required|min_length[3]|max_length[255]',
                'cedula' => 'required|numeric|exact_length[10]|is_unique[docentes.cedula]'
            ];
        }



        $this->validationMessages = [
            'nombre' => [
                'required' => 'El nombre es obligatorio',
                'min_length' => 'El nombre debe tener al menos 3 caracteres',
                'max_length' => 'El nombre no puede exceder los 255 caracteres'
            ],
            'cedula' => [
                'required' => 'La cédula es obligatoria',
                'numeric' => 'La cédula debe contener solo números',
                'exact_length' => 'La cédula debe tener 10 dígitos',
                'is_unique' => 'Esta cédula ya está registrada'
            ]
        ];
    }

    


    public function createAndAssociate($data, $pisId, $type = 'docente')
    {

        $this->db->transBegin();

        try {
            // Primero insertar el participante
            $this->setTableAndValidation($type);

            // Verificamos que la inserción fue exitosa
            if (!$this->db->table($this->table)->insert($data)) {
                throw new Exception('Error al insertar en tabla ' . $this->table);
            }

            // Obtenemos el ID del participante recién insertado
            $participanteId = $this->db->insertID();

            // Verificamos que se obtuvo un ID válido
            if (!$participanteId) {
                throw new Exception('No se pudo obtener el ID del participante');
            }

            // Confirmamos que el registro existe
            $participante = $this->db->table($this->table)->where('id', $participanteId)->get()->getRow();
            if (!$participante) {
                throw new Exception('No se pudo encontrar el participante recién creado');
            }

            // Crear la relación
            $pivotTable = $type === 'estudiante' ? 'pis_estudiantes' : 'pis_docentes';
            $participanteColumn = $type === 'estudiante' ? 'estudiante_id' : 'docente_id';

            $dataRelacion = [
                'proyecto_id' => $pisId,
                $participanteColumn => $participanteId
            ];

            if (!$this->db->table($pivotTable)->insert($dataRelacion)) {
                throw new Exception('Error al crear relación en ' . $pivotTable);
            }

            // Verificar el estado de la transacción
            if ($this->db->transStatus() === false) {
                throw new Exception('Error en la transacción');
            }

            $this->db->transCommit();
            return $participanteId;

        } catch (Exception $e) {
            $this->db->transRollback();
            return false;
        }
    }







    // Método genérico para buscar por cédula
    public function findByCedula($cedula, $type = 'docente')
    {
        $this->setTableAndValidation($type);
        try {
            // Resetear el Query Builder para que use la nueva tabla
            $this->builder = $this->db->table($this->table);

            return $this->where('cedula', $cedula)->first();
        } catch (Exception $e) {
            return null;
        }
    }


    

    // Método genérico para asociar con PIS
    public function associateWithPIS($participanteId, $pisId, $type = 'docente')
    {
        $pivotTable = $type === 'estudiante' ? 'pis_estudiantes' : 'pis_docentes';
        $participanteColumn = $type === 'estudiante' ? 'estudiante_id' : 'docente_id';

        try {
            return $this->db->table($pivotTable)->insert([
                'proyecto_id' => $pisId,
                $participanteColumn => $participanteId
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Método genérico para verificar si está en PIS
    public function isInPIS($pisId, $participanteId, $type = 'docente')
    {
        $pivotTable = $type === 'estudiante' ? 'pis_estudiantes' : 'pis_docentes';
        $participanteColumn = $type === 'estudiante' ? 'estudiante_id' : 'docente_id';

        try {
            return $this->db->table($pivotTable)
                        ->where('proyecto_id', $pisId)
                        ->where($participanteColumn, $participanteId)
                        ->countAllResults() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    // Método genérico para verificar límite
    public function hasReachedLimit($pisId, $type = 'docente')
    {
        $pivotTable = $type === 'estudiante' ? 'pis_estudiantes' : 'pis_docentes';
        $limit = $type === 'estudiante' ? 30 : 10;

        try {
            $count = $this->db->table($pivotTable)
                            ->where('proyecto_id', $pisId)
                            ->countAllResults();
            return $count >= $limit;
        } catch (Exception $e) {
            return true;
        }
    }

    // Método genérico para obtener participantes por PIS
    public function getByPIS($pisId, $type = 'docente')
    {
        $this->setTableAndValidation($type);
        $pivotTable = $type === 'estudiante' ? 'pis_estudiantes' : 'pis_docentes';
        $participanteColumn = $type === 'estudiante' ? 'estudiante_id' : 'docente_id';

        try {
            return $this->db->table($this->table)
                        ->select($this->table . '.*, ' . $pivotTable . '.id as pis_participante_id')
                        ->join($pivotTable, $pivotTable . '.' . $participanteColumn . ' = ' . $this->table . '.id')
                        ->where($pivotTable . '.proyecto_id', $pisId)
                        ->get()
                        ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }















    /**
     * Método para crear y asociar múltiples participantes de diferentes tipos
     */
    public function createAndAssociateMultiple($data, $pisId)
    {
        $this->db->transBegin();
        $insertados = [
            'docentes' => [],
            'estudiantes' => []
        ];

        try {
            // Procesar docentes
            if (!empty($data['docentes'])) {
                foreach ($data['docentes'] as $docente) {
                    if (!empty($docente['nombre']) && !empty($docente['cedula'])) {
                        $docenteExistente = $this->findByCedula($docente['cedula'], 'docente');
                        
                        if ($docenteExistente) {
                            if (!$this->isInPIS($pisId, $docenteExistente['id'], 'docente')) {
                                $this->associateWithPIS($docenteExistente['id'], $pisId, 'docente');
                            }
                            $insertados['docentes'][] = $docenteExistente['id'];
                        } else {
                            $docenteId = $this->createAndAssociate($docente, $pisId, 'docente');
                            if ($docenteId) {
                                $insertados['docentes'][] = $docenteId;
                            }
                        }
                    }
                }
            }

            // Procesar estudiantes
            if (!empty($data['estudiantes'])) {
                foreach ($data['estudiantes'] as $estudiante) {
                    if (!empty($estudiante['nombre']) && !empty($estudiante['cedula'])) {
                        $estudianteExistente = $this->findByCedula($estudiante['cedula'], 'estudiante');
                        
                        if ($estudianteExistente) {
                            if (!$this->isInPIS($pisId, $estudianteExistente['id'], 'estudiante')) {
                                $this->associateWithPIS($estudianteExistente['id'], $pisId, 'estudiante');
                            }
                            $insertados['estudiantes'][] = $estudianteExistente['id'];
                        } else {
                            $estudianteId = $this->createAndAssociate($estudiante, $pisId, 'estudiante');
                            if ($estudianteId) {
                                $insertados['estudiantes'][] = $estudianteId;
                            }
                        }
                    }
                }
            }

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return false;
            }

            $this->db->transCommit();
            return $insertados;

        } catch (Exception $e) {
            $this->db->transRollback();
            return false;
        }
    }

    /**
     * Método para verificar límites para ambos tipos
     */
    public function hasReachedAnyLimit($pisId)
    {
        return [
            'docentes' => $this->hasReachedLimit($pisId, 'docente'),
            'estudiantes' => $this->hasReachedLimit($pisId, 'estudiante')
        ];
    }

    /**
     * Método para obtener todos los participantes de un PIS
     */
    public function getAllParticipantesByPIS($pisId)
    {
        return [
            'docentes' => $this->getByPIS($pisId, 'docente'),
            'estudiantes' => $this->getByPIS($pisId, 'estudiante')
        ];
    }







    /**
     * Elimina todos los participantes asociados a un PIS
    */
    public function deleteParticipantesByPIS($pisId)
    {
        try {
            // Eliminar docentes asociados
            $result1 = $this->db->table('pis_docentes')
                            ->where('proyecto_id', $pisId)
                            ->delete();
            
            // Eliminar estudiantes asociados
            $result2 = $this->db->table('pis_estudiantes')
                            ->where('proyecto_id', $pisId)
                            ->delete();

            return [
                'success' => true,
                'message' => 'Participantes eliminados exitosamente'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => 'Error al eliminar los participantes'
            ];
        }
    }



























    //METODO NECESARIO PARA LOS REPORTES PIS.
    /**
     * Obtiene el primer participante o participantes ingresados para un proyecto específico
     * 
     * @param int $pisId ID del proyecto
     * @param string $tipo Tipo de participante ('Docente', 'Estudiante', 'Docente/Estudiante')
     * @return array|null Datos del(los) participante(s) o null si no se encuentra
    */
    public function getFirstParticipante($pisId, $tipo)
    {
        try {
            // Para cuando el tipo es 'Docente/Estudiante'
            if ($tipo === 'Docente/Estudiante') {
                $primerDocente = $this->db->table('pis_docentes')
                    ->select('docentes.*')
                    ->join('docentes', 'docentes.id = pis_docentes.docente_id')
                    ->where('pis_docentes.proyecto_id', $pisId)
                    ->orderBy('pis_docentes.created_at', 'ASC')
                    ->limit(1)
                    ->get()
                    ->getRowArray();

                $primerEstudiante = $this->db->table('pis_estudiantes')
                    ->select('estudiantes.*')
                    ->join('estudiantes', 'estudiantes.id = pis_estudiantes.estudiante_id')
                    ->where('pis_estudiantes.proyecto_id', $pisId)
                    ->orderBy('pis_estudiantes.created_at', 'ASC')
                    ->limit(1)
                    ->get()
                    ->getRowArray();

                return [
                    'docente' => $primerDocente,
                    'estudiante' => $primerEstudiante
                ];
            }

            // Para cuando el tipo es solo 'Docente'
            if ($tipo === 'Docente') {
                return $this->db->table('pis_docentes')
                    ->select('docentes.*')
                    ->join('docentes', 'docentes.id = pis_docentes.docente_id')
                    ->where('pis_docentes.proyecto_id', $pisId)
                    ->orderBy('pis_docentes.created_at', 'ASC')
                    ->limit(1)
                    ->get()
                    ->getRowArray();
            }

            // Para cuando el tipo es solo 'Estudiante'
            if ($tipo === 'Estudiante') {
                return $this->db->table('pis_estudiantes')
                    ->select('estudiantes.*')
                    ->join('estudiantes', 'estudiantes.id = pis_estudiantes.estudiante_id')
                    ->where('pis_estudiantes.proyecto_id', $pisId)
                    ->orderBy('pis_estudiantes.created_at', 'ASC')
                    ->limit(1)
                    ->get()
                    ->getRowArray();
            }
            
            return null;
        } catch (Exception $e) {
            log_message('error', 'Error al obtener el primer participante ingresado: ' . $e->getMessage());
            return null;
        }
    }














}