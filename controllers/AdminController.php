<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        session_start();

        isAdmin();

        //filtrar por fecha
        //debuguear($_GET);
        $fecha = $_GET['fecha'] ?? date ('Y-m-d');
        //debuguear($fecha);
        $fecha_parts = explode('-', $fecha);
        //debuguear($fecha_parts);

        if(!checkdate($fecha_parts[1], $fecha_parts[2], $fecha_parts[0])) {
            header('Location: /404');
        }

        //consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, citas.fecha, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";
        //debuguear($consulta);

        $citas = AdminCita::SQL($consulta);
        //debuguear($citas);

        //renderizar los datos
        $router -> render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}