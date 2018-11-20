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

class ForgotPassController extends BaseController
{
    /**
     * Redirecciona al perfil del usuario segun el tipo de cuenta que tienen
     */
    public function getIndex()
    {
        return $this->render('accounts/forgotpass.twig');
    }

    public function postIndex()
    {
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: Your name <info@address.com>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
mail("flakita.florida@gmail.com","My subject",$msg, $headers);

return $this->render('accounts/forgotpass.twig');
    }

}