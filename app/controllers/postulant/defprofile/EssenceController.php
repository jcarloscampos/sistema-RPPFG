<?php

namespace AppPHP\Controllers\Postulant\Defprofile;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Postulant;
use AppPHP\Models\Profile;
use AppPHP\Models\Status;
use AppPHP\Models\PostulantProfile;
use Sirius\Validation\Validator;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use AppPHP\Controllers\Common\SettingData;

/**
 * Clase controlador de inicio para Postunalte del proyecto.
 * Mediante este controlador interactuan las opciones de configuracion del Postulante.
 */

class EssenceController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $user = Postulant::where('id_account', $_SESSION['postID'])->first();
            $uimage = substr($user->name, 0, 1);
            $aux = PostulantProfile::where('id_postulant', $user->id)->first();
            if (!isset($aux) || $this->isUnfinished($aux->id_profile)){
                return $this->render('postulant/settle-essence.twig', ['vPerfil'=>$user, 'uimage'=>$uimage]);
            } else {
                $status = Profile::where('id', $aux->id_profile)->first();
                $msg = $status->id_status;
                return $this->render('postulant/messages.twig', ['vPerfil' => $user, 'uimage'=>$uimage, 'msg' => $msg]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }
    
    public function postIndex()
    {
        if (isset($_SESSION['postID'])) {
            $user = Postulant::where('id_account', $_SESSION['postID'])->first();
            $uimage = substr($user->name, 0, 1);
            $makeDB = new ServerConnection(); 
            $validation = new Validation();
            $validator = new Validator();
            $errors = [];
            $validation->setRuleDefTwo($validator);

            $profileData = [
                'title' => $_POST['title'],
                'g_objective' => $_POST['gobj'],
                's_objects' => $_POST['sobj'],
                'description' => $_POST['dcptn']
            ];

            if ($validator->validate($_POST)) {
                $postPfl = PostulantProfile::where('id_postulant', $user->id)->first();
                $currentpfl = Profile::where('id', $postPfl->id_profile)->first();
                if ($makeDB->updateUser($currentpfl, $profileData, $makeDB)) {
                    header('Location: ' . BASE_URL . 'postulant/settle/restrained');
                    return null;
                } else
                    $makeDB->removeProfile($currentpfl);
            } else {
                $errors = $validator->getMessages();
                return $this->render('postulant/settle-essence.twig', ['vPerfil'=>$user, 'uimage'=>$uimage, 'errors' => $errors, 'vpData' => $profileData]);

            }
        }
        header('Location: ' . BASE_URL . '');
    }

    private function isUnfinished($idpfl)
    {
        $result = false;
        $pfl = Profile::where('id', $idpfl)->first();

        if($pfl->title == "" && $pfl->g_objective == "" && $pfl->s_objects == "" && $pfl->description == "")
            $result = true;
        return $result;
    }
}