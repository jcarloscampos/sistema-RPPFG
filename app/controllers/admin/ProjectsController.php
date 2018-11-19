<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\ProfessionalUMSS;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Profile;
use AppPHP\Models\Period;
use AppPHP\Models\Postulant;
use AppPHP\Models\Area;
use AppPHP\Models\Career;
use AppPHP\Models\Modality;
use AppPHP\Models\Status;
use AppPHP\Models\Account;
use AppPHP\Models\ProjectsView;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;
use AppPHP\Controllers\Common\Validation;
use AshleyDawson\SimplePagination\Paginator;


/**
 * Clase controlador para lectura, inserción, eliminación y actualización de datos de la tabla Proyectos
 */

class ProjectsController extends BaseController
{
    /**
     * Mediante método GET se hace la petición para mostrar todos los Proyectos actuales
     * get() se usa para traer los resultados (ejecuta la consulta y regresa el valor que obtienes)
     * @return la vista con la lista de áreas que están en la BD
     */
    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $Proyectos = ProjectsView::query()->orderBy('title', 'asc')->get()->toArray();
            $params = null; 
            $page = 1;
            $myUrl=parse_url($_SERVER['REQUEST_URI']);
            if(isset($myUrl['query'])){
                parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);
                $page = (int)$params['page'];          
            }
            $paginator = new Paginator();
            $paginator->setItemsPerPage(5)->setPagesInRange(5);
            $paginator->setItemTotalCallback(function () use ($Proyectos) {
                return count($Proyectos);
            });
            $length = $paginator->getItemsPerPage();
            $offset =  $page * $length;
            $paginator->setSliceCallback(function ($offset, $length) use ($Proyectos) {
                return array_slice($Proyectos, $offset, $length);
            });
            $pagination = $paginator->paginate($page);
            return $this->render('admin/list_projects.twig', ['Proyectos' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page, 'admin' => $admin]);         

            //return $this->render('admin/list_projects.twig', ['Proyectos' => $Proyectos, 'admin' => $admin]);
        }
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para insertar un docente
     */
    public function getCreate()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/insert_teacher.twig', ['admin' => $admin]);
        }
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postCreate()
    {
        $result = false;
        $errors = [];
        $validator = new Validator();
        
        $validator->add('nameteacher:Nombre del Docente',
                        'required | 
                        minlength(3)({label} debe tener al menos {min} caracteres)'
                    );

        if ($validator->validate($_POST)) {
            // $area = new Area([
            //     'name_area' => $_POST['namearea'],
            //     'desc_area' => $_POST['descarea']
            // ]);
            // $area->save();
            $result = true;
            return $this->render('admin/insert_teacher.twig', ['result'=>$result]);
        }
        $errors = $validator->getMessages();
        return $this->render('admin/insert_teacher.twig', ['result'=>$result, 'errors' => $errors]);
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para importar ProfessionalUMSS
     */
    public function getImport()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            return $this->render('admin/import_project.twig', ['admin' => $admin]);
        }
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postImport()
    {
        $result = false;
        $errors = [];
        $validator = new Validator();
        $validation = new Validation();
        
        $validation->setRuleFile($validator);
        
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
 
        if ($validator->validate($_POST)) {
            $fname = $_FILES['listaProyectos']['name'];
            $chk_ext = explode(".",$fname);

            if(strtolower(end($chk_ext)) == "csv"){
                //si es correcto, entonces damos permisos de lectura para subir
                $filename = $_FILES['listaProyectos']['tmp_name'];
                $handle = fopen($filename, "r");
                $counter = 0;
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE){
                    //asi omitimos la columna de titulos
                    if($counter > 0){
                        $titulo_proyecto_final = $data[0];
                        $nombre_tutor = $data[1];
                        $apellido_paterno_tutor = $data[2];
                        $apellido_materno_tutor = $data[3];
                        $nombre_postulante = $data[4];
                        $apellido_paterno_postulante = $data[5];
                        $apellido_materno_postulante = $data[6];
                        $objetivo_general = $data[7];
                        $area_perfil = $data[8];
                        $modalidad_titulacion = $data[9];
                        $carrera = $data[10];
                        $fecha_de_registro = $data[11];
                        $periodo = $data[12];

                        //Obtenemos el ID de la carrera
                        $career = Career::where('name', $carrera)->first();
                        if (is_null($career)){
                            array_push($errors, "Error en la linea: $counter, La siguiente carrera no se encuentra registrada en el sistema: \"$carrera\", por favor verifique e intente nuevamente.");
                            return $this->render('admin/import_project.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
                        }
                        $id_career = $career->id;
                        
                        //Obtenemos el ID del periodo
                        $period = Period::where('name', $periodo)->first();
                        if (is_null($period)){
                            array_push($errors, "Error en la linea: $counter, El siguiente periodo no se encuentra registrado en el sistema: \"$periodo\", por favor verifique e intente nuevamente.");
                            return $this->render('admin/import_project.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
                        }
                        $id_period = $period->id;

                        //Obtenemos el ID del area
                        $area = Area::where('name_area', $area_perfil)
                                    ->where('id_parent_area', null)->first();
                        if (is_null($area)){
                            array_push($errors, "Error en la linea: $counter, La siguiente area no se encuentra registrada en el sistema: \"$area\", por favor registrela e intente nuevamente.");
                            return $this->render('admin/import_project.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
                        }
                        $id_area = $area->id;

                        //Obtenemos el ID de la modalidad
                        $modality = Modality::where('name_mod', $modalidad_titulacion)->first();
                        if (is_null($modality)){
                            array_push($errors, "Error en la linea: $counter, La siguiente modalidad de titulación no se encuentra registrada en el sistema: \"$modalidad_titulacion\", por favor verifique e intente nuevamente.");
                            return $this->render('admin/import_project.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
                        }
                        $id_modality = $modality->id;

                        //Obtenemos el ID del status
                        $status = Status::where('name', "Pendiente")->first();
                        $id_status = $status->id;

                        //Obtenemos el ID del postulante
                        $id_postulant = getPostulantID($nombre_postulante, $apellido_paterno_postulante, $apellido_materno_postulante, $id_career, $errors);

                        //Obtenemos el ID del tutor
                        $id_tutor = getTutorID($nombre_tutor, $apellido_paterno_tutor, $apellido_materno_tutor, $errors);

                        $new_perfil = new Profile([
                        'title' => $titulo_proyecto_final,
                        'general_obj' => $objetivo_general,
                        'id_period' => $id_period,
                        'registry_date' => $fecha_de_registro,
                        'id_modality' => $id_modality,
                        'id_area' => $id_modality,
                        'id_postulant' => $id_postulant,
                        'id_tutor' => $id_tutor,
                        'id_status' => $id_status,
                        'id_career' => $id_career]);
                        $new_perfil->save();
                    }
                    $counter++;
                }
                //cerramos la lectura del archivo
                fclose($handle);
                $result = "Importación exitosa!";
            }
            else{
                //TODO by Walter -> Juan Carlos por favor agregar el catch de este mensaje o enseñarme como se hace
                array_push($errors, "Archivo invalido!");
                $result = false;
            }
            return $this->render('admin/import_project.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
        }
        $errors = $validator->getMessages();
        return $this->render('admin/import_project.twig', ['result'=>$result, 'errors' => $errors,'admin' => $admin]);
    }

    private function getTutorID($nombre_tutor, $apellido_paterno_tutor, $apellido_materno_tutor, &$errors){
        $tutor_is_prof_umss = ProfessionalUMSS::where('name', $nombre_tutor)
        ->where('l_name', $apellido_paterno_tutor)
        ->where('ml_name', $apellido_materno_tutor)->first();
        if (is_null($tutor_is_prof_umss)){
            //Buscamos al tutor en la lista de profesionales externos actuales
            $tutor_is_prof_ext = ProfessionalExt::where('name', $nombre_tutor)
            ->where('l_name', $apellido_paterno_tutor)
            ->where('ml_name', $apellido_materno_tutor)->first();
            if (is_null($tutor_is_prof_ext)){
                //Si el tutor no existe en niguna lista se crea la cuenta temporal para éste con la sig información
                //informacion por defecto
                //ci por defecto
                $ci_tutor = "1234567";
                //email por defecto
                $email_tutor = $nombre_tutor . $apellido_paterno_tutor . "temp@umss.edu.bo";
                //username = primera letra del nombre y el apellido, ejemplo: wramirez
                $username_tutor = substr($nombre_tutor,0,1) . $apellido_paterno_tutor;
                //password
                //TODO -> Se van a crear los passwords con las 3 primeras letras del nombre, las 3 primeras del apellido y el CI, en caso de no haber CI se utilizará los digitos 1234567
                $pass_tutor = substr($nombre_tutor,0,3) . substr($apellido_paterno_tutor,0,3) . $ci_tutor;
                
                $account = new Account([
                    'username' => $username_tutor,
                    'password' => password_hash($pass_tutor, PASSWORD_DEFAULT)
                ]);
                $account->save();
                $account_id_tutor = Account::where('username', $username_tutor)
                                    ->where('password', password_hash($pass_tutor, PASSWORD_DEFAULT))->first();
                if (is_null($account_id)){
                    array_push($errors, "Cuenta de usuario para el tutor de la linea: $counter no fué creada correctamente, por favor verifique e intente nuevamente");
                }else{
                    //Luego guardamos la informacion en la tabla prof externo
                    $new_prof_externo = new ProfessionalExt([
                    'ci' => $ci_tutor,
                    'name' => $nombre_tutor,
                    'l_name' => $apellido_paterno_tutor,
                    'ml_name' => $apellido_materno_tutor,
                    'email' => $email_tutor,
                    'active' => TRUE,
                    'id_account' => $account_id_tutor]);
                    $new_prof_externo->save();
                }
                return ProfessionalExt::where('name', $nombre_tutor)
                ->where('l_name', $apellido_paterno_tutor)
                ->where('ml_name', $apellido_materno_tutor)->first()->id;
            }else{
                return $tutor_is_prof_ext->id;
            }
        }else{
            return $tutor_is_prof_umss->id;
        }
    }

    private function getPostulantID($nombre_postulante, $apellido_paterno_postulante, $apellido_materno_postulante, $id_career, &$errors){
        //Buscamos al estudiante en la lista de Proyectos actuales
        $postulant_exists = Postulant::where('name', $nombre_postulante)
        ->where('l_name', $apellido_paterno_postulante)
        ->where('ml_name', $apellido_materno_postulante)->first();
        if (is_null($postulant_exists)){
            //Si el postulante no existe, entonces creamos uno con la siguiente información basica
            //informacion por defecto
            //ci por defecto
            $ci_postulante = "1234567";
            //email por defecto
            $email_postulante = $nombre_postulante . $apellido_paterno_postulante . "temp@umss.edu.bo";
            //Cod SIS postulante por defecto
            $cod_sis_postulante = "199999999";
            //username = primera letra del nombre y el apellido, ejemplo: wramirez
            $username_postulante = substr($nombre_postulante,0,1) . $apellido_paterno_postulante;
            //password
            //TODO -> Se van a crear los passwords con las 3 primeras letras del nombre, las 3 primeras del apellido y el CI, en caso de no haber CI se utilizará los digitos 1234567
            $pass_postulante = substr($nombre_postulante,0,3) . substr($apellido_paterno_postulante,0,3) . $ci_postulante;
            
            $account = new Account([
                'username' => $username_postulante,
                'password' => password_hash($pass_postulante, PASSWORD_DEFAULT)
            ]);
            $account->save();
            $account_id_postulante = Account::where('username', $username_postulante)
                                ->where('password', password_hash($pass_postulante, PASSWORD_DEFAULT))->first();
            if (is_null($account_id)){
                array_push($errors, "Cuenta de usuario para el postulante en la linea: $counter no fué creada correctamente, por favor verifique e intente nuevamente");
            }else{
                //Luego guardamos la informacion en la tabla prof externo
                $new_postulant = new Postulant([
                'ci' => $ci_postulante,
                'name' => $nombre_postulante,
                'l_name' => $apellido_paterno_postulante,
                'ml_name' => $apellido_materno_postulante,
                'email' => $email_postulante,
                'cod_sis' => $cod_sis_postulante,
                'id_career' => $id_career,
                'id_account' => $account_id_postulante]);
                $new_postulant>save();
            }
            return Postulant::where('name', $nombre_postulante)
            ->where('l_name', $apellido_paterno_postulante)
            ->where('ml_name', $apellido_materno_postulante)->first()->id;
        }else{
            return $postulant_exists->id;
        }
    }
}