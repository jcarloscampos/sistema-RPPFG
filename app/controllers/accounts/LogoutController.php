<?php

namespace AppPHP\Controllers\Accounts;

use AppPHP\Controllers\BaseController;

/**
 * Clase controlador para cierre de sesión de todos los usuarios asociados a este sistema
 */

class LogoutController extends BaseController
{
    /**
     * Función para terminar la sección de todos los usuarios asociados a este sistema.
     */
    public function getIndex(){

        if (isset($_SESSION['admID'])) {
            unset($_SESSION['admID']);
            header('Location: ' . BASE_URL . '');

        } elseif (isset($_SESSION['dirID'])) {
            unset($_SESSION['dirID']);
            header('Location: ' . BASE_URL . '');

        } elseif (isset($_SESSION['postID'])) {
            unset($_SESSION['postID']);
            header('Location: ' . BASE_URL . '');

        } elseif (isset($_SESSION['iprofID'])) {
            unset($_SESSION['iprofID']);
            header('Location: ' . BASE_URL . '');
        }elseif (isset($_SESSION['eprofID'])) {
            unset($_SESSION['eprofID']);
            header('Location: ' . BASE_URL . '');
        }
    }
}