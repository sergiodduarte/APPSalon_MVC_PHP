<?php

namespace Model;

class Usuario extends ActiveRecord {
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id' ,'nombre','apellido','email','password','telefono','admin','confirmado','token'];

    //Atributos de cada uno de los campos de la base de datos
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    //metodo contructor
    public function __construct($args = []) {
        $this ->id = $args['id'] ?? null;
        $this ->nombre = $args['nombre'] ?? null;
        $this ->apellido = $args['apellido'] ?? null;
        $this ->email = $args['email'] ?? null;
        $this ->password = $args['password'] ?? null;
        $this ->telefono = $args['telefono'] ?? null;
        $this ->admin = $args['admin'] ?? '0';
        $this ->confirmado = $args['confirmado'] ?? '0';
        $this ->token = $args['token'] ?? null;
    }

    //MEnsajes de validacion para creacion de una cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del usuario es obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido del usuario es obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El Numero de contacto del usuario es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del usuario es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es obligatorio';
        }
        if(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'El Password debe contener minimo 8 caracteres';
        }

        return self::$alertas;
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        return self::$alertas;
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio para recuperar tu cuenta';
        } return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        } 
        if(strlen($this->password)<8) {
            self::$alertas['error'][] = 'El password debe contener minimo 8 caracteres';
        }
        return self::$alertas;
    }

    //Valida si el usuario ya existe
    public function existeUsuario() {
        $query = "SELECT * FROM " .self::$tabla. " WHERE email = '" . $this ->email. "' LIMIT 1";
        //debuguear($query);

        $resultado = self::$db -> query($query);

        if($resultado -> num_rows) {
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }

        return $resultado;
    }

    //funcion para hashear password
    public function hashPassword() {
        $this -> password = password_hash($this -> password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this -> token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {
        //debuguear($this);
        $resultado = password_verify($password, $this->password);
        //debuguear($resultado);
        if(!$resultado || !$this->confirmado) {
            self::setAlerta('error','Password incorrecto o tu cuenta no ha sido confirmada');
        } else {
            return true;
        }
    }
}