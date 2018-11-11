<?php

namespace AppPHP\Controllers\Postulant\Defprofile;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Postulant;
use AppPHP\Models\Modality;
use AppPHP\Models\Career;
use AppPHP\Models\Area;
use AppPHP\Models\ProfSmatter;
use AppPHP\Models\SubjectMatter;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\EtnProfArea;
use AppPHP\Models\ItnProfArea;


/**
 * Clase controlador de inicio para Postunalte del proyecto.
 * Mediante este controlador interactuan las opciones de configuracion del Postulante.
 */

class RestrainedController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['postID'])) {
            $userId = $_SESSION['postID'];
            $inforeg = false;

            if ($userId) {
                # si existe la cuenta en la BD
                $user = Postulant::where('id_account', $userId)->first();
                $matter = SubjectMatter::where('sigla', '2010214')->first();
                $pmatter = ProfSmatter::where("id_smatter", "=", $matter->id)->get()->toArray();

                //ProfessionalExt
                //EtnProfArea
                //ItnProfArea
                $profs = ProfessionalUmss::all();

                
                return $this->render('postulant/settle-restrained.twig',
                ['vPerfil'=>$user, 'matter' => $matter, 'pmatters' => $pmatter, 'profs' => $profs]);
            }
        }
        // header('Location: ' . BASE_URL . '');
    }
}