<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Alunos::index');
$routes->get('alunos/getAlunos', 'Alunos::getAlunos');
$routes->post('alunos/addAluno', 'Alunos::addAluno');
$routes->delete('alunos/deleteAluno/(:num)', 'Alunos::deleteAluno/$1');

$routes->get('disciplinas', 'Disciplinas::index');
$routes->get('disciplinas/getDisciplinas', 'Disciplinas::getDisciplinas');
$routes->post('disciplinas/addDisciplina', 'Disciplinas::addDisciplina');
$routes->delete('disciplinas/deleteDisciplina/(:num)', 'Disciplinas::deleteDisciplina/$1');

$routes->add('(:any)', 'DynamicController::index/$1');
