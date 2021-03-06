<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Area;
use AppPHP\Models\AreaProfile;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use AshleyDawson\SimplePagination\Paginator;


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
            $areas = Area::query()->orderBy('name')->get()->toArray();
            $areaprofiles = AreaProfile::all();
            $params = null; 
            $page = 1;
            $myUrl=parse_url($_SERVER['REQUEST_URI']);
            if(isset($myUrl['query'])){
                parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);
                $page = (int)$params['page'];          
            }
            $paginator = new Paginator();
            $paginator->setItemsPerPage(5)->setPagesInRange(5);
            $paginator->setItemTotalCallback(function () use ($areas) {
                return count($areas);
            });
            $length = $paginator->getItemsPerPage();
            $offset =  $page * $length;
            $paginator->setSliceCallback(function ($offset, $length) use ($areas) {
                return array_slice($areas, $offset, $length);
            });
            $uimage = substr($admin->name, 0, 1);
            $pagination = $paginator->paginate($page);
            return $this->render('admin/list-area.twig', ['areaprofiles'=>$areaprofiles, 'areas' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page, 'vadmin' => $admin, 'uimage'=>$uimage]);
        }
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para insertar un area
     */
    public function getCreate()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $uimage = substr($admin->name, 0, 1);
            //$areas = Area::all();
            $typeArea = true;
            //return $this->render('admin/crud-area.twig', ['vadmin' => $admin, 'vareas' => $areas, 'typeArea' => $typeArea]);
            return $this->render('admin/crud-area.twig', ['vadmin' => $admin, 'uimage'=>$uimage, 'typeArea' => $typeArea]);
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
        $duplicateArea = false;
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $uimage = substr($admin->name, 0, 1);
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
                    'id_parent_area' => null
                    ]);
                $area->save();
                
                $uArea = Area::where('name', $_POST['name'])->first();
                $areaprofile = ['id_parent_area' => $uArea->id];
                $result = $makeDB->updateUser($uArea, $areaprofile, $makeDB);
                //return $this->render('admin/insert_area.twig', ['result'=>$result]);
                header('Location:' . BASE_URL . 'admin/area');
                return null;
            } else {
                $duplicateArea = true;
            }
        }
        $errors = $validator->getMessages();
        return $this->render('admin/crud-area.twig',
        ['vadmin' => $admin, 'uimage'=>$uimage, 'errors' => $errors, 'duplicateArea' => $duplicateArea, 'result'=>$result, 'typeArea' => $typeArea]);
    }


    public function getEdit($id)
	{   
        $area = Area::where('id', $id)->first();
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $uimage = substr($admin->name, 0, 1);
        $updarea = true;

		return $this->render('admin/crud-area.twig', ['vadmin' => $admin, 'uimage'=>$uimage, 'varea' => $area, 'updarea' => $updarea]);
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
        $uimage = substr($admin->name, 0, 1);
        $uArea = Area::find($arg);
        
        $validation->setRuleArea($validator);

        if ($validator->validate($_POST)) {
            $areaprofile = ['name' => $_POST['name'], 'description' => $_POST['desc']];
            $result = $makeDB->updateUser($uArea, $areaprofile, $makeDB);
            header('Location:' . BASE_URL . 'admin/area');
            return null;
        }
        $errors = $validator->getMessages();
		return $this->render('admin/crud-area.twig', ['vadmin' => $admin, 'uimage'=>$uimage, 'errors' => $errors, 'varea' => $uArea, 'updarea' => $updarea]);
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
        $uimage = substr($admin->name, 0, 1);
        $areas = Area::query()->orderBy('name')->get();
        $typeArea = false;

        return $this->render('admin/crud-area.twig', 
        ['vadmin' => $admin, 'uimage'=>$uimage, 'vareas' => $areas, 'typeArea' => $typeArea]);
    }

    public function postCreatesubarea()
    {
        $errors = [];
        $result = false;
        $typeArea = false;
        $duplicateArea = false;
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $uimage = substr($admin->name, 0, 1);
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
                $duplicateArea = true;
            }
        }
        $errors = $validator->getMessages();
        return $this->render('admin/crud-area.twig',
        ['vadmin' => $admin, 'uimage'=>$uimage, 'errors' => $errors, 'vareas' => $areas, 'duplicateArea' => $duplicateArea, 'typeArea' => $typeArea]);
    }

    public function getAddsubarea($id)
	{   
        $uArea = Area::find($id);
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $uimage = substr($admin->name, 0, 1);
        $updarea = true;
        $addsubarea = true;

        return $this->render('admin/crud-area.twig', 
        ['vadmin' => $admin, 'uimage'=>$uimage, 'varea' => $uArea, 'updarea' => $updarea, 'addsubarea' => $addsubarea]);
    }
    
    public function postAddsubarea($id)
    {
        $errors = [];
        $result = false;
        $typeArea = false;
        $duplicateArea = false;
        $updarea = true;
        $addsubarea = true;
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $uimage = substr($admin->name, 0, 1);
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
                $duplicateArea = true;
            }
        }
        $errors = $validator->getMessages();
        return $this->render('admin/crud-area.twig',
        ['vadmin' => $admin, 'errors' => $errors, 'duplicateArea' => $duplicateArea, 'typeArea' => $typeArea, 
        'updarea' => $updarea, 'addsubarea' => $addsubarea, 'uimage'=>$uimage]);
    }

    public function getImport()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render(
                'admin/import_from_files.twig',[
                    'admin' => $admin,
                    'prev' => "area",
                    'prevMenu' => "Áreas",
                    'currentMenu' => "Importar Áreas",
                    'currentHeader' => "Importar desde Lista de Areas y Subareas",
                    'formID' => "listaAreasSubareas"
                ]
            );
        }
    }
    
    public function postImport()
    {
        $result = false;
        $errors = [];
        $information = [];
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection(); 
        
        $validation->setRuleFile($validator, "listaAreasSubareas", "Areas y Subareas");
        
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        
        if ($validator->validate($_FILES)) {
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
                        $index = trim($data[0]);
                        $name_area = trim($data[1]);
                        $desc_area = trim($data[2]);
                        $parentID = trim($data[3]);
                        //insertamos el area solo si no tiene un area ID es decir, solo si no es una subarea
                        if(!$parentID){
                            // Usamos esta seccion para validar el formato de los datos
                            if(!preg_match("/^[0-9]+$/", $index)){
                                $line = $counter + 1;
                                array_push($information, "Area en la linea: " . $line . " tiene un formato incorrecto. La Primera columna debe contener un valor numérico.");
                            }else{
                                $area = Area::where('name',$name_area)->get();
                                if(!count($area)){
                                    $area = new Area([
                                        'name' => $name_area,
                                        'description' => $desc_area,
                                        'id_parent_area' => null
                                        ]);
                                    $area->save();
                                    
                                    $uArea = Area::where('name', $name_area)->first();
                                    $areaprofile = ['id_parent_area' => $uArea->id];
                                    $result = $makeDB->updateUser($uArea, $areaprofile, $makeDB);
                                }
                                else{
                                    array_push($information, "Area " . $name_area. " ya registrada");
                                }
                                $uArea = Area::where('name', $name_area)->first();
                                $areaprofile = ['id_parent_area' => $uArea->id];
                                $result = $makeDB->updateUser($uArea, $areaprofile, $makeDB);
                                $Areas_list[$index] = $name_area;
                            }
                        }
                    }else{
                        if(sizeof($data)!=4){
                            $errors = [["Archivo Invalido, por favor refierase al manual de usuario para mayor información."]];
                            return $this->render('admin/import_from_files.twig',
                                [
                                    'result'=>$result,
                                    'errors' => $errors,
                                    'information' => $information,
                                    'admin' => $admin,
                                    'prev' => "area",
                                    'prevMenu' => "Áreas",
                                    'currentMenu' => "Importar Áreas",
                                    'currentHeader' => "Importar desde Lista de Areas y Subareas",
                                    'formID' => "listaAreasSubareas"
                                ]
                            );
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
                    
                            // Usamos esta seccion para validar el formato de los datos
                            if(!preg_match("/^[0-9]+$/", $index) || !preg_match("/^[0-9]+$/", $parentID)){
                                $line = $counter + 1;
                                array_push($information, "Sub-Area en la linea: " . $line . " tiene un formato incorrecto. La Primera y Cuarta columnas deben contener valores numéricos.");
                            }else{
                                $parentName = $Areas_list[$parentID];
                                $area_ID = Area::where('name',$parentName)->first()->id;
                                $subarea = Area::where('name',$name_area)->where('id_parent_area',$area_ID)->get();
                                if(!count($subarea)){
                                    $subarea = new Area([
                                        'name' => $name_area,
                                        'description' => $desc_area,
                                        'id_parent_area' => $area_ID
                                        ]);
                                    $subarea->save();
                                }
                                else{
                                    array_push($information, "SubArea \"" . $name_area. "\" ya registrada para el área \"" . $parentName . "\"");
                                }
                            }
                        }
                    }
                    $counter++;
                }
                fclose($handle);
                $result = true;
            }
            if(count($information) > 0){
                return $this->render('admin/import_from_files.twig',
                    [
                        'result'=>$result,
                        'errors' => $errors,
                        'information' => $information,
                        'admin' => $admin,
                        'prev' => "area",
                        'prevMenu' => "Áreas",
                        'currentMenu' => "Importar Áreas",
                        'currentHeader' => "Importar desde Lista de Areas y Subareas",
                        'formID' => "listaAreasSubareas"
                    ]
                );
            }
            else{
                return $this->getIndex();
            }
        }
        $errors = $validator->getMessages();
        if(count($information) > 0){
            return $this->render('admin/import_from_files.twig',
                [
                    'result'=>$result,
                    'errors' => $errors,
                    'information' => $information,
                    'admin' => $admin,
                    'prev' => "area",
                    'prevMenu' => "Áreas",
                    'currentMenu' => "Importar Áreas",
                    'currentHeader' => "Importar desde Lista de Areas y Subareas",
                    'formID' => "listaAreasSubareas"
                ]
            );
        }
        else{
            return $this->getIndex();
        }
    }
}