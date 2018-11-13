<?php

namespace AppPHP\Controllers\Secretary;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Secretary;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\ProfessionalUmss;

use AppPHP\Models\Postulant;
use AppPHP\Models\Modality;
use AppPHP\Models\Career;
use AppPHP\Models\Area;
use AppPHP\Models\Profile;
use AppPHP\Models\Status;
use AppPHP\Models\Company;
use AppPHP\Models\PostulantProfile;
use AppPHP\Models\AreaProfile;
use AppPHP\Models\Period;

use AppPHP\Models\EtnTutor;
use AppPHP\Models\Responsable;


use Sirius\Validation\Validator;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use AppPHP\Controllers\Common\SettingData;

/**
 * Clase controlador de inicio para Director de Carrera.
 * Mediante este controlador interactuan las opciones de configuracion del Director de Carrera.
 */

class SettleController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['staryID'])) {
            $user = Secretary::where('id_account', $_SESSION['staryID'])->first();
            $uimage = substr($user->name, 0, 1);

            $profiles = Profile::all();
            $modalities = Modality::all();
            $etntutors = EtnTutor::all();
            $responsables = Responsable::all();

            $eprofs = ProfessionalExt::all();
            $iprofs = ProfessionalUmss::all();

            $postperfs = PostulantProfile::all();
            $posts = Postulant::all();

            $status = Status::all();
            $periods = Period::all();

            
            
            return $this->render('secretary/settle.twig',
            ['vPerfil'=>$user, 'uimage'=>$uimage, 'profiles'=>$profiles, 'modalities'=>$modalities, 'etntutors'=>$etntutors,
            'responsables'=>$responsables, 'eprofs'=>$eprofs, 'iprofs'=>$iprofs, 'postperfs'=>$postperfs, 'posts'=>$posts,
            'status'=>$status, 'periods'=>$periods
            ]);
        }
        header('Location: ' . BASE_URL . '');
    }
    public function getEdit($idprofile)
    {
        if (isset($_SESSION['staryID'])) {
            $user = Secretary::where('id_account', $_SESSION['staryID'])->first();
            $uimage = substr($user->name, 0, 1);

            
            return $this->render('secretary/index.twig', ['vPerfil'=>$user, 'uimage'=>$uimage]);
        }
        header('Location: ' . BASE_URL . '');
    }

}