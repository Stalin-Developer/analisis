<?php

namespace App\Models;

use CodeIgniter\Model;

class TrabajoTitulacionModel extends Model
{
    protected $table            = 'trabajos_de_titulacion';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'career_id',
        'academic_period_id',
        'year_id',
        'mes_id',
        'titulo',
        'linea_investigacion',
        'autores',
        'resumen',
        'documento_path',
        'poster_path'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'career_id'           => 'required|numeric|is_natural_no_zero',
        'academic_period_id'  => 'required|numeric|is_natural_no_zero',
        'year_id'            => 'required|numeric|is_natural_no_zero',
        'mes_id'             => 'required|numeric|is_natural_no_zero',
        'titulo'             => 'required|min_length[3]|max_length[255]',
        'linea_investigacion'=> 'required|min_length[3]|max_length[255]',
        'autores'            => 'required',
        'resumen'            => 'permit_empty|max_length[1000]',
        'documento_path'     => 'required',
        'poster_path'        => 'permit_empty'
    ];

    protected $validationMessages = [
        'career_id' => [
            'required' => 'Debe seleccionar una carrera',
            'numeric' => 'ID de carrera inválido',
            'is_natural_no_zero' => 'ID de carrera inválido'
        ],
        'academic_period_id' => [
            'required' => 'Debe seleccionar un periodo académico',
            'numeric' => 'ID de periodo académico inválido',
            'is_natural_no_zero' => 'ID de periodo académico inválido'
        ],
        'year_id' => [
            'required' => 'Debe seleccionar un año',
            'numeric' => 'ID de año inválido',
            'is_natural_no_zero' => 'ID de año inválido'
        ],
        'mes_id' => [
            'required' => 'Debe seleccionar un mes',
            'numeric' => 'ID de mes inválido',
            'is_natural_no_zero' => 'ID de mes inválido'
        ],
        'titulo' => [
            'required' => 'El título es obligatorio',
            'min_length' => 'El título debe tener al menos 3 caracteres',
            'max_length' => 'El título no puede exceder los 255 caracteres'
        ],
        'linea_investigacion' => [
            'required' => 'La línea de investigación es obligatoria',
            'min_length' => 'La línea de investigación debe tener al menos 3 caracteres',
            'max_length' => 'La línea de investigación no puede exceder los 255 caracteres'
        ],
        'autores' => [
            'required' => 'Debe ingresar los autores'
        ],
        'resumen' => [
            'max_length' => 'El resumen no puede exceder los 1000 caracteres'
        ],
        'documento_path' => [
            'required' => 'El documento PDF es obligatorio'
        ],
        'poster_path' => [
            'required' => 'El póster es obligatorio'
        ]
    ];

    protected $skipValidation = false;

    // Relationships
    public function career()
    {
        return $this->belongsTo('App\Models\CareerModel', 'career_id', 'id');
    }

    public function academic_period()
    {
        return $this->belongsTo('App\Models\AcademicPeriodModel', 'academic_period_id', 'id');
    }

    public function year()
    {
        return $this->belongsTo('App\Models\YearModel', 'year_id', 'id');
    }

    public function mes()
    {
        return $this->belongsTo('App\Models\MesModel', 'mes_id', 'id');
    }
}