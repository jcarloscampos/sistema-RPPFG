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

        $user = $array['user'];
        $message = $array['message'];

        // $datasend['user'] = $userName;
        // $datasend['message'] = $message;
        //$datasend['case'] = 2;

        //echo "<script>alert('Funcion \"mail()\" ejecutada, por favor verifique su bandeja de correo.');</script>";
        echo "<script>alert('Cuenta enviada a \"$to\": Username: \"$user\", Contracenia: \"$message\"');</script>";
        # Implementar la funcion para enviar correo con la cuenta u contracenia
        $email_user = "serenium.s.r.l@gmail.com";
        $email_password = "sereniums.r.l.";
        $the_subject = "Creacion cuenta SRPPFG";
        $address_to = $to;
        $from_name = "Administrador ";
        $phpmailer = new PHPMailer();
        // ---------- datos de la cuenta de Gmail -------------------------------
        $phpmailer->Username = $email_user;
        $phpmailer->Password = $email_password;
        //-----------------------------------------------------------------------
        //$phpmailer->SMTPDebug = 1;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Host = "smtp.gmail.com"; // GMail
        //$phpmailer->Port = 465;

        $phpmailer->Port = 465;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;
        $phpmailer->setFrom($phpmailer->Username,$from_name);
        $phpmailer->AddAddress($address_to); // recipients email
        $phpmailer->Subject = $the_subject;
        $phpmailer->Body .= $mensaje;
        $phpmailer->IsHTML(true);

        if ($array['username'] == "" && $array['password'] == "") {
            if ($array['case'] == 1) {
                $phpmailer->Body = '<h1>BIENVENIDO al SRPPFG</h1>'.'<img src="http://serenium.hosting.cs.umss.edu.bo/images/serenium.jpg">'.'  <p><strong>Estimado postulante: </strong> </p>'.$array['user']."\r\n"."\r\n".'<br><br>'.$array['message']."\r\n"."\r\n".
                '<p> <em>Saludos,</em>' ."\r\n".'SRPPFG  </p> ';
            }
        } else {
            $phpmailer->Body = '<h1>BIENVENIDO al SRPPFG</h1>'.'<img src="http://serenium.hosting.cs.umss.edu.bo/images/serenium.jpg">'.'  <p>Se le asigno la siguiente <strong> CUENTA: </strong> </p>'.$uname."\r\n"."\r\n". '<p> y la siguiente <strong> CONTRASENIA : </p>'.$pwd."\r\n"."\r\n".
            '<p> <em> favor entrar al siguiente link para el llenando de sus datos :</em>' ."\r\n".'<a href="http://serenium.hosting.cs.umss.edu.bo/">Serenium finalizacion Registro</a> </p> ';
        }
        



        $resultado="";
        if(!$phpmailer->Send()) {
            $resultado="Error al enviar: ".$phpmailer­->ErrorInfo;
        } else {
            $resultado="Mensaje enviado!";
            $result = true;
        }
        
        //return $resultado;
        //$result = false;
        return $result;
    }
}