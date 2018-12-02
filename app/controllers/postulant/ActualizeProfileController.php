<?php

namespace AppPHP\Controllers\Postulant;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Postulant;
use AppPHP\Models\Postulantprofile;
use AppPHP\Models\Profile;

/**
 * Clase controlador de inicio para Postunalte del proyecto.
 * Mediante este controlador interactuan las opciones de configuracion del Postulante.
 */

class ActualizeProfileController extends BaseController
{
    //controlar que no ingresen antes de definir un perfil y depues de publicar
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $userId = $_SESSION['postID'];
            if ($userId) {
                # si existe la cuenta en la BD
                $user = Postulant::where('id_account', $userId)->first();
                $uimage = substr($user->name, 0, 1);
                $postulantProfile = PostulantProfile::where('id_postulant', $user->id)->first();
                $profile = Profile::where('id', $postulantProfile->id_profile)->first();
                $tutors = $makeDB->getTutors($profile);
                return $this->render('postulant/actualize-profile.twig', ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }
}