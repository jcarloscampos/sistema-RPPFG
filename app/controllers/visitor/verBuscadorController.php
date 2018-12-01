<?php

use Models\Profile;
use AshleyDawson\SimplePagination\Pagination;

require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, []);

#echo $Area= area::all();
#echo $twig->render('verAreas.twig');


class verBuscadorController 
{
	    public function getIndex()
    {       
            $selector = $_GET['selector'];
            $search = $_GET['search'];
            $perfiles = profile::query()->where("$selector","=", $search)->get();
            $params = null; 
            $page = 1;
            $myUrl=parse_url($_SERVER['REQUEST_URI']);
            if(isset($myUrl['query'])){
                parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);
                $page = (int)$params['page'];          
            }
            $paginator = new Paginator();
            $paginator->setItemsPerPage(5)->setPagesInRange(5);
            $paginator->setItemTotalCallback(function () use ($profiles) {
                return count($profiles);
            });
            $length = $paginator->getItemsPerPage();
            $offset =  $page * $length;
            $paginator->setSliceCallback(function ($offset, $length) use ($profiles) {
                return array_slice($profiles, $offset, $length);
            });
        
            $pagination = $paginator->paginate($page);
            return $twig->render('verBuscador.twig', ['perfiles' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page]);
        
    }
}