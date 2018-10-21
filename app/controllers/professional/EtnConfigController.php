<?php

namespace AppPHP\Controllers\Professional;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Account;

class EtnConfigController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['profID'])) {
            $user = ProfessionalExt::where('id_account', $_SESSION['profID'])->first();
        }
        return $this->render('professional/etn-config.twig', ['vPerfil' => $user]);
    }
}