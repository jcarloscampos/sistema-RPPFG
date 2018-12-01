<?php

use Models\Area;

require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem('../views');
$twig = new Twig_Environment($loader, []);

class ServerConnection
{

 public function getSubAreaList($idarea){
        $areas = Area::all();
        $listsubareas = [];
        foreach ($areas as $key => $area) {
            if ($area->id_parent_area == $idarea) {
                $listsubareas[] = $area;
            }
        }
        return $listsubareas;
    }

}


