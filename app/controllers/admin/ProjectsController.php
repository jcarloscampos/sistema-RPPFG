<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\ProfessionalUMSS;
use AppPHP\Models\ProfessionalExt;
use AppPHP\Models\Profile;
use AppPHP\Models\Period;
use AppPHP\Models\Postulant;
use AppPHP\Models\Area;
use AppPHP\Models\UserRol;
use AppPHP\Models\Career;
use AppPHP\Models\Modality;
use AppPHP\Models\Responsable;
use AppPHP\Models\TypeResponsable;
use AppPHP\Models\Status;
use AppPHP\Models\Account;
use AppPHP\Models\EtnProfArea;
use AppPHP\Models\EtnTutor;
use AppPHP\Models\ItnProfArea;
use AppPHP\Models\PostulantProfile;
use AppPHP\Models\AreaProfile;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;
use AppPHP\Controllers\Common\Validation;
use AppPHP\Controllers\Common\SettingData;
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
            $uimage = substr($admin->name, 0, 1);

            //$profiles = Profile::all();
            $modalities = Modality::all();
            $posts = Postulant::all();
            $status = Status::all();
            $periods = Period::all();
            $postperfs = PostulantProfile::all();
            $Proyectos = Profile::query()->orderBy('title')->get()->toArray();
            //$Proyectos = []; //ProjectsView::query()->orderBy('title', 'asc')->get()->toArray();
            //$Proyectos = $profiles;
            $params = null; 
            $page = 1;
            $myUrl=parse_url($_SERVER['REQUEST_URI']);
            if(isset($myUrl['query'])){
                parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);
                $page = (int)$params['page'];          
            }
            $paginator = new Paginator();
            $paginator->setItemsPerPage(10)->setPagesInRange(10);
            $paginator->setItemTotalCallback(function () use ($Proyectos) {
                return count($Proyectos);
            });
            $length = $paginator->getItemsPerPage();
            $offset =  $page * $length;
            $paginator->setSliceCallback(function ($offset, $length) use ($Proyectos) {
                return array_slice($Proyectos, $offset, $length);
            });
            $pagination = $paginator->paginate($page);

            return $this->render('admin/list_projects.twig', ['profiles' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page,
            'vadmin' => $admin, 'uimage'=>$uimage, 'modalities'=>$modalities, 'postperfs'=>$postperfs, 'posts'=>$posts,
            'status'=>$status, 'periods'=>$periods
            ]);
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
            return $this->render(
                'admin/import_from_files.twig',[
                    'admin' => $admin,
                    'prev' => "projects",
                    'prevMenu' => "Proyectos",
                    'currentMenu' => "Importar Proyectos de Grado",
                    'currentHeader' => "Importar desde Lista de Proyectos de Grado",
                    'formID' => "listaProyectos"
                ]
            );
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
        $information = [];
        $validator = new Validator();
        $validation = new Validation();
        
        $validation->setRuleFile($validator,"listaProyectos", "Proyectos de Grado");
        
        $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
 
        if ($validator->validate($_FILES)) {
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
                        $titulo_proyecto_final = trim($data[0]);
                        $nombre_tutor = trim($data[1]);
                        $apellido_paterno_tutor = trim($data[2]);
                        $apellido_materno_tutor = trim($data[3]);
                        $nombre_postulante = trim($data[4]);
                        $apellido_paterno_postulante = trim($data[5]);
                        $apellido_materno_postulante = trim($data[6]);
                        $objetivo_general = trim($data[7]);
                        $area_perfil = trim($data[8]);
                        $modalidad_titulacion = trim($data[9]);
                        $carrera = trim($data[10]);
                        $fecha_de_registro = trim($data[11]);
                        $periodo = trim($data[12]);

                         // Usamos esta seccion para validar el formato de los datos
                         if(!preg_match("/^([0-2][0-9]|3[0-1])(\/|-)(0[1-9]|1[0-2])(\/|-)(\d{4})$/",$fecha_de_registro)){
                            $line = $counter + 1;
                            array_push($information, "Fecha de Registro en la linea: " . $line . $fecha_de_registro . "tiene un formato incorrecto. Por favor verifique e intente nuevamente");
                        }else{
                            //Obtenemos el ID de la carrera
                            $career = Career::where('name', $carrera)->first();
                            if (is_null($career)){
                                $linea = $counter + 1;
                                array_push($information, "Error en la linea: $linea, La siguiente carrera no se encuentra registrada en el sistema: \"$carrera\", por favor verifique e intente nuevamente.");
                            }
                            else {
                                $id_career = $career->id;

                                //Obtenemos el ID del area
                                $area = Area::where('name', $area_perfil)->first();
                                if (is_null($area)){
                                    $linea = $counter + 1;
                                    array_push($information, "Error en la linea: $linea, La siguiente area no se encuentra registrada en el sistema: \"$area_perfil\", por favor registrela e intente nuevamente.");
                                }
                                else{
                                    $id_area = $area->id;

                                    //Obtenemos el ID de la modalidad
                                    $modality = Modality::where('name_mod', $modalidad_titulacion)->first();
                                    if (is_null($modality)){
                                        $linea = $counter + 1;
                                        array_push($information, "Error en la linea: $linea, La siguiente modalidad de titulación no se encuentra registrada en el sistema: \"$modalidad_titulacion\", por favor verifique e intente nuevamente.");
                                    }
                                    else{
                                        $id_modality = $modality->id;

                                        //Obtenemos el ID del status
                                        $status = Status::where('name', "aceptado")->first();
                                        $id_status = $status->id;

                                        //Obtenemos el ID del postulante
                                        $id_postulant = $this->getPostulantID($nombre_postulante, $apellido_paterno_postulante, $apellido_materno_postulante, $id_career, $counter, $information);

                                        //Obtenemos el ID del tutor
                                        $is_ProfUMSS = true;
                                        $id_tutor = $this->getTutorID($nombre_tutor, $apellido_paterno_tutor, $apellido_materno_tutor, $id_area, $counter, $information,$is_ProfUMSS);

                                        //validamos la infomracion del Perfil y la introducimos a la base de datos
                                        $this->crear_actualizarPerfil($counter, $titulo_proyecto_final, $objetivo_general, $id_modality, $periodo, $fecha_de_registro, $id_postulant, $id_area, $id_status, $id_tutor, $id_career, $is_ProfUMSS);
                                    }
                                }
                            }
                        }
                    }else{
                        $sizeColms = sizeof($data);
                        if(sizeof($data)!=13){
                            $errors = [["Archivo Invalido, por favor refierase al manual de usuario para mayor información."]];
                            return $this->render('admin/import_from_files.twig',
                                [
                                    'result'=>$result,
                                    'errors' => $errors,
                                    'information' => $information,
                                    'admin' => $admin,
                                    'prev' => "projects",
                                    'prevMenu' => "Proyectos",
                                    'currentMenu' => "Importar Proyectos de Grado",
                                    'currentHeader' => "Importar desde Lista de Proyectos de Grado",
                                    'formID' => "listaProyectos"
                                ]
                            );
                        }
                    }
                    $counter++;
                }
                //cerramos la lectura del archivo
                fclose($handle);
                $result = true;
            }
            if(count($information) > 0){
                return $this->render('admin/import_from_files.twig',
                    [
                        'result'=>$result,
                        'errors' => $errors,
                        'information' => $information,
                        'admin' => $admin,
                        'prev' => "projects",
                        'prevMenu' => "Proyectos",
                        'currentMenu' => "Importar Proyectos de Grado",
                        'currentHeader' => "Importar desde Lista de Proyectos de Grado",
                        'formID' => "listaProyectos"
                    ]
                );
            }
            else{
                return $this->getIndex();
            }
        }
        $errors = $validator->getMessages();
        if(count($information) > 0){
            return $this->render('admin/import_from_files.twig',
                [
                    'result'=>$result,
                    'errors' => $errors,
                    'information' => $information,
                    'admin' => $admin,
                    'prev' => "projects",
                    'prevMenu' => "Proyectos",
                    'currentMenu' => "Importar Proyectos de Grado",
                    'currentHeader' => "Importar desde Lista de Proyectos de Grado",
                    'formID' => "listaProyectos"
                ]
            );
        }
        else{
            return $this->getIndex();
        }
    }

    private function crear_actualizarPerfil($counter, $titulo_proyecto_final, $objetivo_general, $id_modality, $periodo, $fecha_de_registro, $id_postulant,
                                            $id_area, $id_status, $id_tutor, $id_career, $is_ProfUMSS){
        //Buscamos si el perfil ya existe mediante el título
        $profile_exists = Profile::where('title', $titulo_proyecto_final)->first();
        $profile_id = 0;
        $numProfile = $counter + 1000; //TODO -> Este número esta siendo insertado de esta manera por que no se entiende su proposito ni origen

        //Creamos el Perfil si es que no existe
        if(is_null($profile_exists)){
            $new_perfil = new Profile([
                'num_profile' => $numProfile,
                'title' => $titulo_proyecto_final,
                'g_objective' => $objetivo_general,
                's_objects' => "",
                "description" => "",
                "id_cmpy_area" => $id_area,
                "id_mod" => $id_modality,
                "id_status" => $id_status
            ]);
            $new_perfil->save();
            $profile_id = Profile::where('title', $titulo_proyecto_final)->first()->id;
        }else{
            //actualizamos la informacion de la tabla perfil con los datos más recientes
            $profile_id = $profile_exists->id;
            Profile::where('id',$profile_id)
            ->update([
                'num_profile' => $numProfile,
                'title' => $titulo_proyecto_final,
                'g_objective' => $objetivo_general,
                's_objects' => "",
                "description" => "",
                "id_cmpy_area" => $id_area,
                "id_mod" => $id_modality,
                "id_status" => $id_status
            ]);
        }

        //Completamos todas las relaciones restantes
        //Buscamos la relacion del Perfil con el tutor y la creamos de ser necesario
        if($is_ProfUMSS){
            $type_resp_id = TypeResponsable::where('name',"tutor")->first()->id;
            $resp_tutor_exists = Responsable::where('id_profile',$profile_id)
                                            ->where('id_type_resp', $type_resp_id)
                                            ->where('id_intprof', $id_tutor)->first();
            if(is_null($resp_tutor_exists)){
                $new_resp_tutor_exists = new Responsable([
                    'id_intprof' => $id_tutor,
                    'id_profile' => $profile_id,
                    'id_type_resp' => $type_resp_id
                ]);
                $new_resp_tutor_exists->save();
            }
        }else{
            $etntutor_exists = EtnTutor::where('id_entprof', $id_tutor)->where('id_profile',$profile_id)->first();
            if(is_null($etntutor_exists)){
                $new_etntutor = new EtnTutor([
                    'id_entprof' => $id_tutor,
                    'id_profile' => $profile_id
                ]);
                $new_etntutor->save();
            }
        }
        
        //Buscamos la informacion del Perfil con el responsable, usamos el primer Docente que tenga una relación directa con el área del perfil o el primer docente registrado
        $profUmssArea = ItnProfArea::where('id_area', $id_area)->first();
        $prof_id = 1;
        if(!is_null($profUmssArea)){
            $prof_id = $profUmssArea->id_prof;
        }else{
            $first_prof_area = ItnProfArea::query()->first();
            //en caso de no tener docentes registrados con el área, se asignará al primer docente registrado en el sistema el área
            if(!is_null($first_prof_area)){
                $prof_id = $first_prof_area->id_prof;
            }else{
                $prof_id = ProfessionalUMSS::query()->first()->id;
                $new_prof_area = new ItnProfArea([
                    "id_prof" => $prof_id,
                    "id_area" => $id_area
                ]);
                $new_prof_area->save();
            }
        }

        $type_resp_id = TypeResponsable::where('name',"teacher")->first()->id;
        $responsable_exists = Responsable::where('id_profile', $profile_id)
                                         ->where('id_type_resp',$type_resp_id)->first();
        if(is_null($responsable_exists)){
            $new_responsable = new Responsable([
                'id_intprof' => $prof_id,
                'id_profile' => $profile_id,
                'id_type_resp' => $type_resp_id
            ]);
            $new_responsable->save();
        }else{
            $id_responsable = $responsable_exists->id;
            Responsable::where('id', $id_responsable)
            ->update([
                'id_intprof' => $prof_id,
                'id_profile' => $profile_id,
                'id_type_resp' => $type_resp_id
            ]);
        }
        
        //Buscamos la informacion del Periodo
        //calculamos las fechas
        $currentdateYMD = "" . substr($fecha_de_registro,6,4) . "-" . substr($fecha_de_registro,3,2) . "-" . substr($fecha_de_registro, 0, 2);
        $startdate = date("Y-m-d",strtotime($currentdateYMD));
        $enddate = date("Y-m-d",strtotime($currentdateYMD."+ 2 year"));
        $periodo_exists = Period::where('start_date', $startdate)
                                    ->where('end_date', $enddate)
                                    ->where('period', $periodo)
                                    ->where('extended', FALSE)->first();
        if(is_null($periodo_exists)){
            $new_period = new Period([
                'start_date' => $startdate,
                'end_date' => $enddate,
                'period' => $periodo,
                'extended' => FALSE
            ]);
            $new_period->save();
            $id_period = Period::where('start_date', $startdate)
                               ->where('end_date', $enddate)
                               ->where('period', $periodo)
                               ->where('extended', FALSE)->first()->id;
        }else{
            $id_period = $periodo_exists->id;
            Period::where('id', $id_period)
            ->update([
                'start_date' => $startdate,
                'end_date' => $enddate,
                'period' => $periodo,
                'extended' => FALSE
            ]);
        }

        //Buscamos la informacíon del Perfil con el postulante y la actualizamos/creamos de ser necesario
        $postulantProfile_exists = PostulantProfile::where('id_postulant', $id_postulant)
                                                   ->where('id_profile',$profile_id)
                                                   ->where('id_career',$id_career)->first();
        if(is_null($postulantProfile_exists)){
            $new_postulantProfile = new PostulantProfile([
                'id_postulant' => $id_postulant,
                'id_profile' => $profile_id,
                'id_career' => $id_career,
                'id_period' => $id_period
            ]);
            $new_postulantProfile->save();
        }else{
            $id_postulantProfile = $postulantProfile_exists->id;
            PostulantProfile::where('id', $id_postulantProfile)
            ->update([
                'id_postulant' => $id_postulant,
                'id_profile' => $profile_id,
                'id_career' => $id_career,
                'id_period' => $id_period
            ]);
        }


        //Buscamos la información del Perfil con el Área y la actualizamos/creamos de ser necesario
        $areaProfile_exists = AreaProfile::where('id_profile', $profile_id)
                                         ->where('id_area',$id_area)->first();
        if(is_null($areaProfile_exists)){
            $new_areaProfile = new AreaProfile([
                'id_profile' => $profile_id,
                'id_area' => $id_area
            ]);
            $new_areaProfile->save();
        }else{
            $id_areaProfile = $areaProfile_exists->id;
            AreaProfile::where('id', $id_areaProfile)
            ->update([
                'id_profile' => $profile_id,
                'id_area' => $id_area
            ]);
        }

    }

    private function getTutorID($nombre_tutor, $apellido_paterno_tutor, $apellido_materno_tutor, $id_area, $counter, &$information, &$is_ProfUMSS){
        $tutor_id = 0;
        $tutor_is_prof_umss = ProfessionalUMSS::where('name', $nombre_tutor)
        ->where('l_name', $apellido_paterno_tutor)
        ->where('ml_name', $apellido_materno_tutor)->first();
        if (is_null($tutor_is_prof_umss)){
            $is_ProfUMSS = false;
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
                $email_tutor = substr($nombre_tutor,0,1) . $apellido_paterno_tutor . "_temp@umss.edu.bo";
                //username = primera letra del nombre y el apellido, ejemplo: wramirez
                $username_tutor = str_replace(" ", "", substr($nombre_tutor,0,1) . $apellido_paterno_tutor);
                //password
                //TODO -> Se van a crear los passwords con las 3 primeras letras del nombre, las 3 primeras del apellido y el CI, en caso de no haber CI se utilizará los digitos 1234567
                $pass_tutor = str_replace(" ", "", substr($nombre_tutor,0,3) . substr(str_replace(" ", "", $apellido_paterno_tutor),0,3) . $ci_tutor);
                
                $account = new Account([
                    'username' => $username_tutor,
                    'password' => password_hash($pass_tutor, PASSWORD_DEFAULT),
                    'state' => 1
                ]);
                $account->save();
                $account_id_tutor = Account::where('username', $username_tutor)->first();
                if (is_null($account_id_tutor)){
                    $linea = $counter + 1;
                    array_push($information, "Cuenta de usuario para el tutor de la linea: $linea no fué creada correctamente, por favor verifique e intente nuevamente");
                }else{
                    //creamos la relacion entre el proffesional EXT y su rol
                    $user_rol_profEXT = new UserRol([
                        'id_account' => $account_id_tutor->id,
                        'id_rol' => 3
                    ]);
                    $user_rol_profEXT->save();
                    //Luego guardamos la informacion en la tabla prof externo
                    $new_prof_externo = new ProfessionalExt([
                    'ci' => $ci_tutor,
                    'name' => $nombre_tutor,
                    'l_name' => $apellido_paterno_tutor,
                    'ml_name' => $apellido_materno_tutor,
                    'email' => $email_tutor,
                    'phone' => 0,
                    'address' => "",
                    'active' => 1,
                    //se le dá el grado academico de licenciatura por defecto
                    'id_ad' => 1,
                    'profile' => "",
                    'id_account' => $account_id_tutor->id]);
                    $new_prof_externo->save();
                }
                $tutor_id = ProfessionalExt::where('name', $nombre_tutor)
                ->where('l_name', $apellido_paterno_tutor)
                ->where('ml_name', $apellido_materno_tutor)->first()->id;
                $this->crearRelacionProfExtArea($tutor_id, $id_area);
            }else{
                //Obtenemos el ID del tutor y lo usamos para crear la relación con el área de interes en caso de no existir la relación
                $tutor_id = $tutor_is_prof_ext->id;
                $this->crearRelacionProfExtArea($tutor_id, $id_area);
            }
        }else{
            $is_ProfUMSS = true;
            $tutor_id = $tutor_is_prof_umss->id;
            $this->crearRelacionProfUMSSArea($tutor_id, $id_area);
        }
        return $tutor_id;
    }

    private function crearRelacionProfExtArea($tutor_id, $id_area){
        $etnprof_area_exists = EtnProfArea::where('id_prof', $tutor_id)
        ->where('id_area', $id_area)->first();
        if (is_null($etnprof_area_exists)){
            //si no existe la relacion creamos una nueva
            $new_etnprof_area = new EtnProfArea([
                'id_prof' => $tutor_id,
                'id_area' => $id_area
            ]);
            $new_etnprof_area->save();
        }
    }

    private function crearRelacionProfUMSSArea($tutor_id, $id_area){
        $itnprof_area_exists = ItnProfArea::where('id_prof', $tutor_id)
        ->where('id_area', $id_area)->first();
        if (is_null($itnprof_area_exists)){
            //si no existe la relacion creamos una nueva
            $new_itnprof_area = new ItnProfArea([
                'id_prof' => $tutor_id,
                'id_area' => $id_area
            ]);
            $new_itnprof_area->save();
        }
    }

    private function getPostulantID($nombre_postulante, $apellido_paterno_postulante, $apellido_materno_postulante, $id_career, $counter, &$information){
        //Buscamos al estudiante en la lista de Proyectos actuales
        $postulant_exists = Postulant::where('name', $nombre_postulante)
        ->where('l_name', $apellido_paterno_postulante)
        ->where('ml_name', $apellido_materno_postulante)->first();
        $settingData = new SettingData();

        if (is_null($postulant_exists)){
            //Si el postulante no existe, entonces creamos uno con la siguiente información basica
            //Obtenemos el CI desde el sistema Websiss
            $ci_postulante = $settingData->recuperarCIStudent($nombre_postulante, $apellido_paterno_postulante, $apellido_materno_postulante);
            //email por defecto
            $email_postulante = $settingData->recuperarMailStudent($nombre_postulante, $apellido_paterno_postulante, $apellido_materno_postulante);
            //Cod SIS postulante por defecto
            $cod_sis_postulante = $settingData->recuperarSISStudent($nombre_postulante, $apellido_paterno_postulante, $apellido_materno_postulante);
            //username = primera letra del nombre y el apellido, ejemplo: wramirez
            $username_postulante = str_replace(" ", "", substr($nombre_postulante,0,1) . $apellido_paterno_postulante);
            //password
            //TODO -> Se van a crear los passwords con las 3 primeras letras del nombre, las 3 primeras del apellido y el CI
            $pass_postulante = str_replace(" ", "", substr($nombre_postulante,0,3) . substr(str_replace(" ", "", $apellido_paterno_postulante),0,3) . $ci_postulante);
            
            $account = new Account([
                'username' => $username_postulante,
                'password' => password_hash($pass_postulante, PASSWORD_DEFAULT),
                'state' => 1
            ]);
            $account->save();
            $account_id_postulante = Account::where('username', $username_postulante)
                                            ->where('state', 1)->first();
            if (is_null($account_id_postulante)){
                $linea = $counter + 1;
                array_push($information, "Cuenta de usuario para el postulante en la linea: $linea no fué creada correctamente, por favor verifique e intente nuevamente");
            }else{
                //Luego guardamos la informacion en la tabla postulante
                $new_postulant = new Postulant([
                'ci' => $ci_postulante,
                'name' => $nombre_postulante,
                'l_name' => $apellido_paterno_postulante,
                'ml_name' => $apellido_materno_postulante,
                'email' => $email_postulante,
                'phone' => "0",
                "address" => "",
                'cod_sis' => $cod_sis_postulante,
                'id_account' => $account_id_postulante->id]);
                $new_postulant->save();
            }
            $postulant_exists = Postulant::where('name', $nombre_postulante)
            ->where('l_name', $apellido_paterno_postulante)
            ->where('ml_name', $apellido_materno_postulante)->first();
        }
        return $postulant_exists->id;
    }
}