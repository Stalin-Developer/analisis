<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');





// Rutas públicas (no requieren autenticación)
$routes->get('/', 'Publico::index');
$routes->get('publico', 'Publico::index');
$routes->get('publico/view/(:num)', 'Publico::view/$1');





// Rutas de autenticación
$routes->match(['GET', 'POST'], 'login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// Rutas protegidas
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');



    // Rutas de categorías
    $routes->get('categories', 'Categories::index');
    $routes->get('categories/new', 'Categories::new');
    $routes->post('categories/create', 'Categories::create');
    $routes->get('categories/edit/(:num)', 'Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Categories::update/$1');
    $routes->get('categories/delete/(:num)', 'Categories::delete/$1');



    // Rutas de documentos
    $routes->get('documents', 'Documents::index');
    $routes->get('documents/new', 'Documents::new');
    $routes->post('documents/create', 'Documents::create');
    $routes->get('documents/edit/(:num)', 'Documents::edit/$1');
    $routes->post('documents/update/(:num)', 'Documents::update/$1');
    $routes->get('documents/delete/(:num)', 'Documents::delete/$1');
    $routes->get('documents/download/(:num)', 'Documents::download/$1');



    // Rutas para Trabajos de Titulación
    $routes->get('trabajos-titulacion', 'TrabajosTitulacion::index');
    $routes->get('trabajos-titulacion/new', 'TrabajosTitulacion::new');
    $routes->post('trabajos-titulacion/create', 'TrabajosTitulacion::create');
    $routes->get('trabajos-titulacion/edit/(:num)', 'TrabajosTitulacion::edit/$1');
    $routes->post('trabajos-titulacion/update/(:num)', 'TrabajosTitulacion::update/$1');
    $routes->get('trabajos-titulacion/delete/(:num)', 'TrabajosTitulacion::delete/$1');
    $routes->get('trabajos-titulacion/download/(:num)', 'TrabajosTitulacion::download/$1');
    $routes->get('trabajos-titulacion/download-poster/(:num)', 'TrabajosTitulacion::downloadPoster/$1');
    $routes->post('trabajos-titulacion/extract-text', 'TrabajosTitulacion::extractText');



    //Rutas para Proyectos Integradores de saberes.
    $routes->get('pis', 'PISController::index');
    $routes->get('pis/new', 'PISController::new');
    $routes->post('pis/create', 'PISController::create');
    $routes->get('pis/edit/(:num)', 'PISController::edit/$1');
    $routes->put('pis/update/(:num)', 'PISController::update/$1');
    $routes->get('pis/delete/(:num)', 'PISController::delete/$1');
    $routes->get('pis/download/(:num)', 'PISController::download/$1');
    $routes->get('pis/download-poster/(:num)', 'PISController::downloadPoster/$1');
    $routes->get('pis/get-campos-especificos/(:num)', 'PISController::getCamposEspecificos/$1');
    $routes->get('pis/get-campos-detallados/(:num)', 'PISController::getCamposDetallados/$1');

        //Rutas para las lineas de investigacion
        $routes->get('pis/lineas-investigacion/list', 'PISController::lineasInvestigacionList');
        $routes->get('pis/lineas-investigacion/get/(:num)', 'PISController::lineasInvestigacionGet/$1');
        $routes->post('pis/lineas-investigacion/create', 'PISController::lineasInvestigacionCreate');
        $routes->put('pis/lineas-investigacion/update/(:num)', 'PISController::lineasInvestigacionUpdate/$1');
        $routes->delete('pis/lineas-investigacion/delete/(:num)', 'PISController::lineasInvestigacionDelete/$1');
        $routes->get('pis/careers', 'PISController::getCareers');




        //Rutas para los participantes
        $routes->post('pis/participantes/docente/create', 'ParticipanteController::createDocente');
        $routes->get('pis/participantes/docente/get/(:num)', 'ParticipanteController::getDocentesByPIS/$1');
        $routes->get('pis/participantes/docente/check-limit/(:num)', 'ParticipanteController::checkDocenteLimit/$1');
        $routes->post('pis/participantes/estudiante/create', 'ParticipanteController::createEstudiante');
        $routes->get('pis/participantes/estudiante/get/(:num)', 'ParticipanteController::getEstudiantesByPIS/$1');
        $routes->get('pis/participantes/estudiante/check-limit/(:num)', 'ParticipanteController::checkEstudianteLimit/$1');


    

    // Rutas de reportes
    //TDT
    $routes->get('reports_tdt', 'ReportesTDT::index');
    $routes->post('reports_tdt/generate', 'ReportesTDT::generate');

    $routes->get('show_reports', 'Reports::showReports');
    $routes->get('reports', 'Reports::index');
    $routes->post('reports/generate', 'Reports::generate');


});