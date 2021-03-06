<?php

namespace AppPHP\Controllers\Postulant;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Postulant;

/**
 * Clase controlador de inicio para Postunalte del proyecto.
 * Mediante este controlador interactuan las opciones de configuracion del Postulante.
 */

class IndexController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $userId = $_SESSION['postID'];
            $inforeg = false;

            if ($userId) {
                # si existe la cuenta en la BD
                $user = Postulant::where('id_account', $userId)->first();
                $uimage = substr($user->name, 0, 1);
                if ($user->cod_sis == "") {
                    $inforeg = true;
                }
                return $this->render('postulant/index.twig', ['inforeg'=>$inforeg, 'vPerfil'=>$user, 'uimage'=>$uimage]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }
}