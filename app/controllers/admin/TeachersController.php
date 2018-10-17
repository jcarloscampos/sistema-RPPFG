<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Usuario;
use AppPHP\Models\Docente;
use AppPHP\Models\Area;
use AppPHP\Models\Subarea;
use AppPHP\Models\CargaHoraria;
use AppPHP\Models\GradoAcademico;

/**
 * Clase controlador para lectura, inserción, eliminación y actualización de datos de la tabla docentes
 */

class TeachersController extends BaseController
{
    /**
     * Mediante método GET se hace la petición para mostrar todos los docentes actuales
     * get() se usa para traer los resultados (ejecuta la consulta y regresa el valor que obtienes)
     * @return la vista con la lista de áreas que están en la BD
     */
    public function getIndex()
    {
        //TODO -> Incluir una lista de docentes en esta pagina
        $docentes = array();
        //all(); funciona lo mismo que la anterior consulta; solo no hay opción para hacer ordenamiento
        //$docentes = Docente::all();
        return $this->render('admin/list_teachers.twig', ['docentes' => $docentes]);
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para insertar un docente
     */
    public function getCreate()
    {
        return $this->render('admin/insert_teacher.twig');
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postCreate()
    {
        //TODO -> Insertar docente desde Administration Page
        // $docente = new Docente([
        //     'nomb_docente' => $_POST['nombdocente'],
        //     'desc_docente' => $_POST['descdocente']
        // ]);
        // $docente->save();
        return $this->render('admin/insert_teacher.twig', ['result'=>$result]);
    }

    /**
     * Mediante método GET se hace la peticion para mostrar la plantilla para importar docentes
     */
    public function getImport()
    {
        return $this->render('admin/import_teacher.twig');
    }

    /**
     * Por metoodo POST se hace la insercion de datos en BD. para pasar la informacion
     * lo que se hace es pasar el arreglo dentro del constructor
     */
    public function postImport()
    {
        $fname = $_FILES['listaDocentes']['name'];
        $chk_ext = explode(".",$fname);

        if(strtolower(end($chk_ext)) == "csv"){
            //si es correcto, entonces damos permisos de lectura para subir
            $filename = $_FILES['listaDocentes']['tmp_name'];
            $handle = fopen($filename, "r");
            $counter = 0;
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE){
                //asi omitimos la columna de titulos
                if($counter > 0){
                    $nombre = $data[0];
                    $ap_paterno = $data[1];
                    $ap_materno = $data[2];
                    $email = $data[3];
                    $grado_academico = $data[4];
                    $carga_horaria = $data[5];
                    $nombre_cuenta = $data[6];
                    $telefono = $data[7];
                    $direccion = $data[8];
                    $perfil = $data[9];
                    $pass_cuenta = $data[10];
                    $ci = $data[11];
                    $cod_sis = $data[12];

                    //validamos la informacion e insertamos los datos en el sig orden:
                    // Verificamos si el usuario ya existe regsitrado como docente:
                    // Validamos si existe la carga horaria
                    // validamos si existe el grado academico
                    // Insertamos los datos de usuario
                    // Insertamos los datos del docente
                    $id_user = Usuario::where('nomb_usuario', $nombre)
                                        ->where('ap_pat_usuario', $ap_paterno)
                                        ->where('ap_mat_usuario', $ap_materno)
                                        ->where('ci_usuario', $ci)
                                        ->where('email_usuario', $email)->first();
                    if (is_null($id_user)){
                        $id_carga_horaria = CargaHoraria::where('nombre_carga_horaria',$carga_horaria)->first();
                        $id_grado_academico = GradoAcademico::where('nombre_grado',$grado_academico)->first();
                        if(is_null($id_carga_horaria)){
                            $result = 'Carga horaria: ' . $carga_horaria . ' no registrada.';
                        }else{
                            if (is_null($id_grado_academico)){
                                $result = 'Grado Académico: ' . $grado_academico . ' no registrado.';
                            }else{
                                if($pass_cuenta == ''){
                                    $pass_cuenta = $nombre_cuenta . '.123';
                                }
                                $usuario = new Usuario([
                                    'nomb_usuario' => $nombre,
                                    'ap_pat_usuario' => $ap_paterno,
                                    'ap_mat_usuario' => $ap_materno,
                                    'ci_usuario' => $ci,
                                    'email_usuario' => $email,
                                    'telf_usuario' => $telefono,
                                    'dir_usuario' => $direccion,
                                    'nombre_cta' => $nombre_cuenta,
                                    'pass_cta' => $pass_cuenta
                                ]);
                                $usuario->save();
                                $id_user = Usuario::where('nomb_usuario', $nombre)
                                                    ->where('ap_pat_usuario', $ap_paterno)
                                                    ->where('ap_mat_usuario', $ap_materno)
                                                    ->where('ci_usuario', $ci)
                                                    ->where('email_usuario', $email)->first();
                                if (is_null($id_user)){
                                    $result = 'Usuario: ' . $nomb_usuario . ' no registrado.';
                                }else{
                                    if($pass_cuenta == ''){
                                        $pass_cuenta = $nombre_cuenta . '.123';
                                    }
                                    //Insertamos los datos del docente
                                    $docente = new Docente([
                                        'cod_sis_docente' => $cod_sis,
                                        'perfil_docente' => $perfil,
                                        'id_grado_academico' => $id_grado_academico->id_grado,
                                        'id_usuario' => $id_user->id_usuario,
                                        'id_carga_horaria' => $id_carga_horaria->id_carga_horaria
                                    ]);
                                    $docente->save();
                                }
                            }
                        }
                    }
                    else{
                        $result = "Usuario ya registrado";
                    }
                }
                $counter++;
            }
            //cerramos la lectura del archivo
            fclose($handle);
            $result = "Importación exitosa!";
        }
        else
        {
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para
            //ver si esta separado por " , "
            $result = "Archivo invalido!";
        }
        return $this->render('admin/import_teacher.twig', ['result'=>$result]);
    }
}
