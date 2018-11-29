<?php

namespace AppPHP\Controllers\Postulant\Defprofile;

use AppPHP\Controllers\BaseController;
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
use AppPHP\Models\EtnProfArea;
use AppPHP\Models\ItnProfArea;
use Sirius\Validation\Validator;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\ServerConnection;
use AppPHP\Controllers\Common\SettingData;


class HeadingController extends BaseController
{
    
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $user = Postulant::where('id_account', $_SESSION['postID'])->first();
            $aux = PostulantProfile::where('id_postulant', $user->id)->first();
            $uimage = substr($user->name, 0, 1);
            if (!isset($aux)){
                $postulants = Postulant::all();
                $modalities = Modality::all();
                $career = Career::all();
                $areas = Area::all();
                $company = Company::all();
                $postulantprofiles = PostulantProfile::all();
                $nottutor = true;
                $choiceerror = true;
                $postulantsvals = [];

                // Solo se pasaran los estudiantes que no estan en un perfil
                foreach ($postulants as $key => $postulant) {
                    $auxpp = PostulantProfile::where('id_postulant', $postulant->id)->first();
                    if (!isset($auxpp))
                        if ($user->ci != $postulant->ci)
                            $postulantsvals[] = $postulant;
                }
                
                return $this->render('postulant/settle-heading.twig',
                ['vPerfil' => $user, 'uimage'=>$uimage, 'modalities'=>$modalities, 'careers' => $career, 'areas' => $areas,
                'postulants' => $postulantsvals, 'companies' => $company, 'choiceerror'=>$choiceerror, 'nottutor'=>$nottutor
                ]);
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
            $stts = Status::where('name', 'aceptado')->first();
            $makeDB = new ServerConnection(); 
            $validation = new Validation();
            $validator = new Validator();
            $areasub = [];
            $errors = [];
            $writingError = false;
            $nottutor = false;
            $choiceerror = true;

            $validation->setRuleDefOne($validator);

            if (isset($_POST['jwork'])) {
                if ($_POST['jwork'] == 1) {
                    $validation->setRuleJworkpost($validator);
                }
            }
            if (isset($_POST['modality'])) {
                // if ($_POST['modality'] == 3 || $_POST['modality'] == 4) {
                if ($_POST['modality'] == 3) {
                    $validation->setRuleCompany($validator);
                }
            }
            
            if ($validator->validate($_POST)) {
                if ($this->issettutor($_POST['area'])) {
                    $choiceerror = false;
                    if (isset($_POST['subarea'])) {
                        $choiceerror = false;
                        $aax = Area::where('id', $_POST['subarea'])->first();

                        if ($_POST['area'] == $aax->id_parent_area) {
                            $choiceerror = true;
                        }
                    }else{
                        $choiceerror = true;
                    }
                    $nottutor = true;
                }

                if ($nottutor && $choiceerror) {
                    $profileData = [
                        'id_mod' => $_POST['modality'],
                        'id_status' => $stts->id
                    ];
    
                    // Si modalidad es trabajo dirigido agrega informacion de la empresa proponente del proyecto
                    ($_POST['modality'] == 3) ? $profileData['id_cmpy_area'] = $_POST['company_d'] : $profileData['id_cmpy_area'] = 1;
                    
                    // Array de area y sub area
                    if (isset($_POST['subarea'])) {
    
                        $areasub[] = $_POST['area'];
                        $areasub[] = $_POST['subarea'];
                    } else {
                        $areasub[] = $_POST['area'];
                    }
    
                    $profile = $this->createProfile($profileData);

                    if ($this->createAreaProfile($profile, $areasub) && $this->createPostulantProfile($user, $profile, $_POST['career'], $makeDB -> makePeriod())) {
                        if ($_POST['jwork'] == 1) {
                            $postJW = Postulant::where('id', $_POST['jworkpost'])->first();
                            $ausPP = PostulantProfile::where('id_profile', $profile->id)->first();
                            $prdpfl = Period::where('id', $ausPP->id_period)->first();
                            (isset($postJW)) ? $this->createPostulantProfile($postJW, $profile, $_POST['career'], $prdpfl) : $writingError = true;     
                        }
                    } else
                        $writingError = true;
    
                    if ($writingError) {
                        $makeDB->removeProfile($profile);
                    } else {
                        header('Location: ' . BASE_URL . 'postulant/settle/essence');
                        return null;
                    }
                }
            }else{
                $errors = $validator->getMessages();
            }
            $postulants = Postulant::all();
            $modalities = Modality::all();
            $career = Career::all();
            $areas = Area::all();
            $company = Company::all();
            $postulantprofiles = PostulantProfile::all();

            // Solo se pasaran los estudiantes que no estan en un perfil
            foreach ($postulants as $key => $postulant) {
                $auxpp = PostulantProfile::where('id_postulant', $postulant->id)->first();
                if (!isset($auxpp))
                    if ($user->ci != $postulant->ci)
                        $postulantsvals[] = $postulant;
            }

            return $this->render('postulant/settle-heading.twig',
            ['vPerfil' => $user, 'uimage'=>$uimage, 'errors' => $errors, 'modalities'=>$modalities,
            'careers' => $career, 'areas' => $areas, 'postulants' => $postulantsvals, 'companies' => $company,
            'nottutor'=>$nottutor, 'choiceerror'=>$choiceerror
            ]);
        }
        header('Location: ' . BASE_URL . '');
    }

    /**
     * @param array $dataset : Datos con que se creara el Perfil
     * @return object $nProfile : Nuevo Perfil creado
     */
    private  function createProfile($dataset)
    {
        $nProfile = null;
        //$registered = IsRegistered::where("ci", "=", $_POST['ci'])->get()->toArray();
        $totalp = Profile::all()->toArray();
        $nump = count($totalp)+1;
        $nProfile = new Profile([
            'num_profile' => $nump,
            'id_cmpy_area' => $dataset['id_cmpy_area'],
            'id_mod' => $dataset['id_mod'],
            'id_status' => $dataset['id_status'],
            ]);
        $nProfile->save();
        return $nProfile;
    }

    /**
     * @param object $user : Postulante propietario del Perfil de Grado
     * @param object $profile : Perfil que se relacionara con el Postulante
     * @param int $idcareer : Id de la carrera
     * @param object $makeDB : Objeto generador de funciones
     * @return bool $nPP : Confirma la accion realizada
     */
    private function createPostulantProfile($user, $profile, $idcareer, $prd)
    {
        $nPP = false;
        if(isset($user) && isset($profile) && isset($idcareer) && isset($prd)){
            $nPostPfl = new PostulantProfile([
                'id_postulant' => $user->id,
                'id_profile' => $profile->id,
                'id_career' => $idcareer,
                'id_period' => $prd->id
            ]);
            $nPostPfl->save();
            $nPP = true;
        }
        return $nPP;
    } 

    /**
     * @param object $profile : Perfil de grado
     * @param array $areas : Lista de areas
     * @return bool $result : confirma la accion realizada
     */
    private function createAreaProfile($profile, $areas)
    {
        $result = false;
        foreach ($areas as $idarea) {
            $nAP = new AreaProfile([
                'id_profile' => $profile->id,
                'id_area' => $idarea
            ]);
            $nAP->save();
            $result = true;
        }
        return $result;
    }

    private function inputError(){

    }
    private function issettutor($idarea)
    {
        $result = false;
        $itnprofarea = ItnProfArea::where('id_area', $idarea)->first();
        $etnprofarea = EtnProfArea::where('id_area', $idarea)->first();

        if (isset($itnprofarea) || isset($etnprofarea))
            $result = true;
        return $result;
    }
}