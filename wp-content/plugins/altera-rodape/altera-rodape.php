<?php

/*
Plugin Name: Altera Rodapé
Plugin URI: http://exemplo.com
Description: Este plugin altera o rodapé do Blog
Version: 1.0
Author: Fulano Ciclano
Author URI: http://fulanociclano.com.br
Text Domain: altera-rodape
License: GPLv2
*/

function meu_plugin_altera_rodape(){
    echo "Meu Primeiro Plugin - Fulano Ciclano 2018";
}

add_action('wp_footer', 'meu_plugin_altera_rodape');
//Em Aparências -> Editor -> Rodapé do Tema, deve estar aparecendo no final a função wp_footer();

add_action('init', 'my_user_check'); //Ao iniciar

function my_user_check(){
    if(is_user_logged_in()){
        //echo '<script>alert(1)</script>';
    }

}

//10 é a prioridade. 2 é o núm. de parâmetros que são enviados a função.
add_filter('the_title', 'my_filtered_title', 10, 2);

function my_filtered_title($value, $id){
	$value = '[****' .$value.'****]';
	return $value;
}