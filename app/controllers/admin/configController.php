<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;
use AppPHP\Models\Account;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;

class configController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $userprofile = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/config.twig', ['vPerfil' => $userprofile]);
        }
    }

    public function postIndex()
    {
        $errors = [];
        $result = false;
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection(); 
        $user = Administrator::find($_POST['id']);
        
        $validation->setRuleBasic($validator);

        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'phone'=> $_POST['phone'],
            'email'=> $_POST['email'],
            'address'=> $_POST['address'],
            'avatar'=> $_POST['avatar']
        ];

        if ($validator->validate($_POST)) {
            if (isset($_POST['pwd']) && $_POST['pwd'] != "") {
                 # los campos de pwd fueron modificados
                 $result = $makeDB->updateAccount($user, $_POST['pwd']);
            }
            # solo actualiza datos
            $result = $makeDB->updateUser($user, $userprofile, $makeDB);
        }else{
            $errors = $validator->getMessages();
        }
        $user = Administrator::find($_POST['id']);
        return $this->render('admin/config.twig',
            ['errors' => $errors, 'vPerfil' => $user, 'result' => $result
        ]);
    }
}