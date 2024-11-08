<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\CategoryModel;
use App\Models\CareerModel;
use App\Models\AcademicPeriodModel;

class Documents extends BaseController
{
    protected $documentModel;
    protected $categoryModel;
    protected $careerModel;
    protected $academicPeriodModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->categoryModel = new CategoryModel();
        $this->careerModel = new CareerModel();
        $this->academicPeriodModel = new AcademicPeriodModel();
    }

    public function index()
    {
        $category_id = $this->request->getGet('category_id');
        $career_id = $this->request->getGet('career_id');
        $year = $this->request->getGet('year');
        $period_id = $this->request->getGet('period_id');

        // Construir la consulta base
        $query = $this->documentModel->select('documents.*, categories.name as category_name, careers.name as career_name, academic_periods.name as period_name')
            ->join('categories', 'categories.id = documents.category_id')
            ->join('careers', 'careers.id = documents.career_id')
            ->join('academic_periods', 'academic_periods.id = documents.academic_period_id');

        // Aplicar filtros si existen
        if ($category_id) {
            $query->where('documents.category_id', $category_id);
        }
        if ($career_id) {
            $query->where('documents.career_id', $career_id);
        }
        if ($year) {
            $query->where('documents.publication_year', $year);
        }
        if ($period_id) {
            $query->where('documents.academic_period_id', $period_id);
        }

        
        $data = [
            'documents' => $query->findAll(),
            'categories' => $this->categoryModel->findAll(),
            'careers' => $this->careerModel->findAll(),
            'periods' => $this->academicPeriodModel->findAll(),
            'years' => $this->getYearsList(),
            // Mantener los filtros seleccionados
            'selected_category' => $category_id,
            'selected_career' => $career_id,
            'selected_year' => $year,
            'selected_period' => $period_id
        ];
        
        return view('documents/index', $data);
    }



    private function getYearsList()
    {
        // Obtener años únicos de los documentos
        $years = $this->documentModel->select('DISTINCT(publication_year) as year')
            ->orderBy('publication_year', 'DESC')
            ->findAll();
        
        return array_column($years, 'year');
    }










    public function new()
    {
        $data = [
            'categories' => $this->categoryModel->findAll(),
            'careers' => $this->careerModel->findAll(),
            'academic_periods' => $this->academicPeriodModel->findAll()
        ];
        
        return view('documents/create', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'POST') {
            // Obtener el archivo
            $pdf = $this->request->getFile('pdf_file');

            // Validar que sea un PDF válido
            if ($pdf->isValid() && !$pdf->hasMoved() && $pdf->getClientMimeType() === 'application/pdf') {
                // Generar un nombre único para el archivo
                $newName = $pdf->getRandomName();

                // Crear directorio si no existe
                $uploadPath = 'uploads/documents/' . date('Y') . '/' . date('m');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Mover el archivo
                if ($pdf->move($uploadPath, $newName)) {
                    // Preparar datos para guardar
                    $data = $this->request->getPost();
                    $data['pdf_path'] = $uploadPath . '/' . $newName;

                    // Guardar en la base de datos
                    if ($this->documentModel->save($data)) {
                        return redirect()->to('/documents')
                            ->with('message', 'Documento subido exitosamente');
                    } else {
                        unlink($uploadPath . '/' . $newName); // Eliminar archivo si falla el guardado
                        return redirect()->back()
                            ->with('errors', $this->documentModel->errors())
                            ->withInput();
                    }
                }
            }

            return redirect()->back()
                ->with('error', 'Error al subir el archivo. Asegúrese de que sea un PDF válido.')
                ->withInput();
        }
    }

    public function edit($id = null)
    {
        $data = [
            'document' => $this->documentModel->find($id),
            'categories' => $this->categoryModel->findAll(),
            'careers' => $this->careerModel->findAll(),
            'academic_periods' => $this->academicPeriodModel->findAll()
        ];
        
        if (empty($data['document'])) {
            return redirect()->to('/documents')->with('error', 'Documento no encontrado');
        }

        return view('documents/edit', $data);
    }

    public function update($id = null)
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();
            
            // Verificar si hay un nuevo archivo
            $pdf = $this->request->getFile('pdf_file');
            if ($pdf->isValid() && !$pdf->hasMoved() && $pdf->getClientMimeType() === 'application/pdf') {
                // Eliminar archivo anterior
                $oldDocument = $this->documentModel->find($id);
                if (file_exists($oldDocument['pdf_path'])) {
                    unlink($oldDocument['pdf_path']);
                }

                // Subir nuevo archivo
                $newName = $pdf->getRandomName();
                $uploadPath = 'uploads/documents/' . date('Y') . '/' . date('m');
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                if ($pdf->move($uploadPath, $newName)) {
                    $data['pdf_path'] = $uploadPath . '/' . $newName;
                }
            }

            if ($this->documentModel->update($id, $data)) {
                return redirect()->to('/documents')
                    ->with('message', 'Documento actualizado exitosamente');
            } else {
                return redirect()->back()
                    ->with('errors', $this->documentModel->errors())
                    ->withInput();
            }
        }
    }

    public function delete($id = null)
    {
        $document = $this->documentModel->find($id);
        if ($document) {
            // Eliminar archivo físico
            if (file_exists($document['pdf_path'])) {
                unlink($document['pdf_path']);
            }
            
            // Eliminar registro de la base de datos
            if ($this->documentModel->delete($id)) {
                return redirect()->to('/documents')
                    ->with('message', 'Documento eliminado exitosamente');
            }
        }
        
        return redirect()->to('/documents')
            ->with('error', 'No se pudo eliminar el documento');
    }

    public function download($id = null)
    {
        $document = $this->documentModel->find($id);
        if ($document && file_exists($document['pdf_path'])) {
            return $this->response->download($document['pdf_path'], null);
        }
        
        return redirect()->to('/documents')
            ->with('error', 'No se pudo descargar el documento');
    }
}