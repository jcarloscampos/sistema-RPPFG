<?php

namespace AppPHP\Controllers\Accounts;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Account;
use AppPHP\Models\UserRol;
use AppPHP\Models\Postulant;
use AppPHP\Models\ProfessionalUmss;
use AppPHP\Models\ProfessionalExt;

/**
 * Clase controlador para inicio de sesión de todos los usuarios asociados a este sistema
 */

class SigninController extends BaseController
{
    /**
     * Redirecciona al perfil del usuario segun el tipo de cuenta que tienen
     */
    public function getIndex(){
        if (isset($_SESSION['admID'])) {
            # la cuenta es de un administrador
            header('Location:' . BASE_URL . 'admin');
            return null;
        } elseif (isset($_SESSION['staryID'])) {
            # la cuenta es director de carrera
            header('Location:' . BASE_URL . 'secretary');
            return null;
        }
        elseif (isset($_SESSION['dirID'])) {
            # la cuenta es director de carrera
            header('Location:' . BASE_URL . 'director');
            return null;
        } elseif (isset($_SESSION['postID'])) {
            # la cuenta es de un postulante
            header('Location:' . BASE_URL . 'postulant');
            return null;
        } elseif (isset($_SESSION['iprofID'])) {
            # la cuenta es de un profesional
            header('Location:' . BASE_URL . 'itnprofessional');
            return null;
        }elseif (isset($_SESSION['eprofID'])) {
            # la cuenta es de un profesional
            header('Location:' . BASE_URL . 'etnprofessional');
            return null;
        }

        header('Location: ' . BASE_URL . '');
    }
}