<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Alunos::index');
$routes->get('alunos/getAlunos', 'Alunos::getAlunos');
$routes->post('alunos/addAluno', 'Alunos::addAluno');
$routes->add('(:any)', 'DynamicController::index/$1');
