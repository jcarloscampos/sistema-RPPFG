<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;

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
        return $this->render('admin/index.twig');
    }
}
