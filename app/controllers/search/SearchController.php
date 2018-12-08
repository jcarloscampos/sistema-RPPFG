<?php

namespace AppPHP\Controllers\Search;

use AppPHP\Controllers\BaseController;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use Sirius\Validation\Validator;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Area;
use AppPHP\Models\Account;
use AppPHP\Models\UserRol;
use AppPHP\Models\Rol;
use AppPHP\Models\Modality;
use AppPHP\Models\Profile;
use AppPHP\Models\Status;
use AppPHP\Models\PostulantProfile;
use AppPHP\Models\Postulant;
use AppPHP\Models\Period;
use AppPHP\Models\AreaProfile;
use AppPHP\Models\Responsable;
use AshleyDawson\SimplePagination\Paginator;



class SearchController extends BaseController
{
    public function getIndex()
    {
        $modalities = Modality::all();
        return $this->render('search/index.twig', ['modalities'=>$modalities]);
    }

    public function postIndex()
    {
        $validator = new Validator();
        $validation = new Validation();
        $errors = [];
        $resultprofile = true;
        $validation->setRuleTitle($validator);

        $earchprofile = ['title' => $_POST['title']];
        $modalities = Modality::all();

        if ($validator->validate($_POST)) {
            //$_POST['modality']        $_POST['year']          $_POST['period']
            $titlep = $earchprofile['title'];
            $status = Status::all();
            $postulantprofiles = PostulantProfile::all();
            $postulants =Postulant::all();
            $profiles = Profile::where('title', 'like', "%$titlep%")->get()->toArray();

            if ($_POST['modality'] == 0 && $_POST['year'] == 0 && $_POST['period'] == 0) {
                return $this->render('search/index.twig', 
                ['modalities'=>$modalities, 'resultprofile'=>$resultprofile, 'vPerfil'=>$earchprofile, 'profiles'=>$profiles,
                'status'=>$status, 'postulants'=>$postulants, 'postulantprofiles'=>$postulantprofiles]);
            } else {
                $profilessel = $this->searchmodality($profiles);
                return $this->render('search/index.twig', 
                ['modalities'=>$modalities, 'resultprofile'=>$resultprofile, 'vPerfil'=>$earchprofile, 'profiles'=>$profilessel,
                'status'=>$status, 'postulants'=>$postulants, 'postulantprofiles'=>$postulantprofiles]);
            } 
        }else{
            $errors = $validator->getMessages();
        }
        return $this->render('search/index.twig', ['modalities'=>$modalities, 'vPerfil'=>$earchprofile]);
    }

    private function searchmodality($profiles)
    {
        $result = [];

        if ($_POST['modality'] > 0) {
            $modality = Modality::where('id', $_POST['modality'])->first();

            foreach ($profiles as $key => $value) {
                if ($value['id_mod'] == $modality->id) {
                    $result[] = $value;
                }
            }
        } else {
            $result = $profiles;
        }

        return $this->searchyear($result);
    }

    private function searchyear($profiles)
    {
        $result = [];

        if ($_POST['year'] > 0) {
            foreach ($profiles as $keyp => $valuep) {
                $postulantProfile = PostulantProfile::where('id_profile', $valuep['id'])->first();
                if (isset($postulantProfile)) {
                    if ($this->getYear($postulantProfile) == $_POST['year']) {
                        $result[] = $valuep;
                    }
                }
            }
        } else {
            $result = $profiles;
        }
        
        return $this->searchperiod($result);
    }

    private function searchperiod($profiles)
    {
        $result = [];

        if ($_POST['period'] > 0) {
            foreach ($profiles as $keyp => $valuep) {
                $postulantProfile = PostulantProfile::where('id_profile', $valuep['id'])->first();
                if (isset($postulantProfile)) {
                    if ($this->getPeriod($postulantProfile) == $_POST['period']) {
                        $result[] = $valuep;
                    }
                }
            }
        } else {
            $result = $profiles;
        }

        return $result;
    }
 
    private function getYear($postulantProfile)
    {
        $periodp = null;
        $periods = Period::all();

            foreach ($periods as $key => $valp) {
                if ($valp->id == $postulantProfile->id_period)
                    $periodp = $valp;
            }
        $sapproved = substr($periodp->start_date, 0, 4);
        return $sapproved;
    }

    private function getPeriod($postulantProfile)
    {
        $periodp = null;
        $periods = Period::all();

            foreach ($periods as $key => $valp) {
                if ($valp->id == $postulantProfile->id_period)
                    $periodp = $valp;
            }
        
        $papproved = $periodp->period;
        return $papproved;
    }
    

    public function getProfile($idprofile)
    {
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
            return $this->render('search/setpass.twig', 
                ['profile'=>$profile, 'group'=>$group, 'postf'=>$postf,
                'posts'=>$posts, 'modality'=>$modality, 'career'=>$career, 'period'=>$period, 'approved'=>$approved,
                'status'=>$status, 'cstate'=>$cstate, 'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec,
                'twofold'=>$twofold, 'areap'=>$areap, 'subareap'=>$subareap,  'attendant'=>$attendant
                ]);
        }
        return $this->render('search/setpass.twig', 
            ['profile'=>$profile, 'postf'=>$postf, 'modality'=>$modality,
            'career'=>$career, 'status'=>$status, 'cstate'=>$cstate, 'period'=>$period,'approved'=>$approved,  
            'tutorfir'=>$tutorfir, 'tutorsec'=>$tutorsec, 'twofold'=>$twofold,
            'areap'=>$areap, 'subareap'=>$subareap, 'attendant'=>$attendant
            ]);
    }


    public function getAreas()
    {
        $areasval = true;
        $areas = Area::query()->orderBy('name')->get()->toArray();
        $params = null; 
        $page = 1;
        $myUrl=parse_url($_SERVER['REQUEST_URI']);
        if(isset($myUrl['query'])){
            parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);
            $page = (int)$params['page'];          
        }
        $paginator = new Paginator();
        $paginator->setItemsPerPage(10)->setPagesInRange(10);
        $paginator->setItemTotalCallback(function () use ($areas) {
            return count($areas);
        });
        $length = $paginator->getItemsPerPage();
        $offset =  $page * $length;
        $paginator->setSliceCallback(function ($offset, $length) use ($areas) {
            return array_slice($areas, $offset, $length);
        });
        $pagination = $paginator->paginate($page);
        return $this->render('search/character.twig', ['areasval'=>$areasval,'areas' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page]);
    }

    public function getProfessionals()
    {
        $areasval = false;
        $itn = ProfessionalUmss::query()->get()->toArray();
        $etn = ProfessionalExt::query()->get()->toArray();
        $urol = UserRol::query()->get();
        $rol = Rol::query()->get();
        $profesionales = array_merge($itn, $etn);
        $params = null; 
        $page = 1;
        $myUrl=parse_url($_SERVER['REQUEST_URI']);
        if(isset($myUrl['query'])){
            parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);
            $page = (int)$params['page'];          
        }
        $paginator = new Paginator();
        $paginator->setItemsPerPage(10)->setPagesInRange(10);
        $paginator->setItemTotalCallback(function () use ($profesionales) {
            return count($profesionales);
        });
        $length = $paginator->getItemsPerPage();
        $offset =  $page * $length;
        $paginator->setSliceCallback(function ($offset, $length) use ($profesionales) {
            return array_slice($profesionales, $offset, $length);
        });
        $pagination = $paginator->paginate($page);
        return $this->render('search/character.twig', ['profesionales' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page, 'vurols'=>$urol, 'vrols'=>$rol]);      
    }
    
}