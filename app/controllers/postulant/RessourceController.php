<?php

namespace AppPHP\Controllers\Postulant;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\Postulant;
use AppPHP\Models\Account;

class RessourceController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $user = Postulant::where('id_account', $_SESSION['postID'])->first();
            return $this->render('postulant/config.twig', ['user' => $user]);
        }
    }


    public function postIndex()
    {
        $errors = [];
        $validator = new Validator();
        $result = false;
        $validator->add(array(
            'name:Nonbre'=> 'required | 
                            minlength(3)({label} debe tener al menos {min} caracteres) | 
                            maxlength(30)({label} debe tener menos de {max} caracteres)',
            'lname:Apellido paterno'=> 'required | 
                                        minlength(3)({label} debe tener al menos {min} caracteres) | 
                                        maxlength(20)({label} debe tener menos de {max} caracteres)',
            'mlname:Apellido materno'=> 'required | 
                                        minlength(3)({label} debe tener al menos {min} caracteres) | 
                                        maxlength(20)({label} debe tener menos de {max} caracteres)',

            'ci:No de identificación personal (CI)'=>'required | 
                                                minlength(6)({label} debe tener al menos {min} caracteres) | 
                                                maxlength(15)({label} debe tener menos de {max} caracteres)',
            'codsis:Código SIS'=>'  required | 
                                    minlength(8)({label} debe tener al menos {min} caracteres) | 
                                    maxlength(8)({label} debe tener menos de {max} caracteres)',
            'phone: Teléfono o celular'=>'  minlength(7)({label} debe tener al menos {min} caracteres) | 
                                            maxlength(8)({label} debe tener menos de {max} caracteres)',
            'email:Email'=> 'required | email',
            'address:Dirección de domiciliio'=> 'minlength(5)({label} debe tener al menos {min} caracteres) | 
                                                maxlength(200)({label} debe tener menos de {max} caracteres)',
            'pwd:Contraseña'=>  'minlength(5)({label} debe tener al menos {min} caracteres) | 
                                maxlength(30)({label} debe tener menos de {max} caracteres)',
            'pwdc:Contraseñas'=> 'match(item=pwd)({label} no coinciden )'
            
        ));

        $user = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'cod_sis'=> $_POST['codsis'],
            'phone'=> $_POST['phone'],
            'email'=> $_POST['email'],
            'address'=> $_POST['address'],
            'avatar'=> $_POST['avatar']
        ];
        
        if ($validator->validate($_POST)) {
            if (isset($_SESSION['postID'])) {
                if (isset($_POST['pwd']) && $_POST['pwd'] != "") {
                    echo $_POST['id'];
                    if ($this->datacompare($_POST['id'], $user)) {
                        # solo actualiza el password
                        $result = $this->updateAccount($_POST['id_account'], $_POST['pwd']);
                    } else {
                        # actualiza datos y password
                        $result = $this->updateAccount($_POST['id_account'], $_POST['pwd']);
                        $result = $this->updateUser($_POST['id'], $user);
                    }
                } else {
                    # solo actualiza datos
                    $result = $this->updateUser($_POST['id'], $user);
                }
            }
        }else{
            $errors = $validator->getMessages();
            
        }
        return $this->render(
            'postulant/config.twig',
            ['user' => $user,
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
        $admin = Postulant::find($id);
        if ($admin) {
            Postulant::where('id', $id)->update(array(
                'email' => $profile['email'],
                'phone' => $profile['phone'],
                'address' => $profile['address'],
                'avatar' => $profile['avatar'],
                'cod_sis' => $profile['cod_sis']
            ));
        }
        return true;
    }
    private function datacompare($id, $data)
    {   
        $valid = false;
        $user = Postulant::where('id', $id)->first();
        if ($user->phone == $data['phone'] && $user->email == $data['email'] && 
        $user->address == $data['address'] && $user->avatar == $data['avatar'] &&
        $user->cod_sis == $data['cod_sis']) {
            $valid = true;
        }
        return $valid;
    }
}