<?php

namespace Model;

class Servicio extends ActiveRecord {

    //Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id','nombre','precio']; //crea un objeto igual a info de la base de datos

    //registrar los datos
    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this -> id = $args['id'] ?? null;
        $this -> nombre = $args['nombre'] ?? null;
        $this -> precio = $args['precio'] ?? null;
    }

    public function validar() {
        if(!$this -> nombre) {
            self::$alertas['error'][] = 'El nombre del servicio es obligatorio';
        }
        if(!$this -> precio) {
            self::$alertas['error'][] = 'El precio del servicio es obligatorio';
        }
        if(!is_numeric($this -> precio)) {
            self::$alertas['error'][] = 'El formato del precio no es valido';
        }

        return self::$alertas;
    }

}