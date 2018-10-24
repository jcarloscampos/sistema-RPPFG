<?php

namespace AppPHP\Controllers\Professional;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;

/**
 * Clase controlador de inicio para profesionales de que trabjan en la UMSS.
 * Mediante este controlador interactuan las opciones de configuracion del profesional.
 */

class IndexController extends BaseController
{
    public function getIndex()
    {
        $inforeg = false;
        $etn = true;

        if (isset($_SESSION['profID'])) {
            $userId = $_SESSION['profID'];
            
            if ($userId) {
                # si existe la cuenta en la BD
                $userprofile = ProfessionalUmss::where('id_account', $userId)->first();
                if (isset($userprofile)) {
                    # Es un profecional de UMSS
                    $inforeg = $this->valItn($userprofile);
                    //define que no es profesional externo; uso en vista para mostrar algunos campos
                    $etn = false;
                    return $this->render('professional/index.twig', ['inforeg'=>$inforeg, 'vPerfil'=>$userprofile, 'etn'=>$etn]);
                }
                $userprofile = ProfessionalExt::where('id_account', $userId)->first();
                $inforeg = $this->valEtn($userprofile);
                return $this->render('professional/index.twig', ['inforeg'=>$inforeg, 'vPerfil'=>$userprofile, 'etn' =>$etn]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }
    private function valEtn($uProfile){
        $val = false;
        if ($uProfile->a_degree == "" || $uProfile->phone == 0) {
            $val = true;
        }
        return $val;
    }

    private function valItn($uProfile){
        $val = false;
        if ($uProfile->a_degree == "" || $uProfile->phone == 0 || $uProfile->workload == "" || $uProfile->cod_sis == "") {
            $val = true;
        }
        return $val;
    }
}