<?php

namespace AppPHP\Controllers\Professional;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Account;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;

class EtnConfigController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['profID'])) {
            $userprofile = ProfessionalExt::where('id_account', $_SESSION['profID'])->first();
            return $this->render('professional/etn-config.twig', ['vPerfil' => $userprofile]);
        }
    }
    
    public function postIndex()
    {
        $errors = [];
        $result = false;
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection(); 
        $user = ProfessionalExt::find($_POST['id']);
        
        $validation->setRuleBasic($validator);

        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'email'=> $_POST['email'],
            'phone'=> $_POST['phone'],
            'address'=> $_POST['address'],
            'avatar'=> $_POST['avatar'],
            'profile'=> $_POST['profile']
        ];
        
        (isset($_POST['adegree'])) ? $userprofile['a_degree'] = $_POST['adegree'] : $userprofile['a_degree'] = $user->a_degree;

        if ($validator->validate($_POST)) {
            if (isset($_POST['pwd']) && $_POST['pwd'] != "") {
                # los campos de pwd fueron modificados
                $result = $makeDB->updateAccount($user, $_POST['pwd']);
            }
            # solo actualizar los datos
            $result = $makeDB->updateUser($user, $userprofile, $makeDB);
        }else{
            $errors = $validator->getMessages();
        }
        $user = ProfessionalExt::find($_POST['id']);
        return $this->render('professional/etn-config.twig',
            ['vPerfil' => $user,
            'errors' => $errors,
            'result' => $result
            ]);
    }
}