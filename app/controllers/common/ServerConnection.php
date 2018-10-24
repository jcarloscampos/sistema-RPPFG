<?php

namespace AppPHP\Controllers\Common;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Account;

/**
 * Clase controlador de inicio para Director de Carrera.
 * Mediante este controlador interactuan las opciones de configuracion del Director de Carrera.
 */

class ServerConnection extends BaseController
{
    public function setSession($user, $name)
    {
        $_SESSION[$name] = $user->id;
        header('Location:' . BASE_URL . 'signin');
        return null;
    }

   

    /**
     * @param object $user : Usuario del que se actualizara la contraseña de su cuenta.
     * @param string $pwd : Nueva contraseña.
     * @return bool $result : confirmacion de que fue actualizado el campos de contraseña.
     */
    //$result = $this->updateAccount($_POST['id_account'], $_POST['pwd']);
    public function updateAccount($user, $pwd)
    {
        $result = false;
        $account = Account::find($user->id_account);
        if ($account) {
            Account::where('id', $user->id_account)->update(array(
                'password' => password_hash($pwd, PASSWORD_DEFAULT)
            ));
            $result = true;
        }
        return $result;
    }

    /**
     * @param object $user : Usuario del que se actualizará algún campo
     * @param array $userprofile : Contenido con el que se actualizará algún campo
     * @param object $makeDB : Instancia de la clase ServerConnection (clase actual)
     * @return bool $result : confirmacion de que fue actualizado agun campo.
     */
    public function updateUser($user, $userprofile, $makeDB)
    {   
        $result = false;

        foreach ($userprofile as $column=>$data) {
            if ($user->$column != $data) {
                # Si el campo del usuario es diferente al obtenido del formulario
                $makeDB->$column($user, $data);
                $result = true;
            }
        }
        return $result;
    }



    /********************** FUNCIONES PARA ACTUALIZAR CAMPOS EN LA BD **********************/
    
    /**
     * @param object $user : Usuario del que se actualizara una característica.
     * @param string $arg : Dato con el que se actualizara una característica.
     */

    public function name($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('name' => $arg));
        }
    }
    public function l_name($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('l_name' => $arg));
        }
    }
    public function ml_name($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('ml_name' => $arg));
        }
    }
    public function ci($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('ci' => $arg));
        }
    }
    public function email($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('email' => $arg));
        }
    }
    public function phone($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('phone' => $arg));
        }
    }
    public function address($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('address' => $arg));
        }
    }
    public function avatar($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('avatar' => $arg));
        }
    }
    public function profile($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('profile' => $arg));
        }
    }
    public function a_degree($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('a_degree' => $arg));
        }
    }
    public function cod_sis($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('cod_sis' => $arg));
        }
    }
    public function workload($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('workload' => $arg));
        }
    }
}
