<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ProduccionModel extends Model
{
    protected $table            = 'produccion_cientifica_tecnica';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    protected $allowedFields    = [
        'tipo', 'codigo', 'titulo', 'fecha_publicacion',
        'campo_amplio_id', 'campo_especifico_id', 'campo_detallado_id',
        'filiacion', 'tipo_articulo', 'base_datos_id', 'codigo_issn',
        'nombre_revista', 'estado', 'link_publicacion', 'link_revista',
        'intercultural', 'titulo_libro', 'total_capitulos_libro',
        'codigo_capitulo_isbn', 'editor_copilador', 'paginas',
        'codigo_libro_isbn', 'revisado_pares', 'tipo_apoyo_ies'
    ];

    protected $validationRules = [
        'tipo' => 'required|in_list[Artículo,Capítulo de Libro,Libro,Otro]',
        'codigo' => 'required|max_length[50]',
        'titulo' => 'required',
        'fecha_publicacion' => 'required|valid_date',
        'campo_amplio_id' => 'required|integer',
        'campo_especifico_id' => 'required|integer',
        'campo_detallado_id' => 'required|integer',
        'filiacion' => 'required|in_list[Sí,No]',
        'tipo_articulo' => 'permit_empty|in_list[Revista,Memoria de evento científico]',
        'base_datos_id' => 'permit_empty|integer',
        'codigo_issn' => 'permit_empty|max_length[50]',
        'nombre_revista' => 'permit_empty',
        'estado' => 'permit_empty|in_list[Publicado,Aceptado para publicación]',
        'link_publicacion' => 'permit_empty|valid_url_strict',
        'link_revista' => 'permit_empty|valid_url_strict',
        'intercultural' => 'permit_empty|in_list[Sí,No,No Registra]',
        'titulo_libro' => 'permit_empty',
        'total_capitulos_libro' => 'permit_empty|integer|greater_than[0]',
        'codigo_capitulo_isbn' => 'permit_empty|max_length[50]',
        'editor_copilador' => 'permit_empty|max_length[255]',
        'paginas' => 'permit_empty|max_length[50]',
        'codigo_libro_isbn' => 'permit_empty|max_length[50]',
        'revisado_pares' => 'permit_empty|in_list[Sí,No]',
        'tipo_apoyo_ies' => 'permit_empty'
    ];

    protected $validationMessages = [
        'tipo' => [
            'required' => 'El tipo es obligatorio',
            'in_list' => 'El tipo seleccionado no es válido'
        ],
        'codigo' => [
            'required' => 'El código es obligatorio',
            'max_length' => 'El código no puede exceder los 50 caracteres'
        ],
        'titulo' => [
            'required' => 'El título es obligatorio'
        ],
        'fecha_publicacion' => [
            'required' => 'La fecha de publicación es obligatoria',
            'valid_date' => 'La fecha de publicación debe ser una fecha válida'
        ],
        'campo_amplio_id' => [
            'required' => 'El campo amplio es obligatorio',
            'integer' => 'El campo amplio debe ser un número entero'
        ],
        'campo_especifico_id' => [
            'required' => 'El campo específico es obligatorio',
            'integer' => 'El campo específico debe ser un número entero'
        ],
        'campo_detallado_id' => [
            'required' => 'El campo detallado es obligatorio',
            'integer' => 'El campo detallado debe ser un número entero'
        ],
        'filiacion' => [
            'required' => 'La filiación es obligatoria',
            'in_list' => 'La opción de filiación seleccionada no es válida'
        ],
        'link_publicacion' => [
            'valid_url_strict' => 'El link de la publicación debe ser una URL válida'
        ],
        'link_revista' => [
            'valid_url_strict' => 'El link de la revista debe ser una URL válida'
        ],
        'total_capitulos_libro' => [
            'integer' => 'El total de capítulos debe ser un número entero',
            'greater_than' => 'El total de capítulos debe ser mayor a 0'
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
        $nullableFields = [
            'tipo_articulo', 'base_datos_id', 'codigo_issn',
            'nombre_revista', 'estado', 'link_publicacion',
            'link_revista', 'intercultural', 'titulo_libro',
            'total_capitulos_libro', 'codigo_capitulo_isbn',
            'editor_copilador', 'paginas', 'codigo_libro_isbn',
            'revisado_pares', 'tipo_apoyo_ies'
        ];

        foreach ($nullableFields as $field) {
            if (array_key_exists($field, $data['data']) && empty($data['data'][$field])) {
                $data['data'][$field] = null;
            }
        }

        return $data;
    }

    // Obtener opciones de enum
    public function getEnumValues($field)
    {
        try {
            $query = $this->db->query("SHOW COLUMNS FROM {$this->table} WHERE Field = ?", [$field]);
            $row = $query->getRow();
            if ($row) {
                preg_match("/^enum\(\'(.*)\'\)$/", $row->Type, $matches);
                $values = explode("','", $matches[1]);
                return $values;
            }
            return [];
        } catch (Exception $e) {
            return [];
        }
    }

    // Obtener todos los enums
    public function getAllEnums()
    {
        try {
            return [
                'tipo' => $this->getEnumValues('tipo'),
                'filiacion' => $this->getEnumValues('filiacion'),
                'tipo_articulo' => $this->getEnumValues('tipo_articulo'),
                'estado' => $this->getEnumValues('estado'),
                'intercultural' => $this->getEnumValues('intercultural'),
                'revisado_pares' => $this->getEnumValues('revisado_pares')
            ];
        } catch (Exception $e) {
            return [];
        }
    }

    // Obtener años disponibles para el filtro
    public function getYears()
    {
        try {
            return $this->select('YEAR(created_at) as year')
                    ->distinct()
                    ->orderBy('year', 'DESC')
                    ->get()
                    ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    // Obtener datos de la base de datos indexada
    public function getBaseDatos()
    {
        try {
            return $this->db->table('base_datos_indexada')
                        ->select('id, nombre')
                        ->get()
                        ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    // Obtener campos amplios
    public function getCamposAmplios()
    {
        try {
            return $this->db->table('campo_amplio')
                        ->select('id, nombre_amplio')
                        ->get()
                        ->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }

    // Obtener campos específicos según campo amplio
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

    // Obtener campos detallados según campo específico
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

    // Obtener una producción con sus relaciones
    public function getProduccionConRelaciones($id)
    {
        try {
            $produccion = $this->find($id);
            
            if ($produccion) {
                // Obtener campo amplio
                if ($produccion['campo_amplio_id']) {
                    $campoAmplio = $this->db->table('campo_amplio')
                        ->where('id', $produccion['campo_amplio_id'])
                        ->get()
                        ->getRowArray();
                    $produccion['campo_amplio'] = $campoAmplio ? $campoAmplio['nombre_amplio'] : null;
                }

                // Obtener campo específico
                if ($produccion['campo_especifico_id']) {
                    $campoEspecifico = $this->db->table('campo_especifico')
                        ->where('id', $produccion['campo_especifico_id'])
                        ->get()
                        ->getRowArray();
                    $produccion['campo_especifico'] = $campoEspecifico ? $campoEspecifico['nombre_especifico'] : null;
                }

                // Obtener campo detallado
                if ($produccion['campo_detallado_id']) {
                    $campoDetallado = $this->db->table('campo_detallado')
                        ->where('id', $produccion['campo_detallado_id'])
                        ->get()
                        ->getRowArray();
                    $produccion['campo_detallado'] = $campoDetallado ? $campoDetallado['nombre_detallado'] : null;
                }

                // Obtener base de datos indexada
                if ($produccion['base_datos_id']) {
                    $baseDatos = $this->db->table('base_datos_indexada')
                        ->where('id', $produccion['base_datos_id'])
                        ->get()
                        ->getRowArray();
                    $produccion['base_datos'] = $baseDatos ? $baseDatos['nombre'] : null;
                }
            }

            return $produccion;
        } catch (Exception $e) {
            return null;
        }
    }

    // Obtener una producción con sus participantes
    public function getProduccionWithParticipantes($id)
    {
        try {
            $produccion = $this->getProduccionConRelaciones($id);
            
            if ($produccion) {
                // Obtener participantes
                $participantes = $this->db->table('produccion_participantes')
                    ->select('participantes.*, produccion_participantes.tipo as rol')
                    ->join('participantes', 'participantes.id = produccion_participantes.participante_id')
                    ->where('produccion_participantes.produccion_id', $id)
                    ->get()
                    ->getResultArray();

                

                // En producción científica, solo puede haber autores O coautores, no ambos
                $primerParticipante = $participantes[0] ?? null;
                if ($primerParticipante) {
                    $tipo = $primerParticipante['rol'];
                    $produccion['participantes'] = [
                        'tipo' => $tipo,
                        'lista' => $participantes
                    ];
                } else {
                    $produccion['participantes'] = [
                        'tipo' => null,
                        'lista' => []
                    ];
                }


            }

            return $produccion;
        } catch (Exception $e) {
            return null;
        }
    }

    // Obtener todas las producciones con sus relaciones
    public function getAllProduccionesConRelaciones()
    {
        try {
            $builder = $this->db->table($this->table);
            $builder->select($this->table . '.*, 
                        campo_amplio.nombre_amplio,
                        campo_especifico.nombre_especifico,
                        campo_detallado.nombre_detallado,
                        base_datos_indexada.nombre as nombre_base_datos')
                    ->join('campo_amplio', 'campo_amplio.id = ' . $this->table . '.campo_amplio_id', 'left')
                    ->join('campo_especifico', 'campo_especifico.id = ' . $this->table . '.campo_especifico_id', 'left')
                    ->join('campo_detallado', 'campo_detallado.id = ' . $this->table . '.campo_detallado_id', 'left')
                    ->join('base_datos_indexada', 'base_datos_indexada.id = ' . $this->table . '.base_datos_id', 'left');

            return $builder->get()->getResultArray();
        } catch (Exception $e) {
            return [];
        }
    }






}