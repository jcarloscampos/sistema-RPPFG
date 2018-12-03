<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Account;
use AppPHP\Models\Workload;
use AppPHP\Models\ADegree;
use AppPHP\Models\UserRol;
use AppPHP\Models\Rol;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use AppPHP\Controllers\Common\SettingData;
use AppPHP\Controllers\Common\Mail;
use AshleyDawson\SimplePagination\Paginator;

class ProfessionalsController extends BaseController
{

    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $uimage = substr($admin->name, 0, 1);
            //$title = ADegree::query()->get();
            $itn = ProfessionalUmss::query()->get()->toArray();
            $etn = ProfessionalExt::query()->get()->toArray();
            $account = Account::query()->get();
            $urol = UserRol::query()->get();
            $rol = Rol::query()->get();
            $profesionales = array_merge($itn, $etn);
            $params = null; 
            $page = 1;
            $myUrl=parse_url($_SERVER['REQUEST_URI']);
            if(isset($myUrl['query'])){
                parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);
                $page = (int)$params['page'];          
            }
            $paginator = new Paginator();
            $paginator->setItemsPerPage(5)->setPagesInRange(5);
            $paginator->setItemTotalCallback(function () use ($profesionales) {
                return count($profesionales);
            });
            $length = $paginator->getItemsPerPage();
            $offset =  $page * $length;
            $paginator->setSliceCallback(function ($offset, $length) use ($profesionales) {
                return array_slice($profesionales, $offset, $length);
            });
            $pagination = $paginator->paginate($page);
            return $this->render('admin/list-profesionals.twig', ['profesionales' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page, 'uimage'=>$uimage, 'vadmin' => $admin, 'vaccounts'=>$account, 'vurols'=>$urol, 'vrols'=>$rol]);      

       //     return $this->render('admin/list-profesionals.twig',
         //   ['vadmin' => $admin, 'vitns'=>$itn, 'vetns'=>$etn, 'vaccounts'=>$account, 'vurols'=>$urol, 'vrols'=>$rol]);
        }
    }

    public function getNewaccount()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $uimage = substr($admin->name, 0, 1);
            return $this->render('admin/insert-account.twig', ['vadmin' => $admin, 'uimage'=>$uimage]);
        }
    }

    public function PostNewaccount()
    {
        $errors = [];
        $result = false;
        $duplicate = false;
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection();
        $generate = new SettingData();
        $mail = new Mail();
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
    
        $validation->setRuleBasic($validator);
        $validation->setRuleTuser($validator);
        $validation->setRuleCI($validator);
        
        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'email'=> $_POST['email'],
            'active'=>1
        ];
        if ($validator->validate($_POST)) {
            if ($_POST['tuser'] == "itnprof") {
                $userstemp = ProfessionalUmss::where('ci', '=', $_POST['ci'])->get()->toArray();
            } elseif ($_POST['tuser'] == "etnprof") {
                $userstemp = ProfessionalExt::where('ci', '=', $_POST['ci'])->get()->toArray();
            }
            if (empty($userstemp)){
                $datasend = $this->generateProfile($generate, $makeDB, $userprofile, $_POST['tuser']);
                $result = $mail->sendEMail($datasend);
            } else {
                $duplicate = true;
            }
        } else {
            $errors = $validator->getMessages();
            return $this->render(
                'admin/insert-account.twig', 
                ['vadmin' => $admin, 'errors' => $errors, 'vprofile'=>$userprofile]);
            return null;
        }
        return $this->render(
            'admin/insert-account.twig', 
            ['vadmin' => $admin, 'result' => $result, 'duplicate' => $duplicate, 'vprofile'=>$userprofile]);
    }

    /**
     * @param object $generate : Generador
     * @param object $makeDB : Conector a BD
     * @param array $profile : Perfil de usuario
     * @param string $tuser : Tipo de usuario
     * @return array $dataset : Datos para ser enviados por email
     */
    private function generateProfile($generate, $makeDB, $profile, $tuser)
    {
        $dataset = [];

        $dataset = $this->makeAccount($generate, $makeDB, $generate->generateUserName(strtolower($profile['name']), strtolower($profile['l_name'])));
        $newAccount = $makeDB->newAccount($dataset['username'], $dataset['password']);
        $newUser = $makeDB->createUser($tuser, $newAccount);
        $makeDB->updateUser($newUser, $profile, $makeDB);
        $makeDB->linkUseRol($newUser, $tuser);

        $dataset['email'] = $profile['email'];
        return $dataset;
    }

    /**
     * @param object $generate : Generador
     * @param object $makeDB : Conector a BD
     * @param string $uname : Nombre de usuario
     * @return array $account : Cuenta de usuario
     */
    private function makeAccount($generator, $makeDB, $uname)
    {
        $account = [];

        if ($makeDB->issetAccount($uname)) {
            $account['username'] = $generator->makeUname($generator, $makeDB,  $uname);
        } else {
            $account['username'] = $uname;
        }
        $account['password'] = $generator->generatePassword();

        return $account;
    }

    public function getUpdateprofessional($idAccount)
    {
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $urol = UserRol::where('id_account', $idAccount)->first();
        $rol = Rol::where('id_rol', $urol->id_rol)->first();
        $itn = false;

        
        if ($rol->name_rol == "itnprof" || $rol->name_rol == "director") {
            # Profesional del UMSS
            $user = ProfessionalUmss::where('id_account', $idAccount)->first();
            $itn = true;
        } elseif ($rol->name_rol == "etnprof") {
            # Profesional externo
            $user = ProfessionalExt::where('id_account', $idAccount)->first();
        }
        return $this->render('admin/update-professional.twig', ['vadmin' => $admin, 'vPerfil'=>$user, 'itn'=>$itn, 'rol'=>$rol]);
    }

    public function postUpdateprofessional($idAccount)
    {
        $result = false;
        $itn = false;
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
        $urol = UserRol::where('id_account', $idAccount)->first();
        //$rol = Rol::where('id_rol', $_POST['id_rol'])->first();
        $rol = Rol::where('id_rol', $urol->id_rol)->first();

        $makeDB = new ServerConnection();

        if ($rol->name_rol == "itnprof" || $rol->name_rol == "director") {
            $user = ProfessionalUmss::where('id_account', $idAccount)->first();
            $itn = true;
        } elseif ($rol->name_rol == "etnprof") {
            $user = ProfessionalExt::where('id_account', $idAccount)->first();
        }

        if (isset($_POST['rolprof'])) {
            $userprofile = ['id_rol'=> $_POST['rolprof']];
            $result = $makeDB->updateUser($urol, $userprofile, $makeDB);
        }

        if (isset($_POST['activeprof'])) {
            $userprofile = ['active'=> $_POST['activeprof']];
            $result = $makeDB->updateUser($user, $userprofile, $makeDB);
        }
        //optimizar las vistas...
        if ($rol->name_rol == "itnprof" || $rol->name_rol == "director") {
            $user = ProfessionalUmss::find($_POST['id']);
            $itn = true;
        } elseif ($rol->name_rol == "etnprof") {
            $user = ProfessionalExt::find($_POST['id']);
        }
        $rol = Rol::where('id_rol', $_POST['id_rol'])->first();
        
        return $this->render('admin/update-professional.twig',
        ['vadmin' => $admin, 'result' => $result, 'vPerfil'=>$user, 'itn'=>$itn, 'rol'=>$rol]);
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para importar ProfessionalUMSS
     */
    public function getImport()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render(
                'admin/import_from_files.twig',[
                    'admin' => $admin,
                    'prev' => "professionals",
                    'prevMenu' => "Profesionales",
                    'currentMenu' => "Importar Docentes",
                    'currentHeader' => "Importar desde Lista de Docentes",
                    'formID' => "listaDocentes"
                ]
            );
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
        $information = [];
        $validator = new Validator();
        $validation = new Validation();
        $settingData = new SettingData();

        $validation->setRuleFile($validator, "listaDocentes", "Docentes UMSS");
        
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
 
        if ($validator->validate($_FILES)) {
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
                        $ci = $settingData->recuperarCIProfessional($nombre, $ap_paterno, $ap_materno);
                        $cod_sis = $settingData->recuperarSISProfessional($nombre, $ap_paterno, $ap_materno);

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
                               array_push($information, 'Carga horaria: ' . $carga_horaria . ' no registrada.');
                            }else{
                                if (is_null($id_grado_academico)){
                                    array_push($information, 'Grado Académico: ' . $grado_academico . ' no registrado.');
                                }else{
                                    if($pass_cuenta == ''){
                                        //TODO -> Se van  a crear las cuentas con las 3 primeras letras del nombre, las 3 primeras del apellido y el CI en caso de no existir un password por defecto en el documento de donde se importan los datos
                                        $pass_cuenta = substr($nombre,0,3) . substr($ap_paterno,0,3) . $ci;
                                    }
                                    $account_id = Account::where('username', $nombre_cuenta)->first();
                                    if (is_null($account_id)){
                                        $account = new Account([
                                            'username' => $nombre_cuenta,
                                            'password' => password_hash($pass_cuenta, PASSWORD_DEFAULT),
                                            'state' => 1
                                        ]);
                                        $account->save();
                                    }
                                    $account_id = Account::where('username', $nombre_cuenta)->first();
                                    if (is_null($account_id)){
                                        array_push($error, 'Cuenta de Usuario: ' . $nombre_cuenta . ' no registrada.');
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
                                            'active' => "1",
                                            'id_ad' => $id_grado_academico->id,
                                            'id_wl' => $id_carga_horaria->id,
                                            'profile' => $perfil,
                                            'id_account' => $account_id->id
                                        ]);
                                        $ProfessionalUMSS->save();
                                    }
                                }
                            }
                        }
                        else{
                            array_push($information, "Docente " . $grado_academico . " " . $ap_paterno . " " . $ap_materno . " " . $nombre. " ya registrado");
                        }
                    }
                    $counter++;
                }
                //cerramos la lectura del archivo
                fclose($handle);
                $result=true;
            }
            if(count($information) > 0){
                return $this->render('admin/import_from_files.twig',
                    [
                        'result'=>$result,
                        'errors' => $errors,
                        'information' => $information,
                        'admin' => $admin,
                        'prev' => "professionals",
                        'prevMenu' => "Profesionales",
                        'currentMenu' => "Importar Docentes",
                        'currentHeader' => "Importar desde Lista de Docentes",
                        'formID' => "listaDocentes"
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
                    'prev' => "professionals",
                    'prevMenu' => "Profesionales",
                    'currentMenu' => "Importar Docentes",
                    'currentHeader' => "Importar desde Lista de Docentes",
                    'formID' => "listaDocentes"
                ]
            );
        }
        else{
            return $this->getIndex();
        }
    }
}
