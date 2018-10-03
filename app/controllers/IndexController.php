<?php

namespace AppPHP\Controllers;

/**
 * Esta clase extiende de BaseController adoptando todas sus características y funcionalidades.
 */

class IndexController extends BaseController
{
    /**
     * La función llamada será de tipo GET
     * @return render mediante la plantilla index.twig
     */
    public function getIndex()
    {
        return $this->render('index.twig');
    }
}
