<?php

namespace AppPHP\Controllers\Common;

class SettingData
{
    /**
     * @param string $name : Nombre completo
     * @param string $lname : Apellido paterno
     * @return object $uname : Nuevo nombre de usuario generado
     */
    public function generateUserName($name, $lname)
    {
        $uname = "";
        $uname .= substr($name, 0, 1);
        $uname .= $lname;
        return $uname;
    }

    /**
     * @return string $password : Nueva contracenia generada
     */
    public function generatePassword()
    {
        $password = "";
        $length = 8;
        $charset = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUVXYZ0123456789!@#$%&*-_";
        for ($i=0; $i < $length; $i++) { 
            $rand = rand() % strlen($charset);
            $password .= substr($charset, $rand, 1);
        }
        return $password;
    }

    /**
     * @param string $text : Nombre de usuario base
     * @return string $account : Nuevo nombre de usuario robusta generada
     */
    public function accountSug($text)
    {
        $uname = $text;
        $charset = "0123456789";
        for ($i=0; $i < 2; $i++) { 
            $rand = rand() % strlen($charset);
            $uname .= substr($charset, $rand, 1);
        }
        return $uname;
    }

    /**
     * @param object $generator : Generador
     * @param object $makeDB : Conector a la BD
     * @param string $username : Nombre de usuario
     * @return string $uname : Nombre de usuario que aun no existe en la BD
     */
    public function makeUname($generator, $makeDB, $username)
    {
        $uname = "";

        if ($makeDB->issetAccount($username)) {
            $uname .= $this->makeUname($generator, $makeDB, $generator->accountSug($username)); 
        } else {
            $uname = $username;
        }
        return $uname;
    }

    public function valEtn($uProfile){
        $val = false;
        if ($uProfile->name == "" || $uProfile->l_name == "" || $uProfile->ci == 0 || $uProfile->email == "") {
            $val = true;
        }
        return $val;
    }

    public function valItn($uProfile){
        $val = false;
        if ($uProfile->name == "" || $uProfile->l_name == "" || $uProfile->ci == 0 || $uProfile->email == "" || $uProfile->cod_sis == 0) {
            $val = true;
        }
        return $val;
    }
    //($areaprofiles, $etnprofareas, $eprofessionals);
    public function getTutors($profileareas, $profareas, $professionals, $idprofile){
        $result = [];
        $auxids = [];
        
        foreach ($profileareas as $key => $profilearea) {
            if ($profilearea->id_profile == $idprofile){
                foreach ($profareas as $key => $profarea) {
                    if ($profilearea->id_area == $profarea->id_area) {
                        $auxids[] = $profarea->id_prof;
                    }
                }
            }
        }

        foreach ($auxids as $key => $auxid) {
            foreach ($professionals as $key => $professional) {
                if ($auxid == $professional->id) {
                    $result[] = $professional->id;
                }
            }
        }
        return array_unique($result);
    }
}