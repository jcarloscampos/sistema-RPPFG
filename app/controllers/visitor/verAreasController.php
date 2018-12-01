<?php

use Models\Area;
use Controllers\ServerConnection;
use AshleyDawson\SimplePagination\Pagination;

require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, []);

#echo $Area= area::all();
#echo $twig->render('verAreas.twig');


class verAreasController 
{
	    public function getIndex()
    {       
        
            $areas = Area::query()->orderBy('name')->get()->toArray();
            $params = null; 
            $page = 1;
            $myUrl=parse_url($_SERVER['REQUEST_URI']);
            if(isset($myUrl['query'])){
                parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);
                $page = (int)$params['page'];          
            }
            $paginator = new Paginator();
            $paginator->setItemsPerPage(5)->setPagesInRange(5);
            $paginator->setItemTotalCallback(function () use ($areas) {
                return count($areas);
            });
            $length = $paginator->getItemsPerPage();
            $offset =  $page * $length;
            $paginator->setSliceCallback(function ($offset, $length) use ($areas) {
                return array_slice($areas, $offset, $length);
            });
        
            $pagination = $paginator->paginate($page);
            return $twig->render('verAreas.twig', ['areas' => $pagination->getItems(), 'pagination'=>$pagination, 'page'=>$page]);
        
    }
}