<?php

if (isset($_POST) && !empty($_POST)) {

    // array de respuestas y regreso en JSON
	$response = array(
		"result" 	=> false,
		"mensaje"	=> "No fue posible ejecutar la petición",
		"datos"		=> ""
    );
    // verificamos la accion que vamos a ejecutar
    if (isset($_POST['action']) && isset($_POST['idarea'])) {
        // validar accion
        if ($_POST['action'] == 'setBloqueo') {
            $response = array(
                "result" 	=> true,
                "mensaje"	=> "No fue posible ejecutar la petición",
                "datos"		=> "true"
            );
        }
    }
}