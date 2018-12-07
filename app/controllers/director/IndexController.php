<?php

namespace AppPHP\Controllers\Director;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\ProfessionalUmss;

/**
 * Clase controlador de inicio para Director de Carrera.
 * Mediante este controlador interactuan las opciones de configuracion del Director de Carrera.
 */

class IndexController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['dirID'])) {
            $user = ProfessionalUmss::where('id_account', $_SESSION['dirID'])->first();
            $uimage = substr($user->name, 0, 1);

            if (isset($user)) {
                # si existe la cuenta en la BD
                return $this->render('director/index.twig', ['vPerfil'=>$user, 'uimage'=>$uimage]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }
}