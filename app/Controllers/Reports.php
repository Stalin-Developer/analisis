<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\CategoryModel;
use App\Models\CareerModel;
use App\Models\AcademicPeriodModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Reports extends BaseController
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
            'selected_category' => $category_id,
            'selected_career' => $career_id,
            'selected_year' => $year,
            'selected_period' => $period_id
        ];
        
        return view('reports/index', $data);
    }





    public function showReports()
    {
        return view('reports/showReports');
    }







    private function getYearsList()
    {
        $years = $this->documentModel->select('DISTINCT(publication_year) as year')
            ->orderBy('publication_year', 'DESC')
            ->findAll();
        
        return array_column($years, 'year');
    }








    public function generate()
    {
        // Obtener IDs de documentos seleccionados
        $selectedIds = $this->request->getPost('selected_docs');
        
        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Debe seleccionar al menos un documento para generar el reporte');
        }

        // Obtener documentos seleccionados
        $documents = $this->documentModel->select('documents.*, categories.name as category_name, careers.name as career_name, academic_periods.name as period_name')
            ->join('categories', 'categories.id = documents.category_id')
            ->join('careers', 'careers.id = documents.career_id')
            ->join('academic_periods', 'academic_periods.id = documents.academic_period_id')
            ->whereIn('documents.id', $selectedIds)
            ->findAll();

        // Preparar datos para la vista
        $data = [
            'documents' => $documents,
            'deparment' => 'DEPARTAMENTO DE INVESTIGACIÓN',
            'reportTitle' => 'Reporte de Documentos',
            'filterInfo' => ['Total de documentos: ' . count($documents)],
            'generated_date' => date('Y-m-d H:i:s')
        ];

        // Generar PDF
        $html = view('reports/template', $data);
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true); // Permitir acceso remoto para cargar imágenes

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();




        // Generar nombre del archivo
        $filename = 'Reporte_Documentos_' . date('Y-m-d_H-i-s') . '.pdf';
        

        // Descargar PDF
        return $this->response->setHeader('Content-Type', 'application/pdf')
                             ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                             ->setBody($dompdf->output());
    }
}