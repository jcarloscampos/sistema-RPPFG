<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;
use AppPHP\Models\Account;

class configController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $user = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/config.twig', ['user' => $user]);
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
            'phone: Teléfono o celular'=>'required | 
                                                minlength(7)({label} debe tener al menos {min} caracteres) | 
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
            'phone'=> $_POST['phone'],
            'email'=> $_POST['email'],
            'address'=> $_POST['address'],
            'avatar'=> $_POST['avatar']
        ];

        if ($validator->validate($_POST)) {
            if (isset($_SESSION['admID'])) {
                if (isset($_POST['pwd']) && $_POST['pwd'] != "") {
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
            'admin/config.twig',
            ['user' => $user,
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
        $admin = Administrator::find($id);
        if ($admin) {
            Administrator::where('id', $id)->update(array(
                'name' => $profile['name'],
                'l_name' => $profile['l_name'],
                'ml_name' => $profile['ml_name'],
                'ci' => $profile['ci'],
                'phone' => $profile['phone'],
                'email' => $profile['email'],
                'address' => $profile['address'],
                'avatar' => $profile['avatar']
            ));
        }
        return true;
    }
    private function datacompare($id, $data)
    {   
        $valid = false;
        $user = Administrator::where('id', $id)->first();

        if ($user->name == $data['name'] && $user->l_name == $data['l_name'] && 
        $user->ml_name == $data['ml_name'] && $user->ci == $data['ci'] && 
        $user->phone == $data['phone'] && $user->email == $data['email'] && 
        $user->address == $data['address'] && $user->avatar == $data['avatar']) {
            $valid = true;
        }
        return $valid;
    }
}