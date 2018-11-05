<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\ProfessionalUMSS;
use AppPHP\Models\ProfessionalUMSSView;
use AppPHP\Models\Area;
use AppPHP\Models\Workload;
use AppPHP\Models\ADegree;
use AppPHP\Models\Account;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;
use AppPHP\Controllers\Common\Validation;

/**
 * Clase controlador para lectura, inserción, eliminación y actualización de datos de la tabla ProfessionalUMSS
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
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $docentes = ProfessionalUMSSView::query()->orderBy('full_name', 'asc')->get();
            return $this->render('admin/list_teachers.twig', ['docentes' => $docentes, 'admin' => $admin]);
        }
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para insertar un docente
     */
    public function getCreate()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/insert_teacher.twig', ['admin' => $admin]);
        }
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postCreate()
    {
        $result = false;
        $errors = [];
        $validator = new Validator();
        
        $validator->add('nameteacher:Nombre del Docente',
                        'required | 
                        minlength(3)({label} debe tener al menos {min} caracteres)'
                    );
        //TODO -> Incluir Mas validaciones

        if ($validator->validate($_POST)) {
            // $area = new Area([
            //     'name_area' => $_POST['namearea'],
            //     'desc_area' => $_POST['descarea']
            // ]);
            // $area->save();
            $result = true;
            return $this->render('admin/insert_teacher.twig', ['result'=>$result]);
        }
        $errors = $validator->getMessages();
        return $this->render('admin/insert_teacher.twig', ['result'=>$result, 'errors' => $errors]);
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para importar ProfessionalUMSS
     */
    public function getImport()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/import_teacher.twig', ['admin' => $admin]);
        }
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postImport()
    {
        $result = false;
        $errors = [];
        $validator = new Validator();
        $validation = new Validation();
        
        $validation->setRuleFile($validator);
        
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
 
        if ($validator->validate($_POST)) {
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
                        $user_exists = ProfessionalUMSS::where('name', $nombre)
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
                                        //TODO -> Se van  a crear las cuentas con las 3 primeras letras del nombre, las 3 primeras del apellido y el CI en caso de no existir un password por defecto en el documento de donde se importan los datos
                                        $pass_cuenta = substr($nombre,0,3) . substr($ap_paterno,0,3) . $ci;
                                    }
                                    $account = new Account([
                                        'username' => $nombre_cuenta,
                                        'password' => password_hash($pass_cuenta, PASSWORD_DEFAULT)
                                    ]);
                                    $account->save();
                                    $account_id = Account::where('username', $nombre_cuenta)
                                                        ->where('password', password_hash($pass_cuenta, PASSWORD_DEFAULT))->first();
                                    if (is_null($account_id)){
                                        $result = 'Cuenta de Usuario: ' . $nombre_cuenta . ' no registrada.';
                                    }else{
                                        //Insertamos los datos del docente
                                        $ProfessionalUMSS = new ProfessionalUMSS([
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
                                        $ProfessionalUMSS->save();
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
            else{
                //TODO by Walter -> Juan Carlos por favor agregar el catch de este mensaje o enseñarme como se hace
                array_push($errors, "Archivo invalido!");
                $result = false;
            }
            return $this->render('admin/import_teacher.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
        }
        $errors = $validator->getMessages();
        return $this->render('admin/import_teacher.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
    }
}