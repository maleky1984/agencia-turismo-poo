<?php

    class Destino implements RegistrarAtributos
    {
        use Logger;
        private $idDestino;
        private $destNombre;
        private $idRegion;
        static  $regNombre;
        private $destPrecio;
        private $destAsientos;
        private $destDisponibles;
        private $destActivo;

        public function listarDestinos()
        {
            $sql  =  "SELECT idDestino,
                            destNombre,
                            d.idRegion,
                            regNombre,
                            destPrecio,
                            destAsientos,
                            destDisponibles,
                            destActivo
                        FROM destinos d, regiones r
                        WHERE d.idRegion = r.idRegion";
            $stmt = Conexion::getStatement($sql);
            $stmt->execute();
            $destinos = $stmt->fetchAll( PDO::FETCH_OBJ );
            return $destinos;
        }

        public function cargarDesdeForm()
        {
            if( isset( $_REQUEST['idDestino'] ) ){
                $this->setIdDestino( $_REQUEST['idDestino'] );
            }
            if ( isset( $_POST['destNombre'] ) ){
                $this->setDestNombre( $_POST['destNombre'] );
            }
            if ( isset( $_POST['idRegion'] ) ) {
                $this->setIdRegion( $_POST['idRegion']  );
            }
            if ( isset( $_POST['destPrecio'] ) ) {
                $this->setDestPrecio( $_POST['destPrecio'] );
            }
            if ( isset( $_POST['destAsientos'] ) ) {
                $this->setDestAsientos( $_POST['destAsientos'] );
            }
            if ( isset( $_POST['destDisponibles'] ) ) {
                $this->setDestDisponibles( $_POST['destDisponibles'] );
            }
                $this->setDestActivo(1);//default
        }

        public function cargarDesdeObjeto( stdClass $objeto )
        {
            $this->setIdDestino( $objeto->idDestino );
            $this->setDestNombre( $objeto->destNombre );
            $this->setIdRegion( $objeto->idRegion );
            self::setRegNombre($objeto->regNombre);
            $this->setDestPrecio( $objeto->destPrecio );
            $this->setDestAsientos( $objeto->destAsientos );
            $this->setDestDisponibles( $objeto->destDisponibles );
            $this->setDestActivo(1);//default
        }

        public function verDestinoPorID()
        {
            $this->cargarDesdeForm();
            $idDestino = $this->getIdDestino();
            $sql  =  "SELECT idDestino,
                            destNombre,
                            d.idRegion,
                            regNombre,
                            destPrecio,
                            destAsientos,
                            destDisponibles,
                            destActivo
                        FROM destinos d, regiones r
                        WHERE d.idRegion = r.idRegion
                          AND idDestino = :idDestino";
            $stmt = Conexion::getStatement($sql);
            try{
                $stmt->bindParam(':idDestino', $idDestino);
                $stmt->execute();
                $destino = $stmt->fetch( PDO::FETCH_OBJ );
                // cargar atributos DesdeObjeto
                $this->cargarDesdeObjeto( $destino );
                return $this;
            }catch (PDOException $e){
                $this->log( $e );
            }
        }

        public function agregarDestino()
        {
            $this->cargarDesdeForm();
            $sql = "INSERT INTO destinos
                          ( destNombre, idRegion, destPrecio, destAsientos, destDisponibles )
                        VALUE 
                          ( :destNombre, :idRegion, :destPrecio, :destAsientos, :destDisponibles )";
            $stmt = Conexion::getStatement($sql);

            $destNombre = $this->destNombre;
            $idRegion   = $this->idRegion;
            $destPrecio = $this->destPrecio;
            $destAsientos = $this->destAsientos;
            $destDisponibles = $this->destDisponibles;

            $stmt->bindParam(':destNombre', $destNombre, PDO::PARAM_STR);
            $stmt->bindParam(':idRegion', $idRegion, PDO::PARAM_INT);
            $stmt->bindParam(':destPrecio', $destPrecio, PDO::PARAM_INT);
            $stmt->bindParam(':destAsientos', $destAsientos, PDO::PARAM_INT);
            $stmt->bindParam(':destDisponibles', $destDisponibles, PDO::PARAM_INT);
            try{
                $stmt->execute();
                $this->setIdDestino( Conexion::$link->lastInsertID() );
                return $this;
            }catch ( PDOException $e ){
                $this->log($e);
            }
            return false;

        }

        public function modificarDestino()
        {
            $this->cargarDesdeForm();
            $sql = "UPDATE destinos 
                        SET 
                            destNombre = :destNombre,
                            idRegion = :idRegion,
                            destPrecio = :destPrecio,
                            destAsientos = :destAsientos,
                            destDisponibles = :destDisponibles
                    WHERE   idDestino = :idDestino";
            $stmt = Conexion::getStatement( $sql );

            $destNombre = $this->destNombre;
            $idRegion   = $this->idRegion;
            $destPrecio = $this->destPrecio;
            $destAsientos = $this->destAsientos;
            $destDisponibles = $this->destDisponibles;
            $idDestino  = $this->idDestino;

            $stmt->bindParam(':destNombre', $destNombre, PDO::PARAM_STR);
            $stmt->bindParam(':idRegion', $idRegion, PDO::PARAM_INT);
            $stmt->bindParam(':destPrecio', $destPrecio, PDO::PARAM_INT);
            $stmt->bindParam(':destAsientos', $destAsientos, PDO::PARAM_INT);
            $stmt->bindParam(':destDisponibles', $destDisponibles, PDO::PARAM_INT);
            $stmt->bindParam(':idDestino', $idDestino, PDO::PARAM_INT);
            try{
                $stmt->execute();
                return $this;
            }catch ( PDOException $e ){
                $this->log( $e );
            }
            return false;
        }

        public function eliminarDestino()
        {
            $this->cargarDesdeForm();
            $idDestino = $this->getIdDestino();
            $sql = "DELETE FROM destinos
                        WHERE idDestino = :idDestino";
            $stmt = Conexion::getStatement($sql);
            try{
                $stmt->bindParam(':idDestino', $idDestino);
                $stmt->execute();
                return $this;
            }catch ( PDOException $e ){
                $this->log($e);
            }
            return false;
        }

        ####################################
        /**
         * @return mixed
         */
        public function getIdDestino()
        {
            return $this->idDestino;
        }

        /**
         * @param mixed $idDestino
         */
        public function setIdDestino($idDestino): void
        {
            $this->idDestino = $idDestino;
        }

        /**
         * @return mixed
         */
        public function getDestNombre()
        {
            return $this->destNombre;
        }

        /**
         * @param mixed $destNombre
         */
        public function setDestNombre($destNombre): void
        {
            $this->destNombre = $destNombre;
        }

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
        public static function getRegNombre()
        {
            return self::$regNombre;
        }

        /**
         * @param mixed $regNombre
         */
        static function setRegNombre($regNombre): void
        {
            self::$regNombre = $regNombre;
        }

        /**
         * @return mixed
         */
        public function getDestPrecio()
        {
            return $this->destPrecio;
        }

        /**
         * @param mixed $destPrecio
         */
        public function setDestPrecio($destPrecio): void
        {
            $this->destPrecio = $destPrecio;
        }

        /**
         * @return mixed
         */
        public function getDestAsientos()
        {
            return $this->destAsientos;
        }

        /**
         * @param mixed $destAsientos
         */
        public function setDestAsientos($destAsientos): void
        {
            $this->destAsientos = $destAsientos;
        }

        /**
         * @return mixed
         */
        public function getDestDisponibles()
        {
            return $this->destDisponibles;
        }

        /**
         * @param mixed $destDisponibles
         */
        public function setDestDisponibles($destDisponibles): void
        {
            $this->destDisponibles = $destDisponibles;
        }

        /**
         * @return mixed
         */
        public function getDestActivo()
        {
            return $this->destActivo;
        }

        /**
         * @param mixed $destActivo
         */
        public function setDestActivo($destActivo): void
        {
            $this->destActivo = $destActivo;
        }


    }