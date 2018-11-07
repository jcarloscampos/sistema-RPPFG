<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Area;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;

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
            $areas = Area::query()->orderBy('name')->get();
            return $this->render('admin/list-area.twig', ['areas' => $areas, 'vadmin' => $admin]);
        }
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para insertar un area
     */
    public function getCreate()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            //$areas = Area::all();
            $typeArea = true;
            //return $this->render('admin/crud-area.twig', ['vadmin' => $admin, 'vareas' => $areas, 'typeArea' => $typeArea]);
            return $this->render('admin/crud-area.twig', ['vadmin' => $admin, 'typeArea' => $typeArea]);
        }
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el areglo dentro del constructor
     */
    public function postCreate()
    {
        $errors = [];
        $result = false;
        $typeArea = true;
        $duplicate = false;
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection(); 
        
        $validation->setRuleArea($validator);
        
        if ($validator->validate($_POST)) {
            $existArea = Area::where('name', '=', $_POST['name'])->get()->toArray();
            if (empty($existArea)){ //mejorar para control entre mayusculas y minusculas
                $area = new Area([
                    'name' => $_POST['name'],
                    'description' => $_POST['desc'],
                    'id_parent_area' => 1
                    ]);
                $area->save();
                
                $uArea = Area::where('name', $_POST['name'])->first();
                $areaprofile = ['id_parent_area' => $uArea->id];
                $result = $makeDB->updateUser($uArea, $areaprofile, $makeDB);
                //return $this->render('admin/insert_area.twig', ['result'=>$result]);
                header('Location:' . BASE_URL . 'admin/area');
                return null;
            } else {
                $duplicate = true;
            }
        }
        $errors = $validator->getMessages();
        return $this->render('admin/crud-area.twig',
        ['vadmin' => $admin, 'errors' => $errors, 'duplicate' => $duplicate, 'result'=>$result, 'typeArea' => $typeArea]);
    }


    public function getEdit($id)
	{   
        $area = Area::where('id', $id)->first();
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $updarea = true;

		return $this->render('admin/crud-area.twig', ['vadmin' => $admin, 'varea' => $area, 'updarea' => $updarea]);
	}

    public function postEdit($arg)
	{
        $errors = [];
        $updarea = true;
        $result = false;
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection();
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $uArea = Area::find($arg);
        
        $validation->setRuleArea($validator);

        if ($validator->validate($_POST)) {
            $areaprofile = ['name' => $_POST['name'], 'description' => $_POST['desc']];
            $result = $makeDB->updateUser($uArea, $areaprofile, $makeDB);
            header('Location:' . BASE_URL . 'admin/area');
            return null;
        }
        $errors = $validator->getMessages();
		return $this->render('admin/crud-area.twig', ['vadmin' => $admin, 'errors' => $errors, 'varea' => $uArea, 'updarea' => $updarea]);
    }
    public function getDelete($id)
	{
		$area = Area::find($id);
		$area->delete();
        header('Location:' . BASE_URL . 'admin/area');	
    }

    public function getCreatesubarea()
	{   
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $areas = Area::query()->orderBy('name')->get();
        $typeArea = false;

        return $this->render('admin/crud-area.twig', 
        ['vadmin' => $admin, 'vareas' => $areas, 'typeArea' => $typeArea]);
    }

    public function postCreatesubarea()
    {
        $errors = [];
        $result = false;
        $typeArea = false;
        $duplicate = false;
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection();
        $areas = Area::all();
        
        $validation->setRuleSubareaCreate($validator);
        
        if ($validator->validate($_POST)) {
            $existArea = Area::where('name', '=', $_POST['name'])->get()->toArray();
            if (empty($existArea)){ //mejorar para control entre mayusculas y minusculas
                $area = new Area([
                    'name' => $_POST['name'],
                    'description' => $_POST['desc'],
                    'id_parent_area' => $_POST['nameareasel']
                    ]);
                    $area->save();
                    $result = true;
                    //return $this->render('admin/insert_subarea.twig', ['areas' => $areas, 'result'=>$result, 'admin' => $admin]);
                    header('Location:' . BASE_URL . 'admin/area');
                    return null;
            } else {
                $duplicate = true;
            }
        }
        $errors = $validator->getMessages();
        return $this->render('admin/crud-area.twig',
        ['vadmin' => $admin, 'errors' => $errors, 'vareas' => $areas, 'duplicate' => $duplicate, 'typeArea' => $typeArea]);
    }

    public function getAddsubarea($id)
	{   
        $uArea = Area::find($id);
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $updarea = true;
        $addsubarea = true;

        return $this->render('admin/crud-area.twig', 
        ['vadmin' => $admin, 'varea' => $uArea, 'updarea' => $updarea, 'addsubarea' => $addsubarea]);
    }
    
    public function postAddsubarea($id)
    {
        $errors = [];
        $result = false;
        $typeArea = false;
        $duplicate = false;
        $updarea = true;
        $addsubarea = true;
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection();
        
        $validation->setRuleAddSubarea($validator);
        
        if ($validator->validate($_POST)) {
            $existArea = Area::where('name', '=', $_POST['name'])->get()->toArray();
            if (empty($existArea)){ //mejorar para control entre mayusculas y minusculas
                $area = new Area([
                    'name' => $_POST['name'],
                    'description' => $_POST['desc'],
                    'id_parent_area' => $id
                    ]);
                    $area->save();
                    $result = true;
                    //return $this->render('admin/insert_subarea.twig', ['areas' => $areas, 'result'=>$result, 'admin' => $admin]);
                    header('Location:' . BASE_URL . 'admin/area');
                    return null;
            } else {
                $duplicate = true;
            }
        }
        $errors = $validator->getMessages();
        return $this->render('admin/crud-area.twig',
        ['vadmin' => $admin, 'errors' => $errors, 'duplicate' => $duplicate, 'typeArea' => $typeArea, 
        'updarea' => $updarea, 'addsubarea' => $addsubarea]);
    }
    




    





















































    public function getImport()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/import_areas.twig', ['admin' => $admin]);
        }
    }
    
    public function postImport()
    {
        $result = false;
        $errors = [];
        $validator = new Validator();
        $validation = new Validation();
        
        $validation->setRuleFile($validator);
        
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        
        if ($validator->validate($_POST)) {
            $fname = $_FILES['listaAreasSubareas']['name'];
            $chk_ext = explode(".",$fname);

            if(strtolower(end($chk_ext)) == "csv")
            {
                //si es correcto, entonces damos permisos de lectura para subir
                $filename = $_FILES['listaAreasSubareas']['tmp_name'];
                $handle = fopen($filename, "r");
                //Identificamos solamente las áreas y omitimos cualquier subárea
                $Areas_list=array();
                $counter = 0;
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
                {
                    //asi omitimos la columna de titulos
                    if($counter > 0){
                        $index = $data[0];
                        $name_area = $data[1];
                        $desc_area = $data[2];
                        $parentID = $data[3];
                        //insertamos el area solo si no tiene un area ID es decir, solo si no es una subarea
                        if(!$parentID){
                            $area = Area::where('name_area',$name_area)->get();
                            if(!count($area)){
                                $area = new Area([
                                    'name_area' => $name_area,
                                    'desc_area' => $desc_area
                                    ]);
                                $area->save();
                            }
                            $Areas_list[$index] = $name_area;
                        }
                    }
                    $counter++;
                }
                fclose($handle);
                $handle = fopen($filename, "r");
                //Identificamos solamente las subárea y las insertamos en sus respectivas áreas
                $counter = 0;
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
                {
                    if($counter > 0){
                        $index = $data[0];
                        $name_subarea = $data[1];
                        $desc_subarea = $data[2];
                        $parentID = $data[3];
                        if($parentID){
                            $parentName = $Areas_list[$parentID];
                            $area_ID = Area::where('name_area',$parentName)->first()->id;
                            $subarea = new Area([
                                'name_subarea' => $name_subarea,
                                'desc_subarea' => $desc_subarea,
                                'id_parent_area' => $area_ID
                            ]);
                            $subarea->save();
                        }
                    }
                    $counter++;
                }
                fclose($handle);
                $result = true;
            }
            else{
                //TODO by Walter -> Juan Carlos por favor agregar el catch de este mensaje o enseñarme como se hace
                array_push($errors, "Archivo invalido!");
                $result = false;
            }
            return $this->render('admin/import_areas.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
        }
        $errors = $validator->getMessages();
        return $this->render('admin/import_areas.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
    }
}