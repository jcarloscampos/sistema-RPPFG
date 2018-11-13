<?php

namespace AppPHP\Controllers\Secretary;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Secretary;

/**
 * Clase controlador de inicio para Director de Carrera.
 * Mediante este controlador interactuan las opciones de configuracion del Director de Carrera.
 */

class IndexController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['staryID'])) {
            $userId = $_SESSION['staryID'];
           // $director = ProfessionalUmss->
            $user = Secretary::where('id_account', $userId)->first();
            $uimage = substr($user->name, 0, 1);

            if ($user) {
                # si existe la cuenta en la BD
                return $this->render('secretary/index.twig', ['vPerfil'=>$user, 'uimage'=>$uimage]);

            }
        }
        header('Location: ' . BASE_URL . '');
    }
}