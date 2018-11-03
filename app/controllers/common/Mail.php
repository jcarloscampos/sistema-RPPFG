<?php

namespace AppPHP\Controllers\Common;

class Mail
{
    public function sendEMail($array)
    {
        $result = false;
        $to = $array['email'];
        $uname = $array['username'];
        $pwd = $array['password'];

        //echo "<script>alert('Funcion \"mail()\" ejecutada, por favor verifique su bandeja de correo.');</script>";
        echo "<script>alert('Cuenta enviada a \"$to\": Username: \"$uname\", Contracenia: \"$pwd\"');</script>";
        # Implementar la funcion para enviar correo con la cuenta u contracenia
        $result = true;
        return $result;
    }
}