<?php

namespace AppPHP\Controllers\Student;

use AppPHP\Controllers\BaseController;

class RegistryController extends BaseController
{
  

    public function getIndex(){
        return $this->render('student/registry.twig'); 
    }

    public function postIndex(){
        global $pdo;
        $result = false;
        
        if (!empty($_POST)) {
            $query = $pdo->prepare('SELECT * FROM esta_inscrito');
            $query->execute();
            $val = $query->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($val as $row) {
                if ($row["cod_sis"] == $_POST['codsis']) {
                    if ($_POST['pwd1']==$_POST['pwd2']) {

                        $sql = 'INSERT INTO cuenta (usuario, contracenia) VALUES (:usuario, :contracenia)';
                        $query = $pdo->prepare($sql);
                        $result = $query->execute([
                            'usuario' => $_POST['usuario'],
                            'contracenia' => $_POST['pwd1']
                        ]);
                        
                        
                        $sql = 'INSERT INTO estudiante (cod_sis, ci, nomb, ape_pat, ape_mat, telefono, dir, email)
                        VALUES (:cod_sis, :ci, :nomb, :ape_pat, :ape_mat, :telefono, :dir, :email)';
                        $query = $pdo->prepare($sql);
                        $result = $query->execute([
                           'cod_sis' => $_POST['codsis'],
                           'ci' => $_POST['ci'],
                           'nomb' => $_POST['nombre'],
                           'ape_pat' => $_POST['apaterno'],
                           'ape_mat' => $_POST['amaterno'],
                           'telefono' => $_POST['telefono'],
                           'dir' => $_POST['dir'],
                           'email' => $_POST['email']
                    
                       ]);
                    }
                }
            }
        

        }

        return $this->render('student/registry.twig', ['result'=>$result]); 
    }

}