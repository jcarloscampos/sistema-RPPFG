<?php

namespace AppPHP\Controllers\Common;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Account;
use AppPHP\Models\Rol;
use AppPHP\Models\UserRol;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Postulant;
use AppPHP\Models\Period;
use AppPHP\Models\AreaProfile;
use AppPHP\Models\PostulantProfile;
use AppPHP\Models\TypeResponsable;

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
        $nPeriod = null;
        ini_set('date.timezone', 'America/La_Paz');
        $startdate = date_create(date('d-m-Y', time()));
        $enddate = date_add($startdate, date_interval_create_from_date_string('10 days'));
        
        $currentdate = strtotime(date('d-m-Y', time()));
        $period = (int)date("m", $currentdate);

        $periodData = [
            'start_date' => $startdate,
            'end_date' => $enddate
        ];
        
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
    
}
