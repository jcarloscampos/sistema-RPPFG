<?php

namespace AppPHP\Controllers\Postulant\Defprofile;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Postulant;
use AppPHP\Models\Modality;
use AppPHP\Models\Career;
use AppPHP\Models\Area;
use AppPHP\Models\ProfSmatter;
use AppPHP\Models\SubjectMatter;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\EtnProfArea;
use AppPHP\Models\ItnProfArea;
use AppPHP\Models\Responsable;
use AppPHP\Models\TypeResponsable;
use AppPHP\Models\EtnTutor;

use AppPHP\Models\Profile;
use AppPHP\Models\PostulantProfile;
use AppPHP\Models\AreaProfile;

use Sirius\Validation\Validator;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use AppPHP\Controllers\Common\SettingData;


/**
 * Clase controlador de inicio para Postunalte del proyecto.
 * Mediante este controlador interactuan las opciones de configuracion del Postulante.
 */

class RestrainedController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $user = Postulant::where('id_account', $_SESSION['postID'])->first();
            $uimage = substr($user->name, 0, 1);
            $aux = PostulantProfile::where('id_postulant', $user->id)->first();
            
            if (!isset($aux) || $this->isUnfinished($aux->id_profile)){
                $matter = SubjectMatter::where('sigla', '2010214')->first();
                $pmatter = ProfSmatter::where("id_smatter", "=", $matter->id)->get()->toArray();
                $generate = new SettingData();
                $areaprofiles = AreaProfile::all();
                $iprofessionals = ProfessionalUmss::all();
                $eprofessionals = ProfessionalExt::all();
                $etnprofareas = EtnProfArea::all();
                $itnprofareas = ItnProfArea::all();

                $itutors = $generate->getTutors($areaprofiles, $itnprofareas, $iprofessionals);
                $etutors = $generate->getTutors($areaprofiles, $etnprofareas, $eprofessionals);

                return $this->render('postulant/settle-restrained.twig',
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'matter' => $matter, 'pmatters' => $pmatter, 'iprofessionals'=> $iprofessionals, 
                'eprofessionals' => $eprofessionals, 'itutors' => $itutors, 'etutors' => $etutors]);
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
            $matter = SubjectMatter::where('sigla', '2010214')->first();
            $pmatter = ProfSmatter::where("id_smatter", "=", $matter->id)->get()->toArray();
            
            $generate = new SettingData();
            $areaprofiles = AreaProfile::all();
            $iprofessionals = ProfessionalUmss::all();
            $eprofessionals = ProfessionalExt::all();
            $etnprofareas = EtnProfArea::all();
            $itnprofareas = ItnProfArea::all();
            //hasta aqui para vista............

            $makeDB = new ServerConnection(); 
            $validation = new Validation();
            $validator = new Validator();
            $errors = [];

            $validation->setRuleDefThree($validator);

            if ($validator->validate($_POST)) {

                $postPfl = PostulantProfile::where('id_postulant', $user->id)->first();
                $currentpfl = Profile::where('id', $postPfl->id_profile)->first();

                // Designa el docente de materia
                $doc = $this->setResponsable($_POST['psmatter'], $currentpfl, 'teacher', $makeDB);

                // Designa un tutor
                $ftutor = $this->setTutor($_POST['tutor'], $currentpfl, $makeDB);

                if (isset($_POST['stutor'])) {
                    if($_POST['stutor'] != $_POST['tutor'])
                        $stutor = $this->setTutor($_POST['stutor'], $currentpfl, $makeDB);
                }

                if ($doc && $ftutor) {
                    //header('Location: ' . BASE_URL . 'postulant');
                    //return null;
                    $msg = 2;
                    return $this->render('postulant/messages.twig', ['vPerfil' => $user, 'uimage'=>$uimage, 'msg' => $msg]);
                } else
                    $makeDB->removeProfile($currentpfl);
            } else {
                $errors = $validator->getMessages();
                $itutors = $generate->getTutors($areaprofiles, $itnprofareas, $iprofessionals);
                $etutors = $generate->getTutors($areaprofiles, $etnprofareas, $eprofessionals);
                return $this->render('postulant/settle-restrained.twig', 
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'errors' => $errors, 'matter' => $matter, 'pmatters' => $pmatter, 'iprofessionals'=> $iprofessionals,
                'eprofessionals' => $eprofessionals, 'itutors' => $itutors, 'etutors' => $etutors
                ]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }

    private function isUnfinished($idpfl)
    {
        $result = false;
        $auxt = EtnTutor::where('id_profile', $idpfl)->first();
        $auxp = Responsable::where('id_profile', $idpfl)->first();

        if (!isset($auxt) || !isset($auxp))
            $result = true;
        
        return $result;
    }

    private function setResponsable($idTeacher, $profile, $type, $makeDB)
    {
        $result = false;
        $idTypeResp = $makeDB->getTypeResponsable($type);

        if (isset($idTeacher) && isset($profile) && isset( $idTypeResp)) {
            $resp = new Responsable([
                'id_intprof' => $idTeacher,
                'id_profile' => $profile->id,
                'id_type_resp' => $idTypeResp
            ]);
            $resp->save();
            $result = true;
        }
        return $result;
    }

    private function setTutor($tutorAccount, $profile, $makeDB)
    {
        $result = false;
        $iprof = ProfessionalUmss::where('id_account', $tutorAccount)->first();
        $eprof = ProfessionalExt::where('id_account', $tutorAccount)->first();

        if (isset($iprof)){
            $result = $this->setResponsable($iprof->id, $profile, 'tutor', $makeDB);
        } elseif (isset($eprof)){
            $nEtnTutor = new EtnTutor([
                'id_entprof' => $eprof->id,
                'id_profile' => $profile->id
            ]);
            $nEtnTutor->save();
            $result = true;
        }
        return $result;
    }
    
}