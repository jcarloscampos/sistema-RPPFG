<?php

namespace AppPHP\Controllers\Accounts;

use Sirius\Validation\Validator;
use AppPHP\Controllers\BaseController;
use AppPHP\Models\Account;
use AppPHP\Models\Postulant;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\IsRegistered;
use AppPHP\Controllers\Common\ServerConnection;
use AppPHP\Controllers\Common\Validation;

/**
 * Clase controlador para registro de todos los usuarios asociados a este sistema
 */
class SignupController extends BaseController
{
    /**
     * @return object template
     */
    public function getIndex()
    {
        return $this->render('accounts/signup.twig');
    }

    /**
     * @return object template
     */
    public function postIndex()
    {
        $errors = [];
        $result = false;
        $exists = false;
        $rejected = false;
        $repeatedci = false;

        $validator = new Validator();
        $validation = new Validation();
        $validation->setRuleBasic($validator);
        $validation->setRuleCodeSis($validator);
        $validation->setRuleUser($validator);
        $validation->setRuleCI($validator);
        

        $pData = [
            'ci'=> $_POST['ci'],
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'email'=> $_POST['email'],
            'cod_sis'=>$_POST['codsis'],
            'user' => $_POST['user']
        ];
        //var_dump($pData);
        //return null;

        if ($validator->validate($_POST)) {
            # validacion correcta
            $accounts = Account::where('username', $_POST['user'])->first();
            if (isset($accounts)){
                $exists = true;
            } else {
                # en caso de que sea estudiante verificamos si esta inscrito en la materia
                //$registered = IsRegistered::where("ci", "=", $_POST['ci'])->get()->toArray();
                $registered = IsRegistered::where('ci', $_POST['ci'])->first();
                # crear nuevo usuario
                $tuser = 3;
                //if ($_POST['tuser'] == 1 || $_POST['tuser'] == 2 || !empty($registered)) {
                if (isset($registered)) {
                    $postulant = Postulant::where('ci', $_POST['ci'])->first();
                    if (isset($postulant)) {
                        $repeatedci = true;
                    } else {
                        $userAccount = $this->newAccount($_POST['user'], $_POST['pwd']);
                        $pData['id_account'] = $userAccount;
                        $result = $this->createUser($tuser, $pData);
                        # cambiar definiendo instancia del usuario 
                        $this->setProfile($tuser, $userAccount); 
                    }
                } else {
                    $rejected = true;
                }
            }
        } else {
            # datos no aceptados por el validador
            $errors = $validator->getMessages();
        }
        return $this->render(
            'accounts/signup.twig',
            ['result' => $result,
            'errors' => $errors,
            'user' => $pData,
            'exists' => $exists,
            'rejected' => $rejected,
            'repeatedci' => $repeatedci
        ]);
    }

    /**
     * @param string $user
     * @param string $pwd
     * @return int id_account
     */
    private function newAccount($user, $pwd)
    {
        $account = new Account([
            'username' => $user,
            'password' => password_hash($pwd, PASSWORD_DEFAULT)
        ]);
        $account->save();
        return $account->id;
    }

    /**
     * @param int $user
     * @param array $profile
     * @return bool ok_inserted
     */
    private function createUser($tuser, $profile)
    {   
        $user = null;
        if ($tuser == 1) {
            # Professional de Umss
            $user = new ProfessionalUmss();
        }elseif ($tuser == 2){
            #Professional exterior
            $user = new ProfessionalExt();
        }else {
            # Postulante
            $user = new Postulant();
        }
        $user->ci = $profile['ci'];
        $user->name = $profile['name'];
        $user->l_name = $profile['l_name'];
        $user->ml_name = $profile['ml_name'];
        $user->email = $profile['email'];
        $user->cod_sis = $profile['cod_sis'];
        $user->id_account = $profile['id_account'];        
        $user->save();
        return true;
    }
    private function setProfile($tuser, $id){
        $nameSes = '';
        $account = Account::where('id', $id)->first();
        if ($tuser == 1 || $tuser == 2) {
            # Professional de Umss
            $nameSes = 'profID';
            $this->setSession($account, $nameSes);
        }else {
            # Postulante
            $nameSes = 'postID';
            $this->setSession($account, $nameSes);
        }
    }
    
    private function setSession($user, $name)
    {
        $_SESSION[$name] = $user->id;
        header('Location:' . BASE_URL . 'signin');
        return null;
    }

}
