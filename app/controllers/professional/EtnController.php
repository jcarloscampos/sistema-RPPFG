<?php

namespace AppPHP\Controllers\Professional;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\EtnProfArea;
use AppPHP\Models\Area;
use AppPHP\Models\Account;
use AppPHP\Models\ADegree;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use AppPHP\Controllers\Common\SettingData;


class EtnController extends BaseController
{
    public function getIndex()
    {
        $inforeg = false;
        $etn = true;
        $generate = new SettingData();

        if (isset($_SESSION['eprofID'])) {
            $userprofile = ProfessionalExt::where('id_account',  $_SESSION['eprofID'])->first();
            if (isset($userprofile)) {
                # Es un profecional de Ext
                $inforeg = $generate->valEtn($userprofile);
                return $this->render('professional/index.twig', ['inforeg'=>$inforeg, 'vPerfil'=>$userprofile, 'etn' =>$etn]);
            }  
        }
        header('Location: ' . BASE_URL . '');
    }


    public function getConfig()
    {
        if (isset($_SESSION['eprofID'])) {
            $etn = true;
            $userprofile = ProfessionalExt::where('id_account', $_SESSION['eprofID'])->first();
            $title = ADegree::query()->get();
            return $this->render('professional/etn-config.twig', ['vPerfil' => $userprofile, 'vTitles'=>$title, 'etn' =>$etn]);
        }
    }
    
    public function postConfig()
    {
        $errors = [];
        $result = false;
        $etn = true;
        $validator = new Validator();
        $validation = new Validation();
        $makeDB = new ServerConnection(); 
        $user = ProfessionalExt::find($_POST['id']);
        $title = ADegree::query()->get();
        
        $validation->setRuleBasic($validator);

        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'email'=> $_POST['email'],
            'phone'=> $_POST['phone'],
            'address'=> $_POST['address'],
            'avatar'=> $_POST['avatar'],
            'profile'=> $_POST['profile']
        ];
        if (isset($_POST['adegree'])) {
            $userprofile['id_ad'] = $_POST['adegree'];
        }
        
        if ($validator->validate($_POST)) {
            if (isset($_POST['pwd']) && $_POST['pwd'] != "") {
                $result = $makeDB->updateAccount($user, $_POST['pwd']);
            }
            $result = $makeDB->updateUser($user, $userprofile, $makeDB);
        }else{
            $errors = $validator->getMessages();
        }
        $user = ProfessionalExt::find($_POST['id']);
        return $this->render('professional/etn-config.twig',
            ['vPerfil' => $user,
            'errors' => $errors,
            'result' => $result,
            'vTitles'=>$title,
            'etn' =>$etn
            ]);
    }





    public function getInterestareas()
    {
        if (isset($_SESSION['eprofID'])) {
            $etn = true;
            $emptyarea = true;
            $user = ProfessionalExt::where('id_account', $_SESSION['eprofID'])->first();
            $profarea = EtnProfArea::all();
            $val = EtnProfArea::all()->toArray();
            $areas = Area::query()->orderBy('name')->get();

            if (!empty($val)){
                $emptyarea = false;
            }
            return $this->render('professional/interest-areas.twig',
            ['vPerfil' => $user, 'vareas' => $areas, 'profareas' => $profarea, 'emptyarea' => $emptyarea, 'etn' => $etn]);
        }
    }

    public function getSettle($id)
	{
        if (isset($id)) {
            $repeated = EtnProfArea::where('id_area', '=', $id)->get()->toArray();
            if (empty($repeated)){
                $area = Area::find($id);
                $user = ProfessionalExt::where('id_account', $_SESSION['eprofID'])->first();

                $profarea = new EtnProfArea([
                    'id_prof' => $user->id,
                    'id_area' => $area->id
                ]);
                $profarea->save();
            }
        }
        header('Location:' . BASE_URL . 'etnprofessional/interestareas');	
    }
    
    public function getRemove($id)
	{
        if (isset($id)) {
            $profarea = EtnProfArea::find($id);
            $profarea->delete();
            header('Location:' . BASE_URL . 'etnprofessional/interestareas');	
        }
    }
}