<?php

namespace AppPHP\Controllers;

use Sirius\Validation\Validator;
use AppPHP\Models\Account;
use AppPHP\Models\UserRol;
use AppPHP\Models\Rol;
use AppPHP\Models\Postulant;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;

/**
 * Esta clase extiende de BaseController adoptando todas sus características y funcionalidades.
 */

class IndexController extends BaseController
{
    /**
     * La función llamada será de tipo GET
     * @return render mediante la plantilla index.twig
     */
    public function getIndex()
    {
        if (isset($_SESSION['admID']) || isset($_SESSION['staryID']) || isset($_SESSION['dirID']) || 
        isset($_SESSION['postID']) || isset($_SESSION['iprofID']) || isset($_SESSION['eprofID'])) {
            header('Location:' . BASE_URL . 'signin');
            return null;
        } else {
            return $this->render('index.twig');
        }
        
    }

    /**
     * Funcion que permite crear sessiones segun tipo de usuario manejable por el sistema
     */
    public function postIndex()
    {
        $validator = new Validator();
        
        $validator->add('username:Nonbre de usuario',
                        'required | 
                        minlength(3)({label} debe tener al menos {min} caracteres)'
                    );
        $validator->add('password:Contraseña',
                        'required | 
                        minlength(5)({label} debe tener al menos {min} caracteres)'
                    );
        if ($validator->validate($_POST)) {
            $user = Account::where('username', $_POST['username'])->first();
            if ($user) {
                if (password_verify($_POST['password'], $user->password)) {
                    $nameSes = '';
                    # Si el usuario tiene un rol a su cargo
                    $hasCharge = $this->getAdmin($user->id);
                    if($hasCharge){
                        $rol = $this->getNameRol($hasCharge->id_rol);
                        if ($rol->name_rol == 'admin') {
                            # sesión para un administrador
                            $nameSes = 'admID';
                            $this->setSession($user, $nameSes);
                        } elseif ($rol->name_rol == 'secretary') {
                             # sesión para la secretaria
                             $nameSes = 'staryID';
                             $this->setSession($user, $nameSes);
                        }elseif ($rol->name_rol == 'director') {
                            # sesión para un director de carrera
                            $nameSes = 'dirID';
                            $this->setSession($user, $nameSes);
                        }elseif ($rol->name_rol == 'itnprof') {
                            # sesión para un director de carrera
                            $nameSes = 'iprofID';
                            $this->setSession($user, $nameSes);
                        }elseif ($rol->name_rol == 'etnprof') {
                            # sesión para un director de carrera
                            $nameSes = 'eprofID';
                            $this->setSession($user, $nameSes);
                        }
                    }
                    # si existe la cuenta en la BD y puede ser un postulante
                    $post = Postulant::where('id_account', $user->id)->first();
                    if ($post) {
                        $nameSes = 'postID';
                        $this->setSession($user, $nameSes);
                    }
                }
            }
            $validator->addMessage('username', 'Nombre de usuario y/o contraseña no son correctas');
        }
        $errors = $validator->getMessages();
        return $this->render('index.twig',[
            'errors' => $errors
        ]);
    }

    private function getAdmin($idAccount){
        return  UserRol::where('id_account', $idAccount)->first();
    }

    private function getNameRol($idRol){
        return  Rol::where('id_rol', $idRol)->first();
    }
    private function setSession($user, $name){
        $_SESSION[$name] = $user->id;
        header('Location:' . BASE_URL . 'signin');
        return null;
    }
}
