<?php

namespace AppPHP\Controllers\Professional;

use AppPHP\Controllers\BaseController;
use Sirius\Validation\Validator;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Account;

class EtnConfigController extends BaseController
{
    public function getIndex()
    {
        if (isset($_SESSION['profID'])) {
            $userProfile = ProfessionalExt::where('id_account', $_SESSION['profID'])->first();
        }
        return $this->render('professional/etn-config.twig', ['vPerfil' => $userProfile]);
    }



    public function postIndex()
    {
        $errors = [];
        $validator = new Validator();
        $result = false;
        //$user = ProfessionalExt::where('id_account',$_SESSION['profID'])->first();
        $user = ProfessionalExt::find($_POST['id']);
        $validator->add(array(
            'name:Nonbre'=> 'required | 
                            minlength(3)({label} debe tener al menos {min} caracteres) | 
                            maxlength(30)({label} debe tener menos de {max} caracteres)',
            'lname:Apellido paterno'=> 'required | 
                                        minlength(3)({label} debe tener al menos {min} caracteres) | 
                                        maxlength(20)({label} debe tener menos de {max} caracteres)',
            'mlname:Apellido materno'=> 'required | 
                                        minlength(3)({label} debe tener al menos {min} caracteres) | 
                                        maxlength(20)({label} debe tener menos de {max} caracteres)',

            'ci:No de identificación personal'=>'required | 
                                                minlength(6)({label} debe tener al menos {min} caracteres) | 
                                                maxlength(15)({label} debe tener menos de {max} caracteres)',

            'phone: Teléfono o celular'=>'  minlength(7)({label} debe tener al menos {min} caracteres) | 
                                            maxlength(8)({label} debe tener menos de {max} caracteres)',
            'email:Email'=> 'required | email',
            'address:Dirección de domiciliio'=> 'minlength(5)({label} debe tener al menos {min} caracteres) | 
                                                maxlength(200)({label} debe tener menos de {max} caracteres)',
            'pwd:Contraseña'=>  'minlength(5)({label} debe tener al menos {min} caracteres) | 
                                maxlength(30)({label} debe tener menos de {max} caracteres)',
            'pwdc:Contraseñas'=> 'match(item=pwd)({label} no coinciden )'
            
        ));
       
        $userprofile = [
            'name' => $_POST['name'],
            'l_name' => $_POST['lname'],
            'ml_name' => $_POST['mlname'],
            'ci'=> $_POST['ci'],
            'email'=> $_POST['email'],
            'phone'=> $_POST['phone'],
            'address'=> $_POST['address'],
            'avatar'=> $_POST['avatar'],
            'profile'=> $_POST['profile']
        ];
        
        
        (isset($_POST['adegree'])) ? $userprofile['a_degree'] = $_POST['adegree'] : $userprofile['a_degree'] = $user->a_degree;

        if ($validator->validate($_POST)) {
            if (isset($_POST['pwd']) && $_POST['pwd'] ) {
                # los campos de pwd fueron modificados
                echo "actuliza datos y pass";
            } else {
                # solo actualizar los datos
                $result = $this->updateUser($user, $userprofile);
                echo "acrualia soolo datos";
            }








        }else{
            $errors = $validator->getMessages();
            
        }
        // return $this->render(
        //     'professional/etn-config.twig',
        //     ['vPerfil' => $userprofile,
        //     'errors' => $errors,
        //     'result' => $result
        //     ]);
    }

    private function updateUser($usr, $profile)
    {   
        $fillableCol = $this->compare($usr, $profile);
        if ($usr) {
            $usr::where('id', $usr->id)->update(array(
                'phone' => $profile['phone'],
                'address' => $profile['address'],
                'avatar' => $profile['avatar'],
                'a_degree' => $profile['a_degree'],
                'profile' => $profile['profile']
            ));
        }
        return true;
    }
    /**
     * @param object $usr : usario existente para comparar
     * @param array $filCol : fillable Column in user
     */
    private function compare($usr, $filCol){

    }


}