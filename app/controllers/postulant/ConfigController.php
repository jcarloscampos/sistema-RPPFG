<?php

namespace AppPHP\Controllers\Postulant;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\Postulant;
use AppPHP\Models\Account;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;

class ConfigController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $user = Postulant::where('id_account', $_SESSION['postID'])->first();
            $uimage = substr($user->name, 0, 1);
            return $this->render('postulant/config.twig', ['vPerfil' => $user,'uimage'=>$uimage]);
        }
    }

    public function postIndex()
    {
        $errors = [];
        $resultCPost = false;
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection();
        $user = Postulant::find($_POST['id']);
        
        $validation->setRuleBasic($validator);
        $validation->setRuleCodeSis($validator);
        $validation->setRuleCI($validator);
        
        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'cod_sis'=> $_POST['codsis'],
            'phone'=> $_POST['phone'],
            'email'=> $_POST['email'],
            'address'=> $_POST['address']
        ];
        
        if ($validator->validate($_POST)) {
            if (isset($_POST['pwd']) && $_POST['pwd'] != "") {
                # los campos de pwd fueron modificados
                $resultCPost = $makeDB->updateAccount($user, $_POST['pwd']);
            } else 
            # solo actualizar los datos
            $resultCPost = $makeDB->updateUser($user, $userprofile, $makeDB);
        } else {
            $errors = $validator->getMessages();
        }
        $user = Postulant::find($_POST['id']);
        $uimage = substr($user->name, 0, 1);
        return $this->render(
            'postulant/config.twig',
            ['vPerfil' => $user, 'uimage'=>$uimage, 'errors' => $errors, 'resultCPost' => $resultCPost
            ]
        );
    }
}