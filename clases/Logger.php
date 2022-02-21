<?php

    trait Logger
    {
        public function log( PDOException $e )
        {
            $mensaje  = $e->getMessage().'<br>';
            $mensaje .= $e->getFile().'<br>';
            $mensaje .= 'Línea: '.$e->getLine();
            echo $mensaje;
            //header( $_SERVER['HTTP_REFERER'] );
        }
    }