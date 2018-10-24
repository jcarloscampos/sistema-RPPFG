<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Subarea;
use AppPHP\Models\Area;
use AppPHP\Models\Administrator;
use Sirius\Validation\Validator;
use AppPHP\Controllers\Common\Validation;

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
        $validation = new Validation();
        
        $validation->setRuleSubareaCreate($validator);
        
        $areas = Area::all();

        if ($validator->validate($_POST)) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $subarea = new Subarea([
                'name_subarea' => $_POST['name'],
                'desc_subarea' => $_POST['desc'],
                'id_area' => $_POST['nameareasel']
                ]);
                $subarea->save();
                $result = true;
                //return $this->render('admin/insert_subarea.twig', ['areas' => $areas, 'result'=>$result, 'admin' => $admin]);
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
        $validation = new Validation();
        $userProfile = Administrator::where('id_account', $_SESSION['admID'])->first();
        
        $validation->setRuleSubareaUpdt($validator);

        $subarea = Subarea::find($arg);
        if ($validator->validate($_POST)) {
            Subarea::where('id', $arg)->update(array(
                'name_subarea' => $_POST['name'],
                'desc_subarea' => $_POST['desc']
            ));
            header('Location:' . BASE_URL . 'admin/subarea');
            return null;
        }
        $errors = $validator->getMessages();
		return $this->render('admin/update-subarea.twig', [
            'subarea' => $subarea, 
            'errors' => $errors, 
            'vProfile'=>$userProfile
            ]);
    }
    public function getDelete($id)
	{
		$subarea = Subarea::find($id);
		$subarea->delete();
        header('Location:' . BASE_URL . 'admin/subarea');	
	}
}
