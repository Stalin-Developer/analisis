<?php

namespace App\Controllers;

use App\Models\TrabajoTitulacionModel;
use App\Models\CareerModel;
use App\Models\AcademicPeriodModel;
use App\Models\YearModel;
use App\Models\MesModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportesTDT extends BaseController
{
    protected $tdtModel;
    protected $careerModel;
    protected $academicPeriodModel;
    protected $yearModel;
    protected $mesModel;

    public function __construct()
    {
        $this->tdtModel = new TrabajoTitulacionModel();
        $this->careerModel = new CareerModel();
        $this->academicPeriodModel = new AcademicPeriodModel();
        $this->yearModel = new YearModel();
        $this->mesModel = new MesModel();
    }

    public function index()
    {
        $career_id = $this->request->getGet('career_id');
        $year_id = $this->request->getGet('year_id');
        $period_id = $this->request->getGet('period_id');
        $mes_id = $this->request->getGet('mes_id');

        // Construir la consulta base
        $query = $this->tdtModel->select('trabajos_de_titulacion.*, careers.name as career_name, academic_periods.name as period_name, meses.mes as mes_name, year.anio as year_value')
        ->join('careers', 'careers.id = trabajos_de_titulacion.career_id')
        ->join('academic_periods', 'academic_periods.id = trabajos_de_titulacion.academic_period_id')
        ->join('meses', 'meses.id = trabajos_de_titulacion.mes_id')
        ->join('year', 'year.id = trabajos_de_titulacion.year_id')
        ->orderBy('trabajos_de_titulacion.created_at', 'DESC')
        ->limit(100);

        // Aplicar filtros si existen
        if ($career_id) {
            $query->where('trabajos_de_titulacion.career_id', $career_id);
        }
        if ($year_id) {
            $query->where('trabajos_de_titulacion.year_id', $year_id);
        }
        if ($period_id) {
            $query->where('trabajos_de_titulacion.academic_period_id', $period_id);
        }
        if ($mes_id) {
            $query->where('trabajos_de_titulacion.mes_id', $mes_id);
        }

        $data = [
            'documents' => $query->findAll(),
            'careers' => $this->careerModel->findAll(),
            'periods' => $this->academicPeriodModel->findAll(),
            'years' => $this->yearModel->findAll(),
            'meses' => $this->mesModel->findAll(),
            'selected_career' => $career_id,
            'selected_year' => $year_id,
            'selected_period' => $period_id,
            'selected_mes' => $mes_id
        ];
        
        return view('reports/ViewTDT', $data);
    }

    public function generate()
    {
        // Obtener IDs de documentos seleccionados
        $selectedIds = $this->request->getPost('selected_docs');
        
        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Debe seleccionar al menos un trabajo de titulación para generar el reporte');
        }

        // Obtener documentos seleccionados
        $documents = $this->tdtModel->select('trabajos_de_titulacion.*, careers.name as career_name, academic_periods.name as period_name, meses.mes as mes_name, year.anio as year_value')
            ->join('careers', 'careers.id = trabajos_de_titulacion.career_id')
            ->join('academic_periods', 'academic_periods.id = trabajos_de_titulacion.academic_period_id')
            ->join('meses', 'meses.id = trabajos_de_titulacion.mes_id')
            ->join('year', 'year.id = trabajos_de_titulacion.year_id')
            ->whereIn('trabajos_de_titulacion.id', $selectedIds)
            ->orderBy('trabajos_de_titulacion.created_at', 'DESC')  // Añadido el orderBy
            ->findAll();

        // Preparar datos para la vista
        $data = [
            'documents' => $documents,
            'department' => 'DEPARTAMENTO DE INVESTIGACIÓN',
            'reportTitle' => 'Reporte de Trabajos de Titulación',
            'filterInfo' => ['Total de trabajos: ' . count($documents)],
            'generated_date' => date('Y-m-d H:i:s')
        ];

        // Generar PDF
        $html = view('reports/template_tdt', $data);
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Reporte_TDT_' . date('Y-m-d_H-i-s') . '.pdf';

        return $this->response->setHeader('Content-Type', 'application/pdf')
                             ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                             ->setBody($dompdf->output());
    }
}