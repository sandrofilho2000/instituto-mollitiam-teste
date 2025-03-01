<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class DynamicController extends Controller
{
    public function index($page)
    {
        // Constrói o nome do Controller esperado
        $controllerClass = 'App\\Controllers\\' . ucfirst($page);

        // Verifica se a classe do controlador existe
        if (class_exists($controllerClass)) {
            // Instancia e chama o método index() do controller encontrado
            $controllerInstance = new $controllerClass();
            return $controllerInstance->index();
        }

        // Se não existir, lança um erro 404
        throw PageNotFoundException::forPageNotFound();
    }
}
