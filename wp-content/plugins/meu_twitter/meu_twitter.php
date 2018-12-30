<?php
/*
Plugin Name: Meu Twitter
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido para cadastro do botão do twitter
Version: 1.0
Author: Elton Oliveira
Author URI: http://meusite.com.br
Text Domain: meu-twitter
License: GPL2
*/

//quando tentar acessar http://localhost/wordpress/wp-content/plugins/meu_twitter/meu_twitter.php
if(!defined('ABSPATH')) header("Location: http://localhost/wordpress");

class Meu_twitter {
    private static $instance;

    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', [$this, 'set_custom_fields']);
        
        //Adiciona um shortcode. Ao digitar [twitter], aparecerá o botão do twitter
        add_shortcode('twitter', [$this, 'twitter']);
        
    }

    public function set_custom_fields(){
        //Adiciona um menu na lateral do painel admin
        add_menu_page('Meu Twitter', 'Meu twitter', 'manage_options', 'meu_twitter', 'Meu_twitter::save_custom_fields', 'dashicons-twitter', '25');
    }

    public function save_custom_fields(){
        echo "<h3> " . __("Cadastro do Twitter", "meu-twitter") . " </h3>";
        echo "<form method='POST'>";

            //Nome dos options
            $campos = ['twitter'];

            //Vai criar um textarea para inserir o código do botão de cada item acima
            foreach ($campos as $campo):

                if(isset($_POST[$campo])){
                    update_option($campo, $_POST[$campo]);
                }

                $valor = stripcslashes(get_option($campo));
                $label = ucwords(strtolower($campo)); //Bota td minúsculo, depois altera apenas a primeira p/ maiúsculo.

                echo "
                    <p>
                        <label> $label </label><br>
                        <textarea name='$campo' cols='100' rows='10'> $valor </textarea>
                    </p>
                
                ";
            endforeach;

            //Se existir a opção Twitter, mostra 'Editar', senão 'Cadastrar'.
            $nomeBotao = (get_option('twitter') !== '') ? "Editar" : "Cadastrar";
            echo "<input type='submit' value='".$nomeBotao."'>";

        echo "</form>";
    }

    public function twitter( $params = NULL ){
        return stripslashes(get_option('twitter')); //Remove aspas e barras (?) ao redor da string
    }
}

Meu_twitter::getInstance();