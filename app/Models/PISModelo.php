<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class PISModelo extends Model
{
    protected $table            = 'proyectos_integradores_saberes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    protected $allowedFields    = [
        'nombre', 'codigo', 'tipo', 'objetivo', 'programa_id', 'estado',
        'linea_investigacion_carrera_id', 'facultad_entidad_area', 'fecha_inicio',
        'coordinador_director', 'fecha_fin_planificado', 'correo_coordinador',
        'fecha_fin_real', 'telefono_coordinador', 'campo_amplio_id',
        'campo_especifico_id', 'campo_detallado_id', 'alcance_territorial',
        'investigadores_acreditados', 'impacto_social', 'impacto_cientifico',
        'impacto_economico', 'impacto_politico', 'impacto_ambiental',
        'otro_impacto', 'fuente_financiamiento', 'descripcion_actividad',
        'parametro_cumplimiento', 'cooperacion', 'red', 'resultados_verificables',
        'anio', 'presupuesto_planificado', 'presupuesto_ejecutado',
        'tipo_participante', 'horas', 'publicaciones_id', 'proyecto_path',
        'poster_path'
    ];

    // Validaciones
    protected $validationRules = [
        'nombre' => 'required|min_length[3]',
        'codigo' => 'required|max_length[50]',
        'tipo' => 'required|in_list[Investigación,Vinculación,Investigación y Vinculación]',
        'objetivo' => 'required',
        'programa_id' => 'permit_empty|integer',
        'estado' => 'required|in_list[Finalizado,En Cierre,En Ejecución,Detenido,Cancelado]',
        'linea_investigacion_carrera_id' => 'permit_empty|integer',
        'facultad_entidad_area' => 'required|max_length[255]',
        'fecha_inicio' => 'required|valid_date',
        'coordinador_director' => 'required|max_length[255]',
        'fecha_fin_planificado' => 'required|valid_date',
        'correo_coordinador' => 'required|valid_email|max_length[100]',
        'fecha_fin_real' => 'permit_empty|valid_date',
        'telefono_coordinador' => 'required|numeric|min_length[7]|max_length[10]',
        'campo_amplio_id' => 'permit_empty|integer',
        'campo_especifico_id' => 'permit_empty|integer',
        'campo_detallado_id' => 'permit_empty|integer',
        'alcance_territorial' => 'required|in_list[Cantonal,Institucional,Internacional,Nacional,Parroquial,Provincial]',
        'investigadores_acreditados' => 'required|in_list[Si,No]',
        'impacto_social' => 'permit_empty',
        'impacto_cientifico' => 'permit_empty',
        'impacto_economico' => 'permit_empty',
        'impacto_politico' => 'permit_empty',
        'impacto_ambiental' => 'permit_empty',
        'otro_impacto' => 'permit_empty',
        'fuente_financiamiento' => [
            'rules' => 'required|in_list[Asignación Regular IES,Fondos Concursables Interno IES,Fondos Concursables Nacionales,Fondos Concursables Internacionales,Fondos No Concursables Internacionales,Fondos No Concursables Nacionales Externos a la IES,Otros]',
            'errors' => [
                'in_list' => 'La fuente de financiamiento seleccionada no es válida'
            ]
        ],
        'descripcion_actividad' => 'required',
        'parametro_cumplimiento' => [
            'rules' => 'required|in_list[Gasto Interno,Gasto Externo,Gasto de Capital,Gasto Interno Bruto en I + D + I,Gasto Nacional Bruto en I + D + I,Créditos Presupuestarios Públicos en I + D + I,Costos Salariales Personal  I +D + I]',
            'errors' => [
                'in_list' => 'El parámetro de cumplimiento seleccionado no es válido'
            ]
        ],
        'cooperacion' => 'required|in_list[Internacional,Nacional,Internacional y Nacional,No Aplica]',
        'red' => 'required|in_list[Internacional,Nacional,Internacional y Nacional,No Aplica]',
        'resultados_verificables' => 'required|in_list[Totales,Parciales,Sin Resultados]',
        'anio' => 'required|numeric|exact_length[4]|greater_than[1999]|less_than[2101]',
        'presupuesto_planificado' => 'required|numeric|greater_than[0]|decimal',
        'presupuesto_ejecutado' => 'required|numeric|greater_than_equal_to[0]|decimal',
        'tipo_participante' => 'required|in_list[Docente,Estudiante,Docente/Estudiante]',
        'horas' => 'required|integer|greater_than[0]',
        'publicaciones_id' => 'permit_empty|integer',
        'proyecto_path' => 'permit_empty',
        'poster_path' => 'permit_empty'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre es obligatorio',
            'min_length' => 'El nombre debe tener al menos 3 caracteres'
        ],
        'codigo' => [
            'required' => 'El código es obligatorio',
            'max_length' => 'El código no puede exceder los 50 caracteres'
        ],
        'tipo' => [
            'required' => 'El tipo de proyecto es obligatorio',
            'in_list' => 'El tipo de proyecto seleccionado no es válido'
        ],
        'objetivo' => [
            'required' => 'El objetivo es obligatorio'
        ],
        'estado' => [
            'required' => 'El estado es obligatorio',
            'in_list' => 'El estado seleccionado no es válido'
        ],
        'facultad_entidad_area' => [
            'required' => 'La facultad/entidad/área es obligatoria',
            'max_length' => 'La facultad/entidad/área no puede exceder los 255 caracteres'
        ],
        'fecha_inicio' => [
            'required' => 'La fecha de inicio es obligatoria',
            'valid_date' => 'La fecha de inicio debe ser una fecha válida'
        ],
        'coordinador_director' => [
            'required' => 'El coordinador/director es obligatorio',
            'max_length' => 'El nombre del coordinador/director no puede exceder los 255 caracteres'
        ],
        'fecha_fin_planificado' => [
            'required' => 'La fecha de fin planificada es obligatoria',
            'valid_date' => 'La fecha de fin planificada debe ser una fecha válida'
        ],
        'fecha_fin_real' => [
            'valid_date' => 'La fecha de fin real debe ser una fecha válida'
        ],
        'correo_coordinador' => [
            'required' => 'El correo del coordinador es obligatorio',
            'valid_email' => 'El correo debe tener un formato válido',
            'max_length' => 'El correo no puede exceder los 100 caracteres'
        ],
        'telefono_coordinador' => [
            'required' => 'El teléfono del coordinador es obligatorio',
            'numeric' => 'El teléfono debe contener solo números',
            'min_length' => 'El teléfono debe tener al menos 7 dígitos',
            'max_length' => 'El teléfono no puede exceder los 10 dígitos'
        ],
        'alcance_territorial' => [
            'required' => 'El alcance territorial es obligatorio',
            'in_list' => 'El alcance territorial seleccionado no es válido'
        ],
        'investigadores_acreditados' => [
            'required' => 'Debe indicar si hay investigadores acreditados',
            'in_list' => 'La opción seleccionada no es válida'
        ],
        'descripcion_actividad' => [
            'required' => 'La descripción de la actividad es obligatoria'
        ],
        'anio' => [
            'required' => 'El año es obligatorio',
            'numeric' => 'El año debe ser un número',
            'exact_length' => 'El año debe tener 4 dígitos',
            'greater_than' => 'El año debe ser posterior a 1999',
            'less_than' => 'El año debe ser anterior a 2101'
        ],
        'presupuesto_planificado' => [
            'required' => 'El presupuesto planificado es obligatorio',
            'numeric' => 'El presupuesto debe ser un número',
            'greater_than' => 'El presupuesto debe ser mayor a 0',
            'decimal' => 'El presupuesto debe ser un número decimal'
        ],
        'presupuesto_ejecutado' => [
            'required' => 'El presupuesto ejecutado es obligatorio',
            'numeric' => 'El presupuesto debe ser un número',
            'greater_than_equal_to' => 'El presupuesto debe ser 0 o mayor',
            'decimal' => 'El presupuesto debe ser un número decimal'
        ],
        'tipo_participante' => [
            'required' => 'El tipo de participante es obligatorio',
            'in_list' => 'El tipo de participante seleccionado no es válido'
        ],
        'horas' => [
            'required' => 'Las horas son obligatorias',
            'integer' => 'Las horas deben ser un número entero',
            'greater_than' => 'Las horas deben ser mayores a 0'
        ]
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $skipValidation = false;

    // Hook para convertir campos vacíos a NULL
    protected $beforeInsert = ['nullifyEmptyFields'];
    protected $beforeUpdate = ['nullifyEmptyFields'];

    protected function nullifyEmptyFields(array $data)
    {
        // Campos que pueden ser NULL
        $nullableFields = [
            'programa_id',
            'linea_investigacion_carrera_id',
            'campo_amplio_id',
            'campo_especifico_id',
            'campo_detallado_id',
            'fecha_fin_real',
            'impacto_social',
            'impacto_cientifico',
            'impacto_economico',
            'impacto_politico',
            'impacto_ambiental',
            'otro_impacto',
            'publicaciones_id',
            'proyecto_path',
            'poster_path'
        ];

        foreach ($nullableFields as $field) {
            if (array_key_exists($field, $data['data']) && empty($data['data'][$field])) {
                $data['data'][$field] = null;
            }
        }

        return $data;
    }

    // Métodos para obtener datos de las tablas relacionadas
    public function getProgramas()
    {
        try {
            $builder = $this->db->table('programas');
            return $builder->select('id, nombre_programa')
                          ->get()
                          ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getLineasInvestigacion()
    {
        try {
            $builder = $this->db->table('lineas_investigacion_carreras');
            return $builder->select('id, nombre_linea')
                          ->get()
                          ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCamposAmplios()
    {
        try {
            $builder = $this->db->table('campo_amplio');
            return $builder->select('id, nombre_amplio')
                          ->get()
                          ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCamposEspecificos($amplioId = null)
    {
        try {
            $builder = $this->db->table('campo_especifico');
            if ($amplioId) {
                $builder->where('amplio_id', $amplioId);
            }
            return $builder->select('id, nombre_especifico')
                          ->get()
                          ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCamposDetallados($especificoId = null)
    {
        try {
            $builder = $this->db->table('campo_detallado');
            if ($especificoId) {
                $builder->where('especifico_id', $especificoId);
            }
            return $builder->select('id, nombre_detallado')
                          ->get()
                          ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getProduccionesCientificas()
    {
        try {
            $builder = $this->db->table('produccion_cientifica_tecnica');
            return $builder->select('id, nombre')
                          ->get()
                          ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    // Método para obtener un proyecto con sus relaciones
    public function getProyectoConRelaciones($id)
    {
        try {
            $proyecto = $this->find($id);
            
            if ($proyecto) {
                // Obtener datos relacionados
                if ($proyecto['programa_id']) {
                    $programa = $this->db->table('programas')
                        ->where('id', $proyecto['programa_id'])
                        ->get()
                        ->getRowArray();
                    $proyecto['programa'] = $programa ? $programa['nombre_programa'] : null;
                }

                if ($proyecto['linea_investigacion_carrera_id']) {
                    $linea = $this->db->table('lineas_investigacion_carreras')
                        ->where('id', $proyecto['linea_investigacion_carrera_id'])
                        ->get()
                        ->getRowArray();
                    $proyecto['linea_investigacion'] = $linea ? $linea['nombre_linea'] : null;
                }

                if ($proyecto['campo_amplio_id']) {
                    $campoAmplio = $this->db->table('campo_amplio')
                        ->where('id', $proyecto['campo_amplio_id'])
                        ->get()
                        ->getRowArray();
                    $proyecto['campo_amplio'] = $campoAmplio ? $campoAmplio['nombre_amplio'] : null;
                }

                if ($proyecto['campo_especifico_id']) {
                    $campoEspecifico = $this->db->table('campo_especifico')
                        ->where('id', $proyecto['campo_especifico_id'])
                        ->get()
                        ->getRowArray();
                    $proyecto['campo_especifico'] = $campoEspecifico ? $campoEspecifico['nombre_especifico'] : null;
                }

                if ($proyecto['campo_detallado_id']) {
                    $campoDetallado = $this->db->table('campo_detallado')
                        ->where('id', $proyecto['campo_detallado_id'])
                        ->get()
                        ->getRowArray();
                    $proyecto['campo_detallado'] = $campoDetallado ? $campoDetallado['nombre_detallado'] : null;
                }

                if ($proyecto['publicaciones_id']) {
                    $publicacion = $this->db->table('produccion_cientifica_tecnica')
                        ->where('id', $proyecto['publicaciones_id'])
                        ->get()
                        ->getRowArray();
                    $proyecto['publicacion'] = $publicacion ? $publicacion['nombre'] : null;
                }
            }

            return $proyecto;
        } catch (Exception $e) {
            return null;
        }
    }

    // Método para obtener todos los proyectos con sus relaciones
    public function getAllProyectosConRelaciones()
    {
        try {
            $proyectos = $this->findAll();
            
            foreach ($proyectos as &$proyecto) {
                if ($proyecto['programa_id']) {
                    $programa = $this->db->table('programas')
                        ->where('id', $proyecto['programa_id'])
                        ->get()
                        ->getRowArray();
                    $proyecto['programa'] = $programa ? $programa['nombre_programa'] : null;
                }

                if ($proyecto['linea_investigacion_carrera_id']) {
                    $linea = $this->db->table('lineas_investigacion_carreras')
                        ->where('id', $proyecto['linea_investigacion_carrera_id'])
                        ->get()
                        ->getRowArray();
                    $proyecto['linea_investigacion'] = $linea ? $linea['nombre_linea'] : null;
                }
                
                // ... más relaciones si son necesarias
            }

            return $proyectos;
        } catch (Exception $e) {
            return [];
        }
    }




    //Metodo para obtener las opciones de los enunciados
    public function getEnumValues($field)
    {
        try {
            $query = $this->db->query("SHOW COLUMNS FROM {$this->table} WHERE Field = ?", [$field]);
            $row = $query->getRow();
            if ($row) {
                // Extraer valores del enum
                preg_match("/^enum\(\'(.*)\'\)$/", $row->Type, $matches);
                $values = explode("','", $matches[1]);
                return $values;
            }
            return [];
        } catch (Exception $e) {
            return [];
        }
    }





    // Método para obtener todos los enums de la tabla
    public function getAllEnums()
    {
        try {
            return [
                'tipo' => $this->getEnumValues('tipo'),
                'estado' => $this->getEnumValues('estado'),
                'alcance_territorial' => $this->getEnumValues('alcance_territorial'),
                'investigadores_acreditados' => $this->getEnumValues('investigadores_acreditados'),
                'fuente_financiamiento' => $this->getEnumValues('fuente_financiamiento'),
                'parametro_cumplimiento' => $this->getEnumValues('parametro_cumplimiento'),
                'cooperacion' => $this->getEnumValues('cooperacion'),
                'red' => $this->getEnumValues('red'),
                'resultados_verificables' => $this->getEnumValues('resultados_verificables'),
                'tipo_participante' => $this->getEnumValues('tipo_participante')
            ];
        } catch (Exception $e) {
            return [];
        }
    }











    //Metodos para hacer el crud de las lineas de investigacion.
    public function getLineasConCarrera()
    {
        try {
            return $this->db->table('lineas_investigacion_carreras')
                        ->select('lineas_investigacion_carreras.*, careers.name as carrera_nombre')
                        ->join('careers', 'careers.id = lineas_investigacion_carreras.carrera_id', 'left')
                        ->get()
                        ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getLineaInvestigacion($id)
    {
        try {
            return $this->db->table('lineas_investigacion_carreras')
                        ->where('id', $id)
                        ->get()
                        ->getRowArray();
        } catch (Exception $e) {
            return null;
        }
    }

    public function createLineaInvestigacion($data)
    {
        try {
            return $this->db->table('lineas_investigacion_carreras')
                        ->insert($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateLineaInvestigacion($id, $data)
    {
        try {
            return $this->db->table('lineas_investigacion_carreras')
                        ->where('id', $id)
                        ->update($data);
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteLineaInvestigacion($id)
    {
        try {
            // Verificar si la línea está siendo usada
            $proyectosRelacionados = $this->db->table('proyectos_integradores_saberes')
                                            ->where('linea_investigacion_carrera_id', $id)
                                            ->countAllResults();
                                            
            if ($proyectosRelacionados > 0) {
                return false;
            }

            return $this->db->table('lineas_investigacion_carreras')
                        ->where('id', $id)
                        ->delete();
        } catch (Exception $e) {
            return false;
        }
    }

    public function isLineaEnUso($id)
    {
        try {
            return $this->db->table('proyectos_integradores_saberes')
                        ->where('linea_investigacion_carrera_id', $id)
                        ->countAllResults() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getCareers()
    {
        try {
            return $this->db->table('careers')
                        ->select('id, name')
                        ->get()
                        ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }













}