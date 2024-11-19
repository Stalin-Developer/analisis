<?php

namespace App\Models;

use CodeIgniter\Model;

class MesModel extends Model
{
    protected $table            = 'meses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['mes'];

    // Validation
    protected $validationRules = [
        'mes' => 'required|min_length[3]|max_length[50]|is_unique[meses.mes,id,{id}]'
    ];

    protected $validationMessages = [
        'mes' => [
            'required' => 'El mes es obligatorio',
            'min_length' => 'El nombre del mes debe tener al menos 3 caracteres',
            'max_length' => 'El nombre del mes no puede exceder los 50 caracteres',
            'is_unique' => 'Este mes ya existe en la base de datos'
        ]
    ];

    protected $skipValidation = false;

    // Obtener todos los meses ordenados por ID
    public function getAllMeses()
    {
        return $this->orderBy('id', 'ASC')->findAll();
    }
}