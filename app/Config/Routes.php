<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home/getAlunos', 'Home::getAlunos');
$routes->add('(:any)', 'DynamicController::index/$1');
