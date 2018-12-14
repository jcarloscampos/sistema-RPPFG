<?php

namespace AppPHP\Controllers\Secretary;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\Secretary;
use AppPHP\Models\Account;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;

class configController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['staryID'])) {
            $user = Secretary::where('id_account', $_SESSION['staryID'])->first();
            $uimage = substr($user->name, 0, 1);
            return $this->render('secretary/config.twig', ['vPerfil' => $user, 'uimage'=>$uimage]);
        }
    }

    public function postIndex()
    {
        $errors = [];
        $resultCS = false;
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection(); 
        $user = Secretary::find($_POST['id']);
        $uimage = substr($user->name, 0, 1);
        $validation->setRuleBasic($validator);
        $validation->setRuleCI($validator);

        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'phone'=> $_POST['phone'],
            'email'=> $_POST['email'],
            'address'=> $_POST['address']
        ];

        if ($validator->validate($_POST)) {
            if (isset($_POST['pwd']) && $_POST['pwd'] != "") {
                 # los campos de pwd fueron modificados
                 $resultCS = $makeDB->updateAccount($user, $_POST['pwd']);
            } else 
            # solo actualiza datos
            $resultCS = $makeDB->updateUser($user, $userprofile, $makeDB);
        }else{
            $errors = $validator->getMessages();
        }
        $user = Secretary::find($_POST['id']);
        return $this->render('secretary/config.twig',
            ['errors' => $errors, 'vPerfil' => $user, 'uimage'=>$uimage, 'resultCS' => $resultCS
        ]);
    }
}