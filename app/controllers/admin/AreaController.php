<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Area;
use AppPHP\Models\Subarea;
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
            return $this->render('admin/insert_area.twig', ['result'=>$result]);
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
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        
        //TODO by Walter -> Juan Carlos por favor implementar validaciones para estos casos
        // $validator->add('listaAreasSubareas:Lista de áreas y subáreas',
        //                 'required'
        //             );

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
                            $subarea = new Subarea([
                                'name_subarea' => $name_subarea,
                                'desc_subarea' => $desc_subarea,
                                'id_area' => $area_ID
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
                //TODO by Walter -> Juan Carlos por favor agregar el catch de este mensaje
                array_push($errors, "Archivo invalido!");
                $result = false;
            }
            return $this->render('admin/import_areas.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
        }
        $errors = $validator->getMessages();
        return $this->render('admin/import_areas.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
    }
}