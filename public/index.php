<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\LoginController;
use Controllers\CitaController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router(); //instanciando el router

//Iniciar session
$router -> get('/', [LoginController::class, 'login']);
$router -> post('/', [LoginController::class, 'login']);
$router -> get('/logout', [LoginController::class, 'logout']);

//recuperar password
$router -> get('/olvide', [LoginController::class, 'olvide']);
$router -> post('/olvide', [LoginController::class, 'olvide']);
$router -> get('/recuperar', [LoginController::class, 'recuperar']); //se envia email para solicitar nueva contrasena
$router -> post('/recuperar', [LoginController::class, 'recuperar']); // se permite cambiar la contrasena

//crear cuenta
$router -> get('/crear-cuenta', [LoginController::class, 'crear']);
$router -> post('/crear-cuenta', [LoginController::class, 'crear']);

//confirmar cuenta
$router ->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router ->get('/mensaje', [LoginController::class, 'mensaje']);

//recuperacion de password exitosa
$router ->get('/recuperacionExitosa', [LoginController::class, 'recuperacionExitosa']);

//Area privada
$router ->get('/cita', [CitaController::class, 'index']);
$router ->get('/admin', [AdminController::class, 'index']);

//API de citas
$router ->get('/api/servicios', [APIController::class, 'index']);
$router ->post('/api/citas', [APIController::class, 'guardar']);
$router ->post('/api/eliminar', [APIController::class, 'eliminar']);

//Crud para administracion de servicios
$router ->get('/servicios', [ServicioController::class, 'index']);
$router ->get('/servicios/crear', [ServicioController::class, 'crear']); //muestra los datos del formulario
$router ->post('/servicios/crear', [ServicioController::class, 'crear']); //Lee los datos del formulario
$router ->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router ->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router ->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();