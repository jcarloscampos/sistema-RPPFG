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
}