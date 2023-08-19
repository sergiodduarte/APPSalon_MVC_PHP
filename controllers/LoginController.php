<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $alertas = [];

        $auth = new Usuario;

        if($_SERVER['REQUEST_METHOD']==='POST') {
            //instanciar el modelo de usuario
            $auth = new Usuario($_POST);
            //debuguear($auth);

            $alertas = $auth -> validarLogin();

            if(empty($alertas)) {
                //Comprobar que exista el usuario usando el email
                $usuario = Usuario::where('email',$auth->email);

                if($usuario) {
                    if($usuario -> comprobarPasswordAndVerificado($auth->password)) {
                        //si el password esta ok y esta confirmado:
                        session_start();
                        $_SESSION['id'] = $usuario ->id;
                        $_SESSION['nombre'] = $usuario ->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario ->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento
                        //si es admin
                        if($usuario -> admin === '1') {
                            $_SESSION['admin'] = $usuario -> admin ?? null;

                            header('Location: /admin');
                        }else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'El usuario no se encuentra registrado');
                }
            }

            //debuguear($auth);
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas'=> $alertas,
            'auth'=> $auth
        ]);
    }

    public static function logout() {
        session_start();
        //debuguear($_SESSION);
        $_SESSION = [];
        //debuguear($_SESSION);
        header('Location: /');
    }

    public static function olvide(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            //debuguear($auth);
            $alertas = $auth -> validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where('email',$auth -> email);
                //debuguear($usuario);

                if($usuario && $usuario->confirmado ==='1') {
                    //Generar token de un solo uso
                    $usuario->crearToken();
                    //debuguear($usuario);
                    //Actualizar la base de datos con el nuevo token
                    $usuario->guardar();

                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    //Alerta de exito
                    Usuario::setAlerta('exito','Revisa tu email');
                    $alertas = Usuario::getAlertas();

                }else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                    $alertas = Usuario::getAlertas();
                }
            }
        }

        $router -> render('auth/olvide-password',[
            'alertas'=>$alertas
        ]);
    }

    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false;
        //obterner info del token con GET
        $token = s($_GET['token']);
        //debuguear($token);
        //Buscar user por su token
        $usuario = Usuario::where('token', $token);
        //debuguear($usuario);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Leer y guadar nuevo password
            $password = new Usuario($_POST);
            //debuguear($password);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                
                if($resultado) {
                    
                    sleep(5);
                    header('Location: recuperacionExitosa');
                }
            }

        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password',[
            'alertas'=> $alertas,
            'error' => $error
        ]);
    }

    public static function recuperacionExitosa(Router $router) {
        $router -> render('auth/recuperacionExitosa');
    }

    public static function crear(Router $router) {

        $usuario = new Usuario;

        //Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario -> sincronizar($_POST);
            $alertas = $usuario -> validarNuevaCuenta();

            //debuguear($alertas);

            //validar que el arreglo de alertas este vacio
            if(empty($alertas)) {
                //Verificar que el usuario no este registrado
                $resultado = $usuario -> existeUsuario();

                if($resultado -> num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear el password
                    $usuario -> hashPassword();

                    //generar token
                    $usuario -> crearToken();

                    //enviar email para confirmar cuenta(instancio el email)
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    //Llamo el metodo
                    $email-> enviarConfirmacion();

                    //debuguear($email);
                    //debuguear($usuario);
                    //crear usuario
                    $resultado = $usuario ->guardar();
                    if($resultado) {
                        header('Location: mensaje');
                    }
                }
                
            }
        }

        $router -> render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router -> render('auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];

        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            //Si esta vacio mostrar mensaje de error
            Usuario::setAlerta('error','Token no valido');
        }else {
            //Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada exitosamente');
        }

        //obtener alertas
        $alertas = Usuario::getAlertas();

        //Rederizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas]);

    }
}
