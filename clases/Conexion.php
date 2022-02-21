<?php

    class Conexion
    {
        static $link;
        static $stmt;

        private function __construct()
        {}

        /**
         * Método para conectarnos al server
         * @return PDO
         */
        static function conectar() : PDO
        {
            if ( !isset( self::$link ) ){
                self::$link = new PDO(
                    'mysql:host=localhost;dbname=agenciaOOP',
                    'root',
                    'root'
                );
            }
            return self::$link;
        }

        /**
         * @param $sql
         * @return false|PDOStatement
         */
        static function getStatement( string $sql )
        {
            self::$stmt = self::conectar()->prepare($sql);
            return self::$stmt;
        }
    }
