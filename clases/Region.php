<?php

    class Region implements RegistrarAtributos
    {
        use Logger;
        private $idRegion;
        private $regNombre;

        public function listarRegiones()
        {
            //$link = Conexion::conectar();
            $sql  = "SELECT idRegion, regNombre
                        FROM regiones";
            //$stmt = $link->prepare($sql);
            $stmt = Conexion::getStatement($sql);
            try {
                $stmt->execute();
                $regiones = $stmt->fetchAll( PDO::FETCH_OBJ );
                return $regiones;
            }catch ( PDOException $e ){
                $this->log($e);
            }
            return false;
        }

        public function verRegionPorID()
        {
            //$idRegion = $_GET['idRegion'];
            $this->cargarDesdeForm();
            $idRegion = $this->idRegion;
            $sql = "SELECT idRegion, regNombre
                        FROM regiones
                        WHERE idRegion = :idRegion";
            $stmt = Conexion::getStatement($sql);

            try{
                $stmt->bindParam(':idRegion', $idRegion);
                $stmt->execute();
                $region = $stmt->fetch( PDO::FETCH_OBJ );
                //cargamos atributos desde objeto stdClass
                $this->cargarDesdeObjeto( $region );
                //retornamos objeto de tipo Region
                return $this;
            }catch ( PDOException $e ){
                $this->log($e);
            }
            return false;
        }

        public function cargarDesdeForm()
        {
            if( isset( $_REQUEST['idRegion'] ) ){
                $this->setIdRegion($_REQUEST['idRegion']);
            }
            if( isset($_POST['regNombre']) ){
                $this->setRegNombre($_POST['regNombre']);
            }
        }
        public function cargarDesdeObjeto(stdClass $objeto)
        {
            $this->setIdRegion( $objeto->idRegion );
            $this->setRegNombre( $objeto->regNombre );
        }

        public function agregarRegion()
        {
            $this->cargarDesdeForm();
            $sql = "INSERT INTO regiones
                        VALUES ( DEFAULT, :regNombre )";
            $stmt = Conexion::getStatement( $sql );
            try{
                $stmt->bindParam(':regNombre', $regNombre);
                if ( $stmt->execute() ){
                    //registramos atributos
                    $this->setIdRegion( Conexion::conectar()->lastInsertId() );
                    //$this->setRegNombre( $regNombre );
                    return $this;
                }
            }
            catch ( PDOException $e ){
                $this->log($e);
            }
            return false;
        }

        public function modificarRegion()
        {
            $this->cargarDesdeForm();
            $idRegion  = $this->getIdRegion();
            $regNombre = $this->getRegNombre();

            $sql = "UPDATE regiones 
                        SET regNombre = :regNombre
                       WHERE idRegion = :idRegion";
            $stmt = Conexion::getStatement($sql);

            try{
                $stmt->bindParam(':regNombre', $regNombre);
                $stmt->bindParam(':idRegion', $idRegion);
                $stmt->execute();
                //cargamos atributos desde el formulario
                $this->setIdRegion( $idRegion );
                $this->setRegNombre( $regNombre );
                return $this;
            }
            catch ( PDOException $e ){
                $this->log($e);
            }
            return false;
        }

        private function verificarDestinoPorRegion()
        {
            $idRegion = $this->idRegion;
            $sql = 'SELECT idDestino, destNombre 
                        FROM destinos
                       WHERE idRegion = :idRegion';
            $stmt = Conexion::getStatement($sql);
            try{
                $stmt->bindParam(':idRegion', $idRegion);
                $stmt->execute();
                $destinos = $stmt->fetchAll( PDO::FETCH_OBJ );
                return $destinos;
                // return $stmt->rowCount();
            }catch ( PDOException $e ){
                $this->log( $e );
            }
            return false;
        }

        public function confirmarBaja()
        {
            $this->verRegionPorID();
            $check = $this->verificarDestinoPorRegion();
            return $check;
        }

        public function eliminarRegion()
        {
            $this->cargarDesdeForm();
            $idRegion = $this->idRegion;
            $sql = "DELETE FROM regiones
                        WHERE idRegion = :idRegion";
            $stmt = Conexion::getStatement( $sql );
            try{
                $stmt->bindParam(':idRegion', $idRegion);
                $stmt->execute();
                return $this;
            }catch ( PDOException $e ){
                $this->log( $e );
            }
            return false;
        }
        
        ######################################
        /**
         * @return mixed
         */
        public function getIdRegion()
        {
            return $this->idRegion;
        }

        /**
         * @param mixed $idRegion
         */
        public function setIdRegion($idRegion): void
        {
            $this->idRegion = $idRegion;
        }

        /**
         * @return mixed
         */
        public function getRegNombre()
        {
            return $this->regNombre;
        }

        /**
         * @param mixed $regNombre
         */
        public function setRegNombre($regNombre): void
        {
            $this->regNombre = $regNombre;
        }

    }