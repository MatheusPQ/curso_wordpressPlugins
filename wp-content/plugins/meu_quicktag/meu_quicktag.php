<?php
/*
Plugin Name: Meu Quicktag
Plugin URI: http://exemplo.com
Description: Plugin desenvolvido para inserir quicktags personalizadas
Version: 1.0
Author: Elton Oliveira
Author URI: http://meusite.com.br
Text Domain: meu-quicktag
License: GPL2
*/

//quando tentar acessar http://localhost/wordpress/wp-content/plugins/meu_twitter/meu_twitter.php
if(!defined('ABSPATH')) header("Location: http://localhost/wordpress");
class Meu_quicktag {
    private static $instance;

    public static function getInstance() {
        if (self::$instance == NULL) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action('admin_print_footer_scripts', [$this, 'my_quicktag']);
        // add_action('admin_print_footer_scripts', 'my_quicktag');

    }

    public function my_quicktag(){
        if(wp_script_is('quicktags')){

            ?>

                <script type="text/javascript">

                    //Função para recuperar o texto selecionado
                    function getSel(){
                        var txtarea = document.getElementById("content");
                        var start   = txtarea.selectionStart;
                        var finish  = txtarea.selectionEnd;
                        return txtarea.value.substring(start, finish);
                    }

                    QTags.addButton('btn_personalizado', 'Shortcode Twitter', get_t);

                    function get_t(){
                        var selected_text = getSel();
                        QTags.insertContent('[twitter]');
                    }

                </script>

            <?php
        }
    }

}

Meu_quicktag::getInstance();