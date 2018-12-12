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
use AppPHP\Models\EtnProfArea;
use AppPHP\Models\EtnTutor;
use AppPHP\Models\ItnProfArea;
use AppPHp\Models\AreaProfile;
use AppPHP\Models\PostulantProfile;
use AppPHP\Models\Administrator;

use Sirius\Validation\Validator;
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
            $paginator->setItemsPerPage(1)->setPagesInRange(1);
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
                        }
                        $id_career = $career->id;

                        //Obtenemos el ID del area
                        $area = Area::where('name', $area_perfil)
                                    ->where('id_parent_area', null)->first();
                        if (is_null($area)){
                            array_push($errors, "Error en la linea: $counter, La siguiente area no se encuentra registrada en el sistema: \"$area\", por favor registrela e intente nuevamente.");
                            break;
                        }
                        $id_area = $area->id;
                        echo "<script>console.log( 'ID area $id_area ' );</script>";

                        //Obtenemos el ID de la modalidad
                        $modality = Modality::where('name_mod', $modalidad_titulacion)->first();
                        if (is_null($modality)){
                            array_push($errors, "Error en la linea: $counter, La siguiente modalidad de titulación no se encuentra registrada en el sistema: \"$modalidad_titulacion\", por favor verifique e intente nuevamente.");
                            break;
                        }
                        $id_modality = $modality->id;
                        echo "<script>console.log( 'ID moda $id_modality ' );</script>";

                        //Obtenemos el ID del status
                        $status = Status::where('name', "aceptado")->first();
                        $id_status = $status->id;
                        echo "<script>console.log( 'ID status $id_status ' );</script>";

                        //Obtenemos el ID del postulante
                        $id_postulant = getPostulantID($nombre_postulante, $apellido_paterno_postulante, $apellido_materno_postulante, $id_career, $counter, $errors);
                        echo "<script>console.log( 'ID postulant $id_postulant ' );</script>";

                        //Obtenemos el ID del tutor
                        $id_tutor = getTutorID($nombre_tutor, $apellido_paterno_tutor, $apellido_materno_tutor, $id_area, $counter, $errors);
                        echo "<script>console.log( 'ID tutor $id_tutor ' );</script>";

                        //validamos la infomracion del Perfil y la introducimos a la base de datos
                        crear_actualizarPerfil($counter, $titulo_proyecto_final, $objetivo_general, $id_modality, $periodo, $fecha_de_registro, $id_postulant, $id_area, $id_tutor, $id_career);
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
                                            $id_area, $id_tutor, $id_career){
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
                "id_cmpy_area" => "", //TODO - Investigando el sentido de este valor
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
                "id_cmpy_area" => "", //TODO - Investigando el sentido de este valor
                "id_mod" => $id_modality,
                "id_status" => $id_status
            ]);
        }

        //Completamos todas las relaciones restantes
        //Buscamos la relacion del Perfil con el tutor y la actualizamos/creamos de ser necesario
        $etntutor_exists = EtnTutor::where('id_etnprof', $id_tutor)->where('id_profile',$profile_id)->first();
        if(is_null($etntutor_exists)){
            $new_etntutor = new EtnTutor([
                'id_etnprof' => $id_tutor,
                'id_profile' => $profile_id
            ]);
            $new_etntutor->save();
        }else{
            $id_etntutor = $etntutor_exists->id;
            EtnTutor::where('id', $id_etntutor)
            ->update([
                'id_etnprof' => $id_tutor,
                'id_profile' => $profile_id
            ]);
        }
        
        //Buscamos la informacion del Perfil con el responsable, usamos el primer Docente que tenga una relación directa con el área del perfil o el primer docente registrado
        $profUmssArea = ItnProfArea::where('id_area', $id_area)->first();
        $prof_id = 1;
        if(is_null($profUmssArea)){
            $prof_id = $profUmssArea->id_prof;
        }

        $responsable_exists = Responsable::where('id_profile', $profile_id)
                                         ->where('id_type_resp',"1")->first();
        if(is_null($responsable_exists)){
            $new_responsable = new Responsable([
                'id_intprof' => $prof_id,
                'id_profile' => $profile_id,
                'id_type_resp' => "1"
            ]);
            $new_responsable->save();
        }else{
            $id_responsable = $responsable_exists->id;
            Responsable::where('id', $id_responsable)
            ->update([
                'id_intprof' => $prof_id,
                'id_profile' => $profile_id,
                'id_type_resp' => "1"
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
                                    ->where('extended', FALSE)-first();
        if(is_null($periodo_exists)){
            $new_period = new Period([
                'start_date' => $startdate,
                'end_date' => $enddate,
                'period' => $periodo,
                'extended' => FALSE
            ]);
            $new_period->save();
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

    /* Este método no va a funcionar, o va a devolver resultados incorrectos, hasta que se corrija el error de diseño en la Base de datos referente
    * a tener un docente UMSS como tutor, Punto que ya se había notiicado al equipo en fecha 29 de Octubre, luego de la reunión con el cliente
    */
    private function getTutorID($nombre_tutor, $apellido_paterno_tutor, $apellido_materno_tutor, $id_area, $counter, &$errors){
        $tutor_id = 0;
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
                $email_tutor = $nombre_tutor . $apellido_paterno_tutor . "_temp@umss.edu.bo";
                //username = primera letra del nombre y el apellido, ejemplo: wramirez
                $username_tutor = substr($nombre_tutor,0,1) . $apellido_paterno_tutor;
                //password
                //TODO -> Se van a crear los passwords con las 3 primeras letras del nombre, las 3 primeras del apellido y el CI, en caso de no haber CI se utilizará los digitos 1234567
                $pass_tutor = substr($nombre_tutor,0,3) . substr($apellido_paterno_tutor,0,3) . $ci_tutor;
                
                $account = new Account([
                    'username' => $username_tutor,
                    'password' => password_hash($pass_tutor, PASSWORD_DEFAULT),
                    'state' => 1
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
                    'phone' => "0",
                    'address' => "",
                    'active' => 1,
                    //se le dá el grado academico de licenciatura por defecto
                    'id_ad' => 1,
                    'profile' => "",
                    'id_account' => $account_id_tutor]);
                    $new_prof_externo->save();
                }
                $tutor_id = ProfessionalExt::where('name', $nombre_tutor)
                ->where('l_name', $apellido_paterno_tutor)
                ->where('ml_name', $apellido_materno_tutor)->first()->id;
                crearRelacionProfExtArea($tutor_id, $id_area);
            }else{
                //Obtenemos el ID del tutor y lo usamos para crear la relación con el área de interes en caso de no existir la relación
                $tutor_id = $tutor_is_prof_ext->id;
                crearRelacionProfExtArea($tutor_id, $id_area);
            }
        }else{
            $tutor_id = $tutor_is_prof_umss->id;
            crearRelacionProfUMSSArea($tutor_id, $id_area);
        }
        return $tutor_id;
    }

    private function crearRelacionProfExtArea($tutor_id, $id_area){
        $etnprof_area_exists = EtnProfArea::where('id_prof', $tutor_id)
        ->where('id_area', $id_area)->first();
        if (is_null($etnprof_area_exists)){
            //si no existe la relacion creamos una nueva
            $new_etnprof_area = new EtnProfArea([
                'id_prof', $tutor_id,
                'id_area', $id_area
            ]);
            $new_etnprof_area->save();
        }
    }

    private function crearRelacionProfUMSSArea($tutor_id, $id_area){
        $etnprof_area_exists = ItnProfArea::where('id_prof', $tutor_id)
        ->where('id_area', $id_area)->first();
        if (is_null($etnprof_area_exists)){
            //si no existe la relacion creamos una nueva
            $new_etnprof_area = new ItnProfArea([
                'id_prof', $tutor_id,
                'id_area', $id_area
            ]);
            $new_etnprof_area->save();
        }
    }

    private function getPostulantID($nombre_postulante, $apellido_paterno_postulante, $apellido_materno_postulante, $id_career, $counter, &$errors){
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
            $username_postulante = substr($nombre_postulante,0,1) . $apellido_paterno_postulante;
            //password
            //TODO -> Se van a crear los passwords con las 3 primeras letras del nombre, las 3 primeras del apellido y el CI
            $pass_postulante = substr($nombre_postulante,0,3) . substr($apellido_paterno_postulante,0,3) . $ci_postulante;
            
            $account = new Account([
                'username' => $username_postulante,
                'password' => password_hash($pass_postulante, PASSWORD_DEFAULT),
                'state' => 1
            ]);
            $account->save();
            $account_id_postulante = Account::where('username', $username_postulante)
                                ->where('password', password_hash($pass_postulante, PASSWORD_DEFAULT))->first();
            if (is_null($account_id)){
                array_push($errors, "Cuenta de usuario para el postulante en la linea: $counter no fué creada correctamente, por favor verifique e intente nuevamente");
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