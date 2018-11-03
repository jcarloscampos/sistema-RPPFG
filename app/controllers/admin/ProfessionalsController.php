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

class ProfessionalsController extends BaseController
{

    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            //$title = ADegree::query()->get();
            $itn = ProfessionalUmss::query()->get();
            $etn = ProfessionalExt::query()->get();
            $account = Account::query()->get();
            $urol = UserRol::query()->get();
            $rol = Rol::query()->get();
            return $this->render('admin/list-profesionals.twig',
            ['vadmin' => $admin, 'vitns'=>$itn, 'vetns'=>$etn, 'vaccounts'=>$account, 'vurols'=>$urol, 'vrols'=>$rol]);
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
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection();
        $generate = new SettingData();
        $mail = new Mail();
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
    
        $validation->setRuleBasic($validator);
        $validation->setRuleTuser($validator);
        
        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'email'=> $_POST['email'],
            'active'=>1
        ];
        if ($validator->validate($_POST)) {
            $datasend = $this->generateProfile($generate, $makeDB, $userprofile, $_POST['tuser']);
            $result = $mail->sendEMail($datasend);
        } else {
            $errors = $validator->getMessages();
            return $this->render(
                'admin/insert-account.twig', 
                ['vadmin' => $admin, 'errors' => $errors, 'vPerfil'=>$userprofile]);
            return null;
        }
        return $this->render(
            'admin/insert-account.twig', 
            ['vadmin' => $admin, 'result' => $result]);
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
}
