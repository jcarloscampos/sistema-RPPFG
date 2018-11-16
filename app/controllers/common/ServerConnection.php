<?php

namespace AppPHP\Controllers\Common;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Account;
use AppPHP\Models\Area;
use AppPHP\Models\Rol;
use AppPHP\Models\UserRol;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Postulant;
use AppPHP\Models\Period;
use AppPHP\Models\AreaProfile;
use AppPHP\Models\PostulantProfile;
use AppPHP\Models\TypeResponsable;
use AppPHP\Models\Company;
use AppPHP\Models\Modality;
use AppPHP\Models\Career;
use AppPHP\Models\Status;
use AppPHP\Models\EtnTutor;
use AppPHP\Models\Responsable;

/**
 * Clase controlador de inicio para Director de Carrera.
 * Mediante este controlador interactuan las opciones de configuracion del Director de Carrera.
 */

class ServerConnection extends BaseController
{
    public function setSession($user, $name)
    {
        $_SESSION[$name] = $user->id;
        header('Location:' . BASE_URL . 'signin');
        return null;
    }

    /**
     * genera un periodo de tiempo a partir de la fecha actual
     * @return object $nPeriod : Nuevo periodo
     */
    public function makePeriod()
    {
        ini_set('date.timezone', 'America/La_Paz');
        // $currentdateDMY = date("d-m-Y");
        // echo date("d-m-Y",strtotime($currentdateDMY)).'<br>'; 
        // //sumo 12 meses
        // echo date("d-m-Y",strtotime($currentdateDMY."+ 12 month")).'<br>'; 
        // //sumo 5 anio
        // echo date("d-m-Y",strtotime($currentdateDMY."+ 5 year"));
        
        $nPeriod = null;
        $currentdateYMD = date("Y-m-d");
        $startdate = date("Y-m-d",strtotime($currentdateYMD));
        $enddate = date("Y-m-d",strtotime($currentdateYMD."+ 2 year"));

        $periodData = [
            'start_date' => $startdate,
            'end_date' => $enddate
        ];
        
        $currentdate = strtotime(date('Y-m-d', time()));
        $period = (int)date("m", $currentdate);
        $period <= 6 ? $periodData['period'] = 1 : $periodData['period'] = 2;

        $nPeriod = new Period([
            'start_date'=> $periodData['start_date'],
            'end_date'=> $periodData['end_date'],
            'period'=> $periodData['period']
        ]);

        $nPeriod->save();
        
        return $nPeriod;
    }

    /**
     * @param object $user : Usuario al que se asignara un Rol
     * @param string $rol : Nombre de Rol 
     * @return bool $result
     */
    public function linkUseRol($user, $nr)
    {   
        $result = false;

        if (isset($user)) {
            $rol = Rol::where('name_rol', $nr)->first();
    
            $urol = new UserRol([
                'id_account' => $user->id_account,
                'id_rol' => $rol->id_rol
            ]);
            $urol->save();
            $resul = true;
        }
        return $resul;
    }

    public function issetAccount($uname)
    {
        $exists = false;
        $accounts = Account::where("username", "=", $uname)->get()->toArray();
        if (!empty($accounts)){
            $exists = true;
        }
        return $exists;
    }

    /**
     * @param string $uname
     * @param string $pwd
     * @return int id_account
     */
    public function newAccount($uname, $pwd)
    {
        $account = new Account([
            'username' => $uname,
            'password' => password_hash($pwd, PASSWORD_DEFAULT)
        ]);
        $account->save();
        return $account;
    }

    public function removeProfile($profile)
    {
        $pa = AreaProfile::where('id_profile', $profile->id)->first();
        $pp = PostulantProfile::where('id_profile', $profile->id)->first();
        $per = Period::where('id', $pp->id_period)->first();

        $pa->delete();
        $per->delete();
        $pp->delete();
        $profile->delete();
        
        $msg = 0;
        return $this->render('postulant/messages.twig', ['vPerfil' => $user, 'msg' => $msg]);
    }

    public function getTypeResponsable($name)
    {
        $result = 0;

        $tp = TypeResponsable::where('name', $name)->first();
        $result = $tp->id;

        return $result;
    }

    /**
     * @param int $user
     * @param array $profile
     * @return object new user
     */
    public function createUser($tuser, $account)
    {   
        $user = null;
        if ($tuser == "itnprof") {
            # Professional de Umss
            $user = new ProfessionalUmss();
            $user->id_ad = 1;
            $user->id_wl = 1;
        }elseif ($tuser == "etnprof"){
            #Professional exterior
            $user = new ProfessionalExt();
            $user->id_ad = 1;
        }elseif ($tuser == "pstt") {
            # Postulante
            $user = new Postulant();
        }

        $user->id_account = $account->id;        
        $user->save();
        return $user;
    }

    /**
     * @param object $user : Usuario del que se actualizara la contraseña de su cuenta.
     * @param string $pwd : Nueva contraseña.
     * @return bool $result : confirmacion de que fue actualizado el campos de contraseña.
     */
    //$result = $this->updateAccount($_POST['id_account'], $_POST['pwd']);
    public function updateAccount($user, $pwd)
    {
        $result = false;
        $account = Account::find($user->id_account);
        if ($account) {
            Account::where('id', $user->id_account)->update(array(
                'password' => password_hash($pwd, PASSWORD_DEFAULT)
            ));
            $result = true;
        }
        return $result;
    }

    /**
     * @param object $user : Usuario del que se actualizará algún campo
     * @param array $userprofile : Contenido con el que se actualizará algún campo
     * @param object $makeDB : Instancia de la clase ServerConnection (clase actual)
     * @return bool $result : confirmacion de que fue actualizado agun campo.
     */
    public function updateUser($user, $userprofile, $makeDB)
    {   
        $result = false;

        foreach ($userprofile as $column=>$data) {
            if ($user->$column != $data) {
                # Si el campo del usuario es diferente al obtenido del formulario
                $makeDB->$column($user, $data);
                $result = true;
            }
        }
        return $result;
    }
    public function getAreap($profile, $areaprofiles)
    {
        $areap = null;
        $areas = Area::all();

        foreach ($areaprofiles as $key => $valap) {
            if ($valap->id_profile == $profile->id) {
                foreach ($areas as $key => $area) {
                    if(($area->id == $area->id_parent_area || $area->id_parent_area == null) && $area->id == $valap->id_area)
                        $areap = $area;
                }
            }
        }
        return $areap;
    }

    public function getSubAreap($profile, $areaprofiles)
    {
        $subareap = null;
        $subareas = Area::all();

        foreach ($areaprofiles as $key => $valap) {
            if ($valap->id_profile == $profile->id) {
                foreach ($subareas as $key => $subarea) {
                    if($subarea->id != $subarea->id_parent_area && $subarea->id == $valap->id_area)
                        $subareap = $subarea;
                }
            }
        }
        return $subareap;
    }
    public function getTeacher($profile, $responsables)
    {
        $teacherp = null;
        $iprofs = ProfessionalUmss::all();

        foreach ($responsables as $key => $valitnt) {
            if ($valitnt->id_profile == $profile->id) {
                if ($valitnt->id_type_resp == 1) {
                    foreach ($iprofs as $key => $iprof) {
                        if ($iprof->id == $valitnt->id_intprof)
                            $teacherp = $iprof;
                    }
                } 
            }
        }
        return $teacherp;
    }
    public function getDirector()
    {
        $director = null;

        $roldir = Rol::where('name_rol', 'director')->first();
        $urdir = UserRol::where('id_rol', $roldir->id_rol)->first();
        $director = ProfessionalUmss::where('id_account', $urdir->id_account)->first();
        
        return $director;
    }

    public function getAttendant($profile)
    {
        $attendantp = null;
        $companies = Company::all();

        foreach ($companies as $key => $value) {
            if($value->id == $profile->id_cmpy_area)
                $attendantp = $value;
        }

        return $attendantp;
    }

    public function getModality($profile)
    {
        $modalityp = null;
        $modalities = Modality::all();

        foreach ($modalities as $key => $value) {
            if ($value->id == $profile->id_mod) {
               $modalityp = $value;
            }
        }
        return $modalityp;
    }

    public function getPostulants($postulantProfiles, $profile)
    {
        $postsp = [];
        $postulants = Postulant::all();
              
        foreach ($postulantProfiles as $key => $valpp) {
            if ($valpp->id_profile == $profile->id) {
                foreach ($postulants as $postulant => $valp) {
                    if ($valp->id == $valpp->id_postulant)
                        $postsp[] = $valp;
                }
            }
        }

        return $postsp;
    }

    public function getCareer($postulantProfiles, $profile)
    {
        $careerp = null;
        $careers = Career::all();

        foreach ($postulantProfiles as $key => $valpp) {
            if ($valpp->id_profile ==  $profile->id) {
                foreach ($careers as $key => $career) {
                    if ($career->id == $valpp->id_career)
                        $careerp = $career;
                }
            }
        }

        return $careerp;
    }

    public function getState($profile)
    {
        $statep = null;
        $states = Status::all();

        foreach ($states as $key => $value) {
            if ($value->id == $profile->id_status)
                $statep = $value;
        }

        return $statep;
    }

    public function getPeriod($postulantProfiles, $profile)
    {
        $periodp = null;
        $periods = Period::all();

        foreach ($postulantProfiles as $key => $valpp) {
            if ($valpp->id_profile == $profile->id) {
                foreach ($periods as $key => $valp) {
                    if ($valp->id == $valpp->id_period)
                        $periodp = $valp;
                }
            } 
        }

        return $periodp;
    }

    public function getTutors($profile)
    {
        $eprofs = ProfessionalExt::all();
        $iprofs = ProfessionalUmss::all();
        $arrayetntutors = [];
        $arrayitntutors = [];
        $tutorsp = [];
        
        $responsables = Responsable::all();
        foreach ($responsables as $key => $valitnt) {
            if ($valitnt->id_profile == $profile->id) {
                if ($valitnt->id_type_resp == 2) {
                    foreach ($iprofs as $key => $iprof) {
                        if ($iprof->id == $valitnt->id_intprof) {
                            $arrayitntutors[] = $iprof;
                        }
                    }
                } 
            }
        }
        if (count($arrayitntutors) == 1) {
            $tutorsp[0] = $arrayitntutors[0];
        } elseif (count($arrayitntutors) == 2) {
            $tutorsp[0] = $arrayitntutors[0];
            $tutorsp[1] = $arrayitntutors[1];
        }

        $etntutors = EtnTutor::all();
        foreach ($etntutors as $key => $valetnt) {
            if ($valetnt->id_profile == $profile->id) {
                foreach ($eprofs as $key => $eprof) {
                    if ($eprof->id == $valetnt->id_entprof) {
                        $arrayetntutors[] = $eprof;
                    }
                }
            }
        }
        if (count($arrayetntutors) == 1) {
            if (count($arrayitntutors) == 0) {
                $tutorsp[0] = $arrayetntutors[0];
            } else {
                $tutorsp[1] = $arrayetntutors[0];
            }
            
        } elseif (count($arrayetntutors) == 2) {
            $tutorsp[0] = $arrayetntutors[0];
            $tutorsp[1] = $arrayetntutors[1];
        }
        return $tutorsp;

    }








  








































    /********************** FUNCIONES PARA ACTUALIZAR CAMPOS EN LA BD **********************/
    
    /**
     * @param object $user : Usuario del que se actualizara una característica.
     * @param string $arg : Dato con el que se actualizara una característica.
     */

    public function name($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('name' => $arg));
        }
    }
    public function l_name($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('l_name' => $arg));
        }
    }
    public function ml_name($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('ml_name' => $arg));
        }
    }
    public function ci($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('ci' => $arg));
        }
    }
    public function email($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('email' => $arg));
        }
    }
    public function phone($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('phone' => $arg));
        }
    }
    public function address($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('address' => $arg));
        }
    }
    public function avatar($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('avatar' => $arg));
        }
    }
    public function profile($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('profile' => $arg));
        }
    }
    public function a_degree($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('a_degree' => $arg));
        }
    }
    public function cod_sis($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('cod_sis' => $arg));
        }
    }
    public function workload($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('workload' => $arg));
        }
    }
    public function id_ad($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('id_ad' => $arg));
        }
    }
    public function id_wl($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('id_wl' => $arg));
        }
    }
    public function active($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('active' => $arg));
        }
    }
    public function id_rol($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('id_rol' => $arg));
        }
    }
    public function description($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('description' => $arg));
        }
    }
    public function id_parent_area($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('id_parent_area' => $arg));
        }
    }
    public function title($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('title' => $arg));
        }
    }
    public function g_objective($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('g_objective' => $arg));
        }
    }
    public function s_objects($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('s_objects' => $arg));
        }
    }
    public function id_status($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('id_status' => $arg));
        }
    }
    public function end_date($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('end_date' => $arg));
        }
    }
    public function extended($user, $arg)
    {
        if (isset($user)) {
            $user::where('id', $user->id)->update(array('extended' => $arg));
        }
    }
    
    
}
