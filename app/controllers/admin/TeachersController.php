<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\ProffesionalUMSS;
use AppPHP\Models\ProffesionalUMSSView;
use AppPHP\Models\Area;
use AppPHP\Models\Subarea;
use AppPHP\Models\Workload;
use AppPHP\Models\ADegree;
use AppPHP\Models\Account;

/**
 * Clase controlador para lectura, inserción, eliminación y actualización de datos de la tabla ProffesionalUMSS
 */

class TeachersController extends BaseController
{
    /**
     * Mediante método GET se hace la petición para mostrar todos los docentes actuales
     * get() se usa para traer los resultados (ejecuta la consulta y regresa el valor que obtienes)
     * @return la vista con la lista de áreas que están en la BD
     */
    public function getIndex()
    {
        $docentes = ProffesionalUMSSView::query()->orderBy('full_name', 'asc')->get();
        return $this->render('admin/list_teachers.twig', ['docentes' => $docentes]);
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para insertar un docente
     */
    public function getCreate()
    {
        return $this->render('admin/insert_teacher.twig');
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postCreate()
    {
        //TODO -> Insertar ProffesionalUMSS desde Administration Page
        // $docente = new Docente([
        //     'nomb_docente' => $_POST['nombdocente'],
        //     'desc_docente' => $_POST['descdocente']
        // ]);
        // $docente->save();
        return $this->render('admin/insert_teacher.twig', ['result'=>$result]);
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para importar ProffesionalUMSS
     */
    public function getImport()
    {
        return $this->render('admin/import_teacher.twig');
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postImport()
    {
        $fname = $_FILES['listaDocentes']['name'];
        $chk_ext = explode(".",$fname);

        if(strtolower(end($chk_ext)) == "csv"){
            //si es correcto, entonces damos permisos de lectura para subir
            $filename = $_FILES['listaDocentes']['tmp_name'];
            $handle = fopen($filename, "r");
            $counter = 0;
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE){
                //asi omitimos la columna de titulos
                if($counter > 0){
                    $nombre = $data[0];
                    $ap_paterno = $data[1];
                    $ap_materno = $data[2];
                    $email = $data[3];
                    $grado_academico = $data[4];
                    $carga_horaria = $data[5];
                    $nombre_cuenta = $data[6];
                    $telefono = $data[7];
                    $direccion = $data[8];
                    $perfil = $data[9];
                    $pass_cuenta = $data[10];
                    $ci = $data[11];
                    $cod_sis = $data[12];

                    // Verificamos si el usuario ya existe registrado como docente:
                    // Validamos si existe la carga horaria
                    // validamos si existe el grado academico
                    // Insertamos los datos del docente
                    $user_exists = ProffesionalUMSS::where('name', $nombre)
                                        ->where('l_name', $ap_paterno)
                                        ->where('ml_name', $ap_materno)
                                        ->where('ci', $ci)->first();
                    if (is_null($user_exists)){
                        $id_carga_horaria = Workload::where('name_wl',$carga_horaria)->first();
                        $id_grado_academico = ADegree::where('name_ad',$grado_academico)->first();
                        if(is_null($id_carga_horaria)){
                            $result = 'Carga horaria: ' . $carga_horaria . ' no registrada.';
                        }else{
                            if (is_null($id_grado_academico)){
                                $result = 'Grado Académico: ' . $grado_academico . ' no registrado.';
                            }else{
                                if($pass_cuenta == ''){
                                    $pass_cuenta = $nombre_cuenta . '.123';
                                }
                                //TODO -> Juan Carlos, por favor cambiar esto con la forma correcta de creacion de cuentas de usuario
                                $account = new Account([
                                    'username' => $nombre_cuenta,
                                    'password' => $pass_cuenta
                                ]);
                                $account->save();
                                $account_id = Account::where('username', $nombre_cuenta)
                                                    ->where('password', $pass_cuenta)->first();
                                if (is_null($account_id)){
                                    $result = 'Cuenta de Usuario: ' . $nombre_cuenta . ' no registrada.';
                                }else{
                                    //Insertamos los datos del docente
                                    $proffesionalUMSS = new ProffesionalUMSS([
                                        'ci' => $ci,
                                        'name' => $nombre,
                                        'l_name' => $ap_paterno,
                                        'ml_name' => $ap_materno,
                                        'email' => $email,
                                        'phone' => $telefono,
                                        'address' => $direccion,
                                        'cod_sis' => $cod_sis,
                                        'id_a_degree' => $id_grado_academico->id,
                                        'id_workload' => $id_carga_horaria->id,
                                        'profile' => $perfil,
                                        'id_account' => $account_id->id
                                    ]);
                                    $proffesionalUMSS->save();
                                }
                            }
                        }
                    }
                    else{
                        $result = "Usuario ya registrado";
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
            //ver si esta separado por " , "
            $result = "Archivo invalido!";
        }
        return $this->render('admin/import_teacher.twig', ['result'=>$result]);
    }
}
