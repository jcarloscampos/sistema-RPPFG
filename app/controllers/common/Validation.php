<?php
namespace AppPHP\Controllers\Common;

class Validation 
{
    public function setRuleBasic($validator)
    {
        $validator->add(array(
            'name:Nombre'=> 'required | 
                            minlength(3)({label} debe tener al menos {min} caracteres) | 
                            maxlength(30)({label} debe tener menos de {max} caracteres)',
            'lname:Apellido paterno'=> 'required | 
                                        minlength(2)({label} debe tener al menos {min} caracteres) | 
                                        maxlength(20)({label} debe tener menos de {max} caracteres)',
            'mlname:Apellido materno'=>'minlength(2)({label} debe tener al menos {min} caracteres) | 
                                        maxlength(20)({label} debe tener menos de {max} caracteres)',
            'phone: Teléfono o celular'=>'  minlength(7)({label} debe tener al menos {min} caracteres) | 
                                            maxlength(8)({label} debe tener menos de {max} caracteres)',
            'email:Email'=> 'required | email',
            'address:Dirección de domiciliio'=> 'minlength(5)({label} debe tener al menos {min} caracteres) | 
                                                maxlength(200)({label} debe tener menos de {max} caracteres)',
            'pwd:Contraseña'=>  'minlength(5)({label} debe tener al menos {min} caracteres) | 
                                maxlength(30)({label} debe tener menos de {max} caracteres)',
            'pwdc:Contraseñas'=> 'match(item=pwd)({label} no coinciden )'
            
        ));
        return $validator;
    }
    public function setRuleCodeSis($validator)
    {
        $validator->add(array(
            'codsis:Código SIS'=>'  required | 
                                    minlength(7)({label} debe tener maoyr de {min} caracteres) | 
                                    maxlength(9)({label} debe tener menos de {max} caracteres)'
        ));
        return $validator;
    }

    public function setRuleTuser($validator)
    {
        $validator->add(array('tuser:Tipo de usuario'=> 'required'));
        return $validator;
    }

    public function setRuleUser($validator)
    {
        $validator->add(array(
            'user:Nonbre de usuario'=> 'required | 
                                        minlength(4)({label} debe tener al menos {min} caracteres) | 
                                        maxlength(16)({label} debe tener menos de {max} caracteres)'
        ));
        return $validator;
    }

    public function setRuleArea($validator)
    {
        $validator->add(array(
            'name:Nombre de área'=> 'required | 
                                        minlength(5)({label} debe tener al menos {min} caracteres)',
            'desc:Descripción de área'=> 'minlength(5)({label} debe tener al menos {min} caracteres)'
        ));
        return $validator;
    }
    public function setRuleSubareaUpdt($validator)
    {
        $validator->add(array(
            'name:Nombre de sub área'=> 'required | 
                                        minlength(5)({label} debe tener al menos {min} caracteres)',
            'desc:Descripción de sub área'=> 'minlength(5)({label} debe tener al menos {min} caracteres)'
        ));
        return $validator;
    }

    public function setRuleSubareaCreate($validator)
    {
        $validator->add(array(
            'nameareasel:Identificación de sub área'=> 'required',
            'name:Nombre de sub área'=> 'required | 
                                        minlength(5)({label} debe tener al menos {min} caracteres)',
            'desc:Descripción de sub área'=> 'minlength(5)({label} debe tener al menos {min} caracteres)'
        ));
        return $validator;
    }

    public function setRuleFile($validator)
    {
        $validator->add(array('listaAreasSubareas:Archivo de áreas y sub áreas'=> 'required'));
        return $validator;
    }

    public function setRuleCI($validator)
    {
        $validator->add(array(
            'ci:No de identificación personal'=>'required | 
                                                minlength(6)({label} debe tener al menos {min} caracteres) | 
                                                maxlength(15)({label} debe tener menos de {max} caracteres)'
        ));
        return $validator;
    }
    
}