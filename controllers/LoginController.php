<?php
namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;

class LoginController {
    public static function login(Router $router) {
        $router-> render ('auth/login');

        }
    public static function logout() {
        echo "Desde logout";
    }
    public static function olvide(Router $router) {
        $router-> render ('auth/olvide-password', [

        ]);
    }
    public static function recuperar() {
        echo "Desde recuperar";
    }
    public static function crear(Router $router) {
            $usuario = new Usuario;
    //Alertas vacías
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario -> sincronizar($_POST);
            
            $alertas =$usuario -> validarNuevaCuenta();
        //Revisar que alertas este vacío
        if(empty($alertas)) {
            
            //Verificar que el usuario no esté registrado
            $resultado = $usuario -> existeUsuario();
            if($resultado->num_rows) {
                $alertas = Usuario::getAlertas();
            } else {
                //Hashear el password
                $usuario->hashPassword();

                //Generar un token único
                $usuario->crearToken();

                //Enviar el Email
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                //Enviar el Email
                debuguear($usuario);
            }
        }
        }

        $router-> render ('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
}