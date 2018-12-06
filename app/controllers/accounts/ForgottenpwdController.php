<?php

namespace AppPHP\Controllers\Accounts;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Account;
use AppPHP\Models\UserRol;
use AppPHP\Models\Postulant;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Administrator;
use AppPHP\Models\Secretary;

use Sirius\Validation\Validator;
use AppPHP\Controllers\Common\Mail;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\SettingData;
use AppPHP\Controllers\Common\ServerConnection;

/**
 * Clase controlador para inicio de sesión de todos los usuarios asociados a este sistema
 */

class ForgottenpwdController extends BaseController
{
    /**
     * Redirecciona al perfil del usuario segun el tipo de cuenta que tienen
     */
    public function getIndex()
    {
        if (isset($_SESSION['admID']) || isset($_SESSION['staryID']) || isset($_SESSION['dirID']) || 
        isset($_SESSION['postID']) || isset($_SESSION['iprofID']) || isset($_SESSION['eprofID'])) {
            header('Location:' . BASE_URL . 'signin');
            return null;
        } else {
            return $this->render('accounts/forgottenpwd.twig');
        }
    }
 

    public function postIndex()
    {
        $errors = [];
        $result = false;
        $match = false;
        $matchEmail = false;
        $validator = new Validator();
        $validation = new Validation();
        $generate = new SettingData();
        $makeDB = new ServerConnection();
        $mail = new Mail();

        $validation->setRuleCI($validator);
        $validation->setRuleEmail($validator);

        $userprofile = [
            'email'=> $_POST['email'],
            'ci'=> $_POST['ci']
        ];

        if ($validator->validate($_POST)) {

            $postulant = Postulant::where('ci', $userprofile['ci'])->first();
            $itn = ProfessionalUmss::where('ci', $userprofile['ci'])->first();
            $etn = ProfessionalExt::where('ci', $userprofile['ci'])->first();
            $admin = Administrator::where('ci', $userprofile['ci'])->first();
            $secretary = Secretary::where('ci', $userprofile['ci'])->first();

            if (isset($postulant) || isset($itn) || isset($etn) || isset($admin) || isset($secretary)) {
                if ($this->issetEmail($postulant, $userprofile['email'])) {
                    # Recuperar cuenta de postulante
                    $result = $this ->accountRecovery($postulant, $generate, $makeDB, $mail);
                    return $this->render('accounts/forgottenpwd.twig', ['sent'=>$result]);
                    return null;
                } elseif ($this->issetEmail($itn, $userprofile['email'])) {
                    # Recuperar cuenta de docente de UMS;
                    $result = $this ->accountRecovery($itn, $generate, $makeDB, $mail);
                    return $this->render('accounts/forgottenpwd.twig', ['sent'=>$result]);
                    return null;
                } elseif ($this->issetEmail($etn, $userprofile['email'])) {
                    # Recuperar cuenta de docente extern;
                    $result = $this ->accountRecovery($etn, $generate, $makeDB, $mail);
                    return $this->render('accounts/forgottenpwd.twig', ['sent'=>$result]);
                    return null;
                } elseif ($this->issetEmail($admin, $userprofile['email'])) {
                    # Recuperar cuenta de administrardo;
                    $result = $this ->accountRecovery($admin, $generate, $makeDB, $mail);
                    return $this->render('accounts/forgottenpwd.twig', ['sent'=>$result]);
                    return null;
                } elseif ($this->issetEmail($secretary, $userprofile['email'])) {
                    # Recuperar cuenta de secretari;
                    $result = $this ->accountRecovery($secretary, $generate, $makeDB, $mail);
                    return $this->render('accounts/forgottenpwd.twig', ['sent'=>$result]);
                    return null;
                } else {
                    $matchEmail = true;
                    return $this->render('accounts/forgottenpwd.twig', ['errors' => $errors, 'vPerfil'=>$userprofile, 'matchEmail'=>$matchEmail]);
                }
                

                //header('Location:' . BASE_URL . 'signin');
            }else {
                $match = true;
                return $this->render('accounts/forgottenpwd.twig', ['errors' => $errors, 'vPerfil'=>$userprofile, 'match'=>$match]);
                return null;
            }
        }else{
            $errors = $validator->getMessages();
        }
        return $this->render('accounts/forgottenpwd.twig', ['errors' => $errors, 'vPerfil'=>$userprofile]);
    }

    private function issetEmail($user, $email) 
    {
        $resul = false;
        if (isset($user)) {
            if ($user->email == $email)
                $resul = true;
        }
        return $resul;
    }

    private function accountRecovery($user, $generate, $makeDB, $mail)
    {   
        $result = false;
        $datasend = [];
        $pwd = $generate->generatePassword();

        if ($makeDB->updateAccount($user, $pwd)){
            $account = Account::where('id', $user->id_account)->first();
            $username = $account->username;
    
            $datasend['email'] = $user->email;
            $datasend['username'] = $username;
            $datasend['password'] = $pwd;
    
            $result = $mail->sendEMail($datasend);
        }
        
        return $result;
    }
}