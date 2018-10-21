<?php

namespace AppPHP\Controllers;

use Twig_Loader_Filesystem;
use Twig_Environment;

class BaseController
{
    /**
     * @type object
     */
    protected $templateEngine;

    /**
     * Todas las clases que hereden de BaseController siempre llamaran a este constructor, ya que los
     * controladores hijas no tienen constructor; por tanto siempre se inicializara este.
     */
    public function __construct()
    {
        //Inicializa twig y carga para tener disponible en la aplicación; se pasa el directorio de
        //vistas que será cargada por una ruta relativa a partir del scripts que se manda a llamar (public/index.php).
        $loader = new Twig_Loader_Filesystem('../views');
        $this->templateEngine = new Twig_Environment($loader, [
            'debug' => true,
            'cacche' => false
        ]);
        $this->templateEngine->addFilter(new \Twig_SimpleFilter('url', function ($path) {
            return BASE_URL . $path;
        }));
    }
    /**
     * funcion para render de las vistas con plantillas de twig.
     * @param string $fileName.
     * @param array $data.
     * @return object template.
     */
    public function render($fileName, $data=[])
    {
        return $this->templateEngine->render($fileName, $data);
    }
}
