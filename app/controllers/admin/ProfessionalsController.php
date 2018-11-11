<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Account;
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
            return $this->render('admin/list-profesionals.twig', ['profesionales' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page, 'vadmin' => $admin, 'vaccounts'=>$account, 'vurols'=>$urol, 'vrols'=>$rol]);      

       //     return $this->render('admin/list-profesionals.twig',
         //   ['vadmin' => $admin, 'vitns'=>$itn, 'vetns'=>$etn, 'vaccounts'=>$account, 'vurols'=>$urol, 'vrols'=>$rol]);
        }
    }

    public function getNewaccount()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/insert-account.twig', ['vadmin' => $admin]);
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
                ['vadmin' => $admin, 'errors' => $errors, 'vPerfil'=>$userprofile]);
            return null;
        }
        return $this->render(
            'admin/insert-account.twig', 
            ['vadmin' => $admin, 'result' => $result, 'duplicate' => $duplicate]);
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
}
