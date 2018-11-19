<?php

namespace AppPHP\Controllers\Student;

use AppPHP\Controllers\BaseController;

/**
 * Clase controlador para inicio de sesión del estudiante
 */

class IndexController extends BaseController
{
    /**
     * Mediante el método GET carga la vista de login para estudiante
     * @return plantilla de login de estudiante
     */
    public function getIndex(){
        return $this->render('student/index.twig'); 
    }


}
