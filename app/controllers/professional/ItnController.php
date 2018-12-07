<?php

namespace AppPHP\Controllers\Professional;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ADegree;
use AppPHP\Models\Workload;
use AppPHP\Models\Area;
use AppPHP\Models\ItnProfArea;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use AppPHP\Controllers\Common\SettingData;

use AppPHP\Models\Profile;
use AppPHP\Models\Status;
use AppPHP\Models\Period;
use AppPHP\Models\Postulant;
use AppPHP\Models\PostulantProfile;
use AppPHP\Models\AreaProfile;
use AppPHP\Models\Responsable;


class ItnController extends BaseController
{
    public function getIndex()
    {
        $inforeg = false;
        $etn = false;
        $generate = new SettingData();

        if (isset($_SESSION['iprofID'])) {
            $userprofile = ProfessionalUmss::where('id_account', $_SESSION['iprofID'])->first();
            $uimage = substr($userprofile->name, 0, 1);
            if (isset($userprofile)) {
                $inforeg = $generate->valItn($userprofile);
                return $this->render('professional/index.twig', ['inforeg'=>$inforeg, 'vPerfil'=>$userprofile, 'uimage'=>$uimage, 'etn' => $etn]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }
    

    public function getConfig()
    {
        if (isset($_SESSION['iprofID'])) {
            $etn = false;
            $user = ProfessionalUmss::where('id_account', $_SESSION['iprofID'])->first();
            $uimage = substr($user->name, 0, 1);
            $title = ADegree::query()->get();
            $work = Workload::query()->get();
            return $this->render('professional/itn-config.twig', ['vPerfil' => $user, 'uimage'=>$uimage, 'vTitles'=>$title, 'vWorks'=>$work]);
        }
    }

    public function postConfig()
    {
        $errors = [];
        $result = false;
        $etn = false;
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection();
        $user = ProfessionalUmss::find($_POST['id']);
        $uimage = substr($user->name, 0, 1);
        $title = ADegree::query()->get();
        $work = Workload::query()->get();
        
        $validation->setRuleBasic($validator);
        $validation->setRuleCodeSis($validator);
        $validation->setRuleCI($validator);
       
        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'email'=> $_POST['email'],
            'cod_sis'=> $_POST['codsis'],
            'phone'=> $_POST['phone'],
            'address'=> $_POST['address'],
            'profile'=> $_POST['profile']
        ];

        if (isset($_POST['adegree'])) {
            $userprofile['id_ad'] = $_POST['adegree'];
        }

        if (isset($_POST['wload'])) {
            $userprofile['id_wl'] = $_POST['wload'];
        }
       
        if ($validator->validate($_POST)) {    
            if (isset($_POST['pwd']) && $_POST['pwd'] != "") {
                $result = $makeDB->updateAccount($user, $_POST['pwd']);
            }
            $result = $makeDB->updateUser($user, $userprofile, $makeDB);
        }else{
            $errors = $validator->getMessages();
        }
        $user = ProfessionalUmss::find($_POST['id']);
        return $this->render(
            'professional/itn-config.twig',
            ['vPerfil' => $user,
            'uimage' => $uimage,
            'errors' => $errors,
            'result' => $result,
            'vTitles'=>$title,
            'vWorks'=>$work
            ]);
    }

    public function getInterestareas()
    {
        if (isset($_SESSION['iprofID'])) {
            $etn = false;
            $emptyarea = true;
            $user = ProfessionalUmss::where('id_account', $_SESSION['iprofID'])->first();
            $uimage = substr($user->name, 0, 1);
            $profarea = ItnProfArea::all();
            $val = ItnProfArea::all()->toArray();
            $areas = Area::query()->orderBy('name')->get();

            if (!empty($val)){
                $emptyarea = false;
            }
            return $this->render('professional/interest-areas.twig',
            ['vPerfil' => $user, 'uimage'=>$uimage,'vareas' => $areas, 'profareas' => $profarea, 'emptyarea' => $emptyarea]);
        }
    }

    public function getSettle($id)
	{
        if (isset($id)) {
            $repeated = ItnProfArea::where('id_area', '=', $id)->get()->toArray();
            if (empty($repeated)){
                $area = Area::find($id);
                $user = ProfessionalUmss::where('id_account', $_SESSION['iprofID'])->first();
                //----------------------------------------
                if ($area->id == $area->id_parent_area) {
                    $profarea = new ItnProfArea([
                        'id_prof' => $user->id,
                        'id_area' => $area->id
                    ]);
                    $profarea->save();
                } else {
                    $areaparent = Area::where('id', $area->id_parent_area)->first();
                    $repeatedarea = ItnProfArea::where('id_area', '=', $areaparent->id)->get()->toArray();
                    if (empty($repeatedarea)){
                        //Aniade area y sub area
                        $profarea_subarea = new ItnProfArea([
                            'id_prof' => $user->id,
                            'id_area' => $area->id
                        ]);
                        $profarea_subarea->save();

                        $profarea_area = new ItnProfArea([
                            'id_prof' => $user->id,
                            'id_area' => $areaparent->id
                        ]);
                        $profarea_area->save();

                    }else{
                        //solo sub area
                        $profarea = new ItnProfArea([
                            'id_prof' => $user->id,
                            'id_area' => $area->id
                        ]);
                        $profarea->save();
                    }
                }
                //----------------------------------------
                // $profarea = new ItnProfArea([
                //     'id_prof' => $user->id,
                //     'id_area' => $area->id
                // ]);
                // $profarea->save();
            }
        }
        header('Location:' . BASE_URL . 'itnprofessional/interestareas');	
    }
    
    public function getRemove($id)
	{
        if (isset($id)) {
            $profarea = ItnProfArea::find($id);
            //----------------------------------------
            $area = Area::where('id', $profarea->id_area)->first();
            
            if ($area->id == $area->id_parent_area){
                $makeDB = new ServerConnection();
                $areasr = $makeDB->getSubAreaList($area->id);

                foreach ($areasr as $key => $arear) {
                    $profarea = ItnProfArea::where('id_area', $arear->id);
                    $profarea->delete();
                }
            }else{
                $profarea->delete();
            }
            //----------------------------------------
            //$profarea->delete();
            header('Location:' . BASE_URL . 'itnprofessional/interestareas');	
        }
    }

    public function getProjects()
    {
        if (isset($_SESSION['iprofID'])) {
            $etn = false;
            $user = ProfessionalUmss::where('id_account', $_SESSION['iprofID'])->first();
            $uimage = substr($user->name, 0, 1);
            $postulants = Postulant::all();
            $postulantProfiles = PostulantProfile::all();
            $profiles = Profile::all();

            $responsables = Responsable::all();
            $status = Status::all();
            $makeDB = new ServerConnection();
            $guidedme = [];

            foreach ($responsables as $key => $value) {
                if ($value->id_intprof == $user->id && $value->id_type_resp == 2) {
                    $guidedme[] = $value;
                }
            }
            
            

            $profileme = [];
            foreach ($guidedme as $key => $value) {
                foreach ($profiles as $pkey => $pvalue) {
                    if ($value->id_profile == $pvalue->id) {

                        $period = $makeDB->getPeriod($postulantProfiles, $pvalue);
                        $papproved = $period->period;
                        $pvalue['enddate'] = $period->end_date;
                        $sapproved = substr($period->start_date, 0, 4);
                        $approved = $papproved . '/' . $sapproved;
                        $pvalue['approved'] = $approved;
                        $profileme[] = $pvalue;
                    }
                }
            }
            return $this->render('professional/projectguide.twig',
            ['vPerfil' => $user, 'uimage'=>$uimage, 'etn' => $etn, 'profilesme'=>$profileme, 'status'=>$status]);
        }
        header('Location: ' . BASE_URL . '');
    }

    public function getProjectsid($idprofile)
    {
        if (isset($_SESSION['iprofID'])) {
            $etn = false;
            $user = ProfessionalUmss::where('id_account', $_SESSION['iprofID'])->first();
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
            // Area y sub area
            $areap = $makeDB->getAreap($profile, $areaprofiles);
            $subareap = $makeDB->getSubAreap($profile, $areaprofiles);

            if ($group) {
                return $this->render('professional/setpass.twig', 
                    ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                    'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                    'status'=>$status, 'cstate'=>$cstate, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'etn' => $etn,
                    'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap,  'attendant'=>$attendant
                    ]);
            }
            return $this->render('professional/setpass.twig', 
                ['vPerfil'=>$user, 'uimage'=>$uimage, 'profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
                'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,  
                'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold, 'etn' => $etn,
                'areap'=>$areap, 'subareap'=>$subareap, 'attendant'=>$attendant
                ]);

        }
        header('Location: ' . BASE_URL . '');
    }
}