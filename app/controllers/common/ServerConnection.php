<?php

namespace AppPHP\Controllers\Common;

use AppPHP\Controllers\BaseController;

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
}