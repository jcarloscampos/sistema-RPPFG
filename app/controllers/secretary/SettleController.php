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
use AppPHP\Models\EtnProfArea;
use AppPHP\Models\ItnProfArea;

use Sirius\Validation\Validator;
use AppPHP\Controllers\Common\Mail;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use AppPHP\Controllers\Common\SettingData;

/**
 * Clase controlador de inicio para Secretaria.
 * Mediante este controlador interactuan las opciones de configuracion de Secretaria.
 */

class SettleController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['staryID'])) {
            $user = Secretary::where('id_account', $_SESSION['staryID'])->first();
            $uimage = substr($user->name, 0, 1);
            $makeDB = new ServerConnection();
            $profiles = Profile::all();
            $modalities = Modality::all();

            $postperfs = PostulantProfile::all();
            $posts = Postulant::all();

            $status = Status::all();
            $periods = Period::all();
            
            return $this->render('secretary/settle.twig',
            ['vPerfil'=>$user, 'uimage'=>$uimage, 'profiles'=>$profiles, 'modalities'=>$modalities,
            'postperfs'=>$postperfs, 'posts'=>$posts,
            'status'=>$status, 'periods'=>$periods
            ]);
        }
        header('Location: ' . BASE_URL . '');
    }

    public function getSetpass($idprofile)
    {
        if (isset($_SESSION['staryID'])) {
            $user = Secretary::where('id_account', $_SESSION['staryID'])->first();
            $uimage = substr($user->name, 0, 1);
            $makeDB = new ServerConnection();
            $profile = Profile::where('id', $idprofile)->first();
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
            }else
                $postf = $posts[0];
            
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
            }elseif (count($tutors) == 2) {
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
                return $this->render('secretary/setpass.twig', 
                    ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                    'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                    'status'=>$status, 'cstate'=>$cstate, 'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec,
                    'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director, 'attendant'=>$attendant
                    ]);
            }
            return $this->render('secretary/setpass.twig', 
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
                'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,  
                'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
                'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant
                ]);

        }
        header('Location: ' . BASE_URL . '');
    }

    public function postSetpass($idprofile)
    {
        if (isset($_SESSION['staryID'])) {
            $user = Secretary::where('id_account', $_SESSION['staryID'])->first();
            $uimage = substr($user->name, 0, 1);
            $makeDB = new ServerConnection();
            $mail = new Mail();
            $profile = Profile::where('id', $idprofile)->first();
            $prolonged = false;
            $result = false;
            
            if (isset($_POST['statep'])) {
                $nstatus = Status::where('id', $_POST['statep'])->first();

                $statusdata = ['id_status' => $nstatus->id];

                $result = $makeDB->updateUser($profile, $statusdata, $makeDB);
            }

            if (isset($_POST['enddatep'])) {
                //1 o 2 extended
                $postulantprofile = PostulantProfile::where('id_profile', $profile->id)->first();
                $period = Period::where('id', $postulantprofile->id_period)->first();
                $enddate = date($period->end_date);

                if ($_POST['enddatep'] == 1) {
                    # Si la solicitud es por prorroga de ampliacion
                    if ($period->extended == 0 || $period->extended == 2){
                        $nenddate = date("Y-m-d",strtotime($enddate."+ 6 month"));
                        $extended = 3 + $period->extended; // cambiado por 1
                        $periodData = ['end_date' => $nenddate, 'extended' => $extended];
                        #-----------------------------------------------------------------
                        if ($makeDB->updateUser($period, $periodData, $makeDB)) {
                            # Ejecuta en caso ser alargado fecha de defensa
                            $result = true;
                            $this->sendMessage($postulantprofile->id_profile, $nenddate, $mail);
                        }
                        #-----------------------------------------------------------------
                        //return null;
                    } else 
                        $prolonged = true;

                } elseif ($_POST['enddatep'] == 2) {
                    # Si la solicitud es por apliacion de caso extra ordinario
                    if ($period->extended == 0 || $period->extended == 1) {
                        $nenddate = date("Y-m-d",strtotime($enddate."+ 1 year"));
                        $extended = 3 + $period->extended; // cambiado por 2
                        $periodData = ['end_date' => $nenddate, 'extended' => $extended];
                        //$result = $makeDB->updateUser($period, $periodData, $makeDB);
                        #-----------------------------------------------------------------
                        if ($makeDB->updateUser($period, $periodData, $makeDB)) {
                            # Ejecuta en caso ser alargado fecha de defensa
                            $result = true;
                            $this->sendMessage($postulantprofile->id_profile, $nenddate, $mail);
                        }
                        #-----------------------------------------------------------------
                    } else 
                        $prolonged = true;
                }
            }

            // Parea recargar de nuevo la vista
            $profile = Profile::where('id', $idprofile)->first();
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
            }else
                $postf = $posts[0];
            
            // Obtine carrera
            $career = $makeDB->getCareer($postulantProfiles, $profile);
            // Estdo actual del perfil
            $cstate = $makeDB->getState($profile);
            // periodo
            $period = $makeDB->getPeriod($postulantProfiles, $profile);
            $papproved = $period->period;
            $sapproved = substr($period->start_date, 0, 4);
            $approved = $papproved . '/' . $sapproved;
            $cstate = Status::where('id', $profile->id_status)->first();
            
            // Obtine los tutores del perfil
            $tutors = $makeDB->getTutors($profile);
            $twofold = false; 

            if (count($tutors) == 1) {
                $tutorfir = $tutors[0];
                $tutorsec = null;
            }elseif (count($tutors) == 2) {
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
                return $this->render('secretary/setpass.twig', 
                    ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                    'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                    'status'=>$status, 'cstate'=>$cstate, 'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec,
                    'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director, 'attendant'=>$attendant,
                    'result'=>$result, 'prolonged'=>$prolonged
                    ]);
            }
            return $this->render('secretary/setpass.twig', 
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
                'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,  
                'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
                'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant, 
                'prolonged'=>$prolonged, 'result'=>$result
                ]);
        }
    }
    private function sendMessage($idprofile, $nenddate, $mail)
    {
        $postulantProfiles = PostulantProfile::all();
        $datasend = [];

        foreach ($postulantProfiles as $key => $value) {
            if ($value->id_profile == $idprofile) {
                $postulant = Postulant::where('id', $value->id_postulant)->first();
                if (isset($postulant)) {
                    // $to = $array['email'];
                    // $uname = $array['username'];
                    // $pwd = $array['password'];
                    $userName =  $postulant->name . ' '. $postulant->l_name . ' '. $postulant->ml_name;
                    $message = 'Se le informa que la solicitud que presentó para la ampliación de fecha de defensa fue aceptada, usted debe programar su defensa con fecha anterior a: ' . $nenddate;
                    $datasend['email'] = $postulant->email;
                    $datasend['username'] = '';
                    $datasend['password'] = '';

                    $datasend['user'] = $userName;
                    $datasend['message'] = $message;
                    $datasend['case'] = 1;

                    $mail->sendEMail($datasend);
                }
            }
        }
    }
    













































    public function getChangeprofile($idprofile)
    {
        if (isset($_SESSION['staryID'])) {
            $user = Secretary::where('id_account', $_SESSION['staryID'])->first();
            $uimage = substr($user->name, 0, 1);
            $makeDB = new ServerConnection();
            $profile = Profile::where('id', $idprofile)->first();
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
            }else
                $postf = $posts[0];
            
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

            $tutorsec = null;

            if (count($tutors) == 1) {
                $tutorsec = null;
                $tutorfir = $tutors[0];
            }elseif (count($tutors) == 2) {
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

            $newTutors = [];
            $areaprofile = AreaProfile::where('id_profile', $idprofile)->first();

            $etnprofAreas = EtnProfArea::all();
            $itnprofAreas = ItnProfArea::all();

            if (isset($areaprofile)) {
                foreach ($etnprofAreas as $key => $value) {
                    if ($value->id_area == $areaprofile->id_area) {
                        $newTutors[] = ProfessionalExt::where('id', $value->id_prof)->first();
                    }
                }
    
                foreach ($itnprofAreas as $key => $value) {
                    if ($value->id_area == $areaprofile->id_area) {
                        $newTutors[] = ProfessionalUmss::where('id', $value->id_prof)->first();
                    }
                }
            }



            if ($group) {
                return $this->render('secretary/changeprofile.twig', 
                    ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                    'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                    'status'=>$status, 'cstate'=>$cstate, 'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec,
                    'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director, 'attendant'=>$attendant,
                    'newTutors'=>$newTutors
                    ]);
            }
            return $this->render('secretary/changeprofile.twig', 
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
                'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,  
                'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
                'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant, 'newTutors'=>$newTutors
                ]);

        }
        header('Location: ' . BASE_URL . '');
    }

    ############################################################################################################################################
    public function postChangeprofile($idprofile)
    {
        if (isset($_SESSION['staryID'])) {
            $user = Secretary::where('id_account', $_SESSION['staryID'])->first();
            $uimage = substr($user->name, 0, 1);
            $makeDB = new ServerConnection();
            $mail = new Mail();
            $profile = Profile::where('id', $idprofile)->first();
            $shotperiod = false;
            $result = false;
            $tchanged = false;
            $validation = new Validation();
            $validator = new Validator();
            $errors = [];

            
            $postulantprofile = PostulantProfile::where('id_profile', $profile->id)->first();
            $period = Period::where('id', $postulantprofile->id_period)->first();
            
            $startdate = date($period->start_date);
            $startdate = date("Y-m-d",strtotime($startdate));
            $currentdateYMD = date("Y-m-d");
            $currentdate = date("Y-m-d",strtotime($currentdateYMD));
            
            if ( $this->dateDiff($startdate, $currentdate) < 61 && $profile->tchange == 0){

                $validation->setRuleDefTwo($validator);

                $profileData = [
                    'title' => $_POST['title'],
                    'g_objective' => $_POST['gobj'],
                    's_objects' => $_POST['sobj'],
                    'description' => $_POST['dcptn']
                ];

                if ($validator->validate($_POST)) {

                    if (isset($_POST['tutor'])) {
                        # Busca el tutor antiguo
                        $etnTutorID = EtnTutor::where('id_profile', $profile->id)->value('id');

                        $itnTutorID = 0;
                        $itnTutors = Responsable::where('id_type_resp', 2)->get()->toArray();
                        foreach ($itnTutors as $key => $value) {
                            if ($value['id_profile'] == $profile->id) {
                                $itnTutorID = Responsable::where('id_profile', $value['id_profile'])->value('id');
                            }
                        }

                        if ($etnTutorID > 0) { // Antiguo tutor externo
                            # Genera los nuevos tutores
                            $newEtnTutor = ProfessionalExt::where('id_account', $_POST['tutor'])->first();
                            $newItnTutor = ProfessionalUmss::where('id_account', $_POST['tutor'])->first();

                            if (isset($newEtnTutor)) {
                                # Generar relacion ETN_TUTOR
                                $newTutorActive = new EtnTutor([
                                    'id_entprof' => $newEtnTutor->id,
                                    'id_profile' => $profile->id
                                ]);
                                $newTutorActive->save();
                                $result = true;

                            } elseif (isset($newItnTutor)) {
                                # Genera relacion RESPONSABLE
                                $newTutorActive = new Responsable([
                                    'id_intprof' => $newItnTutor->id,
                                    'id_profile' => $profile->id,
                                    'id_type_resp' => 2
                                ]);
                                $newTutorActive->save();
                                $result = true;
                            }
                            # Elimina antiguo tutor externo
                            $oldTutor = EtnTutor::find($etnTutorID);
                            $oldTutor->delete();

                        } elseif ($itnTutorID > 0) { // Antiguo tutor de UMSS
                             # Genera los nuevos tutores
                             $newEtnTutor = ProfessionalExt::where('id_account', $_POST['tutor'])->first();
                             $newItnTutor = ProfessionalUmss::where('id_account', $_POST['tutor'])->first();

                             if (isset($newEtnTutor)) {
                                # Generar relacion ETN_TUTOR
                                $newTutorActive = new EtnTutor([
                                    'id_entprof' => $newEtnTutor->id,
                                    'id_profile' => $profile->id
                                ]);
                                $newTutorActive->save();
                                $result = true;

                            } elseif (isset($newItnTutor)) {
                                # Genera relacion RESPONSABLE
                                $newTutorActive = new Responsable([
                                    'id_intprof' => $newItnTutor->id,
                                    'id_profile' => $profile->id,
                                    'id_type_resp' => 2
                                ]);
                                $newTutorActive->save();
                                $result = true;
                            }
                            # Elimina antiguo tutor externo
                            $oldTutor = Responsable::find($itnTutorID);
                            $oldTutor->delete();
                        }
                        
                    }
                    // if (isset($_POST['stutor'])) {
                    //     echo "hay segundo tutor".'<br>';
                    // }
                    // //return null;
                    if ($makeDB->updateUser($profile, $profileData, $makeDB)) {
                        $tchanged = true;
                        $result = true;

                    }

                    if ($tchanged) {
                        $statusprofile = ['tchange' => 1];
                        //$result = $makeDB->updateUser($profile, $statusprofile, $makeDB);
                        $this->sendMessageTchange($profile->id, $mail);
                    }
    
                } else {
                    $errors = $validator->getMessages();
                }

            }else{
                $shotperiod = true;
            }

            // Parea recargar de nuevo la vista
            $profile = Profile::where('id', $idprofile)->first();
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
            }else
                $postf = $posts[0];
            
            // Obtine carrera
            $career = $makeDB->getCareer($postulantProfiles, $profile);
            // Estdo actual del perfil
            $cstate = $makeDB->getState($profile);
            // periodo
            $period = $makeDB->getPeriod($postulantProfiles, $profile);
            $papproved = $period->period;
            $sapproved = substr($period->start_date, 0, 4);
            $approved = $papproved . '/' . $sapproved;
            $cstate = Status::where('id', $profile->id_status)->first();
            
            // Obtine los tutores del perfil
            $tutors = $makeDB->getTutors($profile);
            $twofold = false; 

            if (count($tutors) == 1) {
                $tutorfir = $tutors[0];
                $tutorsec = null;
            }elseif (count($tutors) == 2) {
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

            $newTutors = [];
            $areaprofile = AreaProfile::where('id_profile', $idprofile)->first();

            $etnprofAreas = EtnProfArea::all();
            $itnprofAreas = ItnProfArea::all();

            if (isset($areaprofile)) {
                foreach ($etnprofAreas as $key => $value) {
                    if ($value->id_area == $areaprofile->id_area) {
                        $newTutors[] = ProfessionalExt::where('id', $value->id_prof)->first();
                    }
                }
    
                foreach ($itnprofAreas as $key => $value) {
                    if ($value->id_area == $areaprofile->id_area) {
                        $newTutors[] = ProfessionalUmss::where('id', $value->id_prof)->first();
                    }
                }
            }

            if ($group) {
                return $this->render('secretary/changeprofile.twig', 
                    ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                    'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                    'status'=>$status, 'cstate'=>$cstate, 'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec,
                    'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director, 'attendant'=>$attendant,
                    'result'=>$result, 'shotperiod'=>$shotperiod, 'newTutors'=>$newTutors, 'errors'=>$errors
                    ]);
            }
            return $this->render('secretary/changeprofile.twig', 
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
                'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,  
                'teacher'=>$teacher, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
                'areap'=>$areap, 'subareap'=>$subareap, 'director'=>$director,'attendant'=>$attendant, 
                'shotperiod'=>$shotperiod, 'result'=>$result, 'newTutors'=>$newTutors, 'errors'=>$errors
                ]);
        }
    }
    function dateDiff($date1, $date2)
    { 
        $diff = strtotime($date2) - strtotime($date1); 
        return abs(round($diff / 86400)); 
    }

    private function sendMessageTchange($idprofile, $mail)
    {
        $postulantProfiles = PostulantProfile::all();
        $datasend = [];

        foreach ($postulantProfiles as $key => $value) {
            if ($value->id_profile == $idprofile) {
                $postulant = Postulant::where('id', $value->id_postulant)->first();
                if (isset($postulant)) {
                    // $to = $array['email'];
                    // $uname = $array['username'];
                    // $pwd = $array['password'];
                    $userName =  $postulant->name . ' '. $postulant->l_name . ' '. $postulant->ml_name;
                    $message = 'Se le informa que la solicitud que presentó para la ampliación de fecha de defensa fue aceptada, usted debe programar su defensa con fecha anterior a: ' . $nenddate;
                    $datasend['email'] = $postulant->email;
                    $datasend['username'] = '';
                    $datasend['password'] = '';

                    $datasend['user'] = $userName;
                    $datasend['message'] = $message;
                    $datasend['case'] = 1;

                    $mail->sendEMail($datasend);
                }
            }
        }
    }
}