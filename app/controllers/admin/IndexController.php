<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Account;
use AppPHP\Models\Administrator;

/**
 * Clase controlador de inicio de administración.
 * Mediante este controlador se generaran las diferentes tareas del administrador
 */

class IndexController extends BaseController
{
    /**
     * Mediante método GET carga inicio de administración
     * @return plantilla de inicio de administración
     */
    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            # Se guarda la session en una variable local $userId
            $userId = $_SESSION['admID'];
            $inforeg = false;

            if ($userId) {
                # si existe la cuenta en la BD
                $admin = Administrator::where('id_account', $userId)->first();
                if ($admin->ci == "" || $admin->name == "" || $admin->l_name == "") {
                    $inforeg = true;
                }
                return $this->render('admin/index.twig', 
                    ['inforeg'=>$inforeg, 
                    'admin' => $admin
                ]);
            }
        }
        header('Location: ' . BASE_URL . '');
    }
}
