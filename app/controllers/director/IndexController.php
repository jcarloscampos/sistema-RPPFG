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
            $userId = $_SESSION['dirID'];
           // $director = ProfessionalUmss->
            $director = ProfessionalUmss::where('id_account', $userId)->first();

            if ($director) {
                # si existe la cuenta en la BD
                return $this->render('director/index.twig', ['account'=>$director]);

            }
        }
        header('Location: ' . BASE_URL . '');
    }
}