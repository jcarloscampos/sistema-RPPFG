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
                $userProfile = ProfessionalUmss::where('id_account', $userId)->first();
                if (isset($userProfile)) {
                    # Es un profecional de UMSS
                    $inforeg = $this->validated($userProfile);
                    $etn = false;
                    return $this->render('professional/index.twig', ['inforeg'=>$inforeg, 'vPerfil'=>$userProfile, 'etn'=>$etn]);
                }
                $userProfile = ProfessionalExt::where('id_account', $userId)->first();
                $inforeg = $this->validated($userProfile);
                return $this->render('professional/index.twig', ['inforeg'=>$inforeg, 'vPerfil'=>$userProfile, 'etn' =>$etn]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }
    private function validated($uProfile){
        $val = false;
        if ($uProfile->a_degree == "" || $uProfile->workload == "" || $uProfile->cod_sis == "") {
            $val = true;
        }
        return $val;
    }
}