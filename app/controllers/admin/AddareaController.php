<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Area;

/**
 * Clase controlador para lectura, inserción, eliminación y actualización de datos de la tabla área
 */

class AddareaController extends BaseController
{
    /**
     * Mediante método GET se hace la petición para mostrar las áreas
     * query()->orderBy('nomb_area', 'desc') realiza lo mismo que 'SELECT * FROM area ORDER BY nomb_area ASC'
     * get() se usa para traer los resultados (ejecuta la consulta y regresa el valor que obtienes)
     * @return la vista con la lista de áreas que están en la BD
     */
    public function getIndex()
    {
        $areas = Area::query()->orderBy('nomb_area', 'desc')->get();
        //all(); funciona lo mismo que la anterior consulta; solo no hay opción para hacer ordenamiento
        //$areas = Area::all();
        return $this->render('admin/list_area.twig', ['areas' => $areas]);
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para insertar un area
     */
    public function getCreate()
    {
        return $this->render('admin/insert_area.twig');
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el areglo dentro del constructor
     */
    public function postCreate()
    {
        $area = new Area([
            'nomb_area' => $_POST['nombarea'],
            'desc_area' => $_POST['descarea']
        ]);
        $area->save();
        return $this->render('admin/insert_area.twig', ['result'=>$result]);
    }
}
