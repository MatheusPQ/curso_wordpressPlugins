<?php

/*
Plugin Name: Filmes Reviews
Plugin URI: http://exemplo.com
Description: Plguin para reviews de filmes
Version: 1.0
Author: Fulano Ciclano
Author URI: http://fulanociclano.com.br
Text Domain: filmes-reviews
License: GPL2
*/

require dirname(__FILE__).'lib/class-tgm-plugin-activation.php';

//Padrão Singleton
class Filmes_reviews {
    private static $instance;

    public static function getInstance(){
        if(self::$instance == NULL){
            self::$instance = new self();
        }
    }

    private function __construct(){
        //Não precisa usar o $this, pois $instance é 'static'.
        // add_action('init', [$this, 'register_post_type']);
        add_action('init', 'Filmes_reviews::register_post_type');
    }

    public static function register_post_type(){
        register_post_type('filmes_reviews', [
            'labels' => [
                'name' => 'Filmes Reviews',
                'singular_name' => 'Filme Review',
            ],
            
            'description' => 'Post para cadastro de reviews',
            'supports' => [
                'title', 'editor', 'excerpt','author', 'revisions','thumbnail','custom-fields',
            ],
            'public' => TRUE,
            'menu_icon' => 'dashicons-format-video',
            'menu_position'=> 3,
        ]);
    }

    // Checar plugins requeridos

    function check_required_plugins(){
        $plugins = [
            [
                'name' => 'Meta Box',
                'slug' => 'meta-box',
                'required' => true,
                'force_activation' => false, //O próprio usuário fará o processo de instalação
                'force_desactivation' => false
            ],
        ];
    }

    //Quando o plugin for instalado, a regra de rewrite será feita automaticamente (ao invés de ter que ir manualmente em 'Configurações' e apenas clicar em 'Salvar Alterações').
    public static function activate(){
        self::register_post_type();
        flush_rewrite_rules();
    }

}

Filmes_reviews::getInstance();


register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

//Registra uma função quando o plugin é ATIVADO.
register_activation_hook( __FILE__, 'Filmes_reviews::activate' );

