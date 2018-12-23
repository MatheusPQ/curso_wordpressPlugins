<?php

/*
Plugin Name: Personaliza Painel
Plugin URI: http://exemplo.com
Description: Desenvolvido para personalizar painel
Version: 1.0
Author: Fulano Ciclano
Author URI: http://fulanociclano.com.br
Text Domain: meu-segundo-plugin
License: GPL2
*/

//Padrão Singleton
class Segundo_Plugin {
    private static $instance;

    public static function getInstance(){
        if(self::$instance == NULL){
            self::$instance = new self();
        }
    }

    private function __construct(){
        
        //Desativar a action welcome_panel
        remove_action('welcome_panel', 'wp_welcome_panel');

        add_action('welcome_panel', [$this,'welcome_panel']);
        add_action('admin_enqueue_scripts', [$this,'add_css']);

    }

    function welcome_panel(){
        ?>
    
        <div class="welcome-panel-content">
            <h3>Seja bem vindo ao painel administrativo!</h3>
            <p>Siga-nos nas redes sociais!</p>
            <div id="icons">
                <a href="#" target="_blank">
                    <img src="http://localhost/wordpress/wp-content/uploads/2018/12/1474968161-youtube-circle-color.png">
                </a>
                <a href="#" target="_blank">
                    <img src="http://localhost/wordpress/wp-content/uploads/2018/12/1474968150-facebook-circle-color.png">
                </a>
    
            </div>
        </div>
    
        <?php
    }

    function add_css(){

        //plugin_dir_url é o caminho até a pasta do plugin
        wp_register_style('meu-segundo-plugin', plugin_dir_url(__FILE__).'css/meu-segundo-plugin.css');
        wp_enqueue_style('meu-segundo-plugin');

    }
}

Segundo_Plugin::getInstance();