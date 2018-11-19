<?php

namespace AppPHP\Controllers\Admin;

use AppPHP\Controllers\BaseController;
use AppPHP\Models\Postulant;
use Sirius\Validation\Validator;
use AppPHP\Models\Administrator;
use AshleyDawson\SimplePagination\Paginator;


class PostulantsController extends BaseController
{
    /**
     * Mediante método GET se hace la petición para mostrar todos los postulantes actuales
     * get() se usa para traer los resultados (ejecuta la consulta y regresa el valor que obtienes)
     * @return la vista con la lista de áreas que están en la BD
     */
    public function getIndex()
    {
        if (isset($_SESSION['admID'])) {
            $admin = Administrator::where('id_account', $_SESSION['admID'])->first();
            $postulantes = Postulant::query()->orderBy('l_name', 'asc')->get()->toArray();
            $params = null; 
            $page = 1;
            $myUrl=parse_url($_SERVER['REQUEST_URI']);
            if(isset($myUrl['query'])){
                parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);
                $page = (int)$params['page'];          
            }
            $paginator = new Paginator();
            $paginator->setItemsPerPage(5)->setPagesInRange(5);
            $paginator->setItemTotalCallback(function () use ($postulantes) {
                return count($postulantes);
            });
            $length = $paginator->getItemsPerPage();
            $offset =  $page * $length;
            $paginator->setSliceCallback(function ($offset, $length) use ($postulantes) {
                return array_slice($postulantes, $offset, $length);
            });
            $pagination = $paginator->paginate($page);
            return $this->render('admin/list_postulants.twig', ['postulantes' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page, 'admin' => $admin]);         
//            return $this->render('admin/list_postulants.twig', ['postulantes' => $postulantes, 'admin' => $admin]);
        }
    }
}
