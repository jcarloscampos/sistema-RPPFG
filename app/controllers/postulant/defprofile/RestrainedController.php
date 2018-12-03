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
                
                $itutors = $generate->getTutors($areaprofiles, $itnprofareas, $iprofessionals, $aux->id_profile);
                $etutors = $generate->getTutors($areaprofiles, $etnprofareas, $eprofessionals, $aux->id_profile);
                
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
            $aux = PostulantProfile::where('id_postulant', $user->id)->first();
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
                $itutors = $generate->getTutors($areaprofiles, $itnprofareas, $iprofessionals, $aux->id_profile);
                $etutors = $generate->getTutors($areaprofiles, $etnprofareas, $eprofessionals, $aux->id_profile);
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
            $aux = PostulantProfile::where('id_postulant', $user->id)->first();
            $uimage = substr($user->name, 0, 1);
            $generate = new SettingData();
            
            if (isset($aux)){
                

                //--------------------------------------------------------------------------------
                $makeDB = new ServerConnection();
                $pprofile = PostulantProfile::where('id_postulant', $user->id)->first();
                $profile = Profile::where('id', $pprofile->id_profile)->first();

                $postulantProfiles = PostulantProfile::all();
                $status = Status::all();
                $areaprofiles = AreaProfile::all();
                $responsables = Responsable::all();

                $iprofessionals = ProfessionalUmss::all();
                $eprofessionals = ProfessionalExt::all();
                $etnprofareas = EtnProfArea::all();
                $itnprofareas = ItnProfArea::all();

                $itutors = $generate->getTutors($areaprofiles, $itnprofareas, $iprofessionals, $aux->id_profile);
                $etutors = $generate->getTutors($areaprofiles, $etnprofareas, $eprofessionals, $aux->id_profile);
            
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

                if (isset($pprofile)) {
                    //--------------------------------------------------------------------------------
                    $makeDB = new ServerConnection();
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
                    $tutorfir = [];
                    $tutorsec = [];
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
                    ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                    'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                    'status'=>$status, 'cstate'=>$cstate, 'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec,
                    'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director, 'attendant'=>$attendant, 'iprofessionals'=> $iprofessionals, 
                    'eprofessionals' => $eprofessionals, 'itutors' => $itutors, 'etutors' => $etutors                
                    ]
                );
                //--------------------------------------------------------------------------------
            }else{
                $msg = 7;
                return $this->render('postulant/messages.twig', ['vPerfil' => $user, 'uimage'=>$uimage, 'msg' => $msg]);
                
            }
            return $this->render(
            'postulant/preview.twig',
            ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
             'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,
            'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
            'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant, 'iprofessionals'=> $iprofessionals, 
            'eprofessionals' => $eprofessionals, 'itutors' => $itutors, 'etutors' => $etutors
            ]
            );
                //--------------------------------------------------------------------------------
            } else {
                $msg = 7;
                return $this->render('postulant/messages.twig', ['vPerfil' => $user, 'uimage'=>$uimage, 'msg' => $msg]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }

    public function getEdit($idprofile){
        if (isset($_SESSION['postID'])) {
            $profile = Profile::where('id', $idprofile)->first();
            $temstatus = Status::where('name', 'aceptado')->first();
            $user = Postulant::where('id_account', $_SESSION['postID'])->first();
            $uimage = substr($user->name, 0, 1);
            $generate = new SettingData();
            $aux = PostulantProfile::where('id_postulant', $user->id)->first();

            if ($profile->id_status == $temstatus->id) {
                $editp = true;
            
                //--------------------------------------------------------------------------------
                $makeDB = new ServerConnection();
                //$profile = Profile::where('id', $idprofile)->first();
    
                $postulantProfiles = PostulantProfile::all();
                $status = Status::all();
                $areaprofiles = AreaProfile::all();
                $responsables = Responsable::all();
            
                $iprofessionals = ProfessionalUmss::all();
                $eprofessionals = ProfessionalExt::all();
                $etnprofareas = EtnProfArea::all();
                $itnprofareas = ItnProfArea::all();

                $itutors = $generate->getTutors($areaprofiles, $itnprofareas, $iprofessionals, $aux->id_profile);
                $etutors = $generate->getTutors($areaprofiles, $etnprofareas, $eprofessionals, $aux->id_profile);
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
                $tutorfir = [];
                $tutorsec = [];
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
                    'editp'=>$editp, 'iprofessionals'=> $iprofessionals, 
                    'eprofessionals' => $eprofessionals, 'itutors' => $itutors, 'etutors' => $etutors
                    ]
                );
                }
                return $this->render(
                'postulant/preview.twig',
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
                 'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,
                'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
                'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant, 'editp'=>$editp, 'iprofessionals'=> $iprofessionals, 
                'eprofessionals' => $eprofessionals, 'itutors' => $itutors, 'etutors' => $etutors
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
            $aux = PostulantProfile::where('id_postulant', $user->id)->first();
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
                $generate = new SettingData();

    
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

                $iprofessionals = ProfessionalUmss::all();
                $eprofessionals = ProfessionalExt::all();
                $etnprofareas = EtnProfArea::all();
                $itnprofareas = ItnProfArea::all();

                $itutors = $generate->getTutors($areaprofiles, $itnprofareas, $iprofessionals, $aux->id_profile);
                $etutors = $generate->getTutors($areaprofiles, $etnprofareas, $eprofessionals, $aux->id_profile);
            
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
                    'editp'=>$editp, 'errors'=>$errors, 'result'=>$result, 'iprofessionals'=> $iprofessionals, 
                    'eprofessionals' => $eprofessionals, 'itutors' => $itutors, 'etutors' => $etutors
                    ]
                );
                }
                return $this->render(
                'postulant/preview.twig',
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
                 'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,
                'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
                'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant, 'editp'=>$editp,
                'errors'=>$errors, 'result'=>$result, 'iprofessionals'=> $iprofessionals, 
                'eprofessionals' => $eprofessionals, 'itutors' => $itutors, 'etutors' => $etutors
                ]
                );
                //--------------------------------------------------------------------------------

            }

        }
        header('Location: ' . BASE_URL . '');
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


    public function getDownload($idprofile)
    {
        if (isset($_SESSION['postID'])) {
            $auxp = Profile::where('id', $idprofile)->first();
            if (isset($auxp)) {
                //     $styles = file_get_contents('../public/assets/css/stylespdf.css');
                $html = $this->generateHTML($idprofile);
                $mpdf = new \Mpdf\Mpdf([
                    'mode' => 'utf-8', 
                    'format' => 'Letter', 
                    'orientation' => 'P'
                ]);
                //$mpdf->WriteHTML($styles, 1);
                $mpdf->WriteHTML($html);
                $mpdf->Output('perfil.pdf','I');
                exit;
            }
            header('Location: ' . BASE_URL . 'postulant');
        }
        header('Location: ' . BASE_URL . '');
    }
    

    private function generateHTML($idprofile)
    {
        $makeDB = new ServerConnection();
        $profile = Profile::where('id', $idprofile)->first();
        $html = '';
        $html .= '<div>';
        $html .= '
        <style>
        table.x11colortable td.c {text-align:center; background: white; }
        table.x11colortable td.c { text-transform:uppercase }
        table.x11colortable td.center {text-align: center;}
        table.x11colortable td:first-child, table.x11colortable td:first-child+td { border:1px solid black }
        table.x11colortable th {text-align:center; background:black; color:white }
        </style>
       
        <table align="center" class="x11colortable" style="background-color: white" >
            <tbody>
                <tr>
                    <td class="c" >
                        <div class="logoumss">
                            <img src="../public/images/logo-umss.png" alt="UMSS" width="80px" height="80px">
                        </div>
                    </td>
                    <td colspan="2" class="c">
                        <div class="nameinstt">
                            <h4> &nbsp; &nbsp; &nbsp;Universidad Mayor de San Simón &nbsp; &nbsp; </h4>
                            <h4> &nbsp; &nbsp; Facultad de Ciencias y Tecnología &nbsp; &nbsp; </h4>
                        </div>
                    </td>
                    
                    <td class="c">
                        <div class="logofcyt" style="float:right">
                            <img src="../public/images/logo-fcyt.png" alt="FCYT" width="80px" height="80px">
                        </div>
                    </td>
                </tr>
        ';
        
        $postulantProfiles = PostulantProfile::all();
        $status = Status::all();
        $areaprofiles = AreaProfile::all();
        $responsables = Responsable::all();
        
        // Modalidad de perfil
        $modality = $makeDB->getModality($profile);
        if ($modality->name_mod == "Trabajo Dirigido") {
            $html .= '
            <tr>
                <td colspan="4" style=" padding:2em;" class="c">
                    <h3 >Formulario de aprobación tema de trabajo dirigido</h3>
                </td>
                </tr>
                <tr>
                    <td colspan="4" style=" padding:.2em;" class="rr">
                        <p style="color:#3b3d3f;" ><strong>Nro.:</strong> ' . $profile->num_profile . '</p>
                    </td>
                </tr>
            ';
        } else {
            $html .= '
            <tr>
                <td colspan="4" style=" padding:2em;" class="c">
                    <h3 >Formulario de aprobación tema de proyecto final</h3>
                </td>
                </tr>
                <tr>
                    <td colspan="4" style=" padding:.2em;" class="rr">
                        <p><strong>Nro.:</strong> ' . $profile->num_profile . '</p>
                    </td>
                </tr>
            ';
        }
        
        //Extrae los postulantes que trabajan en un perfil
        $posts = $makeDB->getPostulants($postulantProfiles, $profile);
        count($posts)>1 ? $group = true : $group = false;
        
        if ($group) {
            $postf = $posts[0];
            $posts = $posts[1];
            $html .= '
                <tr style="text-align: left;">
                    <td width=25%><strong style="color:#3b3d3f; font-weight: bold;">Nombre del<br> estudiante(s)</strong></td>
                    <td width=25%><p style="font-size: 1em;  border-bottom: solid 1px gray; margin-bottom: 1em;">Apellido Paterno</p><p style="font-size: 1em;">' . $postf->l_name . '</p><p>' . $posts->l_name . '</p></td>
                    <td width=25%><p style="font-size: 1em;  border-bottom: solid 1px gray; margin-bottom: 1em;">Apellido Materno</p><p style="font-size: 1em;">' . $postf->ml_name . '</p><p>' . $posts->ml_name . '</p></td>
                    <td width=25%><p style="font-size: 1em;  border-bottom: solid 1px gray; margin-bottom: 1em;">Nombre(s) </p><p style="font-size: 1em;">' . $postf->name . '</p><p>' . $posts->name . '</p></td>
                </tr>
                <tr>
                    <td colspan="4" style=" padding: .5em;" class="c"></td>
                </tr>
                <tr>
                    <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold; text-align: left;">Email:<br></strong>' . $postf->email . '</p><p>' . $posts->email . '</p></td>
                    <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold; text-align: left;">Teléfono:<br></strong>' . $postf->phone . '</p><p>' . $posts->phone . '</p></td>
                </tr>
                <tr>
                    <td colspan="4" style=" padding: .5em;" class="c"></td>
                </tr>
            ';
        } else {
            $postf = $posts[0];
            $html .= '
                <tr>
                    <td width=25%><strong style="color:#3b3d3f; font-weight: bold;">Nombre del<br> estudiante(s)</strong></td>
                    <td width=25%><p style="font-size: .9em;  border-bottom: solid 1px gray; margin-bottom: 1em;">Apellido Paterno </p><p>' . $postf->l_name . '</p></td>
                    <td width=25%><p style="font-size: .9em;  border-bottom: solid 1px gray; margin-bottom: 1em;">Apellido Materno </p><p>' . $postf->ml_name . '</p></td>
                    <td width=25%><p style="font-size: .9em;  border-bottom: solid 1px gray; margin-bottom: 1em;">Nombre(s)</p><p>' . $postf->name . '</p></td>
                </tr>
                <tr>
                    <td colspan="4" style=" padding: .2em;" class="c"></td>
                </tr>
                <tr>
                    <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold;">Email:<br></strong>' . $postf->email . '</p></td>
                    <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold;">Teléfono:<br></strong>' . $postf->phone . '</p> </td>
                </tr>
                <tr>
                    <td colspan="4" style=" padding: .2em;" class="c"></td>
                </tr>
            ';
        }
        // Obtine carrera
        $career = $makeDB->getCareer($postulantProfiles, $profile);
        $html .= '
        <tr>
            <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold;">Carrera: </strong>' . $career->name . '</p></td>
            
            <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold;">Modalidad: </strong>' . $modality->name_mod . '</p></td>
            
        </tr>
        <tr>
            <td colspan="4" style=" padding: .2em;" class="c"></td>
        </tr>
        ';
        // Estdo actual del perfil
        $cstate = $makeDB->getState($profile);
        // periodo
        $period = $makeDB->getPeriod($postulantProfiles, $profile);
        $papproved = $period->period;
        $sapproved = substr($period->start_date, 0, 4);
        $approved = $papproved . '/' . $sapproved;
        if ($group) {
            $html .= '
            <tr>
                <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold;">Gestión de aprobación: </strong>' . $approved . '</p></td>
                <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold;"><input type="checkbox" checked="checked" /> Trabajo conjunto </strong></p></td>
            </tr>
            <tr>
                <td colspan="4" style=" padding: .2em;" class="c"></td>
            </tr>
            ';
        } else {
            $html .= '
            <tr>
                <td colspan="4"><p><strong style="color:#3b3d3f; font-weight: bold;">Gestión de aprobación: </strong>' . $approved . '</p></td>
            </tr>
            <tr>
                <td colspan="4" style=" padding: .2em;" class="c"></td>
            </tr>
            ';
        }
        // Encargado de Empresa donde se realiza el trabajo dirigido
        $attendant = $makeDB->getAttendant($profile);
        if ($modality->name_mod == "Trabajo Dirigido") {
            $html .= '
            <tr>
                <td colspan="4"><p><strong style="color:#3b3d3f; font-weight: bold;">Institución participante:  </strong>' . $attendant->name . " (".$attendant->acronym .")". '</p></td>
            </tr>
            <tr>
                <td colspan="4" style=" padding: .2em;" class="c"></td>
            </tr>
            ';
        }
        
        // status
        $cstate = Status::where('id', $profile->id_status)->first();
    
        // Obtine los tutores del perfil
        $tutors = $makeDB->getTutors($profile);

        $twofold = false;
        $tutorfir = [];
        $tutorsec = [];
        if (count($tutors) == 1) {
            $tutorfir = $tutors[0];
            $tutorsec = null;
        } elseif (count($tutors) == 2) {
            $tutorfir = $tutors[0];
            $tutorsec = $tutors[1];
            $twofold = true;
        }

        $html .= '
            <tr>
                <td colspan="4"><p><strong style="color:#3b3d3f; font-weight: bold;">Tutor(es): </strong>' . $tutorfir->name . " " . $tutorfir->l_name . " " . $tutorfir->ml_name
        ;
        if ($twofold) {
            $html .= ' - ' . $tutorsec->name . " " . $tutorsec->l_name . " " . $tutorsec->ml_name . '</p>
                </td>
            </tr>
            <tr>
                <td colspan="4" style=" padding: .2em;" class="c"></td>
            </tr>
            ';
        } else {
            $html .= '</p>
                </td>
            </tr>
            <tr>
                <td colspan="4" style=" padding: .2em;" class="c"></td>
            </tr>
            ';
        }
       
        // Director de carrera
        $director = $makeDB->getDirector();
        // Docente de materia
        $teacher = $makeDB->getTeacher($profile, $responsables);
        // Area y sub area
        $areap = $makeDB->getAreap($profile, $areaprofiles);
        $subareap = $makeDB->getSubAreap($profile, $areaprofiles);

        $html .= '
        <tr>
            <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold;">Área: </strong>' . $areap->name . '</p></td>
            <td colspan="2"><p><strong style="color:#3b3d3f; font-weight: bold;">Sub área: </strong>' . $subareap->name . '</p></td>
        </tr>
        <tr>
            <td colspan="4" style=" padding: .2em;" class="c"></td>
        </tr>
        ';
        $html .= '
        <tr>
            <td colspan="4"><p><strong style="color:#3b3d3f; font-weight: bold;">Título: </strong>' . $profile->title . '</p></td>
        </tr>
        <tr>
            <td colspan="4" style=" padding: .2em;" class="c"></td>
        </tr>

        <tr>
            <td colspan="4"><p><strong style="color:#3b3d3f; font-weight: bold;">Objetivo general: </strong>' . $profile->g_objective . '</p></td>
        </tr>
        <tr>
            <td colspan="4" style=" padding: .2em;" class="c"></td>
        </tr>

        <tr>
            <td colspan="4"><p><strong style="color:#3b3d3f; font-weight: bold;">Objetivos específicos: </strong>' . $profile->s_objects . '</p></td>
        </tr>
        <tr>
            <td colspan="4" style=" padding: .2em;" class="c"></td>
        </tr>

        <tr>
            <td colspan="4"><p><strong style="color:#3b3d3f; font-weight: bold;">Descripción: </strong>' . $profile->description . '</p></td>
        </tr>
        <tr>
            <td colspan="4" style=" padding: .2em;" class="c"></td>
        </tr>
        ';
        $html .=' </tbody></table>';
        
        if ($modality->name_mod == "Trabajo Dirigido") {
            $html .= '
            <table align="center" class="x11colortable" style="background-color: white" >
                <tbody>
                    <tr>
                        <td colspan="5" style=" padding: 3em;" class="c"></td>
                    </tr>
                    <tr>
                        <td height="3px" class="center">__________________</td>
                        <td height="3px" class="center">__________________</td>
                        <td height="3px" class="center">__________________</td>
                        <td height="3px" class="center">__________________</td>
                        <td height="3px" class="center">__________________</td>
                    </tr>
                    <tr>
                        <td class="center">
                            <p style="font-size: 10pt;" >'.$director->name . "<br />" . " " . $director->l_name . " " . $director->ml_name.'</p><p style="color:#3b3d3f; font-weight: bold;" >Director de carrera</p>
                        </td>
                        <td class="center">
                            <p style="font-size: 10pt;" >'.$teacher->name . "<br />" . " " . $teacher->l_name . " " . $teacher->ml_name .'</p><p style="color:#3b3d3f; font-weight: bold;" >Docente de la Materia</p>
                        </td>
                        <td class="center">
                            <p style="font-size: 10pt;" >'.$tutorfir->name . "<br />" . " " . $tutorfir->l_name. " " . $tutorfir->ml_name. '</p><p style="color:#3b3d3f; font-weight: bold;" >Tutor</p>
                        </td>
                        <td class="center">
                            <p style="font-size: 10pt;" >'.$attendant->responsable. '</p><p style="color:#3b3d3f; font-weight: bold;" >Responsable de Institución</p>
                        </td>
                        <td class="center">
                            <p style="font-size: 10pt;" >'.$postf->name . "<br />" . " " . $postf->l_name . " " . $postf->ml_name .'</p><p style="color:#3b3d3f; font-weight: bold;" >Estudiante</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            ';
        } else {
            $html .= ' 
            <table align="center" class="x11colortable" style="background-color: white" >
                <tbody>
                    <tr>
                        <td colspan="4" style=" padding: 3em;" class="c"></td>
                    </tr>
                    <tr>
                        <td height="3px" class="center">________________________</td>
                        <td height="3px" class="center">________________________</td>
                        <td height="3px" class="center">________________________</td>
                        <td height="3px" class="center">________________________</td>
                    </tr>
                    <tr>
                        <td class="center">
                            <p style="font-size: 10pt;">'.$director->name . " " . $director->l_name . " " . $director->ml_name.'</p><p style="color:#3b3d3f; font-weight: bold;" >Director de carrera</p>
                        </td>
                        <td class="center">
                            <p style="font-size: 10pt;">'.$teacher->name . " " . $teacher->l_name . " " . $teacher->ml_name .'</p><p style="color:#3b3d3f; font-weight: bold;" >Docente de la Materia</p>
                        </td>
                        <td class="center">
                            <p style="font-size: 10pt;">'.$tutorfir->name. " " . $tutorfir->l_name. " " . $tutorfir->ml_name. '</p><p style="color:#3b3d3f; font-weight: bold;" >Tutor</p>
                        </td>
                        <td class="center">
                            <p style="font-size: 10pt;" >'.$postf->name . " " . $postf->l_name . " " . $postf->ml_name .'</p><p style="color:#3b3d3f; font-weight: bold;" >Estudiante</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            ';
        }

        return $html;
    }
}