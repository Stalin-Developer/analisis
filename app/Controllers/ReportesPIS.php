<?php

namespace App\Controllers;

use App\Models\PISModelo;
use App\Models\ParticipanteModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;

class ReportesPIS extends BaseController
{
    protected $pisModel;
    protected $participanteModel;

    public function __construct()
    {
        $this->pisModel = new PISModelo();
        $this->participanteModel = new ParticipanteModel();
    }

    public function index()
    {
        $programa_id = $this->request->getGet('programa_id');
        $linea_id = $this->request->getGet('linea_id');
        $anio = $this->request->getGet('anio');

        // Construir la consulta base
        $builder = $this->pisModel->db->table('proyectos_integradores_saberes')
            ->select('proyectos_integradores_saberes.*, 
                programas.nombre_programa,
                lineas_investigacion_carreras.nombre_linea')
            ->join('programas', 'programas.id = proyectos_integradores_saberes.programa_id', 'left')
            ->join('lineas_investigacion_carreras', 
                'lineas_investigacion_carreras.id = proyectos_integradores_saberes.linea_investigacion_carrera_id', 'left')
            ->orderBy('proyectos_integradores_saberes.created_at', 'DESC');

        // Aplicar filtros
        if ($programa_id) {
            $builder->where('proyectos_integradores_saberes.programa_id', $programa_id);
        }
        if ($linea_id) {
            $builder->where('proyectos_integradores_saberes.linea_investigacion_carrera_id', $linea_id);
        }
        if ($anio) {
            $builder->where('proyectos_integradores_saberes.anio', $anio);
        }

        // Obtener proyectos y procesar participantes
        $proyectos = $builder->get()->getResultArray();
        foreach ($proyectos as &$proyecto) {
            $proyecto['participante'] = $this->getParticipanteInfo($proyecto['id'], $proyecto['tipo_participante']);
        }

        $data = [
            'proyectos' => $proyectos,
            'programas' => $this->pisModel->getProgramas(),
            'lineas' => $this->pisModel->getLineasInvestigacion(),
            'years' => $this->getYearsList(),
            'selected_programa' => $programa_id,
            'selected_linea' => $linea_id,
            'selected_anio' => $anio
        ];

        return view('reports/pis/index', $data);
    }

    private function getYearsList()
    {
        $years = $this->pisModel->select('DISTINCT(anio) as year')
            ->orderBy('anio', 'DESC')
            ->findAll();
        return array_column($years, 'year');
    }

    


    private function getParticipanteInfo($pisId, $tipoParticipante)
    {
        try {
            $info = '';
            $participante = $this->participanteModel->getFirstParticipante($pisId, $tipoParticipante);
            
            switch ($tipoParticipante) {
                case 'Docente':
                    if ($participante) {
                        $info = $participante['nombre'];
                    }
                    break;
                    
                case 'Estudiante':
                    if ($participante) {
                        $info = $participante['nombre'];
                    }
                    break;
                    
                case 'Docente/Estudiante':
                    if ($participante) {
                        $docente = $participante['docente'] ? $participante['docente']['nombre'] : 'No asignado';
                        $estudiante = $participante['estudiante'] ? $participante['estudiante']['nombre'] : 'No asignado';
                        $info = "D: {$docente} / E: {$estudiante}";
                    }
                    break;
            }
            
            return $info ?: 'No asignado';
        } catch (Exception $e) {
            log_message('error', 'Error al obtener información de participante: ' . $e->getMessage());
            return 'Error al obtener participante';
        }
    }





    public function generate()
    {
        // Obtener IDs de proyectos seleccionados
        $selectedIds = $this->request->getPost('selected_docs');
        
        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Debe seleccionar al menos un proyecto para generar el reporte');
        }

        // Obtener proyectos seleccionados con sus relaciones
        $builder = $this->pisModel->db->table('proyectos_integradores_saberes')
            ->select('proyectos_integradores_saberes.*, 
                programas.nombre_programa,
                lineas_investigacion_carreras.nombre_linea')
            ->join('programas', 'programas.id = proyectos_integradores_saberes.programa_id', 'left')
            ->join('lineas_investigacion_carreras', 
                'lineas_investigacion_carreras.id = proyectos_integradores_saberes.linea_investigacion_carrera_id', 'left')
            ->whereIn('proyectos_integradores_saberes.id', $selectedIds)
            ->orderBy('proyectos_integradores_saberes.created_at', 'DESC');

        $proyectos = $builder->get()->getResultArray();

        // Procesar participantes
        foreach ($proyectos as &$proyecto) {
            $proyecto['participante'] = $this->getParticipanteInfo($proyecto['id'], $proyecto['tipo_participante']);
        }

        // Preparar datos para la vista
        $data = [
            'proyectos' => $proyectos,
            'department' => 'DEPARTAMENTO DE INVESTIGACIÓN',
            'reportTitle' => 'Reporte de Proyectos Integradores de Saberes',
            'filterInfo' => ['Total de proyectos: ' . count($proyectos)],
            'generated_date' => date('Y-m-d H:i:s')
        ];

        // Generar PDF
        $html = view('reports/pis/template', $data);
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Orientación horizontal
        $dompdf->render();

        $filename = 'Reporte_PIS_' . date('Y-m-d_H-i-s') . '.pdf';

        return $this->response->setHeader('Content-Type', 'application/pdf')
                             ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
                             ->setBody($dompdf->output());
    }
}