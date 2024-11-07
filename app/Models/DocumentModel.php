<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table            = 'documents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'career_id',
        'academic_period_id',
        'title',
        'authors',
        'publication_year',
        'summary',
        'pdf_path'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'category_id'        => 'required|numeric|is_natural_no_zero',
        'career_id'          => 'required|numeric|is_natural_no_zero',
        'academic_period_id' => 'required|numeric|is_natural_no_zero',
        'title'             => 'required|min_length[3]|max_length[255]',
        'authors'           => 'required',
        'publication_year'   => 'required|numeric|exact_length[4]|greater_than[1900]|less_than[2100]',
        'summary'           => 'permit_empty|max_length[1000]',
        'pdf_path'          => 'required'

    ];
    protected $validationMessages   = [
        'category_id' => [
            'required' => 'Debe seleccionar una categoría'
        ],
        'career_id' => [
            'required' => 'Debe seleccionar una carrera'
        ],
        'academic_period_id' => [
            'required' => 'Debe seleccionar un periodo académico'
        ],
        'title' => [
            'required' => 'El título es obligatorio',
            'min_length' => 'El título debe tener al menos 3 caracteres'
        ],
        'authors' => [
            'required' => 'Debe ingresar los autores'
        ],
        'publication_year' => [
            'required' => 'El año de publicación es obligatorio',
            'numeric' => 'El año debe ser un número',
            'exact_length' => 'El año debe tener 4 dígitos',
            'greater_than' => 'El año debe ser mayor a 1900',
            'less_than' => 'El año debe ser menor a 2100'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];



    // Relationships
    public function category()
    {
        return $this->belongsTo('App\Models\CategoryModel', 'category_id', 'id');
    }

    public function career()
    {
        return $this->belongsTo('App\Models\CareerModel', 'career_id', 'id');
    }

    public function academic_period()
    {
        return $this->belongsTo('App\Models\AcademicPeriodModel', 'academic_period_id', 'id');
    }


}
