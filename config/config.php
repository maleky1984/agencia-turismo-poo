<?php
    ###### configuración global
    session_start();

    ############# función de autocarga
    function autoLoader( $NClase ){
        require_once 'clases/'.$NClase.'.php';
    }

    spl_autoload_register('autoLoader' );



    /**
     * función para genear un volcado en pantalla de un objeto
     */
    function mostrar($dato)
    {
        echo '<pre>';
        print_r($dato);
        echo '</pre>';
    }