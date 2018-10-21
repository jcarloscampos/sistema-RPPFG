<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Subarea;
use AppPHP\Models\Area;
use AppPHP\Models\Administrator;
use Sirius\Validation\Validator;

/**
 * Clase controlador para lectura, inserción, eliminación y actualización de datos de la tabla área
 */

class SubareaController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $subareas = Subarea::query()->orderBy('name_subarea', 'desc')->get();
            return $this->render('admin/list_subarea.twig', ['subareas' => $subareas, 'admin' => $admin]);
        }
    }

    public function getCreate()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $areas = Area::all();
            return $this->render('admin/insert_subarea.twig', ['areas' => $areas, 'admin' => $admin]);
        }
    }

    public function postCreate()
    {
        $result = false;
        $errors = null;
        $validator = new Validator();
        
        $validator->add('namesubarea:Nombre de sub área',
                        'required | 
                        minlength(5)({label} debe tener al menos {min} caracteres)'
                    );
        $validator->add('descsubarea:Descripción de sub área ',
                        'minlength(5)({label} debe tener al menos {min} caracteres)'
                    );
        $validator->add('nameareasel:Selección de área',
                        'required'
                    );

        $areas = Area::all();

        if ($validator->validate($_POST)) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $subarea = new Subarea([
                'name_subarea' => $_POST['namesubarea'],
                'desc_subarea' => $_POST['descsubarea'],
                'id_area' => $_POST['nameareasel']
                ]);
                $subarea->save();
                $result = true;
                return $this->render('admin/insert_subarea.twig', ['areas' => $areas, 'result'=>$result, 'admin' => $admin]);
            }
        $errors = $validator->getMessages();
        return $this->render('admin/insert_subarea.twig', ['areas' => $areas, 'result'=>$result, 'errors' => $errors]);
    }

    public function getEdit($id)
	{   
        $subarea = Subarea::where('id', $id)->first();
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
		return $this->render('admin/update-subarea.twig', ['subarea' => $subarea, 'admin' => $admin]);
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

        $subarea = Subarea::find($arg);
        if ($validator->validate($_POST)) {
            Subarea::where('id', $arg)->update(array(
                'name_subarea' => $_POST['name'],
                'desc_subarea' => $_POST['desc']
            ));
            header('Location:' . BASE_URL . 'admin/subarea');
        }
        $errors = $validator->getMessages();
		return $this->render('admin/update-subarea.twig', ['subarea' => $subarea, 'errors' => $errors]);
    }
    public function getDelete($id)
	{
		$area = Area::find($id);
		$area->delete();
        header('Location:' . BASE_URL . 'admin/area');	
	}
}
