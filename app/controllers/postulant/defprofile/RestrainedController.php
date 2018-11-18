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
use AppPHP\Models\Status;
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
                    header('Location: ' . BASE_URL . 'postulant/settle/restrained/view');
                    return null;
                    //$msg = 2;
                    //return $this->render('postulant/preview.twig', ['vPerfil' => $user, 'uimage'=>$uimage, 'msg' => $msg]);
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

    public function getView(){
        if (isset($_SESSION['postID'])) {
            $user = Postulant::where('id_account', $_SESSION['postID'])->first();
            $uimage = substr($user->name, 0, 1);
        
            //--------------------------------------------------------------------------------
            $makeDB = new ServerConnection();
            $pprofile = PostulantProfile::where('id_postulant', $user->id)->first();
            $profile = Profile::where('id', $pprofile->id_profile)->first();

            $postulantProfiles = PostulantProfile::all();
            $status = Status::all();
            $areaprofiles = AreaProfile::all();
            $responsables = Responsable::all();
        
            //Extrae los postulantes que trabajan en un perfil
            $posts = $makeDB->getPostulants($postulantProfiles, $profile);
            count($posts)>1 ? $group = true : $group = false;
            if ($group) {
                $postf = $posts[0];
                $posts = $posts[1];
            } else {
                $postf = $posts[0];
            }
        
            // Obtine carrera
            $career = $makeDB->getCareer($postulantProfiles, $profile);
            // Estdo actual del perfil
            $cstate = $makeDB->getState($profile);
            // periodo
            $period = $makeDB->getPeriod($postulantProfiles, $profile);
            $papproved = $period->period;
            $sapproved = substr($period->start_date, 0, 4);
            $approved = $papproved . '/' . $sapproved;
            // status
            $cstate = Status::where('id', $profile->id_status)->first();
        
            // Obtine los tutores del perfil
            $tutors = $makeDB->getTutors($profile);

            $twofold = false;

            if (count($tutors) == 1) {
                $tutorfir = $tutors[0];
                $tutorsec = null;
            } elseif (count($tutors) == 2) {
                $tutorfir = $tutors[0];
                $tutorsec = $tutors[1];
                $twofold = true;
            }

            // Modalidad de perfil
            $modality = $makeDB->getModality($profile);
            // Encargado de Empresa donde se realiza el trabajo dirigido
            $attendant = $makeDB->getAttendant($profile);
            // Director de carrera
            $director = $makeDB->getDirector();
            // Docente de materia
            $teacher = $makeDB->getTeacher($profile, $responsables);
            // Area y sub area
            $areap = $makeDB->getAreap($profile, $areaprofiles);
            $subareap = $makeDB->getSubAreap($profile, $areaprofiles);

            if ($group) {
                return $this->render(
                'postulant/preview.twig',
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                'status'=>$status, 'cstate'=>$cstate, 'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec,
                'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director, 'attendant'=>$attendant
                ]
            );
            }
            return $this->render(
            'postulant/preview.twig',
            ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
             'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,
            'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
            'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant
            ]
        );
            //--------------------------------------------------------------------------------
        }
    }

    public function getEdit($idprofile){
        if (isset($_SESSION['postID'])) {
            $profile = Profile::where('id', $idprofile)->first();
            $temstatus = Status::where('name', 'aceptado')->first();
            $user = Postulant::where('id_account', $_SESSION['postID'])->first();
            $uimage = substr($user->name, 0, 1);

            if ($profile->id_status == $temstatus->id) {
                $editp = true;
            
                //--------------------------------------------------------------------------------
                $makeDB = new ServerConnection();
                //$profile = Profile::where('id', $idprofile)->first();
    
                $postulantProfiles = PostulantProfile::all();
                $status = Status::all();
                $areaprofiles = AreaProfile::all();
                $responsables = Responsable::all();
            
                //Extrae los postulantes que trabajan en un perfil
                $posts = $makeDB->getPostulants($postulantProfiles, $profile);
                count($posts)>1 ? $group = true : $group = false;
                if ($group) {
                    $postf = $posts[0];
                    $posts = $posts[1];
                } else {
                    $postf = $posts[0];
                }
            
                // Obtine carrera
                $career = $makeDB->getCareer($postulantProfiles, $profile);
                // Estdo actual del perfil
                $cstate = $makeDB->getState($profile);
                // periodo
                $period = $makeDB->getPeriod($postulantProfiles, $profile);
                $papproved = $period->period;
                $sapproved = substr($period->start_date, 0, 4);
                $approved = $papproved . '/' . $sapproved;
                // status
                $cstate = Status::where('id', $profile->id_status)->first();
            
                // Obtine los tutores del perfil
                $tutors = $makeDB->getTutors($profile);
    
                $twofold = false;
    
                if (count($tutors) == 1) {
                    $tutorfir = $tutors[0];
                    $tutorsec = null;
                } elseif (count($tutors) == 2) {
                    $tutorfir = $tutors[0];
                    $tutorsec = $tutors[1];
                    $twofold = true;
                }
    
                // Modalidad de perfil
                $modality = $makeDB->getModality($profile);
                // Encargado de Empresa donde se realiza el trabajo dirigido
                $attendant = $makeDB->getAttendant($profile);
                // Director de carrera
                $director = $makeDB->getDirector();
                // Docente de materia
                $teacher = $makeDB->getTeacher($profile, $responsables);
                // Area y sub area
                $areap = $makeDB->getAreap($profile, $areaprofiles);
                $subareap = $makeDB->getSubAreap($profile, $areaprofiles);
    
                if ($group) {
                    return $this->render(
                    'postulant/preview.twig',
                    ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                    'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                    'status'=>$status, 'cstate'=>$cstate, 'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec,
                    'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director, 'attendant'=>$attendant,
                    'editp'=>$editp
                    ]
                );
                }
                return $this->render(
                'postulant/preview.twig',
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
                 'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,
                'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
                'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant, 'editp'=>$editp
                ]
            );
                //--------------------------------------------------------------------------------
            }else{
                $msg = 9;
                return $this->render('postulant/messages.twig', ['vPerfil' => $user, 'uimage'=>$uimage, 'msg' => $msg]);
            }

        }
    }
    public function postEdit($idprofile){
        if (isset($_SESSION['postID'])) {
            $temstatus = Status::where('name', 'aceptado')->first();
            $profile = Profile::where('id', $idprofile)->first();
            if ($profile->id_status == $temstatus->id) {
                $user = Postulant::where('id_account', $_SESSION['postID'])->first();
                $uimage = substr($user->name, 0, 1);
                $makeDB = new ServerConnection(); 
                $validation = new Validation();
                $validator = new Validator();
                $errors = [];
                $result = false;
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
                    $result = $makeDB->updateUser($currentpfl, $profileData, $makeDB);
                } else {
                    $errors = $validator->getMessages();
                    //return $this->render('postulant/settle-essence.twig', ['vPerfil'=>$user, 'uimage'=>$uimage, 'errors' => $errors, 'vpData' => $profileData]);
                }
    
                $editp = true;
            
                //--------------------------------------------------------------------------------
                //$profile = Profile::where('id', $idprofile)->first();
    
                $postulantProfiles = PostulantProfile::all();
                $status = Status::all();
                $areaprofiles = AreaProfile::all();
                $responsables = Responsable::all();
            
                //Extrae los postulantes que trabajan en un perfil
                $posts = $makeDB->getPostulants($postulantProfiles, $profile);
                count($posts)>1 ? $group = true : $group = false;
                if ($group) {
                    $postf = $posts[0];
                    $posts = $posts[1];
                } else {
                    $postf = $posts[0];
                }
            
                // Obtine carrera
                $career = $makeDB->getCareer($postulantProfiles, $profile);
                // Estdo actual del perfil
                $cstate = $makeDB->getState($profile);
                // periodo
                $period = $makeDB->getPeriod($postulantProfiles, $profile);
                $papproved = $period->period;
                $sapproved = substr($period->start_date, 0, 4);
                $approved = $papproved . '/' . $sapproved;
                // status
                $cstate = Status::where('id', $profile->id_status)->first();
            
                // Obtine los tutores del perfil
                $tutors = $makeDB->getTutors($profile);
    
                $twofold = false;
    
                if (count($tutors) == 1) {
                    $tutorfir = $tutors[0];
                    $tutorsec = null;
                } elseif (count($tutors) == 2) {
                    $tutorfir = $tutors[0];
                    $tutorsec = $tutors[1];
                    $twofold = true;
                }
    
                // Modalidad de perfil
                $modality = $makeDB->getModality($profile);
                // Encargado de Empresa donde se realiza el trabajo dirigido
                $attendant = $makeDB->getAttendant($profile);
                // Director de carrera
                $director = $makeDB->getDirector();
                // Docente de materia
                $teacher = $makeDB->getTeacher($profile, $responsables);
                // Area y sub area
                $areap = $makeDB->getAreap($profile, $areaprofiles);
                $subareap = $makeDB->getSubAreap($profile, $areaprofiles);
    
                if ($group) {
                    return $this->render(
                    'postulant/preview.twig',
                    ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                    'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                    'status'=>$status, 'cstate'=>$cstate, 'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec,
                    'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director, 'attendant'=>$attendant,
                    'editp'=>$editp, 'errors'=>$errors, 'result'=>$result
                    ]
                );
                }
                return $this->render(
                'postulant/preview.twig',
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
                 'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,
                'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
                'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant, 'editp'=>$editp,
                'errors'=>$errors, 'result'=>$result
                ]
                );
                //--------------------------------------------------------------------------------

            }

        }
        header('Location: ' . BASE_URL . '');
    }
    public function getDownload($idprofile)
    {
        echo "para descarga";
    }

    public function getPublish($idprofile)
    {
        $profile = Profile::where('id', $idprofile)->first();
        $cstatus = Status::where('name', 'aceptado')->first();
        if ($profile->id_status == $cstatus->id) {
            $nstatus = Status::where('name', 'revision')->first();
    
            $statusdata = ['id_status' => $nstatus->id];
    
            $makeDB = new ServerConnection(); 
    
            $result = $makeDB->updateUser($profile, $statusdata, $makeDB);
        }
        header('Location: ' . BASE_URL . 'postulant/settle/restrained/view');
    }
    
}