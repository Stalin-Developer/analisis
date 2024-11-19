<?php

namespace App\Models;

use CodeIgniter\Model;

class YearModel extends Model
{
    protected $table            = 'year';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['anio'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'anio' => 'required|numeric|exact_length[4]|greater_than[1900]|less_than[2100]|is_unique[year.anio,id,{id}]'
    ];

    protected $validationMessages = [
        'anio' => [
            'required' => 'El año es obligatorio',
            'numeric' => 'El año debe ser un número',
            'exact_length' => 'El año debe tener 4 dígitos',
            'greater_than' => 'El año debe ser mayor a 1900',
            'less_than' => 'El año debe ser menor a 2100',
            'is_unique' => 'Este año ya existe en la base de datos'
        ]
    ];

    protected $skipValidation = false;

    // Obtener todos los años ordenados descendentemente
    public function getAllYears()
    {
        return $this->orderBy('anio', 'DESC')->findAll();
    }
}