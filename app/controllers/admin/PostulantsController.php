<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Postulant;

class PostulantsController extends BaseController
{
    /**
     * Mediante método GET se hace la petición para mostrar todos los postulantes actuales
     * get() se usa para traer los resultados (ejecuta la consulta y regresa el valor que obtienes)
     * @return la vista con la lista de áreas que están en la BD
     */
    public function getIndex()
    {
        $postulantes = Postulant::query()->orderBy('l_name', 'asc')->get();
        return $this->render('admin/list_postulants.twig', ['postulantes' => $postulantes]);
    }
}
