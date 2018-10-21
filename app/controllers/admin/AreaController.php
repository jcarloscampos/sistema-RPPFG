<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Area;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;

/**
 * Clase controlador para lectura, inserción, eliminación y actualización de datos de la tabla área
 */

class AreaController extends BaseController
{
    /**
     * Mediante método GET se hace la petición para mostrar las áreas
     * query()->orderBy('nomb_area', 'desc') realiza lo mismo que 'SELECT * FROM area ORDER BY nomb_area ASC'
     * get() se usa para traer los resultados (ejecuta la consulta y regresa el valor que obtienes)
     * @return la vista con la lista de áreas que están en la BD
     */
    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $areas = Area::query()->orderBy('name_area', 'desc')->get();
            return $this->render('admin/list_area.twig', ['areas' => $areas, 'admin' => $admin]);
        }
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para insertar un area
     */
    public function getCreate()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/insert_area.twig', ['admin' => $admin]);
        }
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el areglo dentro del constructor
     */
    public function postCreate()
    {
        $result = false;
        $errors = [];
        $validator = new Validator();
        
        $validator->add('namearea:Nombre de área',
                        'required | 
                        minlength(5)({label} debe tener al menos {min} caracteres)'
                    );
        $validator->add('descarea:Descripción de área ',
                        'minlength(5)({label} debe tener al menos {min} caracteres)'
                    );

        if ($validator->validate($_POST)) {
            $area = new Area([
                'name_area' => $_POST['namearea'],
                'desc_area' => $_POST['descarea']
            ]);
            $area->save();
            $result = true;
            //return $this->render('admin/insert_area.twig', ['result'=>$result]);
            header('Location:' . BASE_URL . 'admin/area');
            return null;
        }
        $errors = $validator->getMessages();
        return $this->render('admin/insert_area.twig', ['result'=>$result, 'errors' => $errors]);
    }

    public function getEdit($id)
	{   
        $area = Area::where('id', $id)->first();
		return $this->render('admin/update-area.twig', ['area' => $area]);
	}

    public function postEdit($arg)
	{
        $errors = [];

        $validator = new Validator();
        
        $validator->add('name:Nombre de área',
                        'required | 
                        minlength(5)({label} debe tener al menos {min} caracteres)'
                    );
        $validator->add('desc:Descripción de área ',
                        'minlength(5)({label} debe tener al menos {min} caracteres)'
                    );

        $area = Area::find($arg);
        if ($validator->validate($_POST)) {
            Area::where('id', $arg)->update(array(
                'name_area' => $_POST['name'],
                'desc_area' => $_POST['desc']
            ));
            header('Location:' . BASE_URL . 'admin/area');
            return null;
        }
        $errors = $validator->getMessages();
		return $this->render('admin/update-area.twig', ['area' => $area, 'errors' => $errors]);
    }
    public function getDelete($id)
	{
		$area = Area::find($id);
		$area->delete();
        header('Location:' . BASE_URL . 'admin/area');	
	}
}
