<?php

namespace AppPHP\Controllers\Postulant;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Postulant;
use AppPHP\Models\Modality;
use AppPHP\Models\Career;
use AppPHP\Models\Area;

use AppPHP\Models\Profile;
use AppPHP\Models\PostulantProfile;

/**
 * Clase controlador de inicio para Postunalte del proyecto.
 * Mediante este controlador interactuan las opciones de configuracion del Postulante.
 */

class SettleController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $userId = $_SESSION['postID'];

            if ($userId) {
                # si existe la cuenta en la BD
                $user = Postulant::where('id_account', $userId)->first();
                $aux = PostulantProfile::where('id_postulant', $user->id)->first();
                $uimage = substr($user->name, 0, 1);
                if (!isset($aux)){
                    return $this->render('postulant/settle.twig', ['vPerfil'=>$user, 'uimage'=>$uimage]);
                } else {
                    $outer = true;
                    $msg = 1;
                    return $this->render('postulant/messages.twig', ['vPerfil' => $user, 'uimage'=>$uimage, 'msg' => $msg, 'outer'=>$outer]);
                }
            }
        }
        header('Location: ' . BASE_URL . '');
    }
}