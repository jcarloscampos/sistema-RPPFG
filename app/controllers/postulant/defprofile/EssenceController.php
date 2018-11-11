<?php

namespace AppPHP\Controllers\Postulant\Defprofile;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Postulant;
use AppPHP\Models\Modality;
use AppPHP\Models\Career;
use AppPHP\Models\Area;

/**
 * Clase controlador de inicio para Postunalte del proyecto.
 * Mediante este controlador interactuan las opciones de configuracion del Postulante.
 */

class EssenceController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $userId = $_SESSION['postID'];
            $inforeg = false;

            if ($userId) {
                # si existe la cuenta en la BD
                $user = Postulant::where('id_account', $userId)->first();
                if ($user->cod_sis == "") {
                    $inforeg = true;
                }
            }
        }
        return $this->render('postulant/settle-essence.twig', ['vPerfil'=>$user]);
        // header('Location: ' . BASE_URL . '');
    }
    
    public function postIndex()
    {
            if (isset($_SESSION['postID'])) {
                    $user = Postulant::where('id_account', $_SESSION['postID'])->first();
                    echo "holaaaa";
                   //PROFILE['num_profile','title','g_objective','s_objects','description','id_cmpy_area','id_mod','id_status']
            //POSTULANT-PROFILE['id_postulant', 'id_profile', 'id_career', 'id_period']
            header('Location: ' . BASE_URL . 'postulant/settle/restrained');
        }
    }
}