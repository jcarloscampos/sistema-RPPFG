<?php

namespace AppPHP\Controllers\Professional;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\Account;

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
        $validator = new Validator();
        $result = false;
        
        $validator->add(array(
            'codsis:Código SIS'=>'  required | 
                                    minlength(7)({label} debe tener maoyr de {min} caracteres) | 
                                    maxlength(9)({label} debe tener menos de {max} caracteres)',

            'phone: Teléfono o celular'=>'  minlength(7)({label} debe tener al menos {min} caracteres) | 
                                            maxlength(8)({label} debe tener menos de {max} caracteres)',
            'email:Email'=> 'required | email',
            'address:Dirección de domiciliio'=> 'minlength(5)({label} debe tener al menos {min} caracteres) | 
                                                maxlength(200)({label} debe tener menos de {max} caracteres)',
            'pwd:Contraseña'=>  'minlength(5)({label} debe tener al menos {min} caracteres) | 
                                maxlength(30)({label} debe tener menos de {max} caracteres)',
            'pwdc:Contraseñas'=> 'match(item=pwd)({label} no coinciden )'
            
        ));
       
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
        
        $userP = ProfessionalUmss::where('id_account',$_SESSION['profID'])->first();
        (isset($_POST['adegree'])) ? $userprofile['a_degree'] = $_POST['adegree'] : $userprofile['a_degree'] = $userP->a_degree;
        (isset($_POST['wload'])) ? $userprofile['workload'] = $_POST['wload'] : $userprofile['workload'] = $userP->workload;

        if ($validator->validate($_POST)) {
            if (isset($_SESSION['profID'])) {
                
                if (isset($_POST['pwd']) && $_POST['pwd'] != "") {
                    if ($this->datacompare($_POST['id'], $userprofile)) {
                        # solo actualiza el password
                        $result = $this->updateAccount($_POST['id_account'], $_POST['pwd']);
                    } else {
                        # actualiza datos y password
                        $result = $this->updateAccount($_POST['id_account'], $_POST['pwd']);
                        $result = $this->updateUser($_POST['id'], $userprofile);
                    }
                } else {
                    # solo actualiza datos
                    $result = $this->updateUser($_POST['id'], $userprofile);
                }
            }
        }else{
            $errors = $validator->getMessages();
            
        }
        return $this->render(
            'professional/config.twig',
            ['vPerfil' => $userprofile,
            'errors' => $errors,
            'result' => $result
            ]);
    }
    /**
     * @param int $id
     * @param string $pwd
     */
    private function updateAccount($id, $pwd)
    {
        $account = Account::find($id);
        if ($account) {
            Account::where('id', $id)->update(array(
                'password' => password_hash($pwd, PASSWORD_DEFAULT)
            ));
        }
        return true;
    }

    /**
     * @param array $profile
     * @return bool ok_inserted
     */
    private function updateUser($id, $profile)
    {   
        $user = ProfessionalUmss::find($id);
        if ($user) {
            ProfessionalUmss::where('id', $id)->update(array(
                'phone' => $profile['phone'],
                'address' => $profile['address'],
                'avatar' => $profile['avatar'],
                'cod_sis' => $profile['cod_sis'],
                'a_degree' => $profile['a_degree'],
                'workload' => $profile['workload'],
                'profile' => $profile['profile']
            ));
        }
        return true;
    }
    private function datacompare($id, $data)
    {
        $valid = false;
        $user = ProfessionalUmss::where('id', $id)->first();
        if (
        $user->phone == $data['phone'] && $user->cod_sis == $data['cod_sis'] && 
        $user->address == $data['address'] && $user->avatar == $data['avatar'] &&
        $user->a_degree == $data['a_degree'] && $user->workload == $data['workload'] &&
        $user->profile == $data['profile']) {
            $valid = true;
        }
        return $valid;
    }
}