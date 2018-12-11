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
}