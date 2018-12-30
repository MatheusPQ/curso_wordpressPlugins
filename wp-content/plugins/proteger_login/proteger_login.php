<?php
/*
Plugin Name: Proteger Login
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido para proteger tela de login
Version: 1.0
Author: Elton Oliveira
Author URI: http://meusite.com.br
Text Domain: proteger-login
License: GPL2
*/

//quando tentar acessar http://localhost/wordpress/wp-content/plugins/meu_twitter/meu_twitter.php
if(!defined('ABSPATH')) header("Location: http://localhost/wordpress");
class Proteger_login {
    private static $instance;

    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action('login_form_login', [$this, 'pt_login']);

    }

    //Precisa digitar http://localhost/wordpress/wp-login.php?empresa<MINUTOS> pra entrar na tela de login
    public function pt_login(){
        if($_SERVER['SCRIPT_NAME'] == '/wordpress/wp-login.php'){
            // echo "<script>alert('teste')</script>";
            $min = Date('i');
            if(!isset($_GET['empresa'.$min])){
                header('Location: http://localhost/wordpress/');
            }
        }
    }
}

Proteger_login::getInstance();