<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\CategoryModel;
use App\Models\CareerModel;
use App\Models\AcademicPeriodModel;

class Publico extends BaseController
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

        // Obtener datos para los filtros
        $data = [
            'documents' => $query->paginate(10),
            'pager' => $query->pager,
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

        return view('publico/index', $data); // Cambiado de 'public/index' a 'publico/index'
    }

    public function view($id)
    {
        $document = $this->documentModel->select('documents.*, categories.name as category_name, careers.name as career_name, academic_periods.name as period_name')
            ->join('categories', 'categories.id = documents.category_id')
            ->join('careers', 'careers.id = documents.career_id')
            ->join('academic_periods', 'academic_periods.id = documents.academic_period_id')
            ->find($id);

        if (!$document) {
            return redirect()->to('/publico')->with('error', 'Documento no encontrado'); // Cambiado de '/public' a '/publico'
        }

        return view('publico/view', ['document' => $document]); // Cambiado de 'public/view' a 'publico/view'
    }

    private function getYearsList()
    {
        // Obtener años únicos de los documentos
        $years = $this->documentModel->select('DISTINCT(publication_year) as year')
            ->orderBy('publication_year', 'DESC')
            ->findAll();
        
        return array_column($years, 'year');
    }
}