<?php

namespace App\Controllers;

use App\Models\TrabajoTitulacionModel;
use App\Models\CareerModel;
use App\Models\YearModel;
use App\Models\MesModel;
use App\Models\AcademicPeriodModel;

class TrabajosTitulacion extends BaseController
{
    protected $trabajoModel;
    protected $careerModel;
    protected $yearModel;
    protected $mesModel;
    protected $academicPeriodModel;

    public function __construct()
    {
        $this->trabajoModel = new TrabajoTitulacionModel();
        $this->careerModel = new CareerModel();
        $this->yearModel = new YearModel();
        $this->mesModel = new MesModel();
        $this->academicPeriodModel = new AcademicPeriodModel();
    }

    public function index()
    {
        $career_id = $this->request->getGet('career_id');
        $year_id = $this->request->getGet('year_id');
        $mes_id = $this->request->getGet('mes_id');
        $period_id = $this->request->getGet('period_id');

        // Construir la consulta base
        $query = $this->trabajoModel->select('trabajos_de_titulacion.*, careers.name as career_name, academic_periods.name as period_name, year.anio as anio')
            ->join('careers', 'careers.id = trabajos_de_titulacion.career_id')
            ->join('academic_periods', 'academic_periods.id = trabajos_de_titulacion.academic_period_id')
            ->join('year', 'year.id = trabajos_de_titulacion.year_id')
            ->join('meses', 'meses.id = trabajos_de_titulacion.mes_id')
            ->orderBy('trabajos_de_titulacion.created_at', 'DESC')  // Ordenar por fecha de creación descendente
            ->limit(100);  // Opcional: limitar a 100 registros

        // Aplicar filtros si existen
        //Los filtros siguen formando parte del query.
        if ($career_id) {
            $query->where('trabajos_de_titulacion.career_id', $career_id);
        }
        if ($year_id) {
            $query->where('trabajos_de_titulacion.year_id', $year_id);
        }
        if ($mes_id) {
            $query->where('trabajos_de_titulacion.mes_id', $mes_id);
        }
        if ($period_id) {
            $query->where('trabajos_de_titulacion.academic_period_id', $period_id);
        }

        $data = [
            'trabajos' => $query->findAll(),
            'careers' => $this->careerModel->findAll(),
            'years' => $this->yearModel->findAll(),
            'meses' => $this->mesModel->findAll(),
            'periods' => $this->academicPeriodModel->findAll(),
            // Mantener los filtros seleccionados
            'selected_career' => $career_id,
            'selected_year' => $year_id,
            'selected_mes' => $mes_id,
            'selected_period' => $period_id
        ];
        
        return view('tdt/index', $data);
    }

    public function new()
    {
        $data = [
            'careers' => $this->careerModel->findAll(),
            'meses' => $this->mesModel->findAll(),
            'academic_periods' => $this->academicPeriodModel->findAll()
        ];
        
        return view('tdt/create', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            // Obtener los archivos
            $documento = $this->request->getFile('documento_path');
            

            // Validar que sean PDFs válidos
            if ($documento->isValid() && !$documento->hasMoved() && 
                $documento->getClientMimeType() === 'application/pdf') {
                
                // Generar nombre único para el documento
                $documentoName = $documento->getRandomName();

                // Crear directorio si no existe
                $uploadPath = 'uploads/trabajos_titulacion/' . date('Y') . '/' . date('m');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Mover el documento
                if ($documento->move($uploadPath, $documentoName)) {
                    
                    // Preparar datos para guardar
                    $data = $this->request->getPost();
                    $data['documento_path'] = $uploadPath . '/' . $documentoName;
                    
                    //He creado lo del poster en tdt, pero estos van en pis. Nos los elimino porque me pueden servir para el pis.
                    // Procesar el póster solo si se subió uno
                    // if ($poster->isValid() && !$poster->hasMoved() && 
                    //     $poster->getClientMimeType() === 'application/pdf') {
                    //     $posterName = $poster->getRandomName();

                    //     //Mover el poster.
                    //     if ($poster->move($uploadPath, $posterName)) {
                    //         $data['poster_path'] = $uploadPath . '/' . $posterName;
                    //     }
                    // } else {
                    //     // Si no hay póster, establecer como NULL
                    //     $data['poster_path'] = NULL;
                    // }



                    // En el método create() del controlador, antes de guardar en trabajos_de_titulacion
                    $year = $this->request->getPost('year');
                    $yearModel = new \App\Models\YearModel();

                    // Buscar si el año ya existe
                    $existingYear = $yearModel->where('anio', $year)->first();

                    if ($existingYear) {
                        // Si existe, usar su ID
                        $data['year_id'] = $existingYear['id'];
                    } else {
                        // Si no existe, crear nuevo registro
                        $yearData = ['anio' => $year];
                        $yearModel->insert($yearData);
                        $data['year_id'] = $yearModel->getInsertID();
                    }

                    // Eliminar el campo 'year' ya que usaremos year_id
                    unset($data['year']);




                    // Guardar en la base de datos
                    if ($this->trabajoModel->save($data)) {
                        return redirect()->to('/trabajos-titulacion')
                            ->with('message', 'Trabajo de titulación guardado exitosamente');
                    } else {
                        // Eliminar el documento si falla el guardado
                        unlink($uploadPath . '/' . $documentoName);
                        // Eliminar el póster si existe y falla el guardado
                        if (isset($data['poster_path']) && file_exists($data['poster_path'])) {
                            unlink($data['poster_path']);
                        }
                        return redirect()->back()
                            ->with('errors', $this->trabajoModel->errors())
                            ->withInput();
                    }
                }
            }

            return redirect()->back()
                ->with('error', 'Error al subir los archivos. Asegúrese de que sean PDFs válidos.')
                ->withInput();
        }
    }

    public function edit($id = null)
    {
        // Obtener el trabajo de titulación
        $trabajo = $this->trabajoModel->find($id);
        
        if (empty($trabajo)) {
            return redirect()->to('/trabajos-titulacion')
                ->with('error', 'Trabajo no encontrado');
        }

        // Obtener el año actual del trabajo
        $yearModel = new \App\Models\YearModel();
        $yearData = $yearModel->find($trabajo['year_id']);

        $data = [
            'trabajo' => $trabajo,
            'yearData' => $yearData,
            'careers' => $this->careerModel->findAll(),
            'meses' => $this->mesModel->findAll(),
            'academic_periods' => $this->academicPeriodModel->findAll()
        ];

        return view('tdt/edit', $data);
    }

    public function update($id = null)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            $oldTrabajo = $this->trabajoModel->find($id);



            // Manejar el año
            $year = $this->request->getPost('year');
            $yearModel = new \App\Models\YearModel();

            // Buscar si el año ya existe
            $existingYear = $yearModel->where('anio', $year)->first();

            if ($existingYear) {
                // Si existe, usar su ID
                $data['year_id'] = $existingYear['id'];
            } else {
                // Si no existe, crear nuevo registro
                $yearData = ['anio' => $year];
                $yearModel->insert($yearData);
                $data['year_id'] = $yearModel->getInsertID();
            }

            // Eliminar el campo 'year' ya que usaremos year_id
            unset($data['year']);




            
            // Verificar si hay nuevos archivos
            $documento = $this->request->getFile('documento_path');
            //$poster = $this->request->getFile('poster_path');
            
 
            $uploadPath = 'uploads/trabajos_titulacion/' . date('Y') . '/' . date('m');

            // Procesar documento si se subió uno nuevo
            if ($documento->isValid() && !$documento->hasMoved() && 
                $documento->getClientMimeType() === 'application/pdf') {
                
                // Eliminar documento anterior
                if (file_exists($oldTrabajo['documento_path'])) {
                    unlink($oldTrabajo['documento_path']);
                }

                // Subir nuevo documento
                $documentoName = $documento->getRandomName();
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                if ($documento->move($uploadPath, $documentoName)) {
                    $data['documento_path'] = $uploadPath . '/' . $documentoName;
                }
            }

            //He creado lo del poster en tdt, pero estos van en pis. Nos los elimino porque me pueden servir para el pis.
            // Procesar póster si se subió uno nuevo
            // if ($poster->isValid() && !$poster->hasMoved() && 
            //     $poster->getClientMimeType() === 'application/pdf') {
                
            //     // Eliminar póster anterior
            //     if (file_exists($oldTrabajo['poster_path'])) {
            //         unlink($oldTrabajo['poster_path']);
            //     }

            //     // Subir nuevo póster
            //     $posterName = $poster->getRandomName();
            //     if (!is_dir($uploadPath)) {
            //         mkdir($uploadPath, 0777, true);
            //     }
            //     if ($poster->move($uploadPath, $posterName)) {
            //         $data['poster_path'] = $uploadPath . '/' . $posterName;
            //     }
            // }

            if ($this->trabajoModel->update($id, $data)) {
                return redirect()->to('/trabajos-titulacion')
                    ->with('message', 'Trabajo de titulación actualizado exitosamente');
            } else {
                return redirect()->back()
                    ->with('errors', $this->trabajoModel->errors())
                    ->withInput();
            }
        }
    }

    public function delete($id = null)
    {
        $trabajo = $this->trabajoModel->find($id);
        if ($trabajo) {
            // Eliminar archivos físicos
            if (file_exists($trabajo['documento_path'])) {
                unlink($trabajo['documento_path']);
            }
            
            
            // Eliminar registro de la base de datos
            if ($this->trabajoModel->delete($id)) {
                return redirect()->to('/trabajos-titulacion')
                    ->with('message', 'Trabajo de titulación eliminado exitosamente');
            }
        }
        
        return redirect()->to('/trabajos-titulacion')
            ->with('error', 'No se pudo eliminar el trabajo de titulación');
    }

    public function download($id = null)
    {
        $trabajo = $this->trabajoModel->find($id);
        if ($trabajo && file_exists($trabajo['documento_path'])) {
            return $this->response->download($trabajo['documento_path'], null);
        }
        
        return redirect()->to('/trabajos-titulacion')
            ->with('error', 'No se pudo descargar el documento');
    }

    

    //He creado lo del poster en tdt, pero estos van en pis. Nos los elimino porque me pueden servir para el pis.
    // public function downloadPoster($id = null)
    // {
    //     $trabajo = $this->trabajoModel->find($id);
    //     if ($trabajo && file_exists($trabajo['poster_path'])) {
    //         return $this->response->download($trabajo['poster_path'], null);
    //     }
        
    //     return redirect()->to('/trabajos-titulacion')
    //         ->with('error', 'No se pudo descargar el póster');
    // }




    //Funcion para extraer el texto de la primera pagina del tdt.
    public function extractText()
    {
        if ($this->request->getMethod() === 'POST') {
            $file = $this->request->getFile('pdf_file');
            
            if ($file->isValid() && !$file->hasMoved()) {
                try {
                    // Mover el archivo a una ubicación temporal
                    $file->move(WRITEPATH . 'temp', $file->getName());
                    $path = WRITEPATH . 'temp/' . $file->getName();

                    // Usar PDFParser
                    $parser = new \Smalot\PdfParser\Parser();
                    $pdf = $parser->parseFile($path);
                    
                    // Extraer texto de la primera página
                    $text = $pdf->getPages()[0]->getText();

                    
                    //Llamamos a la funcion processWithLlama, para recibir la respuesta del modelo y despues enviarlo a la vista.
                    $analysis = $this->processWithLlama($text);

                    


                    //Vamos a buscar y extraer el Resumen.
                    // Buscar el resumen entre las páginas 2 y 12
                    $abstract = '';
                    $totalPages = count($pdf->getPages());
                    //Si el documento tiene menos de 12 paginas, devolvera el total de paginas del documento.
                    $maxPage = min(12, $totalPages); 

                    // Iterar por pares de páginas hasta la página 12 o el máximo disponible
                    for ($i = 1; $i < min($maxPage - 1, 11); $i++) { // Empezamos desde la página 2 (índice 1)
                        // Obtener el texto de dos páginas consecutivas
                        $currentPageText = $pdf->getPages()[$i]->getText();
                        $nextPageText = $pdf->getPages()[$i + 1]->getText();
                        
                        // Combinar el texto de ambas páginas
                        $combinedText = $currentPageText . "\n" . $nextPageText;                        
                        
                        // Buscar las palabras clave y resumen
                        if (preg_match('/resumen\s*(.*?)\s*(palabras claves:|palabras clave:|palabra claves:|palabra clave:)/si', $combinedText, $matches)) {
                            //Se alamacenara el texto que se encuentra entre "Palabras Clave" y "Resumen".
                            $abstract = trim($matches[1]);
                            
                            break;
                        }


                    }




                    if ($abstract == ''){
                        //Continuar iterando para los casos en donde el autor no puso "Palabras clave:"
                        for ($i = 1; $i < min($maxPage - 1, 11); $i++) { // Empezamos desde la página 2 (índice 1)
                            // Obtener el texto de dos páginas consecutivas
                            $currentPageText = $pdf->getPages()[$i]->getText();
                            $nextPageText = $pdf->getPages()[$i + 1]->getText();
                            
                            // Combinar el texto de ambas páginas
                            $combinedText = $currentPageText . "\n" . $nextPageText;
                            
                            
                            
                            //Si no hay "Palabras clave:", buscar con otras posibles palabras que podrian estar al final del resumen.
                            if (preg_match('/^\s*resumen\s*$\s*(.*?)\s*(SUMMARY|ABSTRACT|Tabla de Contenido|CAPÍTULO I|Introducción)/smi', $combinedText, $matches)) {
                                //Se alamacenara el texto que se encuentra entre "Palabras Clave" y "Resumen".
                                $abstract = trim($matches[1]);

                                break;
                            }


                        }
                    }

                    

                    //Hacemos que llama haga un resumen incluso mas pequeno, de alrededor de 60 palabras.
                    if ($abstract == ''){
                        $resume= "Resumen no encontrado";
                    }else{
                        $resume = $this->resumeWithLlama($abstract);
                    }
                    


                    // Eliminar archivo temporal
                    unlink($path);



                    //Llamamos a la funcion que compara strings para hacer la comparacion con las carreras de la base de datos.
                    $idCarrera= $this->compararCarreras($analysis);




                    return $this->response->setJSON([
                        'success' => true,                       
                        'analysis' => $analysis,
                        'resume' => $resume,
                        'idCarrera' => $idCarrera
                    ]);
                } catch (\Exception $e) {
                    return $this->response->setJSON([
                        'success' => false,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
        
        return $this->response->setJSON([
            'success' => false,
            'error' => 'Archivo inválido'
        ]);
    }







    private function processWithLlama($text)
    {
        $apiUrl = "https://api-inference.huggingface.co/models/meta-llama/Meta-Llama-3-8B-Instruct/v1/chat/completions";
        $apiKey = "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";


        try {
            $ch = curl_init($apiUrl);
            
            $payload = [
                'model' => 'meta-llama/Meta-Llama-3-8B-Instruct',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Identifique estos campos (título, línea de investigación, autor o autores, carrera, año de publicación, mes de publicación) en el siguiente texto:\n" . $text
                    ]
                ],
                'temperature' => 0.5,
                'max_tokens' => 2048,
                'top_p' => 0.7,
                'stream' => false
            ];

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $apiKey,
                    'Content-Type: application/json'
                ]
            ]);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            
            if (curl_errno($ch)) {
                throw new \Exception(curl_error($ch));
            }

            curl_close($ch);

            if ($http_code === 200) {
                $result = json_decode($response, true);
                return $result['choices'][0]['message']['content'] ?? '';
            } else {
                throw new \Exception('Error from API: ' . $response);
            }


        } catch (\Exception $e) {
            //log_message('error', 'Exception: ' . $e->getMessage());
            throw $e;
        }




    }








    private function resumeWithLlama($abstract)
    {
        $apiUrl = "https://api-inference.huggingface.co/models/meta-llama/Meta-Llama-3-8B-Instruct/v1/chat/completions";
        $apiKey = "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";


        try {
            $ch = curl_init($apiUrl);
            
            $payload = [
                'model' => 'meta-llama/Meta-Llama-3-8B-Instruct',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Resumir el siguiente texto a uno de alrededor de 60 palabras. Solo responder con el resumen solicitado:\n" . $abstract
                    ]
                ],
                'temperature' => 0.5,
                'max_tokens' => 2048,
                'top_p' => 0.7,
                'stream' => false
            ];

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $apiKey,
                    'Content-Type: application/json'
                ]
            ]);

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            
            if (curl_errno($ch)) {
                throw new \Exception(curl_error($ch));
            }

            curl_close($ch);

            if ($http_code === 200) {
                $result = json_decode($response, true);
                return $result['choices'][0]['message']['content'] ?? '';
            } else {
                throw new \Exception('Error from API: ' . $response);
            }


        } catch (\Exception $e) {
            //log_message('error', 'Exception: ' . $e->getMessage());
            throw $e;
        }




    }









    //Funcion para comparar carreras.
    private function compararCarreras($analysis)
    {
        if (preg_match('/\d+\.\s*(?:\*\*)?[Cc]arrera(?:\*\*)?[:*]\s*(.*?)(?=\n|$)/', $analysis, $matches)) {
            $carreraExtraida = trim($matches[1]);
            
            // Obtener todas las carreras de la base de datos
            $careers = $this->careerModel->findAll();
            
            // Crear array con carreras en minúsculas
            $carrerasMinusculas = array_map(function($career) {
                return strtolower($career['name']);
            }, $careers);
            
            // Convertir carrera extraída a minúsculas
            $carreraExtraidaMinusculas = strtolower($carreraExtraida);
            
            // Variables para guardar la mejor coincidencia
            $mejorPosicion = 0;
            $mejorPorcentaje = 0;
            
            // Comparar con cada carrera
            foreach($carrerasMinusculas as $index => $carrera) {
                $porcentajeActual = 0;
                similar_text($carreraExtraidaMinusculas, $carrera, $porcentajeActual);
                
                if($index === 0) {
                    $mejorPosicion = $index;
                    $mejorPorcentaje = $porcentajeActual;
                } else if($porcentajeActual > $mejorPorcentaje) {
                    $mejorPosicion = $index;
                    $mejorPorcentaje = $porcentajeActual;
                }
            }
            
            // Registrar en el log los resultados
            // log_message('debug', 'Comparación de carreras: ' . 
            //     'Carrera extraída: "' . $carreraExtraidaMinusculas . '" | ' .
            //     'Mejor coincidencia: "' . $carrerasMinusculas[$mejorPosicion] . '" | ' .
            //     'Posicion en el array: "' . $mejorPosicion . '" | ' .
            //     'Porcentaje de similitud: ' . $mejorPorcentaje . '%');

                
            
            // Retornar el ID de la carrera con mejor coincidencia si supera el 40%
            return $mejorPorcentaje > 40 ? $mejorPosicion+1 : 0;
        }
        
        return 0;


    }















}