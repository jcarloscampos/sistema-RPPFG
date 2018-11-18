<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\User;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;

class UsersController extends BaseController
{
    /**
     * Mediante método GET se hace la petición para mostrar todos los usuarios actuales
     * get() se usa para traer los resultados (ejecuta la consulta y regresa el valor que obtienes)
     * @return la vista con la lista de áreas que están en la BD
     */
    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $users = User::query()->orderBy('name', 'asc')->get();
            return $this->render('admin/list_users.twig', ['users' => $users, 'admin' => $admin]);
        }
    }
}
