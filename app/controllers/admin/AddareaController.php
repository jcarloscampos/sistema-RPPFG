<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Subarea;
use AppPHP\Models\Area;

/**
 * Clase controlador para lectura, inserción, eliminación y actualización de datos de la tabla área
 */

class AddareaController extends BaseController
{
    /**
     * Mediante método GET se hace la petición para mostrar las áreas
     * query()->orderBy('name_area', 'desc') realiza lo mismo que 'SELECT * FROM area ORDER BY name_area ASC'
     * get() se usa para traer los resultados (ejecuta la consulta y regresa el valor que obtienes)
     * @return la vista con la lista de áreas que están en la BD
     */
    public function getIndex()
    {
        $areas = Area::query()->orderBy('name_area', 'desc')->get();
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
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postCreate()
    {
        $area = new Area([
            'name_area' => $_POST['nombarea'],
            'desc_area' => $_POST['descarea']
        ]);
        $area->save();
        return $this->render('admin/insert_area.twig', ['result'=>$result]);
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para importar areas
     */
    public function getImport()
    {
        return $this->render('admin/import_areas.twig');
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postImport()
    {
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
            //cerramos la lectura del archivo
            fclose($handle);
            $result = "Importación exitosa!";
        }
        else
        {
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para
            //ver si esta separado por " ; "
            $result = "Archivo invalido!";
        }
        return $this->render('admin/import_areas.twig');
    }
}
