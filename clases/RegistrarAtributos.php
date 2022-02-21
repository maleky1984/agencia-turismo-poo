<?php
    
    interface RegistrarAtributos
    {
        public function cargarDesdeForm();
        public function cargarDesdeObjeto( stdClass $objeto );
    }