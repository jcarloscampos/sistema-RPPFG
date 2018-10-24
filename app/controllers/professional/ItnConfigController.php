<?php

namespace AppPHP\Controllers\Professional;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;

class ItnConfigController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['profID'])) {
            $user = ProfessionalUmss::where('id_account', $_SESSION['profID'])->first();
            return $this->render('professional/config.twig', ['vPerfil' => $user]);
        }
    }


    public function postIndex()
    {
        $errors = [];
        $result = false;
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection();
        $user = ProfessionalUmss::find($_POST['id']);
        
        $validation->setRuleBasic($validator);
        $validation->setRuleCodeSis($validator);
       
        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'email'=> $_POST['email'],
            'cod_sis'=> $_POST['codsis'],
            'phone'=> $_POST['phone'],
            'address'=> $_POST['address'],
            'avatar'=> $_POST['avatar'],
            'profile'=> $_POST['profile']
        ];

        (isset($_POST['adegree'])) ? $userprofile['a_degree'] = $_POST['adegree'] : $userprofile['a_degree'] = $user->a_degree;
        (isset($_POST['wload'])) ? $userprofile['workload'] = $_POST['wload'] : $userprofile['workload'] = $user->workload;

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
        $user = ProfessionalUmss::find($_POST['id']);
        return $this->render(
            'professional/config.twig',
            ['vPerfil' => $user,
            'errors' => $errors,
            'result' => $result
            ]);
    }
}