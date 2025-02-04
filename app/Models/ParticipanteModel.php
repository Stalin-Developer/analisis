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

    // Método genérico para crear y asociar participante
    public function createAndAssociate($data, $pisId, $type = 'docente')
    {
        $this->setTableAndValidation($type);
        $this->db->transBegin();

        try {
            // Primero insertamos el participante
            $participanteId = $this->insert($data);
            $pivotTable = $type === 'estudiante' ? 'pis_estudiantes' : 'pis_docentes';
            $participanteColumn = $type === 'estudiante' ? 'estudiante_id' : 'docente_id';

            if ($participanteId && $pisId) {
                // Lo asociamos al PIS
                $this->db->table($pivotTable)->insert([
                    'proyecto_id' => $pisId,
                    $participanteColumn => $participanteId
                ]);
            }

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return false;
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
}