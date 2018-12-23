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

require dirname(__FILE__).'\lib\class-tgm-plugin-activation.php';
define('TEXT_DOMAIN', 'filmes-reviews');

//Padrão Singleton
class Filmes_reviews {
    private static $instance;
    // const TEXT_DOMAIN = "filmes-reviews";

    public static function getInstance(){
        if(self::$instance == NULL){
            self::$instance = new self();
        }
    }

    private function __construct(){
        //Não precisa usar o $this, pois $instance é 'static'.
        // add_action('init', [$this, 'register_post_type']);
        add_action('init', 'Filmes_reviews::register_post_type');
        add_action('tgmpa_register', [$this, 'check_required_plugins']);
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

        // Config

        $config = array(
            'domain' => TEXT_DOMAIN,
            'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'install-required-plugins', // Menu slug.
            'parent_slug'  => 'plugins.php',            // Parent menu slug.
            'capability'   => 'update_plugins',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
            
            'strings'      => array(
                'page_title'                      => __( 'Install Required Plugins', TEXT_DOMAIN ),
                'menu_title'                      => __( 'Install Plugins', TEXT_DOMAIN ),
                // <snip>...</snip>
                'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
            
        );
        // Fim Config
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

