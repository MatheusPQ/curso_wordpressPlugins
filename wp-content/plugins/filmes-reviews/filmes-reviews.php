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
define('FIELD_PREFIX', 'fr_');

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
        add_action('init', 'Filmes_reviews::register_taxonomies');
        add_action('tgmpa_register', [$this, 'check_required_plugins']);
        add_filter('rwmb_meta_boxes', [$this, 'metabox_custom_fields']);

        //TEMPLATE CUSTOMIZADO
        add_action('template_include', [$this, 'add_cpt_template']);
        add_action('wp_enqueue_scripts', [$this, 'add_style_scripts']);
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

    public static function register_taxonomies(){
        register_taxonomy('tipos_filmes', ['filmes_reviews'], [
            'labels' => [
                'name' => __('Filmes Tipos'),
                'singular_name' => __('Filme Tipo'),
            ],
            'public' => true,
            'hierarchical' => true,
            'rewrite' => ['slug' => 'tipos-filmes'],
        ]);
    }

    // Checar plugins requeridos

    function check_required_plugins(){
        $plugins = [
            [
                'name' => 'Meta Box',
                'slug' => 'meta-box',
                'required' => true, //É requerido
                'force_activation' => false, //O próprio usuário fará o processo de instalação
                'force_desactivation' => false
            ],
        ];

        /*Config*/
        $config  = array(
            'domain'           => TEXT_DOMAIN,
            'default_path'     => '',
            'parent_slug'      => 'plugins.php',
            'capability'       => 'update_plugins',
            'menu'             => 'install-required-plugins',
            'has_notices'      => true,
            'is_automatic'     => false,
            'message'          => '',
            'strings'          => array(
            'page_title'                      => __( 'Instalar plugins requeridos', TEXT_DOMAIN ),
            'menu_title'                      => __( 'Instalar Plugins', TEXT_DOMAIN),
            'installing'                      => __( 'Instalando Plugin: %s', TEXT_DOMAIN),
            'oops'                            => __( 'Algo deu errado com a API do plug-in.', TEXT_DOMAIN ),
            'notice_can_install_required'     => _n_noop( 'O Comentário do plugin Filmes Reviews depende do seguinte plugin:%1$s.', 'Os Comentários do plugin Filmes Reviews depende dos seguintes plugins:%1$s.' ),
            'notice_can_install_recommended'  => _n_noop( 'O plugin Filmes review recomenda o seguinte plugin: %1$s.', 'O plugin Filmes review recomenda os seguintes plugins: %1$s.' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
            'install_link'                    => _n_noop( 'Comece a instalação de plug-in', 'Comece a instalação dos plugins' ),
            'activate_link'                   => _n_noop( 'Ativar o plugin instalado', 'Ativar os plugins instalados' ),
            'return'                          => __( 'Voltar parapara os plugins requeridos instalados', TEXT_DOMAIN ),
            'plugin_activated'                => __( 'Plugin ativado com sucesso.', TEXT_DOMAIN ),
            'complete'                        => __( 'Todos os plugins instalados e ativados com sucesso. %s', TEXT_DOMAIN ),
            'nag_type'                        => 'updated',
            )
        );
        tgmpa( $plugins, $config );


    /*Fim Config*/  
    }

    // METABOX
    public function metabox_custom_fields(){
        $meta_boxes[] = [
            'id'        => 'data_filme',
            'title'     => __('Informações Adicionais', 'filmes-reviews'),
            'pages'     => ['filmes_reviews', 'post'],
            'context'   => 'normal', //Local onde o menu vai aparecer
            'priority'  => 'high',
            'fields' => [
                [
                    'name' => __('Ano de Lançamento', 'filmes-reviews'),
                    'desc' => __('Ano que o filme foi lançado', 'filmes-reviews'),
                    'id' => FIELD_PREFIX.'filme_ano',
                    'type' => 'number',
                    'std' => date('Y'), //Pega apenas o ano
                    'min' => '1880', //Data mínima
                ],
                [
                    'name' => __('Diretor', 'filmes-reviews'),
                    'desc' => __('Quem dirigiu o filme', 'filmes-reviews'),
                    'id' => FIELD_PREFIX.'filme_diretor',
                    'type' => 'text',
                    'std' => '',
                ],
                [
                    'name' => 'Site',
                    'desc' => __('Link do site do filme', 'filmes-reviews'),
                    'id' => FIELD_PREFIX.'filme_site',
                    'type' => 'url',
                    'std' => '',
                ],
            ],
        ];

        $meta_boxes[] = [
            'id'        => 'review_data',
            'title'     => __('Filme Review', 'filmes-reviews'),
            'pages'     => ['filmes_reviews'],
            'context'   => 'side', //Local onde o menu vai aparecer
            'priority'  => 'high',
            'fields' => [
                [
                    'name' => __('Rating', 'filmes-reviews'),
                    'desc' => __('Em uma escala de 1 - 5, sendo que 5 é a melhor nota', 'filmes-reviews'),
                    'id' => FIELD_PREFIX.'review_rating',
                    'type' => 'select',
                    'options' => [ //Como é do tipo 'select', é necessário especificar 'options'
                        '' => __('Avalie Aqui', 'filmes-reviews'),
                        1 => __('1 - Gostei um Pouco', 'filmes-reviews'),
                        2 => __('2 - Gostei mais ou menos', 'filmes-reviews'),
                        3 => __('3 - Muito bom', 'filmes-reviews'),
                        4 => __('4 - Ótimo', 'filmes-reviews'),
                        5 => __('5 - Espetacular!', 'filmes-reviews'),
                    ],
                    'std' => '',
                ],
            ],
        ];

        return $meta_boxes;
    }

    function add_cpt_template($template){
        if(is_singular('filmes_reviews')){ //Do register post type. Apenas URLS do tipo filmes_Reviews

            if(file_exists(get_stylesheet_directory().'single-filme_review.php')){ //Verifica diretório de estilos do template
                return get_stylesheet_directory().'single-filme_review.php';
            }

            return plugin_dir_path(__FILE__).'single-filme_review.php';

        }

        return $template;
    }

    function add_style_scripts(){
        wp_enqueue_style('filme-review-style',plugin_dir_url(__FILE__).'filme-review.css');
    }

    //Quando o plugin for instalado, a regra de rewrite será feita automaticamente (ao invés de ter que ir manualmente em 'Configurações' e apenas clicar em 'Salvar Alterações').
    public static function activate(){
        self::register_post_type();
        self::register_taxonomies();
        flush_rewrite_rules();
    }

}

Filmes_reviews::getInstance();


register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

//Registra uma função quando o plugin é ATIVADO.
register_activation_hook( __FILE__, 'Filmes_reviews::activate' );

