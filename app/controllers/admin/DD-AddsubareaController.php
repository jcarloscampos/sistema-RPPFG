<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Subarea;
use AppPHP\Models\Area;

/**
 * Clase controlador para lectura, inserción, eliminación y actualización de datos de la tabla área
 */

class AddsubareaController extends BaseController
{
    public function getIndex()
    {
        $subareas = Subarea::query()->orderBy('name_subarea', 'desc')->get();
        return $this->render('admin/list_subarea.twig', ['subareas' => $subareas]);
    }

    public function getCreate()
    {
        $areas = Area::all();
        return $this->render('admin/insert_subarea.twig', ['areas' => $areas]);
    }

    public function postCreate()
    {
        $areas = Area::all();
        $subarea = new Subarea([
            'name_subarea' => $_POST['nombsubarea'],
            'desc_subarea' => $_POST['descsubarea'],
            'id_area' => $_POST['nombareasel']
        ]);
        $subarea->save();
        $result = true;
        return $this->render('admin/insert_subarea.twig', ['areas' => $areas], ['result'=>$result]);
    }
}
