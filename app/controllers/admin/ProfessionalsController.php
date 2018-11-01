<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Account;
use AppPHP\Models\UserRol;
use AppPHP\Models\Rol;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;

class ProfessionalsController extends BaseController
{

    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            //$title = ADegree::query()->get();
            $itn = ProfessionalUmss::query()->get();
            $etn = ProfessionalExt::query()->get();
            $account = Account::query()->get();
            $urol = UserRol::query()->get();
            $rol = Rol::query()->get();
            return $this->render('admin/list-profesionals.twig',
            ['admin' => $admin, 'vitns'=>$itn, 'vetns'=>$etn, 'vaccounts'=>$account, 'vurols'=>$urol, 'vrols'=>$rol]);
        }
    }

    public function getNewaccount()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/insert-account.twig', ['admin' => $admin]);
        }
    }

    public function PostNewaccount()
    {
        # Crea una nueva cuenta para profesionales
    }
}
